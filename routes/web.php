<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// Đăng ký các route auth (login, register, password...)
Auth::routes();

// Trang chủ sau khi đăng nhập
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trang admin chính (chưa qua middleware kiểm tra quyền admin)
Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth','admin'])->name('admin.home');


// Nhóm route quản lý người dùng dưới /admin/users
Route::prefix('admin/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.users.index');           // Danh sách
    Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');   // Form tạo
    Route::post('/', [UserController::class, 'store'])->name('admin.users.store');          // Lưu mới
    Route::get('/{id}', [UserController::class, 'show'])->name('admin.users.show');         // Chi tiết
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');    // Form sửa
    Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');     // Cập nhật
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');// Xóa
});
