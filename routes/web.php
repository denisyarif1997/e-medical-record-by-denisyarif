<?php

use App\Http\Controllers\AsesmenMedisController;
use App\Http\Controllers\LoginWithOTPController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AsesmenPerawatController;
use App\Livewire\AsesmenMedisCrud;
use App\Livewire\JenisHargaCrud;
use App\Livewire\PostComponent;
use App\Livewire\Diagnosa;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return redirect()->route('login');
});

// Login with OTP Routes
Route::prefix('/otp')->middleware('guest')->name('otp.')->controller(LoginWithOTPController::class)->group(function(){
    Route::get('/login','login')->name('login');
    Route::post('/generate','generate')->name('generate');
    Route::get('/verification/{userId}','verification')->name('verification');
    Route::post('login/verification','loginWithOtp')->name('loginWithOtp');
});



// route pendaftaran
Route::get('pendaftaran/cari_pasien', [PendaftaranController::class, 'cariPasien'])->name('admin.pendaftaran.cari_pasien');
Route::post('pendaftaran/{id}/cancel', [PendaftaranController::class, 'cancelRegis'])->name('admin.pendaftaran.cancelVisit');
// route asesmen
Route::get('/asesmen_perawat/create/{id}', [AsesmenPerawatController::class, 'createWithId'])->name('admin.asesmen_perawat.createWithId');
Route::get('/asesmen_medis/create/{id}', [AsesmenMedisController::class, 'createWithId'])->name('admin.asesmen_medis.createWithId');
// get diagnosa

// livewire routes
Route::get('/asesmen-medis', AsesmenMedisCrud::class)->name('forms.asesmen_medis');
Route::get('/diagnosa', Diagnosa::class)->name('forms.diagnosa');


Route::get('/jenis-harga', JenisHargaCrud::class)->name('forms.jenis_harga');
Route::get('/post', PostComponent::class)->name('');











// Auth routes
require __DIR__.'/auth.php';
// Admin Routes
require('admin.php');
