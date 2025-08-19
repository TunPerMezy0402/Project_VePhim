@extends('admin.layouts.AdminLayout')

@section('content')

<a href="{{ route('admin.cinemas.schedules.index', ['cinema' => $cinema->id]) }}"
    class="btn btn-danger btn-sm mt-3">
    <i class="fas fa-arrow-left me-1"></i>Quay lại
</a>

<div class="card mb-3 mt-3">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-clock me-2"></i>Chỉnh Sửa Giờ Chiếu
        </h5>
    </div>
    <div class="card-body bg-body-tertiary">
        <form class="row g-3" method="POST"
            action="{{ route('admin.cinemas.schedule_times.update', ['cinema' => $cinema->id, 'schedule' => $scheduleTime->id]) }}">
            @csrf
            @method('PUT')

            <div class="card p-4">
                <div class="row">
                    {{-- Tên Ca Chiếu --}}
                    <div class="col-md-6 mb-3">
                        <label for="label" class="form-label">
                            <i class="fas fa-tag me-1"></i>Ca Chiếu <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('label') is-invalid @enderror" 
                               id="label"
                               name="label" 
                               value="{{ old('label', $scheduleTime->label) }}" 
                               placeholder="Ví dụ: Ca Sáng, Ca Chiều, Ca Tối" 
                               required>
                        @error('label') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    {{-- Giờ Bắt Đầu --}}
                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label">
                            <i class="fas fa-play me-1"></i>Giờ Bắt Đầu <span class="text-danger">*</span>
                        </label>
                        <div class="row">
                            <div class="col-6">
                                <select class="form-select @error('hour') is-invalid @enderror"
                                        id="hour_select" name="hour" required>
                                    <option value="">Giờ</option>
                                    @for ($hour = 0; $hour < 24; $hour++)
                                        @php
                                            $hourValue = sprintf('%02d', $hour);
                                            $oldHour = old('hour', $scheduleTime->hour ?? '');
                                        @endphp
                                        <option value="{{ $hourValue }}" {{ $oldHour == $hourValue ? 'selected' : '' }}>
                                            {{ $hourValue }}h
                                        </option>
                                    @endfor
                                </select>
                                @error('hour') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                            <div class="col-6">
                                <select class="form-select @error('minute') is-invalid @enderror"
                                        id="minute_select" name="minute" required>
                                    <option value="">Phút</option>
                                    @for ($minute = 0; $minute < 60; $minute += 5)
                                        @php
                                            $minuteValue = sprintf('%02d', $minute);
                                            $oldMinute = old('minute', $scheduleTime->minute ?? '');
                                        @endphp
                                        <option value="{{ $minuteValue }}" {{ $oldMinute == $minuteValue ? 'selected' : '' }}>
                                            {{ $minuteValue }}p
                                        </option>
                                    @endfor
                                </select>
                                @error('minute') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                        @error('start_time') 
                            <div class="invalid-feedback d-block">{{ $message }}</div> 
                        @enderror
                        <small class="text-muted">Chọn giờ và phút (mỗi 5 phút)</small>
                    </div>
                </div>

                {{-- Hiển thị thời gian đã chọn --}}
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-info" id="time_preview" style="display: none;">
                            <i class="fas fa-info-circle me-1"></i>
                            Thời gian đã chọn: <strong id="selected_time">--:--</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <!-- Nút Cập nhật -->
                <form action="{{ route('admin.cinemas.schedule_times.update', ['cinema' => $cinema->id, 'schedule' => $scheduleTime->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save me-1"></i> Cập Nhật
                    </button>
                </form>

                <!-- Nút Xóa -->
                <form action="{{ route('admin.cinemas.schedule_times.destroy', ['cinema' => $cinema->id, 'schedule' => $scheduleTime->id]) }}" method="POST" class="d-inline">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hourSelect = document.getElementById('hour_select');
    const minuteSelect = document.getElementById('minute_select');
    const timePreview = document.getElementById('time_preview');
    const selectedTimeSpan = document.getElementById('selected_time');

    function updateTimePreview() {
        const hour = hourSelect.value;
        const minute = minuteSelect.value;
        
        if (hour && minute) {
            const timeString = hour + ':' + minute;
            selectedTimeSpan.textContent = timeString;
            timePreview.style.display = 'block';
        } else {
            timePreview.style.display = 'none';
        }
    }

    // Khởi tạo giá trị ban đầu nếu có
    if (hourSelect.value && minuteSelect.value) {
        updateTimePreview();
    }

    hourSelect.addEventListener('change', updateTimePreview);
    minuteSelect.addEventListener('change', updateTimePreview);
});
</script>

@endsection