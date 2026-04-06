<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->nullable(); // credit_card, bank_transfer, etc
            $table->string('order_id')->unique(); // Midtrans order ID
            $table->string('transaction_id')->nullable(); // Midtrans transaction ID
            $table->string('snap_token')->nullable(); // Midtrans snap token
            $table->enum('status', ['pending', 'success', 'failed', 'expired', 'challenge'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->json('midtrans_response')->nullable(); // Store full response from Midtrans
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
