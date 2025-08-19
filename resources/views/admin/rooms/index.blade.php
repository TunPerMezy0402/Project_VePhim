@extends('admin.layouts.AdminLayout')

@section('content')

{{-- Action Buttons --}}
@include('admin.layouts.partials.cinemas')

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
        --glass-bg: rgba(255, 255, 255, 0.25);
        --glass-border: rgba(255, 255, 255, 0.18);
        --shadow-light: 0 8px 32px rgba(31, 38, 135, 0.37);
        --shadow-hover: 0 15px 35px rgba(31, 38, 135, 0.5);
        --border-radius: 16px;
        --transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
    }



    /* Responsive Grid */
    @media (min-width: 1400px) {
        .custom-col-5 { flex: 0 0 20%; max-width: 20%; }
    }
    @media (max-width: 1399px) {
        .custom-col-5 { flex: 0 0 25%; max-width: 25%; }
    }
    @media (max-width: 1199px) {
        .custom-col-5 { flex: 0 0 33.333%; max-width: 33.333%; }
    }
    @media (max-width: 991px) {
        .custom-col-5 { flex: 0 0 50%; max-width: 50%; }
    }
    @media (max-width: 575px) {
        .custom-col-5 { flex: 0 0 100%; max-width: 100%; }
    }

    /* Glassmorphism Card */
    .room-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: var(--border-radius);
        padding: 24px;
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .room-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary-gradient);
        transform: scaleX(0);
        transition: var(--transition);
        transform-origin: left;
    }

    .room-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: var(--shadow-hover);
        background: rgba(255, 255, 255, 0.35);
    }

    .room-card:hover::before {
        transform: scaleX(1);
    }

    /* Room Header */
    .room-header {
        text-align: center;
        margin-bottom: 20px;
        position: relative;
    }

    .room-number {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.5rem;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    /* Stats Section */
    .room-stats {
        flex: 1;
        margin-bottom: 20px;
    }

    .total-capacity {
        background: var(--success-gradient);
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        margin-bottom: 16px;
        position: relative;
        overflow: hidden;
    }

    .total-capacity::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: var(--transition);
    }

    .room-card:hover .total-capacity::before {
        left: 100%;
    }

    .capacity-number {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .capacity-label {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.9);
        margin: 0;
        font-weight: 500;
    }

    /* Seat Types Grid */
    .seat-types-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .seat-type-item {
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        transition: var(--transition);
        backdrop-filter: blur(5px);
    }

    .seat-type-item:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: scale(1.05);
    }

    .seat-icon {
        font-size: 1.2rem;
        margin-bottom: 4px;
        display: block;
    }

    .seat-icon.single { color: #3182ce; }
    .seat-icon.couple { color: #e53e3e; }
    .seat-icon.single-vip { color: #d69e2e; }
    .seat-icon.couple-vip { color: #38a169; }

    .seat-count {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }

    .seat-label {
        font-size: 0.75rem;
        color: #718096;
        margin: 0;
        font-weight: 500;
    }

    /* Modern Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        margin-top: auto;
    }

    .modern-btn {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modern-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: var(--transition);
    }

    .modern-btn:hover::before {
        left: 100%;
    }

    .btn-view-modern {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-view-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        color: white;
    }

    .btn-view-modern .btn-icon {
        transition: var(--transition);
        margin-right: 6px;
    }

    .btn-view-modern .btn-text {
        transition: var(--transition);
    }

    .btn-view-modern:hover .btn-icon {
        opacity: 0;
        transform: translateX(-10px);
    }

    .btn-view-modern:hover .btn-text {
        transform: translateX(-8px);
    }

    .btn-edit-modern {
        background: var(--warning-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(67, 233, 123, 0.4);
    }

    .btn-edit-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(67, 233, 123, 0.6);
        color: white;
    }


    .header-card {
        background: rgb(18, 31, 46);
        
        padding: 20px 24px;
        margin-bottom: 20px
    }

    /* Modern Search */
    .search-modern {
        position: relative;
        max-width: 400px;
    }

    .search-modern input {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid transparent;
        border-radius: 25px;
        padding: 12px 50px 12px 20px;
        font-size: 0.95rem;
        transition: var(--transition);
        backdrop-filter: blur(10px);
    }

    .search-modern input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: rgba(255, 255, 255, 1);
    }

    .search-modern button {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--primary-gradient);
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        color: white;
    }

    .search-modern button:hover {
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    /* Modern Action Buttons in Header */
    .header-actions .btn {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 500;
        transition: var(--transition);
        color: #4a5568;
    }

    .header-actions .btn:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        color: #2d3748;
    }

    /* Empty State Modern */
    .empty-state-modern {
        text-align: center;
        padding: 80px 20px;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
    }

    .empty-state-modern .empty-icon {
        font-size: 5rem;
        background: var(--secondary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 20px;
    }

    .empty-state-modern h4 {
        color: #2d3748;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .empty-state-modern p {
        color: #718096;
        margin-bottom: 30px;
    }

    .empty-state-modern .btn {
        background: var(--primary-gradient);
        border: none;
        border-radius: 25px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .empty-state-modern .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    /* Pagination Modern */
    .pagination-modern {
        justify-content: center;
        margin-top: 40px;
        gap: 8px;
    }

    .pagination-modern .page-link {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 12px 16px;
        color: #4a5568;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
    }

    .pagination-modern .page-link:hover {
        background: var(--primary-gradient);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .pagination-modern .page-item.active .page-link {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    /* Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .room-card {
        animation: slideInUp 0.6s cubic-bezier(0.23, 1, 0.320, 1);
    }

    .room-card:nth-child(1) { animation-delay: 0.1s; }
    .room-card:nth-child(2) { animation-delay: 0.15s; }
    .room-card:nth-child(3) { animation-delay: 0.2s; }
    .room-card:nth-child(4) { animation-delay: 0.25s; }
    .room-card:nth-child(5) { animation-delay: 0.3s; }

    /* Loading States */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--border-radius);
        z-index: 10;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(102, 126, 234, 0.2);
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

{{-- Header Card --}}
<div class="header-card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            {{-- Form tìm kiếm --}}
            <form action="{{ route('admin.cinemas.rooms.index', ['cinema' => $cinema->id]) }}" method="GET" class="w-100 w-md-auto">
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

{{-- Rooms Grid --}}
<div class="card-body">
    <div class="row" id="roomsContainer">
        @if ($rooms->count())
            @foreach ($rooms as $room)
                <div class="custom-col-5 mb-4">
                    <div class="room-card">
                        {{-- Room Header --}}
                        <div class="room-header">
                            <h5 class="room-number">{{ $room->name }}</h5>
                        </div>

                        {{-- Room Stats --}}
                        <div class="room-stats">
                            {{-- Total Capacity --}}
                            <div class="total-capacity">
                                <h3 class="capacity-number">{{ $room->total_seats }}</h3>
                                <p class="capacity-label">Tổng sức chứa</p>
                            </div>

                            {{-- Seat Types Grid --}}
                            <div class="seat-types-grid">
                                @php
                                    $seatTypes = [
                                        'single' => ['label' => 'Đơn thường', 'icon' => 'fa-chair', 'class' => 'single'],
                                        'couple' => ['label' => 'Đôi thường', 'icon' => 'fa-heart', 'class' => 'couple'],
                                        'single_vip' => ['label' => 'VIP Đơn', 'icon' => 'fa-crown', 'class' => 'single-vip'],
                                        'couple_vip' => ['label' => 'VIP Đôi', 'icon' => 'fa-gem', 'class' => 'couple-vip'],
                                    ];
                                @endphp
                                @foreach($seatTypes as $type => $info)
                                    <div class="seat-type-item">
                                        <i class="fas {{ $info['icon'] }} seat-icon {{ $info['class'] }}"></i>
                                        <p class="seat-count">{{ $room->seat_stats[$type] ?? 0 }}</p>
                                        <p class="seat-label">{{ $info['label'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- Modern Action Buttons --}}
                        <div class="action-buttons">
                            <a href="{{ route('admin.cinemas.rooms.show', [$cinema->id, $room->id]) }}"
                               class="modern-btn btn-view-modern"
                               onclick="event.stopPropagation();">
                                <i class="fas fa-eye btn-icon"></i>
                                <span class="btn-text">Chi tiết</span>
                            </a>
                            <a href="{{ route('admin.cinemas.rooms.edit', [$cinema->id, $room->id]) }}" class="modern-btn btn-edit-modern"
                               onclick="event.stopPropagation(); editRoom({{ $room->id }})">
                                <i class="fas fa-edit me-1"></i>Sửa
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="empty-state-modern">
                    <div class="empty-icon">
                        <i class="fas fa-door-closed"></i>
                    </div>
                    <h4>Chưa có phòng chiếu nào</h4>
                    <p>Hãy tạo phòng chiếu đầu tiên cho rạp này!</p>
                    <a href="{{ route('admin.cinemas.rooms.create', $cinema->id) }}" class="btn">
                        <i class="fas fa-plus me-2"></i>Tạo Phòng Chiếu
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Modern Pagination --}}
@if ($rooms->hasPages())
    <div class="d-flex pagination-modern">
        {!! $rooms->links('pagination::bootstrap-5') !!}
    </div>
@endif


@endsection