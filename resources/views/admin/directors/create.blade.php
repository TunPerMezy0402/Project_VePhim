@extends('admin.layouts.AdminLayout')

@section('content')

<a href="{{ route('admin.directors.index') }}" class="btn btn-danger btn-sm mt-3">Back</a>
<div class="card mb-3 mt-3">
    <div class="card-header">
        <h5 class="mb-0">Thêm đạo diễn mới</h5>
    </div>
    <div class="card-body bg-body-tertiary">
        <form class="row g-3" method="POST" action="{{ route('admin.directors.store') }}">
            @csrf
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="card p-4">
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="name" class="form-label">Tên Đạo Diễn</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-sm col-2">
                    Thêm Đạo Diễn
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
