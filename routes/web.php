<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HomepageSettingController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Santri\DashboardController as SantriDashboardController;
use App\Http\Controllers\Santri\ProgramController as SantriProgramController;
use App\Http\Controllers\Santri\BiodataController;
use App\Http\Controllers\Santri\PaymentController;
use App\Http\Controllers\Panitia\DashboardController as PanitiaDashboardController;
use App\Http\Controllers\Panitia\PendaftarController;
use App\Http\Controllers\Panitia\InterviewController as PanitiaInterviewController;
use App\Http\Controllers\Panitia\GraduationController;
use App\Http\Controllers\Ustad\DashboardController as UstadDashboardController;
use App\Http\Controllers\Ustad\InterviewController as UstadInterviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout (Authenticated only)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/homepage-settings', [HomepageSettingController::class, 'index'])->name('homepage-settings.index');
    Route::put('/homepage-settings', [HomepageSettingController::class, 'update'])->name('homepage-settings.update');
    Route::resource('programs', AdminProgramController::class);
    Route::resource('users', AdminUserController::class);
    
    // Assessment Criteria & Aspects
    Route::get('/assessment', [\App\Http\Controllers\Admin\AssessmentController::class, 'index'])->name('assessment.index');
    Route::post('/assessment/criteria', [\App\Http\Controllers\Admin\AssessmentController::class, 'storeCriteria'])->name('assessment.criteria.store');
    Route::put('/assessment/criteria/{id}', [\App\Http\Controllers\Admin\AssessmentController::class, 'updateCriteria'])->name('assessment.criteria.update');
    Route::delete('/assessment/criteria/{id}', [\App\Http\Controllers\Admin\AssessmentController::class, 'destroyCriteria'])->name('assessment.criteria.destroy');
    Route::post('/assessment/aspect', [\App\Http\Controllers\Admin\AssessmentController::class, 'storeAspect'])->name('assessment.aspect.store');
    Route::put('/assessment/aspect/{id}', [\App\Http\Controllers\Admin\AssessmentController::class, 'updateAspect'])->name('assessment.aspect.update');
    Route::delete('/assessment/aspect/{id}', [\App\Http\Controllers\Admin\AssessmentController::class, 'destroyAspect'])->name('assessment.aspect.destroy');
    Route::post('/assessment/copy', [\App\Http\Controllers\Admin\AssessmentController::class, 'copyToYear'])->name('assessment.copy');
    
    // Kelola Santri
    Route::get('/kelola-santri', [\App\Http\Controllers\Admin\KelolaSantriController::class, 'index'])->name('kelola-santri.index');
    Route::get('/kelola-santri/{id}', [\App\Http\Controllers\Admin\KelolaSantriController::class, 'show'])->name('kelola-santri.show');
    Route::put('/kelola-santri/{id}/user', [\App\Http\Controllers\Admin\KelolaSantriController::class, 'updateUser'])->name('kelola-santri.update-user');
    Route::put('/kelola-santri/{id}/biodata', [\App\Http\Controllers\Admin\KelolaSantriController::class, 'updateBiodata'])->name('kelola-santri.update-biodata');
    Route::put('/kelola-santri/{id}/daftar-ulang', [\App\Http\Controllers\Admin\KelolaSantriController::class, 'updateDaftarUlang'])->name('kelola-santri.update-daftar-ulang');
});

