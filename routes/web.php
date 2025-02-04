<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::get('/', [UserController::class, 'create'])->name('user.create');
Route::post('/store-users', [UserController::class, 'store'])->name('user.store');
Route::post('/import-users', [UserController::class, 'importUsers'])->name('user.import');
Route::get('/export-users', [UserController::class, 'exportUsers'])->name('user.export');