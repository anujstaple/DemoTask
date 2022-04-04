<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/productlist', [App\Http\Controllers\HomeController::class, 'productlist'])->name('home');


Route::post('/attached', [App\Http\Controllers\HomeController::class, 'attachedProduct'])->name('attached');

//admin route
Route::group(['middleware'=>['auth','admin'],'prefix'=>'admin'],function(){

Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
});
