<?php

use Illuminate\Support\Facades\Auth;



use Illuminate\Support\Facades\Route;





use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\Fk_MovieController;

// Đăng ký các route auth (login, register, password...)
Auth::routes();

// Trang chủ sau khi đăng nhập
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/movies', [HomeController::class, 'movies'])->name('client.movies');
Route::get('/show', [HomeController::class, 'show'])->name('client.show');
Route::get('/showtimes', [HomeController::class, 'showtimes'])->name('client.showtimes');

// Trang admin chính (chưa qua middleware kiểm tra quyền admin)
Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.index');


Route::macro('adminResource', function ($prefix, $controller) {
    Route::prefix($prefix)->middleware(['auth', 'admin'])->name(str_replace('/', '.', $prefix) . '.')->group(function () use ($controller, $prefix) {
        Route::get('/trash', [$controller, 'trash'])->name('trash');
        Route::get('/create', [$controller, 'create'])->name('create');
        Route::post('/{id}/restore', [$controller, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [$controller, 'forceDelete'])->name('forceDelete');
        Route::get('/{id}/edit', [$controller, 'edit'])->name('edit');
        Route::get('/{id}', [$controller, 'show'])->name('show');
        Route::put('/{id}', [$controller, 'update'])->name('update');
        Route::delete('/{id}', [$controller, 'destroy'])->name('destroy');
        Route::get('/', [$controller, 'index'])->name('index');
        Route::post('/', [$controller, 'store'])->name('store');
    });
});

// Áp dụng cho các nhóm lặp
Route::adminResource('admin/users', UserController::class);
Route::adminResource('admin/actors', ActorController::class);
Route::adminResource('admin/countries', CountryController::class);
Route::adminResource('admin/genres', GenreController::class);
Route::adminResource('admin/directors', DirectorController::class);
Route::adminResource('admin/movies', MovieController::class);

// Cinema group (vì nested đặc biệt nên vẫn tách riêng)
Route::prefix('admin/cinemas')->middleware(['auth', 'admin'])->name('admin.cinemas.')->group(function () {
    Route::get('/trash', [CinemaController::class, 'trash'])->name('trash');
    Route::get('/create', [CinemaController::class, 'create'])->name('create');
    Route::post('/{cinema}/restore', [CinemaController::class, 'restore'])->name('restore');
    Route::delete('/{cinema}/force-delete', [CinemaController::class, 'forceDelete'])->name('forceDelete');
    Route::get('/{cinema}/edit', [CinemaController::class, 'edit'])->name('edit');
    Route::get('/{cinema}', [CinemaController::class, 'show'])->name('show');
    Route::put('/{cinema}', [CinemaController::class, 'update'])->name('update');
    Route::delete('/{cinema}', [CinemaController::class, 'destroy'])->name('destroy');
    Route::get('/', [CinemaController::class, 'index'])->name('index');
    Route::post('/', [CinemaController::class, 'store'])->name('store');

    // Nested Movies trong Cinema
    Route::prefix('{cinema}/movies')->name('movies.')->group(function () {
        Route::get('/trash', [Fk_MovieController::class, 'trash'])->name('trash');
        Route::get('/create', [Fk_MovieController::class, 'create'])->name('create');
        Route::post('/{movie}/restore', [Fk_MovieController::class, 'restore'])->name('restore');
        Route::delete('/{movie}/force-delete', [Fk_MovieController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/{movie}/edit', [Fk_MovieController::class, 'edit'])->name('edit');
        Route::get('/{movie}', [Fk_MovieController::class, 'show'])->name('show');
        Route::put('/{movie}', [Fk_MovieController::class, 'update'])->name('update');
        Route::delete('/{movie}', [Fk_MovieController::class, 'destroy'])->name('destroy');
        Route::get('/', [Fk_MovieController::class, 'index'])->name('index');
        Route::post('/', [Fk_MovieController::class, 'store'])->name('store');
    });

    // Nested Rooms trong Cinema
    Route::prefix('{cinema}/rooms')->name('rooms.')->group(function () {
        Route::get('/trash', [RoomController::class, 'trash'])->name('trash');
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/{room}/restore', [RoomController::class, 'restore'])->name('restore');
        Route::delete('/{room}/force-delete', [RoomController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/{room}/edit', [RoomController::class, 'edit'])->name('edit');
        Route::get('/{room}', [RoomController::class, 'show'])->name('show');
        Route::put('/{room}', [RoomController::class, 'update'])->name('update');
        Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy');
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::post('/', [RoomController::class, 'store'])->name('store');
    });
});