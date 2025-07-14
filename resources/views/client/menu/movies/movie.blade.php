@extends('client.layouts.ClientLayout')

@section('content')
<h1 class="page-title">🎬 Đặt Vé Phim</h1>

<!-- Filter Section -->
<div class="filter-section">
    <h2 class="filter-title">
        🔍 Bộ Lọc Tìm Kiếm
    </h2>

    <div class="filter-grid">
        <div class="filter-group">
            <label class="filter-label">
                🎭 Thể loại
            </label>
            <select class="filter-select" id="genreFilter">
                <option value="">Tất cả thể loại</option>
                <option value="action">Hành động</option>
                <option value="comedy">Hài kịch</option>
                <option value="drama">Chính kịch</option>
                <option value="horror">Kinh dị</option>
                <option value="romance">Lãng mạn</option>
                <option value="animation">Hoạt hình</option>
                <option value="thriller">Ly kỳ</option>
            </select>
        </div>

        <div class="filter-group">
            <label class="filter-label">
                ⭐ Quốc gia
            </label>
            <select class="filter-select" id="ratingFilter">
                <option value="">Tất cả quốc gia</option>
                <option value="4+">Việt Nam</option>
                <option value="3+">Hàn Quốc</option>
                <option value="2+">Mỹ</option>
            </select>
        </div>

        <div class="filter-group">
            <label class="filter-label">
                🏢 Rạp chiếu
            </label>
            <select class="filter-select" id="cinemaFilter">
                <option value="">Tất cả rạp</option>
                <option value="galaxy-nguyen-trai">Galaxy Nguyễn Trãi</option>
                <option value="galaxy-tan-binh">Galaxy Tân Bình</option>
                <option value="galaxy-kinh-duong">Galaxy Kinh Dương Vương</option>
                <option value="galaxy-linh-dam">Galaxy Linh Đàm</option>
            </select>
        </div>

        <div class="filter-group">
            <label class="filter-label">
                ⏰ Khung giờ
            </label>
            <select class="filter-select" id="timeFilter">
                <option value="">Tất cả giờ</option>
                <option value="morning">Buổi sáng (6:00 - 12:00)</option>
                <option value="afternoon">Buổi chiều (12:00 - 18:00)</option>
                <option value="evening">Buổi tối (18:00 - 24:00)</option>
            </select>
        </div>

    </div>

    <div class="filter-buttons">
        <button class="filter-btn" onclick="applyFilters()">
            🔍 Áp dụng bộ lọc
        </button>
        <button class="reset-btn" onclick="resetFilters()">
            🔄 Đặt lại
        </button>
    </div>
</div>

<!-- Movies Container -->
<div class="movies-container">
    <div class="results-header">
        <div class="results-count" id="resultsCount">
            Tìm thấy 12 bộ phim
        </div>
        <div class="sort-controls">
            <label>Sắp xếp theo:</label>
            <select class="sort-select" id="sortBy" onchange="sortMovies()">
                <option value="popular">Phổ biến</option>
                <option value="rating">Đánh giá cao</option>
                <option value="price-low">Giá thấp đến cao</option>
                <option value="price-high">Giá cao đến thấp</option>
                <option value="name">Tên A-Z</option>
            </select>
        </div>
    </div>

    <div class="movies-grid" id="moviesGrid">
        <!-- Movies will be dynamically loaded here -->
    </div>

    <div class="pagination" id="pagination">
        <!-- Pagination will be dynamically loaded here -->
    </div>
</div>
@endsection