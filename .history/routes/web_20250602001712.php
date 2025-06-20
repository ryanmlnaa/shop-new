<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\transaksiAdminController;


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

Route::get('/', [TransaksiController::class, 'index'])->name('home');
Route::post('/addToCart', [TransaksiController::class, 'addToCart'])->name('addToCart');
Route::POST('/storePelanggan', [UserController::class, 'storePelanggan'])->name('storePelanggan');
Route::POST('/login_pelanggan', [UserController::class, 'loginProses'])->name('loginproses.pelanggan');
Route::GET('/logout_pelanggan', [UserController::class, 'logout'])->name('logout.pelanggan');

Route::get('/shop', [Controller::class, 'shop'])->name('shop');
Route::get('/transaksi', [Controller::class, 'transaksi'])->name('transaksi');
Route::get('/contact', [Controller::class, 'contact'])->name('contact');

Route::post('/checkout', [Controller::class, 'checkout'])->name('checkout');
Route::post('/checkout/proses/{id}', [Controller::class, 'prosesCheckout'])->name('checkout.product');
Route::post('/checkout/prosesPembayaran', [Controller::class, 'prosesPembayaran'])->name('checkout.bayar');
Route::get('/checkOut', [Controller::class, 'keranjang'])->name('keranjang');
Route::get('/checkOut/{id}', [Controller::class, 'bayar'])->name('keranjang.bayar');

Route::get('/admin', [Controller::class, 'login'])->name('login');
Route::post('/admin/loginProses', [Controller::class, 'loginProses'])->name('loginProses');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/dashboard', [Controller::class, 'admin'])->name('admin');
    Route::get('/admin/product', [ProductController::class, 'index'])->name('product');
    Route::get('/admin/logout', [Controller::class, 'logout'])->name('logout');
    Route::get('/admin/report', [Controller::class, 'report'])->name('report');
    Route::get('/admin/addModal', [ProductController::class, 'addModal'])->name('addModal');

    Route::GET('/admin/user_management', [UserController::class, 'index'])->name('userManagement');
    Route::GET('/admin/user_management/addModalUser', [UserController::class, 'addModalUser'])->name('addModalUser');
    Route::POST('/admin/user_management/addData', [UserController::class, 'store'])->name('addDataUser');
    Route::get('/admin/user_management/editUser/{id}', [UserController::class, 'show'])->name('showDataUser');
    Route::PUT('/admin/user_management/updateDataUser/{id}', [UserController::class, 'update'])->name('updateDataUSer');
    Route::DELETE('/admin/user_management/deleteUSer/{id}', [UserController::class, 'destroy'])->name('destroyDataUser');

    Route::post('/admin/addData', [ProductController::class, 'store'])->name('addData');
    Route::get('/admin/editModal/{id}/', [ProductController::class, 'show'])->name('editModal');
    Route::put('/admin/updateData/{id}', [ProductController::class, 'update'])->name('updateData');
    Route::delete('/admin/deleteData/{id}', [ProductController::class, 'destroy'])->name('deleteData');
    Route::post('/predict-Gender', [ProductController::class, 'predictGender']);

    Route::post('/predict-flask', [ProductController::class, 'predictFromFlask']);

    Route::get('/admin/transaksi', [TransaksiController::class, 'index'])->name('transaksi.admin');
    Route::post('/midtrans/callback', [Controller::class, 'notificationHandler']);

    Route::GET('/admin/transaksi', [TransaksiAdminController::class, 'index'])->name('transaksi.admin');
    Route::delete('/cart/{id}', [transaksiController::class, 'destroy'])->name('cart.delete');



});
