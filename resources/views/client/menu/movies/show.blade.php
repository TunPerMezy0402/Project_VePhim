@extends('client.layouts.ClientLayout')
@section('content')
    <div class="movie-header">
    <div class="movie-info">
        <img src="https://images.unsplash.com/photo-1608270586620-248524c67de9?w=300&h=450&fit=crop"
            alt="Avengers: Endgame" class="movie-poster">
        <div class="movie-details">
            <h1>Avengers: Endgame</h1>
            <div class="movie-meta">
                <span class="meta-item">181 phút</span>
                <span class="meta-item">Hành động</span>
                <span class="meta-item">T13</span>
                <span class="meta-item">2D/3D</span>
            </div>
            <div class="rating">
                <div class="stars">★★★★★</div>
                <span><strong>9.2/10</strong> (89,456 đánh giá)</span>
            </div>
            <p class="description">
                Sau thảm họa xảy ra trong "Avengers: Infinity War", vũ trụ đang trong tình trạng hỗn loạn.
                Với sự giúp đỡ của các đồng minh còn lại, các Avengers tập hợp một lần nữa để đảo ngược
                hành động của Thanos và khôi phục lại trật tự của vũ trụ bằng mọi giá cần thiết.
            </p>
            <p><strong>Đạo diễn:</strong> Anthony Russo, Joe Russo</p>
            <p><strong>Diễn viên:</strong> Robert Downey Jr., Chris Evans, Mark Ruffalo, Chris Hemsworth</p>
        </div>
    </div>
</div>

<div class="booking-section">
    <h2 class="section-title">Đặt Vé Xem Phim</h2>

    <div>
        <h3 style="margin-bottom: 15px; color: #2c3e50;">Chọn Suất Chiếu</h3>
        <div class="showtime-grid" id="showtimeGrid">
            <div class="showtime-btn" data-time="09:00" data-price="100000">
                <div>09:00</div>
                <div>100.000đ</div>
            </div>
            <div class="showtime-btn" data-time="12:30" data-price="120000">
                <div>12:30</div>
                <div>120.000đ</div>
            </div>
            <div class="showtime-btn" data-time="15:45" data-price="120000">
                <div>15:45</div>
                <div>120.000đ</div>
            </div>
            <div class="showtime-btn" data-time="18:20" data-price="150000">
                <div>18:20</div>
                <div>150.000đ</div>
            </div>
            <div class="showtime-btn" data-time="21:00" data-price="150000">
                <div>21:00</div>
                <div>150.000đ</div>
            </div>
            <div class="showtime-btn" data-time="23:30" data-price="130000">
                <div>23:30</div>
                <div>130.000đ</div>
            </div>
        </div>
    </div>

    <div>
        <h3 style="margin-bottom: 15px; color: #2c3e50;">Chọn Ghế</h3>
        <div class="seat-map">
            <div class="screen"></div>
            <div class="screen-label">MÀN HÌNH</div>
            <div id="seatMap"></div>
            <div class="seat-legend">
                <div class="legend-item">
                    <div class="legend-seat available" style="background: #e8f5e8; border: 2px solid #4caf50;">
                    </div>
                    <span>Trống</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat selected" style="background: linear-gradient(45deg, #667eea, #764ba2);">
                    </div>
                    <span>Đã chọn</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat occupied" style="background: #ffebee; border: 2px solid #f44336;"></div>
                    <span>Đã bán</span>
                </div>
            </div>
        </div>
    </div>

    <div class="booking-summary" id="bookingSummary" style="display: none;">
        <h3 style="margin-bottom: 15px; color: #2c3e50;">Thông Tin Đặt Vé</h3>
        <div class="summary-row">
            <span>Phim:</span>
            <span>Avengers: Endgame</span>
        </div>
        <div class="summary-row">
            <span>Suất chiếu:</span>
            <span id="selectedTime">-</span>
        </div>
        <div class="summary-row">
            <span>Ghế đã chọn:</span>
            <span id="selectedSeats">-</span>
        </div>
        <div class="summary-row">
            <span>Số lượng vé:</span>
            <span id="ticketCount">0</span>
        </div>
        <div class="summary-row total">
            <span>Tổng tiền:</span>
            <span id="totalPrice">0đ</span>
        </div>
    </div>

    <button class="book-btn" id="bookBtn" disabled>Chọn suất chiếu và ghế</button>
</div>
@endsection