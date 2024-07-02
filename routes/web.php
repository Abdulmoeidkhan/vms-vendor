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
use App\Http\Middleware\Admin;
use App\Http\Middleware\Organization;
use App\Http\Middleware\Authenticate;

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

Route::post('/signInRequest', [SignInController::class, 'signIn'])->name('request.signIn');
Route::post('/signUpRequest', [SignUpController::class, 'signUp'])->name('request.signUp');
Route::post('/activationRequest', [ActivationRequest::class, 'activation'])->name('request.activation');


Route::group(['middleware' => 'auth'], function () {

    // Dashboard Routes
    Route::get('/', [DashboardController::class, 'renderView'])->name("pages.dashboard");


    Route::get('/profileUser/{id}', [UserFullProfileController::class, 'render'])->name('pages.profileUser');
    Route::get('/userProfile/profileActivation', [ActivateProfileController::class, 'renderProfileActivation'])->name('pages.profileActivation');
    Route::post('/imageUpload', [ProfileImageController::class, 'imageBlobUpload'])->name('request.imageUpload');
    Route::post('/updateProfile', [UpdateProfileController::class, 'updateProflie'])->name('request.updateProfile');
    Route::post('/updateProfilePassowrd', [UpdateProfileController::class, 'updatePassword'])->name('request.updatePassword');
    Route::post('/activateProfile', [ActivateProfileController::class, 'activateProfile'])->name('request.activateProfile');

    // Logout Routes
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout.request');

    Route::middleware('adminCheck')->group(function () {

        // User Panel Routes
        Route::get('/userPanel', [UserPanelController::class, 'render'])->name("pages.userPanel");


        // My profile
        Route::get('/userProfile/myProfile', [UserFullProfileController::class, 'renderMyProfile'])->name('pages.myProfile');
        Route::post('/updateAuthority', [UpdateProfileController::class, 'updateAuthority'])->name('request.updateAuthority');

        // Organizations
        Route::get('/organizations', [OrganizationController::class, 'render'])->name('pages.organizations');
        Route::get('/getOrganizations', [OrganizationController::class, 'getOrganizations'])->name('request.getOrganizations');
        Route::get('/addOrganization/{id?}', [OrganizationController::class, 'addOrganizationRender'])->name('pages.addOrganization');
        Route::post('/addOrganizationRequest', [OrganizationController::class, 'addOrganization'])->name('request.addOrganization');
        Route::post('/updateOrganizationRequest/{id}', [OrganizationController::class, 'updateOrganization'])->name('request.updateOrganization');
    });

    Route::middleware('orgCheck')->group(function () {
        // Organization
        Route::get('/organization/{id}', [OrganizationController::class, 'renderOrganisation'])->name('pages.organization');
        Route::get('/getOrganizationStaff/{id}', [OrganizationController::class, 'getOrganizationStaff'])->name('request.getOrganizationStaff');
        Route::get('/organization/{id}/addOrganizationStaff/{staffId?}', [OrganizationController::class, 'addOrganizationStaffRender'])->name('pages.addOrganizationStaff');
        Route::post('/addOrganizationStaffRequest/{id}', [OrganizationController::class, 'addOrganizationStaff'])->name('request.addOrganizationStaff');
        Route::post('/updateOrganizationStaffRequest/{staffId?}', [OrganizationController::class, 'updateOrganizationStaff'])->name('request.updateOrganizationStaff');
    });
});
