@extends('admin.layouts.AdminLayout')

@section('content')
{{-- Nút quay lại --}}
<a href="{{ route('admin.cinemas.index') }}" class="btn btn-danger btn-sm mb-3">
    <i class="fas fa-arrow-left me-1"></i> Quay lại
</a>

{{-- Thông báo --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Action Buttons --}}
@include('admin.layouts.partials.cinemas')

{{-- Card: Header & Actions --}}
<div class="card mb-4 shadow-sm">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">

        {{-- Search + Sort --}}
        <div class="d-flex flex-grow-1 flex-md-grow-0 gap-2">
            {{-- Tìm kiếm --}}
            <div class="input-group input-group-sm">
                <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm phim...">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>
            </div>

            {{-- Sắp xếp --}}
            <select id="sortSelect" class="form-select form-select-sm">
                <option value="created_desc">Tạo mới nhất</option>
                <option value="created_asc">Tạo cũ nhất</option>
                <option value="release_desc">Năm phát hành mới nhất</option>
                <option value="release_asc">Năm phát hành cũ nhất</option>
            </select>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.cinemas.movies.create', $cinema->id) }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1"></i> Quản lý phim
            </a>

            <a href="{{ route('admin.cinemas.trash') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-trash-alt me-1"></i> Thùng Rác
            </a>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="card-body">
        @if($movies->count())
        <div class="row g-4" id="moviesContainer">
            @foreach($movies as $movie)
            <div class="col-6 col-md-4 col-lg custom-col-5 movie-item"
                data-created="{{ $movie->created_at->timestamp }}"
                data-release="{{ \Carbon\Carbon::parse($movie->release_date)->timestamp }}">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $movie->image ? asset('storage/' . $movie->image) : asset('assets/img/generic/notimage.png') }}"
                        alt="{{ $movie->title }}" class="card-img-top" style="height: 250px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate">{{ $movie->title }}</h5>
                        <p class="mb-1"><strong>⏱ Thời lượng:</strong> {{ $movie->duration }} phút</p>
                        <p class="mb-1"><strong>📅 Khởi chiếu:</strong>
                            {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}
                        </p>
                        <p class="mb-3"><strong>🌍 Quốc gia:</strong> {{ $movie->country->name ?? 'N/A' }}</p>

                        <a href="{{ route('admin.movies.show', $movie->id) }}"
                            class="btn btn-sm btn-outline-primary mt-auto w-100">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Phân trang --}}
        <div class="mt-4 d-flex justify-content-center">
            {!! $movies->links('pagination::bootstrap-5') !!}
        </div>
        @else
        <div class="alert alert-warning text-center mb-0">
            🚫 Hiện tại chưa có phim nào đang được chiếu tại rạp này.
        </div>
        @endif
    </div>
</div>

<style>
    /* Custom column for 5 per row */
    @media (min-width: 1200px) {
        .custom-col-5 {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }
</style>

{{-- JS Search + Sort --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const sortSelect = document.getElementById('sortSelect');
        const moviesContainer = document.getElementById('moviesContainer');
        let movieItems = Array.from(document.querySelectorAll('.movie-item'));

        // Tìm kiếm
        searchInput.addEventListener('input', function () {
            filterAndSort();
        });

        // Sắp xếp
        sortSelect.addEventListener('change', function () {
            filterAndSort();
        });

        function filterAndSort() {
            const keyword = searchInput.value.toLowerCase().trim();
            let filtered = movieItems.filter(item => {
                const title = item.querySelector('.card-title').textContent.toLowerCase();
                return title.includes(keyword);
            });

            // Sort
            const sortValue = sortSelect.value;
            filtered.sort((a, b) => {
                let aVal, bVal;

                if (sortValue.includes('created')) {
                    aVal = parseInt(a.dataset.created);
                    bVal = parseInt(b.dataset.created);
                } else if (sortValue.includes('release')) {
                    aVal = parseInt(a.dataset.release);
                    bVal = parseInt(b.dataset.release);
                }

                return sortValue.endsWith('asc') ? aVal - bVal : bVal - aVal;
            });

            // Remove old & append new
            moviesContainer.innerHTML = '';
            filtered.forEach(item => moviesContainer.appendChild(item));
        }
    });
</script>
@endsection
