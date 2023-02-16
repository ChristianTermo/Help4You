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

Route::get('/', function () {
    return view('welcome');
});
route::get('getPanel', 'App\Http\Controllers\Api\AdminController@getPanel')->name('getPanel');
route::get('login', 'App\Http\Controllers\Api\AdminController@getLogin')->name('login');
Route::post('custom-login', [AdminController::class, 'customLogin'])->name('login.custom'); 
Route::get('categorie', [AdminController::class, 'categories'])->name('categorie');
Route::get('user', [AdminController::class, 'users'])->name('user');
Route::resource('categories', CategoryController::class);
Route::get('logoutadmin', [AdminController::class, 'logout'])->name('logoutadmin');

Route::get('auth/facebook', 'App\Http\Controllers\api\auth\LoginController@facebookRedirect');
Route::get('auth/facebook/callback', 'App\Http\Controllers\api\auth\LoginController@loginWithFacebook');
Route::get('auth/login/google', 'App\Http\Controllers\api\auth\LoginController@redirect');
Route::get('login/google/callback', 'App\Http\Controllers\api\auth\LoginController@loginByGoogle');

Route::put('editCat/{id}', [CategoryController::class, 'update'])->name('editCat');