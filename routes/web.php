<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;

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

//********   Website Section  *********//
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::post('/search', [HomeController::class, 'search'])->name('search');


// ADMIN LOGIN & LOGOUT
Route::get('/admin-login', [AdminController::class, 'index'])->name('admin.login');
Route::post('/post-login', [AdminController::class, 'login'])->name('post.login');
Route::post('/admin-logout', [AdminController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')->middleware(['auth'])->group(function(){

    // Dashboard
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    // Product Module
    Route::get('/products', [ProductController::class, 'index'])->name('all.product');
    Route::post('/product/store', [ProductController::class, 'store'])->name('store.product');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('edit.product');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('update.product');
    Route::get('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy.product');



});
