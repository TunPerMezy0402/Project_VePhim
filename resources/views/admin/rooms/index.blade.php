@extends('admin.layouts.AdminLayout')

@section('content')

{{-- Nút quay lại --}}
<a href="{{ route('admin.cinemas.index') }}" class="btn btn-danger btn-sm mb-3">
    <i class="fas fa-arrow-left me-1"></i> Quay lại
</a>

{{-- Thông báo thành công --}}
@if(session('success'))
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif

{{-- Action Buttons --}}
@include('admin.layouts.partials.cinemas')

{{-- Danh sách phòng --}}
<div class="card mt-3">
    {{-- Header: Tìm kiếm & hành động --}}
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            {{-- Form tìm kiếm --}}
            <form action="{{ route('admin.cinemas.index') }}" method="GET" class="w-100 w-md-auto">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..."
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Tìm</button>
                </div>
            </form>

            {{-- Nút hành động --}}
            <div class="mt-2 mt-md-0">
                <a href="{{ route('admin.cinemas.rooms.create', ['cinema' => $cinema->id]) }}"
                    class="btn btn-falcon-default btn-sm me-2">
                    <i class="fas fa-plus me-1"></i> <span class="d-none d-sm-inline">Thêm Mới</span>
                </a>

                <a href="{{ route('admin.cinemas.trash') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-trash-alt me-1"></i> <span class="d-none d-sm-inline">Thùng Rác</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body fs-10">
        <div class="row">
            @if ($rooms && $rooms->count())
            @foreach ($rooms as $room)
            <div class="custom-col-5 mb-3">
                <a href="#" class="d-flex justify-content-center align-items-center text-decoration-none">
                    <div class="calendar text-center">
                        <span class="calendar-month">Phòng</span>
                        <span class="calendar-day">{{ $room->name }}</span>
                    </div>
                </a>

            </div>
            @endforeach
            @else
            <div class="col-12 text-center mt-3">
                <span class="badge bg-secondary-subtle text-dark fs-6">
                    Không có phòng chiếu nào hoạt động!
                </span>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Phân trang --}}
<div class="d-flex justify-content-center mt-3">
    {!! $rooms->links('pagination::bootstrap-5') !!}
</div>

<style>
    @media (min-width: 1200px) {
        .custom-col-5 {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }
</style>

@endsection