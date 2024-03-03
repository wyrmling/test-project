<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth;

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
})->name('welcome');

Route::get('register', [Auth\RegisterController::class, 'show'])->name('register');
Route::post('register', [Auth\RegisterController::class, 'register']);
Route::get('login', fn() => view('login'))->name('login');
