<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\productController;
use App\Http\Controllers\TransaksiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'apiLogin']);

Route::post('/midtrans/callback', [Controller::class, 'notificationHandler']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/products', [productController::class, 'product']);
Route::post('/transaksi', [TransaksiController::class, 'store']);

