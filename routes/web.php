<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CategoryController;
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


route::get('getPanel', 'App\Http\Controllers\Api\AdminController@getPanel')->name('getPanel');
route::get('/', 'App\Http\Controllers\Api\AdminController@getLogin')->name('login');
Route::post('custom-login', 'App\Http\Controllers\Api\AdminController@customLogin')->name('login.custom'); 
Route::get('categorie', 'App\Http\Controllers\Api\AdminController@categories')->name('categorie');
Route::get('user', 'App\Http\Controllers\Api\AdminController@users')->name('user');
Route::resource('categories', CategoryController::class);
Route::get('logoutadmin',  'App\Http\Controllers\Api\AdminController@logout')->name('logoutadmin');

route::get('getCouponPage', 'App\Http\Controllers\Api\CouponController@getCouponPage')->name('getCouponPage');
Route::post('generate/coupon', 'App\Http\Controllers\Api\CouponController@generate')->name('generate');

route::get('getTransactions', 'App\Http\Controllers\Api\PaymentController@getTransactions')->name('getTransactions');

Route::get('auth/facebook', 'App\Http\Controllers\api\auth\LoginController@facebookRedirect');
Route::get('auth/facebook/callback', 'App\Http\Controllers\api\auth\LoginController@loginWithFacebook');
Route::get('auth/login/google', 'App\Http\Controllers\api\auth\LoginController@redirect');
Route::get('login/google/callback', 'App\Http\Controllers\api\auth\LoginController@loginByGoogle');
