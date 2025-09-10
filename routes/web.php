<?php

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('register', function () {
        return view('auth.register');
    })->name('register');
    Route::get('logout', function () {
        return view('auth.logout');
    });

    Route::prefix('backend')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->name('auth.register');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('auth.login');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('auth.logout');
    });
});

Route::prefix('email')->group(function () {
    Route::get('verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('verification-notification', function () {
        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            return "Your email has already been verified.";
        }
        Auth::user()->sendEmailVerificationNotification();
        return "Verification link sent!";
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

