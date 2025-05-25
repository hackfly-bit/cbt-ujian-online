<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\BankSoalController;


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

Route::group(['prefix' => 'filter', 'middleware' => 'auth'], function () {
    Route::get('/tingkat-kesulitan', [BankSoalController::class, 'getTingkatKesulitan']);
    Route::get('/kategori', [BankSoalController::class, 'getKategori']);
    Route::get('/sub-kategori/{kategoriId}', [BankSoalController::class, 'getSubKategori']);
});


Route::group(['prefix' => 'bank-soal', 'as' => 'bank-soal.', 'middleware' => 'auth'], function () {
    Route::get('/', [BankSoalController::class, 'index'])->name('index');
    Route::post('/', [BankSoalController::class, 'store'])->name('store');
    Route::put('/{id}', [BankSoalController::class, 'update'])->name('update');
    Route::delete('/{id}', [BankSoalController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [BankSoalController::class, 'show'])->name('show');
});
