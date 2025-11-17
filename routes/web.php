<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;

// Game Routes
Route::get('/', [GameController::class, 'board'])->name('game.board');
Route::get('/game/create', [GameController::class, 'create'])->name('game.create');
Route::post('/game', [GameController::class, 'store'])->name('game.store');
Route::get('/game/{game}', [GameController::class, 'play'])->name('game.play');
Route::post('/game/{game}/answer', [GameController::class, 'answer'])->name('game.answer');
Route::get('/game/{game}/end', [GameController::class, 'end'])->name('game.end');
Route::get('/question/{id}', [GameController::class, 'showQuestion'])->name('question.show');
Route::get('/rules', [GameController::class, 'rules'])->name('game.rules');
Route::get('/main-title', [GameController::class, 'mainTitle'])->name('game.mainTitle');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::post('/export', [AdminController::class, 'export'])->name('admin.export');
    Route::post('/import', [AdminController::class, 'import'])->name('admin.import');
    
    // Category Routes
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    
    // Question Routes
    Route::resource('questions', QuestionController::class);
});
