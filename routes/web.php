<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})
    ->middleware('auth', 'verified')
    ->name('welcome');

Route::prefix('auth')->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })
        ->name('login')
        ->middleware('guest');
    Route::get('register', function () {
        return view('auth.register');
    })
        ->name('register')
        ->middleware('guest');
    Route::get('logout', function () {
        return view('auth.logout');
    })
        ->middleware('auth')
        ->name('logout');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->middleware('guest')->name('password.request');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');

    Route::prefix('backend')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->name('auth.register');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('auth.login');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('auth.logout');

        Route::post('/update-password', [AuthController::class, 'updatePassword'])
            ->name('auth.update-password');

        Route::post('/delete-account', [AuthController::class, 'deleteAccount'])
            ->name('auth.delete-account');
    });
});

Route::prefix('profile')->group(function () {
    Route::get('settings', function () {
        return view('profile.account-settings', ['user' => Auth::user()]);
    })
        ->middleware('auth')
        ->name('profile.account-settings');

    Route::prefix('backend')->group(function () {
        Route::post('update-password', [AuthController::class, 'updatePasswordWithoutToken'])
            ->name('profile.update-password');

        Route::post('update-username', [AuthController::class, 'updateUsername'])
            ->name('profile.update-username');
    });
});

Route::prefix('email')->group(function () {
    Route::get('verify', function () {
        return view('auth.verify-email');
    })
        ->middleware('auth', 'unverified')
        ->name('verification.notice');

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

    Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.email');
});

