<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HasilUjianController;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\JenisUjianController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\UserController;
use App\Models\JenisUjian;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/home', function () {
//    return view('index');
//})->middleware('auth')->name('home');

//Route::get('/test', function () {
//    return view('test');
//});

require __DIR__ . '/auth.php';



Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    // Route::get('/', function () {
    //     return view('index');
    // })->name('home');
});



Route::group(['prefix' => 'bank-soal', 'as' => 'bank-soal.', 'middleware' => 'auth'], function () {
    Route::get('/', [BankSoalController::class, 'index'])->name('index');
    Route::post('/', [BankSoalController::class, 'store'])->name('store');
    Route::put('/{id}', [BankSoalController::class, 'update'])->name('update');
    Route::delete('/{id}', [BankSoalController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [BankSoalController::class, 'show'])->name('show');
});


Route::group(['prefix' => 'ujian', 'as' => 'ujian.', 'middleware' => 'auth'], function () {
    Route::get('/', [UjianController::class, 'index'])->name('index');
    Route::get('/create', [UjianController::class, 'create'])->name('create');
    Route::post('/', [UjianController::class, 'store'])->name('store');
    Route::put('/{id}', [UjianController::class, 'update'])->name('update');
    Route::delete('/{id}', [UjianController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [UjianController::class, 'show'])->name('show');
});

// route for master kategori
Route::group(['prefix' => 'kategori', 'as' => 'kategori.', 'middleware' => 'auth'], function () {
    Route::get('/', [KategoriController::class, 'index'])->name('index');
    Route::post('/', [KategoriController::class, 'store'])->name('store');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [KategoriController::class, 'show'])->name('show');
});

// jenis-ujian

Route::group(['prefix' => 'jenis-ujian', 'as' => 'jenis-ujian.', 'middleware' => 'auth'], function () {
    Route::get('/', [JenisUjianController::class, 'index'])->name('index');
    Route::post('/', [JenisUjianController::class, 'store'])->name('store');
    Route::put('/{id}', [JenisUjianController::class, 'update'])->name('update');
    Route::delete('/{id}', [JenisUjianController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [JenisUjianController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'filter', 'as' => 'filter.', 'middleware' => 'auth'], function () {
    Route::get('/soals', [FilterController::class, 'getSoals'])->name('soals');
    Route::get('/tingkat-kesulitan', [FilterController::class, 'getTingkatKesulitan'])->name('tingkat-kesulitan');
    Route::get('/kategori', [FilterController::class, 'getKategori'])->name('kategori');
    Route::get('/sub-kategori/{kategoriId}', [FilterController::class, 'getSubKategori'])->name('sub-kategori');
    Route::get('/ujian-sections-soals', [FilterController::class, 'getUjianSectionsSoals'])->name('ujian-sections-soals');
});

// route for master sub kategori
Route::group(['prefix' => 'subkategori', 'as' => 'subkategori.', 'middleware' => 'auth'], function () {
    Route::get('/', [SubKategoriController::class, 'index'])->name('index');
    Route::post('/', [SubKategoriController::class, 'store'])->name('store');
    Route::put('/{id}', [SubKategoriController::class, 'update'])->name('update');
    Route::delete('/{id}', [SubKategoriController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [SubKategoriController::class, 'show'])->name('show');
});

Route::middleware(['auth'])->prefix('sertifikat')->as('sertifikat.')->group(function () {
    Route::get('/', [SertifikatController::class, 'index'])->name('index');
    Route::get('/create', [SertifikatController::class, 'create'])->name('create');
    Route::get('/template', [SertifikatController::class, 'template'])->name('template');
    Route::post('/', [SertifikatController::class, 'store'])->name('store');
    Route::get('/{id}/preview', [SertifikatController::class, 'preview'])->name('preview');
    Route::get('/{id}/edit', [SertifikatController::class, 'edit'])->name('edit');
    Route::put('/{id}/template', [SertifikatController::class, 'updateTemplate'])->name('updateTemplate');
    Route::delete('/{id}', [SertifikatController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pengaturan', [SystemSettingController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/profil', [SystemSettingController::class, 'updateProfil'])->name('pengaturan.updateProfil');
    Route::put('/pengaturan/logo', [SystemSettingController::class, 'updateLogo'])->name('pengaturan.updateLogo');
    // Manajemen User
    Route::get('/pengaturan/users', [UserController::class, 'datatable'])->name('pengaturan.users.datatable');
    Route::put('/pengaturan/users/{user}/status', [UserController::class, 'updateStatus'])->name('pengaturan.users.updateStatus');
    Route::put('/pengaturan/users/{user}/role', [UserController::class, 'updateRole'])->name('pengaturan.users.updateRole');
    Route::delete('/pengaturan/users/{user}', [UserController::class, 'destroy'])->name('pengaturan.users.destroy');
    // Reset Password
    Route::put('/pengaturan/reset-password', [SystemSettingController::class, 'resetPassword'])->name('pengaturan.resetPassword');
});


Route::group(['prefix' => 'hasil-ujian', 'as' => 'hasil-ujian.', 'middleware' => 'auth'], function () {
    Route::get('/', [HasilUjianController::class, 'index'])->name('index');
    Route::get('/{id}', [HasilUjianController::class, 'show'])->name('show');
    Route::get('/{id}/sertifikat', [HasilUjianController::class, 'showCertificate'])->name('certificate');
    Route::get('/download/results', [HasilUjianController::class, 'downloadResults'])->name('download');
});

Route::get('/kerjakan/{link}', [\App\Http\Controllers\UjianPesertaController::class, 'ujianLogin'])->name('ujian.login');
Route::post('/kerjakan/{link}', [\App\Http\Controllers\UjianPesertaController::class, 'generateSession'])->name('ujian.generateSession');
Route::get('/kerjakan/{link}/ujian', [\App\Http\Controllers\UjianPesertaController::class, 'ujianPeserta'])->name('ujian.peserta');
Route::post('/kerjakan/{link}/save-answer', [\App\Http\Controllers\UjianPesertaController::class, 'saveAnswer'])->name('ujian.save-answer');
Route::get('/kerjakan/{link}/submit', [\App\Http\Controllers\UjianPesertaController::class, 'submitExam'])->name('ujian.submit');

Route::group(['prefix' => 'test', 'middleware' => 'auth'], function () {
    Route::get('/{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('/{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('/{any}', [RoutingController::class, 'root'])->name('any');
});
