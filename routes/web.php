<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Form\FormController;
use App\Http\Controllers\Front\IndexController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'register'])->name('auth.register');
    Route::get('/login', [LoginController::class, 'login'])->name('auth.login');
});


Route::post('/verify-sms', [RegisterController::class, 'sendSms'])->name('register.verify.sms');
Route::post('/verify-sms-auth', [LoginController::class, 'sendSmsAuth'])->name('auth.verify.sms');

Route::match(['get', 'post'], '/verify-success-register', [\App\Http\Controllers\Auth\AuthController::class, 'verifySms'])->name('auth.verify.success');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/', [IndexController::class, 'index'])->name('front.index');
    Route::post('/form/send', [FormController::class, 'send'])->name('form.send');

});
