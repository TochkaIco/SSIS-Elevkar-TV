<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventImageController;
use App\Http\Controllers\SessionsUserController;
use App\Http\Controllers\StepController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('event.show');

Route::get('/tv', [EventController::class, 'tv'])->name('tv');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [SessionsUserController::class, 'destroy']);

    Route::middleware(EnsureUserIsAdmin::class)->group(function () {
        Route::get('/admin', [EventController::class, 'index'])->name('admin.events.index');
        Route::get('/admin/events/{event}', [EventController::class, 'show'])->name('admin.event.show');
        Route::post('/admin/events', [EventController::class, 'store'])->name('admin.event.store');
        Route::patch('/admin/events/{event}', [EventController::class, 'update'])->name('admin.event.update');
        Route::patch('/steps/{step}', [StepController::class, 'update'])->name('admin.step.update');
        Route::delete('/admin/events/{event}', [EventController::class, 'destroy'])->name('admin.event.destroy');
        Route::delete('/admin/events/{event}/image', [EventImageController::class, 'destroy'])->name('admin.event.image.destroy');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionsUserController::class, 'create'])->name('login');

    Route::get('/auth/redirect', function () {
        return Socialite::driver('google')->redirect();
    })->name('auth.google');

    Route::get('/api/auth/callback/google', [SessionsUserController::class, 'store']);
});