// Santri Routes
Route::prefix('santri')->middleware(['auth', 'role:santri'])->name('santri.')->group(function () {
    Route::get('/dashboard', [SantriDashboardController::class, 'index'])->name('dashboard');
    
    // Program selection and form
    Route::get('/program', [SantriProgramController::class, 'index'])->name('program.index');
    Route::post('/program/select', [SantriProgramController::class, 'selectProgram'])->name('program.select');
    Route::get('/program/{slug}/form', [SantriProgramController::class, 'showForm'])->name('program.form');
    Route::post('/program/{slug}/store', [SantriProgramController::class, 'storeForm'])->name('program.store');
    
    // Biodata
    Route::get('/biodata', [BiodataController::class, 'index'])->name('biodata.index');
    Route::put('/biodata', [BiodataController::class, 'update'])->name('biodata.update');
    
    // Payment
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    
    // Interview & Announcement
    Route::get('/jadwal-wawancara', [SantriDashboardController::class, 'jadwalWawancara'])->name('jadwal-wawancara');
    Route::get('/pengumuman', [SantriDashboardController::class, 'pengumuman'])->name('pengumuman');
    
    // Daftar Ulang
    Route::get('/daftar-ulang', [\App\Http\Controllers\Santri\DaftarUlangController::class, 'index'])->name('daftar-ulang');
    Route::post('/daftar-ulang/lil-athfal', [\App\Http\Controllers\Santri\DaftarUlangController::class, 'storeLilAthfal'])->name('daftar-ulang.lil-athfal');
    Route::post('/daftar-ulang/iddah-tahfidz', [\App\Http\Controllers\Santri\DaftarUlangController::class, 'storeIddahTahfidz'])->name('daftar-ulang.iddah-tahfidz');
    Route::post('/daftar-ulang/paudqu', [\App\Http\Controllers\Santri\DaftarUlangController::class, 'storePaudqu'])->name('daftar-ulang.paudqu');
});

// Panitia Routes
Route::prefix('panitia')->middleware(['auth', 'role:panitia'])->name('panitia.')->group(function () {
    Route::get('/dashboard', [PanitiaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pendaftar', [PendaftarController::class, 'index'])->name('pendaftar.index');
    Route::get('/pendaftar/{id}', [PendaftarController::class, 'show'])->name('pendaftar.show');
    
    // Interview scheduling
    Route::get('/interview', [PanitiaInterviewController::class, 'index'])->name('interview.index');
    Route::post('/interview/schedule', [PanitiaInterviewController::class, 'schedule'])->name('interview.schedule');
    Route::get('/interview/monitor', [PanitiaInterviewController::class, 'monitor'])->name('interview.monitor');
    
    // Graduation decisions
    Route::get('/graduation', [GraduationController::class, 'index'])->name('graduation.index');
    Route::post('/graduation/{registrationId}/decide', [GraduationController::class, 'decide'])->name('graduation.decide');
    
    // Data Santri & PDF
    Route::get('/data-santri', [\App\Http\Controllers\Panitia\DataSantriController::class, 'index'])->name('data-santri.index');
    Route::get('/data-santri/{id}/pdf', [\App\Http\Controllers\Panitia\DataSantriController::class, 'downloadPdfTemplate'])->name('data-santri.pdf');
    Route::get('/data-santri/{id}/word', [\App\Http\Controllers\Panitia\DataSantriController::class, 'downloadWord'])->name('data-santri.word');
    Route::get('/data-santri/{id}/template', [\App\Http\Controllers\Panitia\DataSantriController::class, 'downloadTemplate'])->name('data-santri.template');
    Route::get('/data-santri/{id}/pdf-template', [\App\Http\Controllers\Panitia\DataSantriController::class, 'downloadPdfTemplate'])->name('data-santri.pdf-template');
    
    // Keuangan
    Route::get('/keuangan', [\App\Http\Controllers\Panitia\KeuanganController::class, 'index'])->name('keuangan.index');
    
    // Rekap Data
    Route::get('/rekap-data', [\App\Http\Controllers\Panitia\RekapDataController::class, 'index'])->name('rekap-data.index');
    Route::get('/rekap-data/export', [\App\Http\Controllers\Panitia\RekapDataController::class, 'exportExcel'])->name('rekap-data.export');
});

// Ustad Routes
Route::prefix('ustad')->middleware(['auth', 'role:ustad'])->name('ustad.')->group(function () {
    Route::get('/dashboard', [UstadDashboardController::class, 'index'])->name('dashboard');
    Route::get('/interviews', [UstadInterviewController::class, 'index'])->name('interview.index');
    Route::get('/interviews/{id}', [UstadInterviewController::class, 'show'])->name('interview.show');
    Route::post('/interviews/{id}/result', [UstadInterviewController::class, 'storeResult'])->name('interview.store-result');
    Route::get('/completed', [UstadInterviewController::class, 'completed'])->name('interview.completed');
});

// Midtrans Payment Callback (no auth required)
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
