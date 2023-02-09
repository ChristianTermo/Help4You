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
Route::get('auth/facebook', 'App\Http\Controllers\api\auth\LoginController@facebookRedirect');
Route::get('auth/facebook/callback', 'App\Http\Controllers\api\auth\LoginController@loginWithFacebook');
Route::post('apple/login','api\\Auth\\AppleLoginController@login');
route::post('auth/logout', 'App\Http\Controllers\api\auth\LogoutController');

Route::post('generate/coupon', 'App\Http\Controllers\Api\CouponController@generate');
Route::post('generate/code', 'App\Http\Controllers\Api\CouponController@generateCode');

route::get('geocode', 'App\Http\Controllers\Api\ServicesController@getGeocode');

route::get('getCategories', 'App\Http\Controllers\Api\CategoriesController@getCategories');
route::post('Create/Categories', 'App\Http\Controllers\Api\CategoriesController@CreateCategories');
route::post('Update/Categories/{id}', 'App\Http\Controllers\Api\CategoriesController@UpdateCategories');
route::post('Delete/Categories/{id}', 'App\Http\Controllers\Api\CategoriesController@DeleteCategories');

route::get('verifyrole','App\Http\Controllers\Api\AdminController@verifyRole');

route::post('create/services', 'App\Http\Controllers\Api\ServicesController@create');
route::post('Update/Services/{id}', 'App\Http\Controllers\Api\ServicesController@update');
route::post('Delete/Services/{id}', 'App\Http\Controllers\Api\ServicesController@delete');

Route::post('Verify/otp', 'App\Http\Controllers\Api\Auth\RegisterController@validateOtp');
Route::post('resend/otp', 'App\Http\Controllers\Api\EditDataController@validateOtp');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('auth/update/professional', 'App\Http\Controllers\Api\UpdateController@updateToProfessional');
    Route::post('auth/update/user', 'App\Http\Controllers\Api\UpdateController@updateToUser');
    Route::post('auth/edit/phone/number', 'App\Http\Controllers\Api\Auth\EditDataController@updatePhoneNumber');
    Route::post('auth/edit/data', 'App\Http\Controllers\Api\Auth\EditDataController@updateName');   
    Route::post('auth/edit/password', 'App\Http\Controllers\Api\Auth\EditDataController@updatePassword');
    Route::post('auth/forget/password', 'App\Http\Controllers\Api\Auth\ForgotPasswordController@submitForgetPasswordForm');
    Route::post('auth/reset/password', 'App\Http\Controllers\Api\Auth\ForgotPasswordController@submitResetPasswordForm');
    Route::post('create/order', 'App\Http\Controllers\Api\CustomerOrderController@create');
    Route::post('update/order/{id}', 'App\Http\Controllers\Api\CustomerOrderController@update');
    Route::post('delete/order/{id}', 'App\Http\Controllers\Api\CustomerOrderController@delete');
    route::get('getOrders', 'App\Http\Controllers\Api\CustomerOrderController@getOrders');
});

Route::prefix('facebook')->name('facebook.')->group(function () {
    Route::get('auth/login/facebook',  'App\Http\Controllers\api\auth\LoginController@loginUsingFacebook');
    Route::get('callback',  'App\Http\Controllers\api\auth\LoginController@callbackFromFacebook');
});
