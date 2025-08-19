@extends('admin.layouts.AdminLayout')

@section('content')
@include('admin.layouts.partials.cinemas')

<style>
    .admin-content {
        background: #0f172a;
        min-height: 100vh;
    }

    .page-header {
        background: #1e293b;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        padding: 24px;
        margin-bottom: 24px;
        border-left: 4px solid #3b82f6;
    }

    .cinema-title {
        color: #f8fafc;
        font-size: 1.875rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .cinema-title i {
        color: #60a5fa;
    }

    .cinema-address {
        color: #cbd5e1;
        margin: 8px 0 0 0;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Admin Cards */
    .admin-card {
        background: #1e293b;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        border: 1px solid #334155;
        margin-bottom: 24px;
    }

    .admin-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #334155;
        background: #334155;
        border-radius: 8px 8px 0 0;
    }

    .admin-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #f8fafc;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .admin-card-title i {
        color: #60a5fa;
    }

    .admin-card-body {
        padding: 24px;
    }

    /* Date Navigation & Reset Button */
    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: #10b981;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-reset:hover {
        background: #059669;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .nav-btn.disabled {
        background: #475569;
        color: #94a3b8;
        cursor: not-allowed;
        pointer-events: none;
    }

    .nav-btn.disabled:hover {
        background: #475569;
        color: #94a3b8;
        transform: none;
    }

    /* Date Items */
    .date-item.past {
        background: #374151;
        color: #d1d5db;
        border-color: #4b5563;
    }

    .date-item.past:hover {
        border-color: #6b7280;
        color: #e5e7eb;
    }

    .date-badge {
        position: absolute;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 500;
    }

    .today-badge {
        background: #fbbf24;
        color: #1f2937;
    }

    .past-badge {
        background: #6b7280;
        color: white;
    }

    .date-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #3b82f6;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .nav-btn:hover {
        background: #2563eb;
        color: white;
        text-decoration: none;
    }

    .current-date {
        font-size: 30px;
        font-weight: 600;
        text-transform: capitalize;
        color: #f8fafc;
    }

    /* Date Grid */
    .date-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 12px;
    }

    .date-item {
        background: #1e293b;
        border: 1px solid #475569;
        border-radius: 6px;
        padding: 16px;
        text-align: center;
        text-decoration: none;
        color: #e2e8f0;
        transition: all 0.2s;
        position: relative;
    }

    .date-item:hover {
        border-color: #3b82f6;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
        text-decoration: none;
        color: #f1f5f9;
    }

    .date-item.active {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }

    .date-item.today {
        background: #f59e0b;
        border-color: #f59e0b;
        color: #1f2937;
    }

    .date-item.today.active {
        background: #3b82f6;
        border-color: #3b82f6;
    }

    .date-day {
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .date-number {
        font-size: 18px;
        font-weight: 700;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 16px;
    }

    .filter-tab {
        padding: 8px 16px;
        background: #374151;
        color: #d1d5db;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .filter-tab:hover {
        background: #4b5563;
        text-decoration: none;
        color: #e5e7eb;
    }

    .filter-tab.active {
        background: #3b82f6;
        color: white;
    }

    /* Three Column Layout */
    .admin-layout {
        display: grid;
        grid-template-columns: 300px 1fr 350px;
        gap: 24px;
    }

    @media (max-width: 1200px) {
        .admin-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Panel Styles */
    .admin-panel {
        background: #1e293b;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        border: 1px solid #334155;
        height: fit-content;
    }

    .admin-panel-header {
        padding: 16px 20px;
        border-bottom: 1px solid #334155;
        background: #334155;
        border-radius: 8px 8px 0 0;
    }

    .admin-panel-title {
        font-size: 1rem;
        font-weight: 600;
        color: #f8fafc;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .admin-panel-body {
        padding: 16px;
        max-height: 500px;
        overflow-y: auto;
    }

    /* Custom Scrollbar */
    .admin-panel-body::-webkit-scrollbar {
        width: 6px;
    }

    .admin-panel-body::-webkit-scrollbar-track {
        background: #1e293b;
    }

    .admin-panel-body::-webkit-scrollbar-thumb {
        background: #475569;
        border-radius: 3px;
    }

    .admin-panel-body::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }

    /* List Items */
    .list-item {
        display: block;
        padding: 12px;
        margin-bottom: 8px;
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 6px;
        text-decoration: none;
        color: #e2e8f0;
        transition: all 0.2s;
    }

    .list-item:hover {
        background: #1e293b;
        border-color: #475569;
        text-decoration: none;
        color: #f1f5f9;
    }

    .list-item.active {
        background: #1e40af;
        border-color: #3b82f6;
        color: white;
    }

    .list-item-title {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .list-item-subtitle {
        font-size: 14px;
        color: #cbd5e1;
    }

    .list-item-meta {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-section {
        background: #1e293b;
        padding: 20px;
        border-radius: 6px;
        border: 1px solid #334155;
    }

    .info-section h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #000;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-section h5 i {
        color: #60a5fa;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .info-label {
        font-weight: 500;
        color: #000;
    }

    .info-value {
        color: #000;
        font-weight: 500;
    }

    /* Movie Poster */
    .poster-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .movie-poster {
        width: 130%;
        max-width: 200px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #334155;
    }

    .poster-placeholder {
        width: 100%;
        max-width: 200px;
        aspect-ratio: 1/3;
        background: #374151;
        border: 1px solid #475569;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 48px;
    }

    /* Seating Section */
    .seating-section {
        grid-column: 1 / -1;
        background: #1e293b;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        border: 1px solid #334155;
    }

    .seating-header {
        padding: 20px 24px;
        border-bottom: 1px solid #334155;
        background: #334155;
        border-radius: 8px 8px 0 0;
    }

    .seating-body {
        padding: 40px;
        background: #0f172a;
        color: #e2e8f0;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 500px;
    }

    /* Screen */
    .cinema-screen {
        width: 70%;
        height: 8px;
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        border-radius: 4px;
        margin-bottom: 40px;
        position: relative;
        box-shadow: 0 2px 10px rgba(251, 191, 36, 0.5);
    }

    .cinema-screen::after {
        content: "MÀN HÌNH";
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        color: #fbbf24;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 2px;
    }

    /* Seating Area */
    .seating-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
        max-width: 800px;
    }

    .seat-row {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
    }

    .row-label {
        color: #fbbf24;
        font-weight: 700;
        width: 24px;
        text-align: center;
        font-size: 14px;
    }

    .seat-container {
        position: relative;
        display: inline-block;
    }

    .seat-checkbox {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        cursor: pointer;
        z-index: 2;
    }

    .seat-checkbox:disabled {
        cursor: not-allowed;
    }

    .seat {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
    }

    .seat.couple {
        width: 72px;
    }

    .seat.available {
        background: #10b981;
        border-color: #059669;
        color: white;
    }

    .seat.available:hover {
        transform: scale(1.1);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
    }

    .seat.booked {
        background: #ef4444;
        border-color: #dc2626;
        color: white;
        cursor: not-allowed;
    }

    .seat.vip {
        background: #f59e0b;
        border-color: #d97706;
        color: #1f2937;
    }

    .seat-checkbox:checked+.seat {
        background: #3b82f6 !important;
        border-color: #2563eb !important;
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.5) !important;
        color: white !important;
    }

    .aisle {
        width: 16px;
    }

    /* Legend */
    .seat-legend {
        display: flex;
        justify-content: center;
        gap: 24px;
        margin: 30px 0;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #e2e8f0;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px 16px;
        border-radius: 20px;
    }

    .legend-seat {
        width: 16px;
        height: 16px;
        border-radius: 4px;
    }

    .legend-seat.available {
        background: #10b981;
    }

    .legend-seat.selected {
        background: #3b82f6;
    }

    .legend-seat.booked {
        background: #ef4444;
    }

    .legend-seat.vip {
        background: #f59e0b;
    }

    /* Stats */
    .seat-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin: 30px 0;
        width: 100%;
        max-width: 400px;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 16px;
        border-radius: 6px;
        text-align: center;
    }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 4px;
        color: #f1f5f9;
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.8;
        color: #cbd5e1;
    }

    /* Action Buttons */
    .seat-actions {
        margin-top: 30px;
        display: flex;
        gap: 16px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-admin {
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        font-size: 14px;
        cursor: pointer;
    }

    .btn-confirm {
        background: #10b981;
        color: white;
    }

    .btn-confirm:hover {
        background: #059669;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-clear {
        background: #ef4444;
        color: white;
    }

    .btn-clear:hover {
        background: #dc2626;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Summary Section */
    .booking-summary {
        background: #1e293b;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        border: 1px solid #334155;
        padding: 24px;
        margin-top: 24px;
    }

    .summary-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #f8fafc;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-title i {
        color: #10b981;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    @media (max-width: 768px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }
    }

    .summary-section {
        background: #0f172a;
        padding: 20px;
        border-radius: 6px;
        border: 1px solid #334155;
    }

    .summary-section h6 {
        font-size: 1rem;
        font-weight: 600;
        color: #f8fafc;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .seat-tags {
        margin: 12px 0;
    }

    .seat-tag {
        background: #3b82f6;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        margin: 2px;
        display: inline-block;
        font-size: 12px;
        font-weight: 500;
    }

    .total-price {
        color: #10b981;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .btn-proceed {
        padding: 16px 32px;
        background: #10b981;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        width: 100%;
        justify-content: center;
    }

    .btn-proceed:hover {
        background: #059669;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #cbd5e1;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.4;
    }

    .empty-state h4 {
        font-weight: 600;
        margin-bottom: 8px;
        color: #f1f5f9;
    }

    /* Instructions */
    .instructions {
        background: #1e293b;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        border: 1px solid #334155;
        padding: 32px;
        text-align: center;
        margin-top: 24px;
    }

    .instructions i {
        font-size: 48px;
        color: #60a5fa;
        margin-bottom: 20px;
    }

    .instructions h4 {
        color: #f8fafc;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .step-list {
        text-align: left;
        max-width: 500px;
        margin: 20px auto 0;
        background: #0f172a;
        padding: 24px;
        border-radius: 6px;
        border: 1px solid #334155;
    }

    .step-item {
        margin-bottom: 16px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .step-item:last-child {
        margin-bottom: 0;
    }

    .step-number {
        background: #3b82f6;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        flex-shrink: 0;
    }

    .step-content {
        flex: 1;
    }

    .step-title {
        font-weight: 600;
        color: #f8fafc;
        margin-bottom: 4px;
    }

    .step-description {
        font-size: 14px;
        color: #cbd5e1;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge.today {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.active {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-layout {
            grid-template-columns: 1fr;
        }

        .date-nav {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .seat-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .seat {
            width: 28px;
            height: 28px;
        }

        .seat.couple {
            width: 60px;
        }
    }

    /* Alert Messages */
    .alert {
        padding: 12px 16px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 6px;
    }

    .alert-info {
        color: #0ea5e9;
        background-color: #0f172a;
        border-color: #0284c7;
    }

    .alert-warning {
        color: #f59e0b;
        background-color: #1f1611;
        border-color: #d97706;
    }

    .alert-success {
        color: #10b981;
        background-color: #0f1b16;
        border-color: #059669;
    }
</style>

@php
// Smart date generation
$today = now();
$smartDates = collect();

for ($i = -3; $i <= 3; $i++) { $date=$today->copy()->addDays($i);
    $dateValue = $date->format('Y-m-d');

    if ($i === -1) {
    $dayLabel = 'Hôm qua';
    } elseif ($i === 0) {
    $dayLabel = 'Hôm nay';
    } elseif ($i === 1) {
    $dayLabel = 'Ngày mai';
    } else {
    $dayLabel = $date->locale('vi')->dayName;
    }

    $smartDates->push([
    'value' => $dateValue,
    'day' => $dayLabel,
    'date' => $date->format('d/m'),
    'is_today' => $i === 0,
    'is_yesterday' => $i === -1,
    'is_tomorrow' => $i === 1
    ]);
    }

    $selectedDate = request('date', $today->format('Y-m-d'));
    $selectedRoom = request('room', 'all');
    @endphp

    <div class="admin-content">
        {{-- Page Header --}}
        <div class="page-header">
            <h1 class="cinema-title">
                <i class="fas fa-film"></i>
                {{ $cinema->name }}
            </h1>
            <p class="cinema-address">
                <i class="fas fa-map-marker-alt"></i>
                {{ $cinema->address }}
            </p>
        </div>

        {{-- Date Selection Card --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; gap: 12px; width: 100%;">
                    <h3 class="admin-card-title" style="margin: 0; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-calendar-alt"></i>
                        Chọn Ngày Chiếu
                    </h3>

                    <div style="display: flex; align-items: center; gap: 10px;">
                        <a href="{{ route('admin.cinemas.schedules.index', [
            'cinema' => $cinema->id,
            'date' => now('Asia/Ho_Chi_Minh')->format('Y-m-d'),
            'room' => request('room', 'all'),
            'search' => request('search')
        ]) }}" class="btn-reset"
                            style="padding: 6px 12px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-home"></i>
                            Hôm nay
                        </a>

                        <form method="GET" action="{{ route('admin.cinemas.schedules.index', $cinema->id) }}"
                            style="margin: 0;">
                            <input type="hidden" name="room" value="{{ request('room', 'all') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">

                            <input type="date" name="date"
                                value="{{ request('date', now('Asia/Ho_Chi_Minh')->format('Y-m-d')) }}"
                                class="form-control"
                                style="padding: 6px 10px; border-radius: 6px; border: 1px solid #ccc;"
                                onchange="this.form.submit()">
                        </form>
                    </div>
                </div>

            </div>
            <div class="admin-card-body">
                @php
                use Carbon\Carbon;

                // Đặt timezone Việt Nam
                date_default_timezone_set('Asia/Ho_Chi_Minh');

                $selectedDateObj = Carbon::parse($selectedDate)->timezone('Asia/Ho_Chi_Minh');
                $today = Carbon::now('Asia/Ho_Chi_Minh');
                $maxDate = $today->copy()->addDays(30); // Giới hạn 30 ngày từ hôm nay

                // Tính toán ngày trước và sau với logic thông minh
                $prevDate = $selectedDateObj->copy()->subDay();
                $nextDate = $selectedDateObj->copy()->addDay();

                // Nếu ngày tiếp theo vượt quá giới hạn, giữ nguyên ngày hiện tại
                if ($nextDate->gt($maxDate)) {
                $nextDate = $selectedDateObj; // Không cho phép tăng thêm
                }

                // Nếu ngày trước nhỏ hơn 3 ngày trước hôm nay, giữ nguyên
                $minDate = $today->copy()->subDays(3);
                if ($prevDate->lt($minDate)) {
                $prevDate = $selectedDateObj; // Không cho phép giảm thêm
                }

                $canGoPrev = !$selectedDateObj->eq($prevDate);
                $canGoNext = !$selectedDateObj->eq($nextDate);
                @endphp


                {{-- Date Navigation --}}
                <div class="date-nav">
                    <a href="{{ $canGoPrev ? route('admin.cinemas.schedules.index', [
                    'cinema' => $cinema->id,
                    'date' => $prevDate->toDateString(),
                    'room' => request('room', 'all'),
                    'search' => request('search')
                ]) : '#' }}" class="nav-btn {{ !$canGoPrev ? 'disabled' : '' }}">
                        <i class="fas fa-chevron-left"></i>
                        Ngày trước
                    </a>

                    <div class="current-date">
                        @php
                        if ($selectedDateObj->isToday()) {
                        echo 'Hôm nay - ' . $selectedDateObj->format('d/m/Y');
                        } elseif ($selectedDateObj->isYesterday()) {
                        echo 'Hôm qua - ' . $selectedDateObj->format('d/m/Y');
                        } elseif ($selectedDateObj->isTomorrow()) {
                        echo 'Ngày mai - ' . $selectedDateObj->format('d/m/Y');
                        } else {
                        echo $selectedDateObj->locale('vi')->dayName . ' - ' . $selectedDateObj->format('d/m/Y');
                        }
                        @endphp
                    </div>

                    <a href="{{ $canGoNext ? route('admin.cinemas.schedules.index', [
                    'cinema' => $cinema->id,
                    'date' => $nextDate->toDateString(),
                    'room' => request('room', 'all'),
                    'search' => request('search')
                ]) : '#' }}" class="nav-btn {{ !$canGoNext ? 'disabled' : '' }}">
                        Ngày sau
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                {{-- Date Grid với logic thông minh --}}
                @php
                // Tạo danh sách ngày thông minh với giới hạn
                $today = Carbon::now();
                $selectedDateCarbon = Carbon::parse($selectedDate);
                $smartDates = collect();

                // Tạo range 7 ngày xung quanh ngày được chọn
                $startDate = $selectedDateCarbon->copy()->subDays(3);
                $endDate = $selectedDateCarbon->copy()->addDays(3);

                // Đảm bảo không vượt quá giới hạn
                $minAllowed = $today->copy()->subDays(3);
                $maxAllowed = $today->copy()->addDays(30);

                if ($startDate->lt($minAllowed)) {
                $startDate = $minAllowed->copy();
                $endDate = $startDate->copy()->addDays(6);
                }

                if ($endDate->gt($maxAllowed)) {
                $endDate = $maxAllowed->copy();
                $startDate = $endDate->copy()->subDays(6);
                }

                // Tạo danh sách ngày
                for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $dateValue = $date->format('Y-m-d');
                $daysDiff = $date->diffInDays($today, false);

                if ($daysDiff === 1) {
                $dayLabel = 'Hôm qua';
                } elseif ($daysDiff === 0) {
                $dayLabel = 'Hôm nay';
                } elseif ($daysDiff === -1) {
                $dayLabel = 'Ngày mai';
                } else {
                $dayLabel = $date->locale('vi')->dayName;
                }

                $smartDates->push([
                'value' => $dateValue,
                'day' => $dayLabel,
                'date' => $date->format('d/m'),
                'is_today' => $date->isToday(),
                'is_yesterday' => $date->isYesterday(),
                'is_tomorrow' => $date->isTomorrow(),
                'is_past' => $date->lt($today->startOfDay()),
                'is_future' => $date->gt($today->endOfDay())
                ]);
                }
                @endphp

                <div class="date-grid">
                    @foreach($smartDates as $date)
                    <a href="{{ route('admin.cinemas.schedules.index', [
                    'cinema' => $cinema->id,
                    'date' => $date['value'],
                    'room' => request('room', 'all'),
                    'search' => request('search')
                ]) }}" class="date-item 
                    {{ $date['value'] === $selectedDate ? 'active' : '' }} 
                    {{ $date['is_today'] ? 'today' : '' }}
                    {{ $date['is_past'] ? 'past' : '' }}">
                        <div class="date-day">{{ $date['day'] }}</div>
                        <div class="date-number">{{ $date['date'] }}</div>
                        @if($date['is_today'])
                        <div class="date-badge today-badge">Hôm nay</div>
                        @elseif($date['is_past'])
                        <div class="date-badge past-badge">Đã qua</div>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Room Filters --}}
        @if($selectedDate)
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-door-open"></i>
                    Lọc theo phòng chiếu
                </h3>
            </div>
            <div class="admin-card-body">
                <div class="filter-tabs">
                    <a href="{{ route('admin.cinemas.schedules.index', [
                    'cinema' => $cinema->id,
                    'date' => $selectedDate,
                    'room' => 'all',
                    'search' => request('search')
                ]) }}" class="filter-tab {{ $selectedRoom === 'all' ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        Tất cả phòng
                    </a>
                    @foreach($rooms as $room)
                    <a href="{{ route('admin.cinemas.schedules.index', [
                    'cinema' => $cinema->id,
                    'date' => $selectedDate,
                    'room' => $room->id,
                    'search' => request('search')
                ]) }}" class="filter-tab {{ $selectedRoom == $room->id ? 'active' : '' }}">
                        <i class="fas fa-couch"></i>
                        {{ $room->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Main Content Layout --}}
        @if($selectedDate)
        <div class="admin-layout">
            {{-- Time Slots Panel --}}
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h4 class="admin-panel-title">
                        <i class="fas fa-clock"></i>
                        Khung Giờ Chiếu
                    </h4>
                </div>
                <div class="admin-panel-body">
                    @php
                    $timeSlots = $showtimes->groupBy(function($showtime) {
                    return $showtime->scheduleTime ? $showtime->scheduleTime->start_time : '00:00:00';
                    })->sortKeys();
                    $selectedTimeSlot = request('time_slot');
                    @endphp

                    @if($timeSlots->count() > 0)
                    @foreach($timeSlots as $time => $showtimesInSlot)
                    <a href="{{ route('admin.cinemas.schedules.index', [
                        'cinema' => $cinema->id,
                        'date' => $selectedDate,
                        'room' => request('room', 'all'),
                        'time_slot' => \Carbon\Carbon::parse($time)->format('H:i'),
                        'search' => request('search')
                    ]) }}"
                        class="list-item {{ \Carbon\Carbon::parse($time)->format('H:i') === $selectedTimeSlot ? 'active' : '' }}">
                        <div class="list-item-title">{{ \Carbon\Carbon::parse($time)->format('H:i') }}</div>
                        <div class="list-item-subtitle">{{ $showtimesInSlot->count() }} suất chiếu</div>
                    </a>
                    @endforeach
                    @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h4>Không có lịch chiếu</h4>
                        <p>Chưa có suất chiếu nào trong ngày này</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Showtimes Panel --}}
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h4 class="admin-panel-title">
                        <i class="fas fa-film"></i>
                        Danh Sách Phim
                    </h4>
                </div>
                <div class="admin-panel-body">
                    @if(request('time_slot'))
                    @php
                    $filteredShowtimes = $showtimes->filter(function($showtime) {
                    $showtimeTime = $showtime->scheduleTime ?
                    \Carbon\Carbon::parse($showtime->scheduleTime->start_time)->format('H:i') :
                    null;
                    return $showtimeTime === request('time_slot');
                    });
                    @endphp

                    @if($filteredShowtimes->count() > 0)
                    @foreach($filteredShowtimes as $showtime)
                    @php
                    $currentRoom = $showtime->room->id;
                    @endphp
                    <a href="{{ route('admin.cinemas.schedules.index', [
                            'cinema' => $cinema->id,
                            'date' => $selectedDate,
                            'room' => request('room', 'all'),
                            'time_slot' => request('time_slot'),
                            'showtime' => $showtime->id,
                            'search' => request('search')
                        ]) }}" class="list-item {{ request('showtime') == $showtime->id ? 'active' : '' }}">
                        <div class="list-item-title">{{ $showtime->movie->title }}</div>
                        <div class="list-item-subtitle">
                            <i class="fas fa-couch"></i> {{ $showtime->room->name }} •
                            <i class="fas fa-users"></i> {{ $showtime->room->total_seats ?? 'N/A' }} ghế
                        </div>
                        <div class="list-item-meta">
                            <i class="fas fa-clock"></i> {{ $showtime->movie->duration ?? 'N/A' }} phút •
                            <i class="fas fa-money-bill"></i> {{ number_format($showtime->base_price) }} VNĐ
                        </div>
                    </a>
                    @endforeach
                    @else
                    <div class="empty-state">
                        <i class="fas fa-film"></i>
                        <h4>Không có phim</h4>
                        <p>Không có phim chiếu trong khung giờ này</p>
                    </div>
                    @endif
                    @else
                    <div class="empty-state">
                        <i class="fas fa-mouse-pointer"></i>
                        <h4>Chọn khung giờ</h4>
                        <p>Vui lòng chọn khung giờ chiếu để xem danh sách phim</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Info Panel --}}
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h4 class="admin-panel-title">
                        <i class="fas fa-info-circle"></i>
                        Thông Tin Chi Tiết
                    </h4>
                </div>
                <div class="admin-panel-body">
                    <div class="info-grid">
                        <div class="info-details">
                            @if(request('showtime') && $showtimes->where('id', request('showtime'))->first())
                            @php $selectedShowtime = $showtimes->where('id', request('showtime'))->first(); @endphp
                            <div class="info-section" style="border-left: 3px solid #10b981; background: #f0fdf4;">
                                <h5><i class="fas fa-film"></i> Phim đã chọn</h5>
                                <div class="info-row">
                                    <span class="info-label">Tên phim:</span>
                                    <span class="info-value">{{ $selectedShowtime->movie->title }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Thời lượng:</span>
                                    <span class="info-value">{{ $selectedShowtime->movie->duration ?? 'N/A' }}
                                        phút</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Phòng chiếu:</span>
                                    <span class="info-value">{{ $selectedShowtime->room->name }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Giá vé:</span>
                                    <span class="info-value">{{ number_format($selectedShowtime->base_price) }}
                                        VNĐ</span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="poster-container">
                            @if(request('showtime') && $showtimes->where('id', request('showtime'))->first())
                            @php $selectedShowtime = $showtimes->where('id', request('showtime'))->first(); @endphp
                            @if($selectedShowtime->movie->image)
                            <img src="{{ asset('storage/' . $selectedShowtime->movie->image) }}"
                                alt="{{ $selectedShowtime->movie->title }}" class="movie-poster">
                            @else
                            <div class="poster-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                            @endif
                            @else
                            <div class="poster-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif

        {{-- Seating Section --}}
        @if(request('showtime') && request('time_slot'))
        <div class="seating-section">
            <div class="seating-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-couch"></i>
                    Sơ Đồ Ghế
                    @if(isset($showtimes))
                    @php $selectedShowtime = $showtimes->where('id', request('showtime'))->first(); @endphp
                    @if($selectedShowtime)
                    - {{ $selectedShowtime->movie->title }}
                    @endif
                    @endif
                </h3>
            </div>

            <div class="seating-section">

                <div class="seating-body">
                    @php
                    // Ghế đang chọn
                    $selectedSeats = request('seats', []);
                    if (!is_array($selectedSeats)) {
                    $selectedSeats = explode(',', $selectedSeats);
                    $selectedSeats = array_filter($selectedSeats);
                    }

                    // Lấy room id từ $currentRoom (có thể là object hoặc số)
                    $roomId = null;
                    if (isset($currentRoom)) {
                    $roomId = is_object($currentRoom) ? (int)($currentRoom->id ?? null) : (int)$currentRoom;
                    }

                    // Nạp dữ liệu phòng ngay tại view (không dùng "use")
                    $room = $roomId ? \App\Models\Room::with(['seats','seatRows'])->find($roomId) : null;

                    // Chuẩn hoá biến hiển thị
                    $seats = $room?->seats ?? collect();
                    $seatRows = $room?->seatRows ?? collect();
                    $totalSeats = $seats->sum(fn($s) => $s->seat_chair === 'couple' ? 2 : 1);
                    @endphp

                    @if($room && $seats->count() > 0)
                    <div class="cinema-screen"></div>

                    <div class="seating-grid">
                        @foreach($seatRows as $row)
                        <div class="seat-row">
                            <div class="row-label">{{ $row->row_label }}</div>

                            @php
                            $rowSeats = $seats->filter(fn($s) => str_starts_with($s->seat_number, $row->row_label));
                            $totalSlots = $rowSeats->sum(fn($seat) => $seat->seat_chair === 'couple' ? 2 : 1);
                            $currentSlot = 0;
                            @endphp

                            @foreach($rowSeats as $seat)
                            @php
                            $seatClass = !$seat->is_available ? 'booked' : 'available';
                            if (($row->type ?? null) === 'vip') $seatClass .= ' vip';

                            if ($seat->seat_chair === 'couple') {
                            $seatClass .= ' couple';
                            $slotSpan = 2;
                            } else {
                            $seatClass .= ' single';
                            $slotSpan = 1;
                            }

                            $seatNumber = $seat->seat_number;
                            $seatId = $seat->id;
                            $isDisabled = !$seat->is_available;
                            @endphp

                            <div class="seat-container">
                                <input type="checkbox" class="seat-checkbox" name="seats[]" value="{{ $seatId }}"
                                    id="seat_{{ $seatId }}" {{ in_array($seatId, $selectedSeats) ? 'checked' : '' }} {{
                                    $isDisabled ? 'disabled' : '' }} onchange="this.form.submit()">
                                <div class="seat {{ $seatClass }}" title="Ghế {{ $seatNumber }}">
                                    {{ $seatNumber }}
                                </div>
                            </div>

                            @php $currentSlot += $slotSpan; @endphp
                            @if($currentSlot === floor($totalSlots / 2))
                            <div class="aisle"></div>
                            @endif
                            @endforeach
                        </div>
                        @endforeach
                    </div>

                    <div class="seat-legend">
                        <div class="legend-item">
                            <div class="legend-seat available"></div><span>Ghế trống</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-seat selected"></div><span>Đang chọn</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-seat booked"></div><span>Đã đặt</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-seat vip"></div><span>Ghế VIP</span>
                        </div>
                    </div>

                    <div class="seat-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $totalSeats }}</div>
                            <div class="stat-label">Tổng ghế</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $seats->where('is_available', true)->count() }}</div>
                            <div class="stat-label">Còn trống</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $seats->where('is_available', false)->count() }}</div>
                            <div class="stat-label">Đã đặt</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ count($selectedSeats) }}</div>
                            <div class="stat-label">Đang chọn</div>
                        </div>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Lỗi tải dữ liệu</h4>
                        <p>Phòng hiện tại: {{ $roomId ?: 'chưa chọn' }}</p>
                        <p>Không thể tải sơ đồ ghế cho suất chiếu này</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        @endif
    </div>

    @endsection