@extends('admin.layouts.AdminLayout')

@section('content')

<a href="{{ route('admin.actors.index') }}" class="btn btn-danger btn-sm mt-3">Back</a>
<div class="card mb-3 mt-3">
    <div class="card-header">
        <h5 class="mb-0">Sửa diễn viên</h5>
    </div>
    <div class="card-body bg-body-tertiary">
        <form class="row g-3" method="POST" action="{{ route('admin.actors.update', ['id' => $actor->id]) }}">
            @csrf
            @method('PUT')

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="card p-4">
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="name" class="form-label">Tên Diễn Viên</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ $actor->name }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="text-end">
                <!-- Nút Cập nhật -->
                <form action="{{ route('admin.actors.update', $actor->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save me-1"></i> Cập Nhật
                    </button>
                </form>

                <!-- Nút Xóa -->
                <form action="{{ route('admin.actors.destroy', $actor->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa diễn viên này không?')">
                        <i class="fas fa-trash-alt me-1"></i> Xóa
                    </button>
                </form>
            </div>



        </form>

    </div>
</div>

@endsection