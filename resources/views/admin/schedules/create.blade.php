@extends('admin.layouts.AdminLayout')

@section('content')
<div class="container-fluid">
    {{-- Quay lại --}}
    <a href="{{ route('admin.cinemas.schedules.index', ['cinema' => $cinema->id]) }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Quay lại
    </a>

    {{-- Thông báo --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Form tạo lịch chiếu --}}
    <div class="card">
        <div class="card-header">Tạo Lịch Chiếu Mới</div>
        <div class="card-body">
            <form action="{{ route('admin.cinemas.schedules.store', ['cinema' => $cinema->id]) }}" method="POST">
                @csrf

                {{-- Phim --}}
                <div class="mb-3">
                    <label for="movie_id" class="form-label">Phim</label>
                    <select name="movie_id" id="movie_id" class="form-select @error('movie_id') is-invalid @enderror">
                        <option value="">-- Chọn phim --</option>
                        @foreach($movies as $movie)
                        <option value="{{ $movie->id }}" data-duration="{{ $movie->duration }}" {{
                            old('movie_id')==$movie->id ? 'selected' : '' }}>
                            {{ $movie->title }} ({{ $movie->duration }} phút)
                        </option>
                        @endforeach
                    </select>
                    @error('movie_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Phòng chiếu --}}
                <div class="mb-3">
                    <label for="room_id" class="form-label">Phòng chiếu</label>
                    <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror">
                        <option value="">-- Chọn phòng chiếu --</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id')==$room->id ? 'selected' : '' }}>
                            Phòng {{ $room->name }} ({{ $room->capacity }} ghế)
                        </option>
                        @endforeach
                    </select>
                    @error('room_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Ngày chiếu --}}
                <div class="mb-3">
                    <label for="day_time" class="form-label">Ngày chiếu</label>
                    <input type="date" name="day_time" id="day_time"
                        class="form-control @error('day_time') is-invalid @enderror"
                        value="{{ old('day_time', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}"
                        max="{{ date('Y-m-d', strtotime('+30 days')) }}">
                    @error('day_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Giờ bắt đầu và kết thúc --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label">Giờ bắt đầu</label>
                        <select name="schedule_time_id" id="schedule_time_id"
                            class="form-select @error('schedule_time_id') is-invalid @enderror">
                            <option value="">-- Chọn giờ bắt đầu --</option>
                            @foreach($scheduleTimes as $time)
                            <option value="{{ $time->id }}" data-start="{{ $time->start_time }}">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->start_time)->format('H:i') }}
                            </option>
                            @endforeach
                        </select>
                        @error('schedule_time_id') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="base_price" class="form-label">Giá vé cơ bản (VNĐ)</label>
                        <input type="number" name="base_price" id="base_price"
                            class="form-control @error('base_price') is-invalid @enderror"
                            value="{{ old('base_price', 80000) }}" min="50000" max="500000" step="5000">
                        @error('base_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Tạo lịch chiếu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection