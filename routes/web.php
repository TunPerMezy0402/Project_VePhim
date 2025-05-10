<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DirectorController;

// Đăng ký các route auth (login, register, password...)
Auth::routes();

// Trang chủ sau khi đăng nhập
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trang admin chính (chưa qua middleware kiểm tra quyền admin)
Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.index');


// Nhóm route quản lý người dùng dưới /admin/users
Route::prefix('admin/users')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.users.index');           // Danh sách
    Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');   // Form tạo
    Route::post('/', [UserController::class, 'store'])->name('admin.users.store');          // Lưu mới
    Route::get('/{id}', [UserController::class, 'show'])->name('admin.users.show');         // Chi tiết
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');    // Form sửa
    Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');     // Cập nhật
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy'); // Xóa
});

Route::prefix('admin/actors')->middleware(['auth', 'admin'])->group(function () {
    // Các route tĩnh phải đặt TRƯỚC khi khai báo {id}
    Route::get('/trash', [ActorController::class, 'trash'])->name('admin.actors.trash');                  // Danh sách các diễn viên đã xóa mềm
    Route::get('/create', [ActorController::class, 'create'])->name('admin.actors.create');               // Form tạo

    // Các route phụ thuộc vào id
    Route::post('/{id}/restore', [ActorController::class, 'restore'])->name('admin.actors.restore');      // Khôi phục mềm
    Route::delete('/{id}/force-delete', [ActorController::class, 'forceDelete'])->name('admin.actors.forceDelete'); // Xóa vĩnh viễn
    Route::get('/{id}/edit', [ActorController::class, 'edit'])->name('admin.actors.edit');               // Form sửa
    Route::get('/{id}', [ActorController::class, 'show'])->name('admin.actors.show');                    // Chi tiết
    Route::put('/{id}', [ActorController::class, 'update'])->name('admin.actors.update');                // Cập nhật
    Route::delete('/{id}', [ActorController::class, 'destroy'])->name('admin.actors.destroy');           // Xóa

    // Route index và store cuối cùng
    Route::get('/', [ActorController::class, 'index'])->name('admin.actors.index');                      // Danh sách
    Route::post('/', [ActorController::class, 'store'])->name('admin.actors.store');                     // Lưu mới
});



Route::prefix('admin/countries')->middleware(['auth', 'admin'])->group(function () {
    // Các route tĩnh phải đặt TRƯỚC khi khai báo {id}
    Route::get('/trash', [CountryController::class, 'trash'])->name('admin.countries.trash');                  // Danh sách các diễn viên đã xóa mềm
    Route::get('/create', [CountryController::class, 'create'])->name('admin.countries.create');               // Form tạo

    // Các route phụ thuộc vào id
    Route::post('/{id}/restore', [CountryController::class, 'restore'])->name('admin.countries.restore');      // Khôi phục mềm
    Route::delete('/{id}/force-delete', [CountryController::class, 'forceDelete'])->name('admin.countries.forceDelete'); // Xóa vĩnh viễn
    Route::get('/{id}/edit', [CountryController::class, 'edit'])->name('admin.countries.edit');               // Form sửa
    Route::get('/{id}', [CountryController::class, 'show'])->name('admin.countries.show');                    // Chi tiết
    Route::put('/{id}', [CountryController::class, 'update'])->name('admin.countries.update');                // Cập nhật
    Route::delete('/{id}', [CountryController::class, 'destroy'])->name('admin.countries.destroy');           // Xóa

    // Route index và store cuối cùng
    Route::get('/', [CountryController::class, 'index'])->name('admin.countries.index');                      // Danh sách
    Route::post('/', [CountryController::class, 'store'])->name('admin.countries.store');                     // Lưu mới
});



Route::prefix('admin/genres')->middleware(['auth', 'admin'])->group(function () {
    // Các route tĩnh phải đặt TRƯỚC khi khai báo {id}
    Route::get('/trash', [GenreController::class, 'trash'])->name('admin.genres.trash');                  // Danh sách các thể loại đã xóa mềm
    Route::get('/create', [GenreController::class, 'create'])->name('admin.genres.create');               // Form tạo

    // Các route phụ thuộc vào id
    Route::post('/{id}/restore', [GenreController::class, 'restore'])->name('admin.genres.restore');      // Khôi phục mềm
    Route::delete('/{id}/force-delete', [GenreController::class, 'forceDelete'])->name('admin.genres.forceDelete'); // Xóa vĩnh viễn
    Route::get('/{id}/edit', [GenreController::class, 'edit'])->name('admin.genres.edit');               // Form sửa
    Route::get('/{id}', [GenreController::class, 'show'])->name('admin.genres.show');                    // Chi tiết
    Route::put('/{id}', [GenreController::class, 'update'])->name('admin.genres.update');                // Cập nhật
    Route::delete('/{id}', [GenreController::class, 'destroy'])->name('admin.genres.destroy');           // Xóa

    // Route index và store cuối cùng
    Route::get('/', [GenreController::class, 'index'])->name('admin.genres.index');                      // Danh sách
    Route::post('/', [GenreController::class, 'store'])->name('admin.genres.store');                     // Lưu mới
});


Route::prefix('admin/directors')->middleware(['auth', 'admin'])->group(function () {
    // Các route tĩnh
    Route::get('/trash', [DirectorController::class, 'trash'])->name('admin.directors.trash');                  // Danh sách đã xóa mềm
    Route::get('/create', [DirectorController::class, 'create'])->name('admin.directors.create');               // Form tạo

    // Các route phụ thuộc vào id
    Route::post('/{id}/restore', [DirectorController::class, 'restore'])->name('admin.directors.restore');      // Khôi phục mềm
    Route::delete('/{id}/force-delete', [DirectorController::class, 'forceDelete'])->name('admin.directors.forceDelete'); // Xóa vĩnh viễn
    Route::get('/{id}/edit', [DirectorController::class, 'edit'])->name('admin.directors.edit');               // Form sửa
    Route::get('/{id}', [DirectorController::class, 'show'])->name('admin.directors.show');                    // Chi tiết
    Route::put('/{id}', [DirectorController::class, 'update'])->name('admin.directors.update');                // Cập nhật
    Route::delete('/{id}', [DirectorController::class, 'destroy'])->name('admin.directors.destroy');           // Xóa mềm

    // Route index và store
    Route::get('/', [DirectorController::class, 'index'])->name('admin.directors.index');                      // Danh sách
    Route::post('/', [DirectorController::class, 'store'])->name('admin.directors.store');                     // Lưu mới
});

Route::prefix('admin/movies')->middleware(['auth', 'admin'])->group(function () {
    // Các route tĩnh
    Route::get('/trash', [MovieController::class, 'trash'])->name('admin.movies.trash');                        // Danh sách đã xóa mềm
    Route::get('/create', [MovieController::class, 'create'])->name('admin.movies.create');                     // Form tạo

    // Các route phụ thuộc vào id
    Route::post('/{id}/restore', [MovieController::class, 'restore'])->name('admin.movies.restore');            // Khôi phục mềm
    Route::delete('/{id}/force-delete', [MovieController::class, 'forceDelete'])->name('admin.movies.forceDelete'); // Xóa vĩnh viễn
    Route::get('/{id}/edit', [MovieController::class, 'edit'])->name('admin.movies.edit');                      // Form sửa
    Route::get('/{id}', [MovieController::class, 'show'])->name('admin.movies.show');                           // Chi tiết
    Route::put('/{id}', [MovieController::class, 'update'])->name('admin.movies.update');                       // Cập nhật
    Route::delete('/{id}', [MovieController::class, 'destroy'])->name('admin.movies.destroy');                  // Xóa mềm

    // Route index và store
    Route::get('/', [MovieController::class, 'index'])->name('admin.movies.index');                             // Danh sách
    Route::post('/', [MovieController::class, 'store'])->name('admin.movies.store');                            // Lưu mới
});

