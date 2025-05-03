<?php

use App\Http\Controllers\LoginWithOTPController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;

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

// // Socialite Routes
// Route::prefix('oauth/')->group(function(){
//     Route::prefix('/github/login')->name('github.')->group(function(){
//         Route::get('/',[SocialiteController::class,'redirectToGithub'])->name('login');
//         Route::get('/callback',[SocialiteController::class,'HandleGithubCallBack'])->name('callback');
//     });

//     Route::prefix('/google/login')->name('google.')->group(function(){
//         Route::get('/',[SocialiteController::class,'redirectToGoogle'])->name('login');
//         Route::get('/callback',[SocialiteController::class,'HandleGoogleCallBack'])->name('callback');        
//     });

//     Route::prefix('/facebook/login')->name('facebook.')->group(function(){
//         Route::get('/',[SocialiteController::class,'redirectToFaceBook'])->name('login');
//         Route::get('/callback',[SocialiteController::class,'HandleFaceBookCallBack'])->name('callback');
//     });
// });


// route pendaftaran
Route::get('pendaftaran/cari_pasien', [PendaftaranController::class, 'cariPasien'])->name('admin.pendaftaran.cari_pasien');
Route::post('pendaftaran/{id}/cancel', [PendaftaranController::class, 'cancelRegis'])->name('admin.pendaftaran.cancelVisit');








// Auth routes
require __DIR__.'/auth.php';
// Admin Routes
require('admin.php');
