<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('apple/login', 'api\\Auth\\AppleLoginController@login');
route::post('auth/logout', 'App\Http\Controllers\api\auth\LogoutController');


Route::post('generate/code', 'App\Http\Controllers\Api\CouponController@generateCode');

Route::post('message', 'App\Http\Controllers\Api\ChatController@message');

Route::post('Verify/otp', 'App\Http\Controllers\Api\Auth\RegisterController@validateOtp');
Route::post('resend/otp', 'App\Http\Controllers\Api\Auth\EditDataController@resendOtp');

Route::post('auth/forget/password', 'App\Http\Controllers\Api\Auth\ForgotPasswordController@submitForgetPasswordForm');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('auth/update/professional', 'App\Http\Controllers\Api\UpdateController@updateToProfessional');
    Route::post('auth/update/user', 'App\Http\Controllers\Api\UpdateController@updateToUser');
    Route::post('auth/edit/phone/number', 'App\Http\Controllers\Api\Auth\EditDataController@updatePhoneNumber');
    Route::post('auth/edit/data', 'App\Http\Controllers\Api\Auth\EditDataController@updateName');
    Route::post('auth/edit/password', 'App\Http\Controllers\Api\Auth\EditDataController@updatePassword');
    Route::post('create/order', 'App\Http\Controllers\Api\CustomerOrderController@create');
    Route::post('update/order/{id}', 'App\Http\Controllers\Api\CustomerOrderController@update');
    Route::post('delete/order/{id}', 'App\Http\Controllers\Api\CustomerOrderController@delete');
    route::get('getOrders', 'App\Http\Controllers\Api\CustomerOrderController@getOrders');
    route::get('getCategories', 'App\Http\Controllers\Api\CategoryController@getCategories');
    route::get('getFeedback', 'App\Http\Controllers\Api\FeedbackController@getFeedback');
    Route::post('submitFeedback/{id}', 'App\Http\Controllers\Api\FeedbackController@submitFeedback');
    route::post('create/services', 'App\Http\Controllers\Api\ServicesController@create');
    route::post('Update/Services/{id}', 'App\Http\Controllers\Api\ServicesController@update');
    route::post('Delete/Services/{id}', 'App\Http\Controllers\Api\ServicesController@delete');
    route::get('getServices', 'App\Http\Controllers\Api\CustomerOrderController@getServices');
    route::get('getProposals', 'App\Http\Controllers\Api\CustomerOrderController@getProposals');
    route::post('create/proposal/{id}', 'App\Http\Controllers\Api\ServicesController@makeProposal');
    Route::post('acceptProposal/{id}', 'App\Http\Controllers\Api\CustomerOrderController@acceptProposal');
});

Route::prefix('facebook')->name('facebook.')->group(function () {
    Route::get('auth/login/facebook',  'App\Http\Controllers\api\auth\LoginController@loginUsingFacebook');
    Route::get('callback',  'App\Http\Controllers\api\auth\LoginController@callbackFromFacebook');
});
