@extends('admin.layouts.AdminLayout')

@section('content')

<a href="{{ route('admin.cinemas.rooms.index', ['cinema' => $cinema->id]) }}" class="btn btn-danger btn-sm mt-3">Back</a>

<div class="card mb-3 mt-3">
    <div class="card-header">
        <h5 class="mb-0">Thêm Phòng <span class="bdage bg-primary">{{$cinema->name}}</span></h5>
    </div>
    <div class="card-body bg-body-tertiary">
        <form class="row g-3" method="POST" action="{{ route('admin.cinemas.rooms.store', ['cinema' => $cinema->id]) }}">
            @csrf
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="card p-4">
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="name" class="form-label">Tên Phòng</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="total_seats" class="form-label">Số Chỗ Ngồi</label>
                        <input type="text" class="form-control @error('total_seats') is-invalid @enderror" id="total_seats"
                            name="total_seats" value="{{ old('total_seats') }}">
                        @error('total_seats') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-sm col-2">
                    Thêm Phòng
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
