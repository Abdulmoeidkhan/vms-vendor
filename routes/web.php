<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\ActivationRequest;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ActivateProfileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileImageController;
use App\Http\Controllers\UserPanelController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\UpdateProfileController;
use App\Http\Controllers\UserFullProfileController;

Route::get('/login', function () {
    if (auth()?->user()?->uid) {
        return redirect()->route('pages.dashboard');
    } else {
        return view('pages.signIn');
    }
})->name("login");

Route::get('/accountActivation', function () {
    if (auth()?->user()?->uid) {
        return redirect()->route('pages.dashboard');
    } else {
        return view('pages.activation');
    }
})->name("accountActivation");


Route::group(['middleware' => 'auth'], function () {

    // Dashboard Routes
    Route::get('/', [DashboardController::class, 'renderView'])->name("pages.dashboard");


    // User Panel Routes
    Route::get('/userPanel', [UserPanelController::class, 'render'])->name("pages.userPanel");
    Route::get('/profileUser/{id}', [UserFullProfileController::class, 'render'])->name('pages.profileUser');
    Route::get('/userProfile/profileActivation', [ActivateProfileController::class, 'renderProfileActivation'])->name('pages.profileActivation');
    Route::post('/imageUpload', [ProfileImageController::class, 'imageBlobUpload'])->name('request.imageUpload');

    // My profile
    Route::get('/userProfile/myProfile', [UserFullProfileController::class, 'renderMyProfile'])->name('pages.myProfile');
    Route::post('/updateAuthority', [UpdateProfileController::class, 'updateAuthority'])->name('request.updateAuthority');

    // Organization 
    Route::get('/organization', [OrganizationController::class, 'render'])->name('pages.organization');
    Route::get('/getOrganization', [OrganizationController::class, 'getOrganization'])->name('request.getOrganization');

    Route::get('/addOrganization/{id?}', [OrganizationController::class, 'addOrganizationRender'])->name('pages.addOrganization');
    
    Route::post('/addOrganizationRequest', [OrganizationController::class, 'addOrganization'])->name('request.addOrganization');
    Route::post('/updateOrganizationRequest/{id?}', [OrganizationController::class, 'updateOrganization'])->name('request.updateOrganization');


    // Logout Routes
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout.request');
});

Route::post('/signInRequest', [SignInController::class, 'signIn'])->name('request.signIn');
Route::post('/signUpRequest', [SignUpController::class, 'signUp'])->name('request.signUp');
Route::post('/activationRequest', [ActivationRequest::class, 'activation'])->name('request.activation');
