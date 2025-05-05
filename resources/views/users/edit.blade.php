{{-- @extends('layouts.AdminLayout')

@section('title', 'Chỉnh sửa người dùng')
@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Chỉnh sửa thông tin người dùng {{$user->name}} </h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Tên</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" disabled>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" disabled>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" disabled>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="role" class="form-label">Vai trò</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="status">Trạng thái tài khoản</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Mở tài khoản</option>
                    <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Khóa tài khoản</option>
                </select>
            </div>
            
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật người dùng</button>
    </form>
</div>
@endsection
 --}}