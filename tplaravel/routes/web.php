<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\postController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/meal/create', function () {
        return view('meal.create');
    });
});

// meals

Route::middleware(['auth', 'admin'])->get('/meal/{id}/edit', [PostController::class, 'Edit'])
    ->name('meal.redirect.edit');

Route::middleware(['auth', 'user'])->get('/meals', [PostController::class, 'Meals'])
    ->name('meals.show');

Route::middleware(['auth', 'user'])->get('/meal/{id}', [PostController::class, 'Meal'])
    ->name('meal.show');

Route::middleware(['auth', 'user'])->get('/deleteMeal/{id}', [PostController::class, 'DeleteMeal'])
    ->name('meal.delete');

Route::middleware(['auth', 'admin'])->post('/editMeal/{id}', [PostController::class, 'EditPost'])
    ->name('meal.edit');

Route::middleware(['auth', 'admin'])->post('/createMeal', [PostController::class, 'MealPost'])
    ->name('meal.create');

// favorite

Route::middleware(['auth', 'user'])->get('/favoritesCount', [FavoriteController::class, 'FavoritesCount'])
    ->name('favorites.count');

Route::middleware(['auth', 'user'])->get('/userFavorites/{id}', [FavoriteController::class, 'FavoriteUser'])
    ->name('favoritesUser.show');

Route::middleware(['auth', 'user'])->get('/userFavoritePost/{userId}/{postId}', [FavoriteController::class, 'FavoriteUserPost'])
    ->name('favoritesUserPost.show');

Route::middleware(['auth', 'user'])->get('/userToggleFavorite/{postId}', [FavoriteController::class, 'ChangeFavorite'])
    ->name('toggleUserPost.show');

Route::middleware(['auth', 'user'])->get('/mealFavoriteCount/{postId}', [FavoriteController::class, 'FavoritesPostCount'])
    ->name('mealFavoriteCount.show');

require __DIR__.'/auth.php';
