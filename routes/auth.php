<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('/register/verify', [RegisteredUserController::class, 'verifyForm'])->name('register.verify');
    Route::post('/register/verify', [RegisteredUserController::class, 'verifyOtp'])->name('register.verify.submit');
    Route::post('/register/resendOtp', [RegisteredUserController::class, 'resendOtp'])->name('register.verify.resend');


    Route::get('verify-otp', function (Request $request) {
        return view('auth.verify-otp', ['email' => $request->email]);
    })->name('verifyOtp');

    Route::post('verify-otp', [RegisteredUserController::class, 'verifyOtp'])->name('verifyOtp.post');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('password/verify', function (Request $request) {
        return view('auth.verify-otp', ['email' => $request->email]);
    })->name('password.verify');

    Route::post('password/verify', [PasswordResetLinkController::class, 'verify'])->name('password.verify.post');

    // Show reset password form after OTP verification
    Route::get('password/reset-form', function (Request $request) {
        return view('auth.reset-password', ['email' => $request->email]);
    })->name('password.reset.form');

    Route::post('password/reset-form', [PasswordResetLinkController::class, 'resetPassword'])->name('password.reset.post');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
