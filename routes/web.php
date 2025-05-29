<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\UjianController;

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

Route::group(['prefix' => 'test', 'middleware' => 'auth'], function () {
    Route::get('/{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('/{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('/{any}', [RoutingController::class, 'root'])->name('any');
});

Route::get('/', [RoutingController::class, 'index'])->name('root');
Route::get('/home', fn() => view('index'))->name('home');



Route::group(['prefix' => 'bank-soal', 'as' => 'bank-soal.', 'middleware' => 'auth'], function () {
    Route::get('/', [BankSoalController::class, 'index'])->name('index');
    Route::post('/', [BankSoalController::class, 'store'])->name('store');
    Route::put('/{id}', [BankSoalController::class, 'update'])->name('update');
    Route::delete('/{id}', [BankSoalController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [BankSoalController::class, 'show'])->name('show');
});


Route::group(['prefix' => 'ujian', 'as' => 'ujian.', 'middleware' => 'auth'], function () {
    Route::get('/', [UjianController::class, 'index'])->name('index');
    Route::post('/', [UjianController::class, 'store'])->name('store');
    Route::put('/{id}', [UjianController::class, 'update'])->name('update');
    Route::delete('/{id}', [UjianController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [UjianController::class, 'show'])->name('show');
});


Route::group(['prefix' => 'filter', 'as' => 'filter.', 'middleware' => 'auth'], function () {
    Route::get('/soals', [FilterController::class, 'getSoals'])->name('soals');
    Route::get('/tingkat-kesulitan', [FilterController::class, 'getTingkatKesulitan'])->name('tingkat-kesulitan');
    Route::get('/kategori', [FilterController::class, 'getKategori'])->name('kategori');
    Route::get('/sub-kategori/{kategoriId}', [FilterController::class, 'getSubKategori'])->name('sub-kategori');
});
