<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Panitia\PesertaController as PanitiaPesertaController;
use App\Http\Controllers\Peserta\AcaraController as PesertaAcaraController;
use App\Http\Controllers\Peserta\RiwayatController as PesertaRiwayatController;


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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role-specific dashboards
//panitia
Route::middleware(['auth', 'role:panitia'])->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/dashboard', [PanitiaController::class, 'dashboard'])->name('dashboard');
    
    // Peserta management routes
    Route::get('/peserta', [PanitiaPesertaController::class, 'index'])->name('peserta.index');
    Route::get('/peserta/{pendaftaran}', [PanitiaPesertaController::class, 'show'])->name('peserta.show');
    Route::post('/peserta/{pendaftaran}/approve', [PanitiaPesertaController::class, 'approve'])->name('peserta.approve');
    Route::post('/peserta/{pendaftaran}/reject', [PanitiaPesertaController::class, 'reject'])->name('peserta.reject');
    Route::post('/peserta/{pendaftaran}/reset', [PanitiaPesertaController::class, 'reset'])->name('peserta.reset');
});

//admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User management routes
    Route::resource('users', UserController::class);

    //acara management routes
    Route::resource('acara', AcaraController::class);

});

// peserta
Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/dashboard', [PesertaController::class, 'dashboard'])->name('dashboard');
    
    // Acara routes
    Route::get('/acara', [PesertaAcaraController::class, 'index'])->name('acara.index');
    Route::get('/acara/{acara}', [PesertaAcaraController::class, 'show'])->name('acara.show');
    Route::post('/acara/{acara}/daftar', [PesertaAcaraController::class, 'daftar'])->name('acara.daftar');
    Route::delete('/acara/batalkan/{pendaftaran}', [PesertaAcaraController::class, 'batalkan'])->name('acara.batalkan');
    
    // Riwayat routes
    Route::get('/riwayat', [PesertaRiwayatController::class, 'index'])->name('riwayat.index');
});
        
require __DIR__.'/auth.php';