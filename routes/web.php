<?php

// routes/web.php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
// ... (All other controller imports)
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GameManagementController;
use App\Http\Controllers\Admin\TournamentManagementController;
use App\Http\Controllers\Admin\ReviewManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Games
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{slug}', [GameController::class, 'show'])->name('games.show');

// Tournaments
Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/{slug}', [TournamentController::class, 'show'])->name('tournaments.show');

// Teams
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{slug}', [TeamController::class, 'show'])->name('teams.show');

// Matches
Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
Route::get('/matches/{id}', [MatchController::class, 'show'])->name('matches.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    //  FIX: ADDED GENERIC USER DASHBOARD ROUTE 
    // This defines the route named 'dashboard' for all authenticated users
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    //  END FIX
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Games - CRUD
    Route::get('/games/create/new', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{slug}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{slug}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{slug}', [GameController::class, 'destroy'])->name('games.destroy');
    
    // Game Rating
    Route::post('/games/{slug}/rate', [GameController::class, 'rate'])->name('games.rate');
    
    // Game Reviews
    Route::post('/games/{slug}/reviews', [ReviewController::class, 'storeGameReview'])->name
    ('games.reviews.store');
    Route::put('/reviews/games/{id}', [ReviewController::class, 'updateGameReview'])->name
    ('games.reviews.update');
    Route::delete('/reviews/games/{id}', [ReviewController::class, 'deleteGameReview'])->name
    ('games.reviews.destroy');
    Route::post('/reviews/games/{id}/helpful', [ReviewController::class, 'markGameReviewHelpful'])->name
    ('games.reviews.helpful');

    // Tournaments - CRUD
    Route::get('/tournaments/create/new', [TournamentController::class, 'create'])->name
    ('tournaments.create');
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
    
    Route::post('/tournaments', [TournamentController::class, 'store'])->name
    ('tournaments.store');
    Route::get('/tournaments/{slug}/edit', [TournamentController::class, 'edit'])->name
    ('tournaments.edit');
    Route::put('/tournaments/{slug}', [TournamentController::class, 'update'])->name
    ('tournaments.update');
    Route::delete('/tournaments/{slug}', [TournamentController::class, 'destroy'])->name
    ('tournaments.destroy');
    
    // Tournament Registration
    Route::post('/tournaments/{slug}/register', [TournamentController::class, 'register'])->name('tournaments.register');
    Route::post('/tournaments/{slug}/fixtures', [TournamentController::class, 'generateFixtures'])->name('tournaments.generate-fixtures');
    Route::get('/tournaments/{slug}/leaderboard', [TournamentController::class, 'leaderboard'])->name('tournaments.leaderboard');

    // Teams - CRUD
    Route::get('/teams/create/new', [TeamController::class, 'create'])->name
    ('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{slug}/edit', [TeamController::class, 'edit'])->name
    ('teams.edit');
    Route::put('/teams/{slug}', [TeamController::class, 'update'])->name
    ('teams.update');
    Route::delete('/teams/{slug}', [TeamController::class, 'destroy'])->name
    ('teams.destroy');
    
    // Team Members
    Route::get('/teams/{slug}/members', [TeamController::class, 'manageMembers'])->name('teams.members');
    Route::post('/teams/{slug}/members', [TeamController::class, 'addMember'])->name('teams.members.add');
    Route::delete('/teams/{slug}/members/{userId}', [TeamController::class, 'removeMember'])->name('teams.members.remove');

    // Matches
    Route::get('/tournaments/{slug}/matches/create', [MatchController::class, 'create'])->name('matches.create');
    Route::post('/tournaments/{slug}/matches', [MatchController::class, 'store'])->name('matches.store');
    Route::put('/matches/{id}/score', [MatchController::class, 'updateScore'])->name('matches.update-score');
    Route::post('/matches/{id}/performance', [MatchController::class, 'addPerformance'])->name('matches.add-performance');
    
    // Match Reviews
    Route::post('/matches/{id}/reviews', [ReviewController::class, 'storeMatchReview'])->name('matches.reviews.store');
    Route::put('/reviews/matches/{id}', [ReviewController::class, 'updateMatchReview'])->name('matches.reviews.update');
    Route::delete('/reviews/matches/{id}', [ReviewController::class, 'deleteMatchReview'])->name('matches.reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Full name: 'admin.dashboard'

    // Games Management
    Route::get('/games', [GameManagementController::class, 'index'])->name('games.index');
    Route::post('/games/{id}/toggle-status', [GameManagementController::class, 'toggleStatus'])->name('games.toggle-status');
    Route::delete('/games/{id}', [GameManagementController::class, 'destroy'])->name('games.destroy');

    // Tournaments Management
    Route::get('/tournaments', [TournamentManagementController::class, 'index'])->name('tournaments.index');
    Route::get('/tournaments/{id}/registrations', [TournamentManagementController::class, 'registrations'])->name('tournaments.registrations');
    Route::post('/registrations/{id}/approve', [TournamentManagementController::class, 'approveRegistration'])->name('registrations.approve');
    Route::post('/registrations/{id}/reject', [TournamentManagementController::class, 'rejectRegistration'])->name('registrations.reject');
    Route::put('/tournaments/{id}/status', [TournamentManagementController::class, 'updateStatus'])->name('tournaments.update-status');

    // Reviews Management
    Route::get('/reviews/games', [ReviewManagementController::class, 'gameReviews'])->name('reviews.games');
    Route::post('/reviews/games/{id}/approve', [ReviewManagementController::class, 'approveGameReview'])->name('reviews.games.approve');
    Route::delete('/reviews/games/{id}/reject', [ReviewManagementController::class, 'rejectGameReview'])->name('reviews.games.reject');
    
    Route::get('/reviews/matches', [ReviewManagementController::class, 'matchReviews'])->name('reviews.matches');
    Route::post('/reviews/matches/{id}/approve', [ReviewManagementController::class, 'approveMatchReview'])->name('reviews.matches.approve');
    Route::delete('/reviews/matches/{id}/reject', [ReviewManagementController::class, 'rejectMatchReview'])->name('reviews.matches.reject');

    // Users Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserManagementController::class, 'show'])->name('users.show');
    Route::put('/users/{id}/role', [UserManagementController::class, 'updateRole'])->name('users.update-role');
    Route::post('/users/{id}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});
