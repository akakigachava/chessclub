<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberProfileController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/users/{user}/approve', [AdminController::class, 'approve'])->name('admin.users.approve');
    Route::post('/users/{user}/reject', [AdminController::class, 'reject'])->name('admin.users.reject');

    Route::post('/tournaments', [AdminController::class, 'createTournament'])->name('admin.tournaments.create');

    Route::put('/admin/tournaments/{tournament}', [AdminController::class, 'updateTournament'])->name('admin.tournaments.update');
    Route::delete('/admin/tournaments/{tournament}', [AdminController::class, 'destroyTournament'])->name('admin.tournaments.destroy');
});


Route::get('/member/profile', [MemberProfileController::class, 'show'])->name('member.profile');
Route::get('/member/qrcode/{user}', [MemberProfileController::class, 'qrCode'])->name('member.qrcode');

require __DIR__.'/auth.php';
