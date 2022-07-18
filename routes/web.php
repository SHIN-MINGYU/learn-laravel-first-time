<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();



// 色々なactionの書き方を学んでいますので悪く見ないでくださいT.T

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/create', [HomeController::class, 'create'])->name('create');
Route::post('/store',[HomeController::class,'store'])->name('stroe');
Route::get('/edit/{id}',[HomeController::class,'edit'])->name('edit');
Route::post('/update/{id}',[HomeController::class,'update'])->name('update');
Route::post('/delete/{id}',[HomeController::class,'delete'])->name('delete');