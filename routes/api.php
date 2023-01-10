<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('auth/register', 'App\Http\Controllers\Api\Auth\RegisterController@action');
Route::post('auth/login', 'App\Http\Controllers\api\auth\LoginController');
Route::POST('auth/login/google', 'App\Http\Controllers\api\auth\LoginController@loginByGoogle');
route::post('auth/logout', 'App\Http\Controllers\api\auth\LogoutController');

route::get('getCategories', 'App\Http\Controllers\Api\CategoriesController@getCategories');
route::post('Create/Categories', 'App\Http\Controllers\Api\CategoriesController@CreateCategories');
route::post('update/Categories', 'App\Http\Controllers\Api\CategoriesController@UpdateCategories');
route::post('Delete/Categories', 'App\Http\Controllers\Api\CategoriesController@DeleteCategories');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('auth/update/professional', 'App\Http\Controllers\Api\UpdateController@updateToProfessional');
    Route::post('auth/update/user', 'App\Http\Controllers\Api\UpdateController@updateToUser');
    Route::post('auth/edit/phone/number', 'App\Http\Controllers\Api\Auth\EditDataController@updatePhoneNumber');
    Route::post('auth/edit/data', 'App\Http\Controllers\Api\Auth\EditDataController@updateName');   
    Route::post('auth/edit/password', 'App\Http\Controllers\Api\Auth\EditDataController@updatePassword');
    Route::post('auth/forget/password', 'App\Http\Controllers\Api\Auth\ForgotPasswordController@submitForgetPasswordForm');
    Route::post('auth/reset/password', 'App\Http\Controllers\Api\Auth\ForgotPasswordController@submitResetPasswordForm');
    Route::post('create/order', 'App\Http\Controllers\Api\CustomerOrderController@create');
    Route::post('update/order', 'App\Http\Controllers\Api\CustomerOrderController@update');
    Route::post('delete/order', 'App\Http\Controllers\Api\CustomerOrderController@delete');
});

Route::prefix('facebook')->name('facebook.')->group(function () {
    Route::get('auth/login/facebook',  'App\Http\Controllers\api\auth\LoginController@loginUsingFacebook');
    Route::get('callback',  'App\Http\Controllers\api\auth\LoginController@callbackFromFacebook');
});
