<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
});

use App\Http\Controllers\UserController;
Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');  // Hiển thị danh sách người dùng
    Route::get('/create', [UserController::class, 'create'])->name('users.create');  // Form tạo người dùng
    Route::post('/', [UserController::class, 'store'])->name('users.store');  // Lưu người dùng mới
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');  // Chi tiết người dùng
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');  // Form sửa người dùng
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');  // Cập nhật người dùng
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');  // Xóa người dùng
});