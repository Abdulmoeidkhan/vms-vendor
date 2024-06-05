<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\ActivationRequest;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ActivateProfileController;


Route::get('/signIn', function () {
    if (auth()?->user()?->uid) {
        return redirect()->route('pages.dashboard');
    } else {
        return view('pages.signIn');
    }
})->name("signIn");

Route::get('/accountActivation', function () {
    if (auth()?->user()?->uid) {
        return redirect()->route('pages.dashboard');
    } else {
        return view('pages.activation');
    }
})->name("accountActivation");

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'renderView'])->name("pages.dashboard");
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout.request');
    Route::get('/userProfile/profileActivation', [ActivateProfileController::class, 'renderProfileActivation'])->name('pages.profileActivation');
});

Route::post('/signInRequest', [SignInController::class, 'signIn'])->name('request.signIn');
Route::post('/activationRequest', [ActivationRequest::class, 'activation'])->name('request.activation');

