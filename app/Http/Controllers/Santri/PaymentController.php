<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\Program;

class PaymentController extends Controller
{
    /**
     * Show payment page
     */
    public function index()
    {
        $user = auth()->user();
        $registration = Registration::with(['program', 'payment'])
            ->where('user_id', $user->id)
            ->first();

        if (!$registration) {
            return redirect()->route('santri.program.index')
                ->with('info', 'Silakan pilih program dan lengkapi data terlebih dahulu.');
        }

        if (!$registration->is_program_locked) {
            return redirect()->route('santri.program.index')
                ->with('info', 'Silakan lengkapi formulir pendaftaran terlebih dahulu.');
        }

        $payment = $registration->payment;

        return view('santri.payment', compact('registration', 'payment'));
    }

    /**
     * Create payment via Midtrans
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $registration = Registration::with('program')
            ->where('user_id', $user->id)
            ->first();

        if (!$registration || !$registration->is_program_locked) {
            return back()->withErrors(['error' => 'Registrasi tidak valid.']);
        }

        // Check if payment already exists
        $existingPayment = Payment::where('registration_id', $registration->id)
            ->where('status', 'success')
            ->first();

        if ($existingPayment) {
            return back()->with('info', 'Pembayaran sudah berhasil dilakukan.');
        }

        $program = $registration->program;
        $amount = $program->price;

        if ($amount <= 0) {
            // Free registration
            $registration->update(['payment_status' => 'paid', 'status' => 'paid']);
            return redirect()->route('santri.dashboard')
                ->with('success', 'Pendaftaran berhasil! Tidak ada biaya yang perlu dibayar.');
        }

        // Generate order ID
        $orderId = 'PPDB-' . $registration->id . '-' . time();

        // Create payment record
        $payment = Payment::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'amount' => $amount,
                'order_id' => $orderId,
                'status' => 'pending',
            ]
        );

        // Configure Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $program->id,
                    'price' => (int) $amount,
                    'quantity' => 1,
                    'name' => 'Pendaftaran ' . $program->name,
                ]
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $payment->update(['snap_token' => $snapToken]);

            return view('santri.payment-process', compact('snapToken', 'payment', 'registration'));

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle Midtrans callback
     */
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $payment = Payment::where('order_id', $request->order_id)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $paymentType = $request->payment_type;

        $payment->update([
            'transaction_id' => $request->transaction_id,
            'payment_method' => $paymentType,
            'midtrans_response' => $request->all(),
        ]);

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $payment->update([
                'status' => 'success',
                'paid_at' => now(),
            ]);

            $payment->registration->update([
                'payment_status' => 'paid',
                'status' => 'paid',
            ]);

        } elseif ($transactionStatus == 'pending') {
            $payment->update(['status' => 'pending']);

        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $payment->update(['status' => 'failed']);
            $payment->registration->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'OK']);
    }
}
