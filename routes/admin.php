<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\FormulaController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanObatController;
use App\Http\Controllers\SpesialisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AsuransiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCateoryController;
use App\Http\Controllers\AsesmenPerawatController;
use App\Http\Controllers\JsProcedureController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard',[ProfileController::class,'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['role:admin'])->group(function(){
        Route::resource('user',UserController::class);
        Route::resource('role',RoleController::class);
        Route::resource('permission',PermissionController::class);
        Route::resource('category',CategoryController::class);
        Route::resource('subcategory',SubCateoryController::class);
        Route::resource('collection',CollectionController::class);
        Route::resource('product',ProductController::class);
        Route::resource('asuransi',AsuransiController::class);
        Route::resource('pasien',PasienController::class);
        Route::resource('spesialis',SpesialisController::class);
        Route::resource('dokter',DokterController::class);
        Route::resource('poliklinik',PoliklinikController::class);
        Route::resource('pendaftaran', PendaftaranController::class)->except(['show']);
        Route::resource('obat', ObatController::class);
        Route::resource('asesmen_perawat', AsesmenPerawatController::class);
        Route::resource('satuan_obat', SatuanObatController::class);
        Route::resource('formula', FormulaController::class);
        Route::resource('procedures', ProcedureController::class);
        Route::resource('js_procedures', JsProcedureController::class);







        // In routes/admin.php






        Route::get('/get/subcategory',[ProductController::class,'getsubcategory'])->name('getsubcategory');
        Route::get('/remove-external-img/{id}',[ProductController::class,'removeImage'])->name('remove.image');
    });
});
