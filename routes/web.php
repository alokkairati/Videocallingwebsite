<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MeetingController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\GuestMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('signup', function(){
//     return view('auth.singup');
// })->name('signup');

    Route::middleware(['Guest'])->group(function () {
        Route::get('/', [AuthController::class, 'login'])->name('login');
        Route::get('signup', [AuthController::class, 'signup'])->name('signup');
        Route::post('signin-post',[AuthController::class,'signin_post'])->name('auth.login.post');
        Route::post('signup-post',[AuthController::class,'signup_post'])->name('auth.signup.post');
    });

    Route::middleware(['Auth'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('panel.dashboard');
        
        Route::get('/start-meeting/{id}', [MeetingController::class, 'start_meeting'])->name('panel.start.meeting');
        // Route::post('/save-meeting', [MeetingController::class, 'store'])->name('save.meeting');
        Route::post('/send-invitation', [MeetingController::class, 'saveInvitation'])->name('save.invitation');
        Route::get('/join-meeting', [MeetingController::class, 'joinMeeting'])->name('join.meeting');
        Route::get('/previous-meeting', [MeetingController::class, 'previousMeeting'])->name('previous.meeting');
        
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    });