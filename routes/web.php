<?php

use App\Http\Controllers\PaymentController;
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

include __DIR__.'/back-office.php';
include __DIR__.'/frontend.php';

// payment
Route::post('/payment', [PaymentController::class, 'createTransaction']);
Route::post('/payment/notification', [PaymentController::class, 'notificationHandler']);