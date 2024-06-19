<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BackOffice\HomeController;
use App\Http\Controllers\BackOffice\PlaceController;
use App\Http\Controllers\BackOffice\RatingController;

Route::get('/admin', function(){
    return redirect('/admin/login');
});

Route::prefix('admin')->group(function () {

    Route::get('/login', [LoginController::class, 'login']);
    Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');
    
        // place
        Route::get('/place', [PlaceController::class, 'index'])->name('place');
        Route::get('/place/get-image/{id}', [PlaceController::class, 'getImage']);
        Route::get('/place/delete/{id}', [PlaceController::class, 'delete'])->name('place.delete');
        Route::post('/place/update/{id}', [PlaceController::class, 'update'])->name('place.update');
        Route::post('/place/store', [PlaceController::class, 'store'])->name('place.store');
    
        // rating
        Route::get('/rating', [RatingController::class, 'index']);
    });

    //REGISTER
    Route::get('register', [RegisterController::class, 'register'])->name('register');
    Route::post('register/action', [RegisterController::class, 'actionregister'])->name('actionregister');
    
});