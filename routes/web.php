<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberProfileController;
use App\Http\Controllers\TournamentController;
use App\Models\Tournament;
use App\Http\Controllers\RatingController;

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

    Route::patch('/users/{user}/toggle-vip', [AdminController::class, 'toggleVip'])
    ->name('admin.users.toggle-vip');
});


Route::get('/member/profile', [MemberProfileController::class, 'show'])->name('member.profile');
Route::get('/member/qrcode/{user}', [MemberProfileController::class, 'qrCode'])->name('member.qrcode');


Route::middleware(['auth'])->group(function () {
    Route::post('/tournaments/{tournament}/register', [TournamentController::class, 'register']);
    Route::delete('/tournaments/{tournament}/register', [TournamentController::class, 'unregister']);
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/tournaments', function () {
        $tournaments = Tournament::withCount('registrations')->get();
        return Inertia::render('Admin/Tournaments', compact('tournaments'));
    });
});



Route::get('/rankings', [RatingController::class, 'index'])->name('rankings.index');

//Route::get('/users', [RatingController::class, 'index'])->name('users.index');


Route::put('/users/{user}', [RatingController::class, 'update'])->name('users.update');

require __DIR__.'/auth.php';
