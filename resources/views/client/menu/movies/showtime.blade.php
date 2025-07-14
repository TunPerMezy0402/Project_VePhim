@extends('client.layouts.ClientLayout')

@section('content')
     <div class="page-header">
            <h1>Lịch Chiếu Phim</h1>
            <p>Khám phá lịch chiếu các bộ phim hot nhất tại Cinema Galaxy</p>
        </div>

        <!-- Date Navigation -->
        <div class="date-nav">
            <div class="date-tabs">
                <div class="date-tab past" data-date="2024-12-23" onclick="selectDate(this)">
                    <div class="date-display">23/12</div>
                    <div class="day-name">Thứ Hai</div>
                </div>
                <div class="date-tab past" data-date="2024-12-24" onclick="selectDate(this)">
                    <div class="date-display">24/12</div>
                    <div class="day-name">Thứ Ba</div>
                </div>
                <div class="date-tab past" data-date="2024-12-25" onclick="selectDate(this)">
                    <div class="date-display">25/12</div>
                    <div class="day-name">Hôm qua</div>
                </div>
                <div class="date-tab today active" data-date="2024-12-26" onclick="selectDate(this)">
                    <div class="date-display">26/12</div>
                    <div class="day-name">Hôm nay</div>
                </div>
                <div class="date-tab" data-date="2024-12-27" onclick="selectDate(this)">
                    <div class="date-display">27/12</div>
                    <div class="day-name">Ngày mai</div>
                </div>
                <div class="date-tab" data-date="2024-12-28" onclick="selectDate(this)">
                    <div class="date-display">28/12</div>
                    <div class="day-name">Thứ Bảy</div>
                </div>
                <div class="date-tab" data-date="2024-12-29" onclick="selectDate(this)">
                    <div class="date-display">29/12</div>
                    <div class="day-name">Chủ Nhật</div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-title">Lọc theo thể loại:</div>
            <div class="filter-options">
                <button class="filter-btn active" onclick="filterGenre('all')">Tất cả</button>
                <button class="filter-btn" onclick="filterGenre('action')">Hành động</button>
                <button class="filter-btn" onclick="filterGenre('comedy')">Hài kịch</button>
                <button class="filter-btn" onclick="filterGenre('horror')">Kinh dị</button>
                <button class="filter-btn" onclick="filterGenre('romance')">Lãng mạn</button>
                <button class="filter-btn" onclick="filterGenre('animation')">Hoạt hình</button>
            </div>
        </div>

        <!-- Schedule Content -->
        <div class="schedule-content" id="scheduleContent">
            <div class="schedule-date-header">
                <div class="schedule-date-title" id="selectedDateTitle">Hôm nay - 26/12/2024</div>
                <div class="schedule-date-subtitle" id="selectedDateSubtitle">Thứ Năm</div>
            </div>

            <!-- Theater 1 -->
            <div class="theater-section">
                <div class="theater-header">
                    <div class="theater-icon">🏢</div>
                    <div class="theater-info">
                        <h3>Cinema Galaxy Landmark 81</h3>
                        <div class="theater-address">Tầng 3-4, Landmark 81, Q. Bình Thạnh, TP.HCM</div>
                    </div>
                </div>

                <div class="movies-list">
                    <div class="movie-schedule" data-genre="action">
                        <div class="movie-header">
                            <img src="https://images.unsplash.com/photo-1509347528160-9a9e33742cdb?w=200&h=300&fit=crop"
                                alt="Avatar 3" class="movie-poster">
                            <div class="movie-info">
                                <div class="movie-title">Avatar: The Way of Water 3</div>
                                <div class="movie-meta">
                                    <span class="meta-tag">Hành động</span>
                                    <span class="meta-tag">Khoa học viễn tưởng</span>
                                    <span class="meta-tag">192 phút</span>
                                    <span class="meta-tag">T13</span>
                                </div>
                                <div class="movie-rating">
                                    <span class="stars">⭐⭐⭐⭐⭐</span>
                                    <span class="rating-text">8.7/10 (1,234 đánh giá)</span>
                                </div>
                                <div class="movie-description">
                                    Cuộc phiêu lưu tiếp theo của gia đình Jake Sully trong thế giới Pandora huyền
                                    diệu...
                                </div>
                            </div>
                        </div>
                        <div class="showtimes-section">
                            <div class="showtimes-label">Suất chiếu:</div>
                            <div class="showtimes-grid">
                                <button class="showtime-btn past">09:00</button>
                                <button class="showtime-btn past">12:30</button>
                                <button class="showtime-btn available">15:45</button>
                                <button class="showtime-btn few-seats">18:30</button>
                                <button class="showtime-btn available">21:15</button>
                                <button class="showtime-btn available">23:45</button>
                            </div>
                        </div>
                    </div>

                    <div class="movie-schedule" data-genre="comedy">
                        <div class="movie-header">
                            <img src="https://images.unsplash.com/photo-1489599894451-c5e3a7e41b15?w=200&h=300&fit=crop"
                                alt="Em Là Báu Vật" class="movie-poster">
                            <div class="movie-info">
                                <div class="movie-title">Em Là Báu Vật Của Anh</div>
                                <div class="movie-meta">
                                    <span class="meta-tag">Hài kịch</span>
                                    <span class="meta-tag">Lãng mạn</span>
                                    <span class="meta-tag">108 phút</span>
                                    <span class="meta-tag">T16</span>
                                </div>
                                <div class="movie-rating">
                                    <span class="stars">⭐⭐⭐⭐</span>
                                    <span class="rating-text">7.5/10 (892 đánh giá)</span>
                                </div>
                                <div class="movie-description">
                                    Câu chuyện tình yêu ngọt ngào và hài hước giữa cặp đôi trẻ...
                                </div>
                            </div>
                        </div>
                        <div class="showtimes-section">
                            <div class="showtimes-label">Suất chiếu:</div>
                            <div class="showtimes-grid">
                                <button class="showtime-btn past">10:15</button>
                                <button class="showtime-btn past">13:45</button>
                                <button class="showtime-btn available">16:30</button>
                                <button class="showtime-btn available">19:00</button>
                                <button class="showtime-btn few-seats">21:30</button>
                            </div>
                        </div>
                    </div>

                    <div class="movie-schedule" data-genre="horror">
                        <div class="movie-header">
                            <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=200&h=300&fit=crop"
                                alt="The Nun 3" class="movie-poster">
                            <div class="movie-info">
                                <div class="movie-title">The Nun 3: The Awakening</div>
                                <div class="movie-meta">
                                    <span class="meta-tag">Kinh dị</span>
                                    <span class="meta-tag">Siêu nhiên</span>
                                    <span class="meta-tag">96 phút</span>
                                    <span class="meta-tag">T18</span>
                                </div>
                                <div class="movie-rating">
                                    <span class="stars">⭐⭐⭐⭐</span>
                                    <span class="rating-text">6.8/10 (567 đánh giá)</span>
                                </div>
                                <div class="movie-description">
                                    Sự trở lại đáng sợ của ác ma Valak trong tu viện bị nguyền rủa...
                                </div>
                            </div>
                        </div>
                        <div class="showtimes-section">
                            <div class="showtimes-label">Suất chiếu:</div>
                            <div class="showtimes-grid">
                                <button class="showtime-btn past">14:00</button>
                                <button class="showtime-btn available">17:15</button>
                                <button class="showtime-btn available">20:00</button>
                                <button class="showtime-btn few-seats">22:30</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection