<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API Routes for your application. These
| Routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('authenticate', 'App\Http\Controllers\Api\Auth\RegisterController@action');
Route::post('registertest', 'App\Http\Controllers\Api\Auth\RegisterController@registertest');
Route::post('register/professional', 'App\Http\Controllers\Api\Auth\RegisterController@registerProfessional');
//Route::post('auth/login', 'App\Http\Controllers\Api\Auth\LoginController@login');
//Route::post('apple/login', 'api\Auth\AppleLoginController@login');
Route::post('auth/logout', 'App\Http\Controllers\Api\Auth\LogoutController');
Route::post('generate/code', 'App\Http\Controllers\Api\CouponController@generateCode');
Route::post('Verify/otp', 'App\Http\Controllers\Api\Auth\RegisterController@validateOtp');
Route::post('resend/otp', 'App\Http\Controllers\Api\Auth\EditDataController@resendOtp');
Route::post('auth/forget/password', 'App\Http\Controllers\Api\Auth\ForgotPasswordController@submitForgetPasswordForm');
Route::get('average/response/time/{userId}', 'App\Http\Controllers\Api\ChatController@averageResponseTime');
Route::post('save/contacts', 'App\Http\Controllers\Api\Auth\MeController@saveContact');
Route::post('support', 'App\Http\Controllers\Api\Auth\MeController@submitSupportForm');
Route::post('update/user', 'App\Http\Controllers\Api\Auth\MeController@updateUserData');
Route::get('recommendation', 'App\Http\Controllers\Api\SocialEngineController@raccomandazioni');
Route::post('register', 'App\Http\Controllers\Api\SocialEngineController@register');
Route::get('get/categories', 'App\Http\Controllers\Api\CategoryController@getCategories');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('auth/update/professional', 'App\Http\Controllers\Api\UpdateController@updateToProfessional');
    Route::post('auth/update/user', 'App\Http\Controllers\Api\UpdateController@updateToUser');
    Route::post('auth/edit/phone/number', 'App\Http\Controllers\Api\Auth\EditDataController@updatePhoneNumber');
    Route::post('auth/edit/data', 'App\Http\Controllers\Api\Auth\EditDataController@updateName');
    Route::post('auth/edit/password', 'App\Http\Controllers\Api\Auth\EditDataController@updatePassword');
    Route::post('create/order', 'App\Http\Controllers\Api\CustomerOrderController@create');
    Route::post('update/order/{id}', 'App\Http\Controllers\Api\CustomerOrderController@update');
    Route::post('delete/order/{id}', 'App\Http\Controllers\Api\CustomerOrderController@delete');
    Route::get('get/orders', 'App\Http\Controllers\Api\CustomerOrderController@getOrders');
    Route::get('get/feedback', 'App\Http\Controllers\Api\FeedbackController@getFeedback');
    Route::post('submit/feedback/{id}', 'App\Http\Controllers\Api\FeedbackController@submitFeedback');
    Route::post('create/services', 'App\Http\Controllers\Api\ServicesController@create');
    Route::post('update/services/{id}', 'App\Http\Controllers\Api\ServicesController@update');
    Route::post('delete/services/{id}', 'App\Http\Controllers\Api\ServicesController@delete');
    Route::get('get/services', 'App\Http\Controllers\Api\ServicesController@getServices');
    Route::get('get/proposals', 'App\Http\Controllers\Api\CustomerOrderController@getProposals');
    Route::post('create/proposal/{id}', 'App\Http\Controllers\Api\ServicesController@makeProposal');
    Route::post('accept/proposal/{id}', 'App\Http\Controllers\Api\CustomerOrderController@acceptProposal');
    Route::post('message', 'App\Http\Controllers\Api\ChatController@message');
    Route::get('retrieve/messages/{to_id}', 'App\Http\Controllers\Api\ChatController@retrieveMessages');
    Route::post('stripePayment', 'App\Http\Controllers\Api\PaymentController@stripePayment');
    Route::post('paypalPayment', 'App\Http\Controllers\Api\PaymentController@postPaymentWithpaypal');
    Route::post('reverseTransactions/{id}', 'App\Http\Controllers\Api\PaymentController@reverseTransactions');
    Route::post('disable', 'App\Http\Controllers\Api\Auth\MeController@disableProfile');
});

Route::prefix('facebook')->name('facebook.')->group(function () {
    Route::get('auth/login/facebook',  'App\Http\Controllers\Api\Auth\LoginController@loginUsingFacebook');
    Route::get('callback',  'App\Http\Controllers\Api\Auth\LoginController@callbackFromFacebook');
});
