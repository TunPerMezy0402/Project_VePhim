@extends('admin.layouts.AdminLayout')

@section('content')
<style>
    :root {
        --primary: #1bb1d3;
        --secondary: #ff6b6b;
        --accent: #fd79a8;
        --warning: #fdcb6e;
        --success: #28a745;
        --error: #e17055;
        --dark: #2d3436;
        --light: #f8f9fa;
        --white: #ffffff;
        --black: #000;
        --border: #ddd;
        --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        --radius: 8px;
        --transition: all 0.3s ease;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: var(--white);
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 15px;
        text-align: center;
    }

    .page-header .subtitle {
        opacity: 0.9;
        margin-top: 0.5rem;
        font-size: 1.1rem;
    }

    .card {
        background: var(--white);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .card h5 {
        color: var(--dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        color: var(--white);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.single {
        background: linear-gradient(135deg, var(--success), #55a3ff);
    }

    .stat-card.couple {
        background: linear-gradient(135deg, var(--error), var(--secondary));
    }

    .stat-card.vip {
        background: linear-gradient(135deg, var(--accent), var(--warning));
    }

    .stat-card.number {
        background: linear-gradient(135deg, var(--accent), var(--primary));
    }

    .stat-card.total {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .stat-card h6 {
        margin-bottom: 0.5rem;
        opacity: 0.9;
        font-weight: 600;
    }

    .stat-card h3 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .cinema-screen {
        background: linear-gradient(135deg, var(--dark), #636e72);
        color: var(--white);
        height: 50px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
    }

    .seat-area {
        display: flex;
        gap: 12px;
        background: var(--light);
        padding: 1.5rem;
        border-radius: 15px;
        overflow-x: auto;
        justify-content: center;
    }

    .seat {
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        background: var(--success);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        transition: var(--transition);
        box-shadow: var(--shadow);
        cursor: default;
    }

    .seat.couple {
        width: 86px;
        background: var(--secondary)
    }

    .seat.vip {
        background: linear-gradient(135deg, var(--accent), var(--warning));
    }

    .row-label {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: var(--white);
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        cursor: default;
    }

    .row-label.vip {
        background: linear-gradient(135deg, var(--accent), var(--warning));
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: var(--light);
        border-radius: var(--radius);
        margin-bottom: 0.5rem;
    }

    .info-label {
        font-weight: 600;
        color: var(--dark);
    }

    .info-value {
        font-weight: 700;
        color: var(--primary);
    }

    .price-value {
        color: var(--error);
        font-weight: 700;
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: var(--radius);
        font-weight: 600;
        cursor: pointer;
        color: var(--white);
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        text-decoration: none;
        color: var(--white);
    }

    .btn-action.primary {
        background: linear-gradient(135deg, var(--primary), #20a745);
    }

    .btn-action.warning {
        background: linear-gradient(135deg, var(--warning), #e17055);
        color: var(--dark);
    }

    .btn-action.danger {
        background: linear-gradient(135deg, var(--error), var(--secondary));
    }

    .btn-action.info {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .legend {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
    }

    .legend-color.single {
        background: var(--success);
    }

    .legend-color.couple {
        background: var(--error);
    }

    .legend-color.vip {
        background: linear-gradient(135deg, var(--accent), var(--warning));
    }


    .legend-color.unavailable {
        background: #95a5a6;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .seat {
            width: 30px;
            height: 30px;
            font-size: 10px;
        }

        .seat.couple {
            width: 64px;
            background: var(--secondary)
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.active {
        background: var(--success);
        color: var(--white);
    }

    .status-badge.inactive {
        background: var(--error);
        color: var(--white);
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('admin.cinemas.rooms.index', $cinema->id) }}" class="btn-action info">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>
    
{{--     <div class="d-flex gap-2">
        <span class="status-badge {{ $room->status === 'active' ? 'active' : 'inactive' }}">
            {{ $room->status === 'active' ? 'Đang hoạt động' : 'Tạm dừng' }}
        </span>
    </div> --}}
</div>

<div class="page-header">
    <h1><i class="fas fa-theater-masks me-3"></i>{{ $room->name }}</h1>
    <div class="subtitle">Rạp {{ $cinema->name }} - Chi tiết cấu hình phòng chiếu</div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card single">
                <h6>Ghế đơn</h6>
                <h3>{{ ($room->seat_stats['single'] ?? 0) + ($room->seat_stats['single_vip'] ?? 0) }}</h3>
            </div>
            <div class="stat-card couple">
                <h6>Ghế đôi</h6>
                <h3>{{ ($room->seat_stats['couple'] ?? 0) + ($room->seat_stats['couple_vip'] ?? 0) }}</h3>
            </div>
            <div class="stat-card vip">
                <h6>Ghế VIP</h6>
                <h3>{{ ($room->seat_stats['single_vip'] ?? 0) + ($room->seat_stats['couple_vip'] ?? 0) }}</h3>
            </div>
            <div class="stat-card number">
                <h6>Tổng số ghế</h6>
                <h3>{{ $room->seats->count() }}</h3>
            </div>
            <div class="stat-card total">
                <h6>Tổng sức chứa</h6>
                <h3>{{ ($room->seat_stats['single'] ?? 0) + ($room->seat_stats['single_vip'] ?? 0) + (($room->seat_stats['couple'] ?? 0) + ($room->seat_stats['couple_vip'] ?? 0)) * 2 }}</h3>
            </div>
        </div>

        <!-- Seat Layout -->
        <div class="card">
            <h5><i class="fas fa-couch"></i> Sơ đồ ghế ngồi</h5>
            
            <div class="cinema-screen">
                <i class="fas fa-tv me-2"></i>MÀN HÌNH CHIẾU
            </div>

            <div class="seat-area">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($room->seatRows->sortBy('row_order') as $row)
                        <div class="row-label {{ $row->type === 'vip' ? 'vip' : '' }}">
                            {{ $row->row_label }}
                        </div>
                    @endforeach
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($room->seatRows->sortBy('row_order') as $row)
                        <div style="display: flex; gap: 6px;">
                            @foreach($room->seats->filter(function($seat) use ($row) { return strpos($seat->seat_number, $row->row_label) === 0; })->sortBy('seat_number') as $seat)
                                <div class="seat 
                                    {{ $seat->seat_chair === 'couple' ? 'couple' : '' }}
                                    {{ $row->type === 'vip' ? 'vip' : '' }}
                                    {{ $seat->status !== 'available' ? 'unavailable' : '' }}"
                                    title="Ghế {{ $seat->seat_number }} - {{ number_format($seat->price) }}đ">
                                    {{ $seat->seat_number }}
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Legend -->
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color single"></div>
                    <span>Ghế đơn</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color couple"></div>
                    <span>Ghế đôi</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color vip"></div>
                    <span>Ghế VIP</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color unavailable"></div>
                    <span>Không khả dụng</span>
                </div>
            </div>
        </div>
        <div class="card mt-4">
    <h5><i class="fas fa-chart-bar"></i> Thống kê chi tiết</h5>
    <div class="row">
        <div class="col-md-6">
            <h6>Phân bố ghế theo loại</h6>
            <div class="info-item">
                <span class="info-label">Ghế đơn thường:</span>
                <span class="info-value">{{ $room->seat_stats['single'] ?? 0 }} ghế</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ghế đơn VIP:</span>
                <span class="info-value">{{ $room->seat_stats['single_vip'] ?? 0 }} ghế</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ghế đôi thường:</span>
                <span class="info-value">{{ $room->seat_stats['couple'] ?? 0 }} ghế</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ghế đôi VIP:</span>
                <span class="info-value">{{ $room->seat_stats['couple_vip'] ?? 0 }} ghế</span>
            </div>
        </div>
        <div class="col-md-6">
            <h6>Doanh thu tiềm năng (nếu full)</h6>
            @php
                $totalRevenue = 0;
                foreach($room->seats as $seat) {
                    $totalRevenue += $seat->price;
                }
            @endphp
            <div class="info-item">
                <span class="info-label">Tổng doanh thu:</span>
                <span class="price-value">{{ number_format($totalRevenue) }}đ</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ngày tạo:</span>
                <span class="info-value">{{ $room->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Cập nhật lần cuối:</span>
                <span class="info-value">{{ $room->updated_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
</div>
    </div>

    <div class="col-lg-4">
        <!-- Room Information -->
        <div class="card">
            <h5><i class="fas fa-info-circle"></i> Thông tin phòng</h5>
            <div class="info-item">
                <span class="info-label">Tên phòng:</span>
                <span class="info-value">{{ $room->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Rạp chiếu:</span>
                <span class="info-value">{{ $cinema->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tổng số hàng:</span>
                <span class="info-value">{{ $room->seatRows->count() }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tổng số ghế:</span>
                <span class="info-value">{{ $room->seats->count() }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Sức chứa tối đa:</span>
                <span class="info-value">{{ ($room->seat_stats['single'] ?? 0) + ($room->seat_stats['single_vip'] ?? 0) + (($room->seat_stats['couple'] ?? 0) + ($room->seat_stats['couple_vip'] ?? 0)) * 2 }} người</span>
            </div>
            <a href="{{ route('admin.cinemas.rooms.edit', ['cinema' => $cinema->id, 'room' => $room->id]) }}" 
               class="btn btn-primary warning">
                <i class="fas fa-edit"></i> Chỉnh sửa
            </a>
        </div>

        <!-- Pricing Information -->
        <div class="card">
            <h5><i class="fas fa-dollar-sign"></i> Bảng giá</h5>
            @php
                $sampleSingleSeat = $room->seats->where('seat_chair', 'single')/* ->where('status', 'available') */->first();
                $sampleCoupleSeat = $room->seats->where('seat_chair', 'couple')/* ->where('status', 'available') */->first();
                $sampleVipSingleSeat = $room->seats->filter(function($seat) use ($room) {
                    $seatRow = $room->seatRows->firstWhere('row_label', substr($seat->seat_number, 0, 1));
                    return $seat->seat_chair === 'single' && $seatRow && $seatRow->type === 'vip';
                })->first();
                $sampleVipCoupleSeat = $room->seats->filter(function($seat) use ($room) {
                    $seatRow = $room->seatRows->firstWhere('row_label', substr($seat->seat_number, 0, 1));
                    return $seat->seat_chair === 'couple' && $seatRow && $seatRow->type === 'vip';
                })->first();
            @endphp
            <div class="info-item">
                <span class="info-label">Ghế thường:</span>
                <span class="price-value">{{ number_format($sampleSingleSeat->price ?? 0) }}đ</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ghế VIP:</span>
                <span class="price-value">{{ number_format($sampleVipSingleSeat->price ?? 0) }}đ</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ghế đôi thường:</span>
                <span class="price-value">{{ number_format($sampleCoupleSeat->price ?? 0) }}đ</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ghế đôi VIP:</span>
                <span class="price-value">{{ number_format($sampleVipCoupleSeat->price ?? 0) }}đ</span>
            </div>
        </div>

        <!-- Row Configuration -->
        <div class="card">
            <h5><i class="fas fa-list"></i> Cấu hình hàng</h5>
            <div style="max-height: 300px; overflow-y: auto;">
                @foreach($room->seatRows->sortBy('row_order') as $row)
                    @php
                        $seatsInRow = $room->seats->filter(function($seat) use ($row) {
                            return strpos($seat->seat_number, $row->row_label) === 0;
                        })->count();
                    @endphp
                    <div class="info-item">
                        <div>
                            <span class="info-label">Hàng {{ $row->row_label }}</span>
                            <span class="status-badge {{ $row->type === 'vip' ? 'active' : 'inactive' }}" style="margin-left: 0.5rem; font-size: 0.7rem;">
                                {{ $row->type === 'vip' ? 'VIP' : 'Thường' }}
                            </span>
                        </div>
                        <span class="info-value">{{ $seatsInRow }} ghế</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            {{-- @if($room->status === 'active')
                <form method="POST" action="{{ route('admin.cinemas.rooms.toggle-status', ['cinema' => $cinema->id, 'room' => $room->id]) }}" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-action danger" onclick="return confirm('Bạn có chắc muốn tạm dừng phòng này?')">
                        <i class="fas fa-pause"></i> Tạm dừng
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.cinemas.rooms.toggle-status', ['cinema' => $cinema->id, 'room' => $room->id]) }}" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-action primary" onclick="return confirm('Bạn có chắc muốn kích hoạt phòng này?')">
                        <i class="fas fa-play"></i> Kích hoạt
                    </button>
                </form>
            @endif --}}
        </div>
    </div>
</div>

<!-- Room Statistics Details -->


@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@endsection