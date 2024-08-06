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


Route::view('/', 'welcome');

Route::get('/reply',function (){
    return view('Pdf.reply');
})->name('api.reply');

// Route::group(
//     [
//         'prefix' => LaravelLocalization::setLocale(),
//         'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
//     ], function() {

//     Route::get('/',function (){
//         return redirect()->route('admin.login');
//     })->name('frontend.index');



// });
Route::post('/fawry/payment/initiate', [\App\Http\Controllers\Api\FawryApiController::class, 'initiatePayment'])->name('fawry');
Route::post('/fawry-callback', [\App\Http\Controllers\Api\FawryApiController::class, 'handleCallback']);

Route::get('/payment-form', function () {
    return view('fawry');
});

Route::get('/clear/route', function (){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('migrate');

    return 'Optimize Cleared Successfully By El Sdodey';
});


Route::get('/empty/route', function (){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('migrate:refresh');

    return 'Optimize Cleared Successfully By El Sdodey';
});


Route::get('paymob/payment', [\App\Http\Controllers\Api\Setting\PaymobController::class, 'index']);

Route::get('callback',  [\App\Http\Controllers\Api\Setting\PaymobController::class, 'callback']);

Route::get('payment', [\App\Http\Controllers\PayPalController::class, 'payment'])->name('payment');
Route::get('cancel', [\App\Http\Controllers\PayPalController::class, 'cancel'])->name('payment.cancel');
Route::get('payment/success', [\App\Http\Controllers\PayPalController::class, 'success'])->name('payment.success');