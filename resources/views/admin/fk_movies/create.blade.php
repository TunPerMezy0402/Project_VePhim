@extends('admin.layouts.AdminLayout')

@section('content')
<a href="{{ route('admin.cinemas.movies.index', $cinema->id) }}" class="btn btn-danger btn-sm mb-3">
    <i class="fas fa-arrow-left me-1"></i> Quay lại
</a>

<div class="content">
    <div class="card">
        {{-- Header --}}
        <div class="card-header bg-body-tertiary">
            <h5 class="mb-0">
                <i class="fas fa-film me-2"></i>Movie Selection for Screening
            </h5>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Selection Form --}}
        <form action="{{ route('admin.cinemas.movies.store', ['cinema' => $cinema->id]) }}" method="POST">
            @csrf

            {{-- Main Filters --}}
            <div class="card-body border-bottom">
                <div class="row g-3 p-3 bg-dark rounded">
                    {{-- Genre Filter --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-white">Genre</label>
                        <select class="form-select form-select-sm" name="genre_id" id="genre_id">
                            <option value="">All Genres</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Country Filter --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-white">Country</label>
                        <select class="form-select form-select-sm" name="country_id" id="country_id">
                            <option value="">All Countries</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Year Filter --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-white">Year</label>
                        <select class="form-select form-select-sm" name="year" id="year">
                            <option value="">All Years</option>
                            @for ($y = now()->year; $y >= 2000; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- Duration Filter --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-white">Duration</label>
                        <select class="form-select form-select-sm" name="duration" id="duration">
                            <option value="">All Durations</option>
                            <option value="0-90">≤ 90 min</option>
                            <option value="91-120">91-120 min</option>
                            <option value="121-180">121-180 min</option>
                            <option value="181-999">180+ min</option>
                        </select>
                    </div>

                    {{-- Search --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-white">Search</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="search" placeholder="Title, director...">
                            <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Status Filter Section --}}
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Selection Status</label>
                        <select class="form-select form-select-sm" name="selection_status" id="selection_status">
                            <option value="">All Movies</option>
                            <option value="selected">Đã Chọn</option>
                            <option value="unselected">Chưa Chọn</option>
                            <option value="pre-selected">Hoàn Thành</option>
                            <option value="temp-removed">Tạm Bỏ</option>
                        </select>
                    </div>
                    <div class="col-md-9 d-flex justify-content-between align-items-end">
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-muted"><span id="resultsCount">{{ count($movies) }}</span> movies
                                found</span>
                            <span class="badge bg-success" id="selectedCountBadge">
                                <i class="fas fa-check me-1"></i><span id="selectedCount">0</span> selected
                            </span>
                            <span class="badge bg-primary" id="preSelectedCountBadge">
                                <i class="fas fa-calendar-check me-1"></i><span id="preSelectedCount">0</span> scheduled
                            </span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" id="selectAllVisible" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-check-square me-1"></i>Select All Visible
                            </button>
                            <button type="button" id="clearSelection" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-times-circle me-1"></i>Clear Selection
                            </button>
                            <button type="button" id="resetFilters" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i>Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Movies Grid --}}
            <div class="card-body">
                <div id="moviesGrid" class="row g-3">
                    @forelse($movies as $movie)
                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-12 movie-item" data-id="{{ $movie->id }}"
                        data-title="{{ $movie->title }}"
                        data-director="{{ $movie->director ? $movie->director->name : '' }}"
                        data-genre-ids="{{ $movie->genres->pluck('id')->implode(',') }}"
                        data-country-id="{{ $movie->country_id }}"
                        data-year="{{ \Carbon\Carbon::parse($movie->release_date)->year }}"
                        data-duration="{{ $movie->duration }}"
                        data-pre-selected="{{ in_array($movie->id, $selectedMovieIds) ? 'true' : 'false' }}">
                        <div
                            class="movie-card border rounded-3 shadow-sm position-relative overflow-hidden {{ in_array($movie->id, $selectedMovieIds) ? 'pre-selected' : '' }}">
                            {{-- Hidden Checkbox --}}
                            <input class="movie-checkbox d-none" type="checkbox" name="movies[]"
                                value="{{ $movie->id }}" id="movie_{{ $movie->id }}" {{ in_array($movie->id,
                            $selectedMovieIds) ? 'checked' : '' }}>

                            {{-- Pre-selected Badge (Blue) --}}
                            <div class="pre-selected-badge">
                                <i class="fas fa-calendar-check me-1"></i>Đã lên kệ
                            </div>

                            {{-- Pre-selected Restored Badge (Orange) --}}
                            <div class="pre-selected-restored-badge">
                                <i class="fas fa-calendar-plus me-1"></i>Đã lên kệ
                            </div>

                            {{-- Temporarily Removed Badge (Red) --}}
                            <div class="temporarily-removed-badge" title="Nhấn để khôi phục">
                                <i class="fas fa-undo me-1"></i>Tạm bỏ
                            </div>

                            {{-- Newly Selected Badge (Green) --}}
                            <div class="selected-badge">
                                <i class="fas fa-check me-1"></i>Đã chọn
                            </div>

                            {{-- Movie Image --}}
                            <div class="movie-image">
                                <img src="{{ $movie->image ? asset('storage/'.$movie->image) : asset('assets/img/generic/notimage.png') }}"
                                    alt="{{ $movie->title }}" class="img-fluid rounded-top w-100"
                                    style="height: 180px; object-fit: cover;">
                            </div>

                            {{-- Info --}}
                            <div class="p-2">
                                <h6 class="fw-bold mb-1 text-truncate" style="font-size: 0.9rem;">{{ $movie->title }}
                                </h6>
                                @if($movie->director)
                                <div class="mb-1 text-truncate" style="font-size: 0.8rem;"><i
                                        class="fas fa-user-tie me-1"></i>{{ $movie->director->name }}</div>
                                @endif
                                @if($movie->country)
                                <div class="mb-1" style="font-size: 0.8rem;"><i class="fas fa-flag me-1"></i>{{
                                    $movie->country->name }}</div>
                                @endif
                                <div class="mb-2" style="font-size: 0.8rem;"><i class="fas fa-calendar me-1"></i>{{
                                    \Carbon\Carbon::parse($movie->release_date)->format('M Y') }}</div>
                                <span class="badge bg-dark" style="font-size: 0.7rem;"><i
                                        class="fas fa-clock me-1"></i>{{ $movie->duration }}
                                    min</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-film text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No movies found</h5>
                    </div>
                    @endforelse
                </div>

                {{-- Submit Button --}}
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success"
                        onclick="return confirm('Bạn chắc chắn muốn cập nhật chứ !')">
                        <i class="fas fa-calendar-plus me-1"></i> Cập Nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .movie-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .movie-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }

    /* DEFAULT: Pre-selected movies (already on schedule) - Blue border */
    .movie-card.pre-selected {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25) !important;
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.05), rgba(13, 110, 253, 0.1));
    }

    /* STATE 2: Movies that are temporarily removed (pre-selected but unchecked) - Red border */
    .movie-card.temporarily-removed {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.25) !important;
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.05), rgba(220, 53, 69, 0.1));
        opacity: 0.7;
    }

    /* STATE 3: Pre-selected movies that are restored after being temporarily removed - Orange border */
    .movie-card.pre-selected-restored {
        border-color: #fd7e14 !important;
        box-shadow: 0 0 0 2px rgba(253, 126, 20, 0.25) !important;
        background: linear-gradient(135deg, rgba(253, 126, 20, 0.05), rgba(253, 126, 20, 0.1));
    }

    /* Newly selected movies (not pre-selected) - Green border */
    .movie-card.selected:not(.pre-selected):not(.pre-selected-restored) {
        border-color: #198754 !important;
        box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.25) !important;
    }

    .movie-image {
        overflow: hidden;
    }

    .movie-image img {
        transition: transform 0.3s ease;
    }

    .movie-card:hover .movie-image img {
        transform: scale(1.05);
    }

    /* All badges are hidden by default */
    .pre-selected-badge,
    .pre-selected-restored-badge,
    .temporarily-removed-badge,
    .selected-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        color: white;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 12px;
        display: none;
        font-weight: 600;
        z-index: 10;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* STATE 1: Pre-selected badge (Blue) */
    .pre-selected-badge {
        background: linear-gradient(45deg, #0d6efd, #3d8bfd);
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
    }

    /* STATE 2: Temporarily removed badge (Red) */
    .temporarily-removed-badge {
        background: linear-gradient(45deg, #dc3545, #e85a64);
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        cursor: pointer;
    }

    /* STATE 3: Pre-selected restored badge (Orange) */
    .pre-selected-restored-badge {
        background: linear-gradient(45deg, #fd7e14, #fd9843);
        box-shadow: 0 2px 8px rgba(253, 126, 20, 0.3);
    }

    /* Newly selected badge (Green) */
    .selected-badge {
        background: linear-gradient(45deg, #28a745, #34ce57);
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }

    /* Show appropriate badges based on card state */
    .movie-card.pre-selected .pre-selected-badge {
        display: block;
    }

    .movie-card.temporarily-removed .temporarily-removed-badge {
        display: block;
        animation: shakeIn 0.3s ease;
    }

    .movie-card.pre-selected-restored .pre-selected-restored-badge {
        display: block;
        animation: bounceIn 0.3s ease;
    }

    .movie-card.selected:not(.pre-selected):not(.pre-selected-restored) .selected-badge {
        display: block;
        animation: bounceIn 0.3s ease;
    }

    /* Hover effect for temporarily removed badge */
    .temporarily-removed-badge:hover {
        background: linear-gradient(45deg, #a02832, #c94855);
        transform: scale(1.05);
    }

    @keyframes shakeIn {
        0% {
            transform: scale(0.3) rotate(-10deg);
            opacity: 0;
        }

        50% {
            transform: scale(1.05) rotate(5deg);
        }

        70% {
            transform: scale(0.9) rotate(-3deg);
        }

        100% {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }

        50% {
            transform: scale(1.05);
        }

        70% {
            transform: scale(0.9);
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .movie-image img {
            height: 150px !important;
        }

        .movie-card .p-2 {
            padding: 0.75rem !important;
        }
    }

    @media (min-width: 1400px) {
        .movie-card {
            min-height: 280px;
        }
    }

    @media (max-width: 576px) {
        .movie-card .p-2 h6 {
            font-size: 0.85rem !important;
        }

        .movie-card .p-2 div {
            font-size: 0.75rem !important;
        }
    }
</style>

<script>
    class MovieSelector {
    constructor() {
        this.selectedMovies = new Set();
        this.preSelectedMovies = new Set();
        this.temporarilyRemovedMovies = new Set();
        this.restoredMovies = new Set(); // Track movies that were restored after being temporarily removed
        this.allMovies = [];
        this.currentFilters = {
            genre: '',
            country: '',
            year: '',
            duration: '',
            selectionStatus: '',
            search: ''
        };
        this.init();
    }

    init() {
        this.collectMovies();
        this.initializeSelected();
        this.bindEvents();
        this.updateCounts();
    }

    collectMovies() {
        this.allMovies = Array.from(document.querySelectorAll('.movie-item')).map(item => ({
            id: item.dataset.id,
            title: item.dataset.title,
            director: item.dataset.director || '',
            genreIds: item.dataset.genreIds.split(',').filter(Boolean),
            countryId: item.dataset.countryId,
            year: parseInt(item.dataset.year),
            duration: parseInt(item.dataset.duration),
            isPreSelected: item.dataset.preSelected === 'true',
            element: item
        }));
    }

    initializeSelected() {
        document.querySelectorAll('.movie-checkbox').forEach(checkbox => {
            const movieId = checkbox.value;
            const movieItem = checkbox.closest('.movie-item');
            const isPreSelected = movieItem.dataset.preSelected === 'true';
            
            if (isPreSelected) {
                this.preSelectedMovies.add(movieId);
            }
            
            if (checkbox.checked) {
                this.selectedMovies.add(movieId);
            }
            
            this.updateCardState(movieId);
        });
    }

    bindEvents() {
        // Card click events
        document.querySelectorAll('.movie-card').forEach(card => {
            card.addEventListener('click', (e) => {
                // Don't toggle if clicking on the temporarily removed badge
                if (e.target.closest('.temporarily-removed-badge')) {
                    return;
                }
                
                const checkbox = card.querySelector('.movie-checkbox');
                checkbox.checked = !checkbox.checked;
                this.toggleMovie(checkbox);
            });
        });

        // Temporarily removed badge click to restore
        document.querySelectorAll('.temporarily-removed-badge').forEach(badge => {
            badge.addEventListener('click', (e) => {
                e.stopPropagation();
                const card = badge.closest('.movie-card');
                const checkbox = card.querySelector('.movie-checkbox');
                checkbox.checked = true;
                this.toggleMovie(checkbox);
            });
        });

        // Filter events
        const filterElements = document.querySelectorAll('#genre_id, #country_id, #year, #duration, #selection_status');
        filterElements.forEach(input => {
            input.addEventListener('change', (e) => {
                const filterName = e.target.id.replace('_id', '').replace('selection_status', 'selectionStatus');
                this.currentFilters[filterName] = e.target.value;
                this.applyFilters();
            });
        });

        // Search event
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('input', 
                this.debounce((e) => {
                    this.currentFilters.search = e.target.value.toLowerCase().trim();
                    this.applyFilters();
                }, 300)
            );
        }

        // Button events
        const selectAllBtn = document.getElementById('selectAllVisible');
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', () => this.selectAllVisible());
        }

        const clearSelectionBtn = document.getElementById('clearSelection');
        if (clearSelectionBtn) {
            clearSelectionBtn.addEventListener('click', () => this.clearSelection());
        }

        const resetFiltersBtn = document.getElementById('resetFilters');
        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', () => this.resetFilters());
        }

        const clearSearchBtn = document.getElementById('clearSearch');
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', () => this.clearSearch());
        }
    }

    toggleMovie(checkbox) {
        const movieId = checkbox.value;
        const isPreSelected = this.preSelectedMovies.has(movieId);
        
        if (checkbox.checked) {
            this.selectedMovies.add(movieId);
            
            // If it was temporarily removed, remove it from temporarily removed set and mark as restored
            if (this.temporarilyRemovedMovies.has(movieId)) {
                this.temporarilyRemovedMovies.delete(movieId);
                this.restoredMovies.add(movieId);
            }
        } else {
            this.selectedMovies.delete(movieId);
            
            // If it was pre-selected, add it to temporarily removed set
            if (isPreSelected) {
                this.temporarilyRemovedMovies.add(movieId);
                this.restoredMovies.delete(movieId); // Remove from restored if it was there
            }
        }
        
        this.updateCardState(movieId);
        this.updateCounts();
        // Don't reapply filters to preserve current filter state
        // this.applyFilters();
    }

    getMovieState(movieId) {
        const isSelected = this.selectedMovies.has(movieId);
        const isPreSelected = this.preSelectedMovies.has(movieId);
        const isTemporarilyRemoved = this.temporarilyRemovedMovies.has(movieId);
        const isRestored = this.restoredMovies.has(movieId);
        
        if (isPreSelected) {
            if (isTemporarilyRemoved) {
                return 'temp-removed'; // STATE 2: Red
            } else if (isSelected && isRestored) {
                return 'pre-selected-restored'; // STATE 3: Orange
            } else if (isSelected) {
                return 'pre-selected'; // STATE 1: Blue
            } else {
                return 'pre-selected'; // Default pre-selected state
            }
        } else if (isSelected) {
            return 'selected'; // Newly selected: Green
        }
        return 'unselected'; // Default state
    }

    updateCardState(movieId) {
        const movieData = this.allMovies.find(m => m.id === movieId);
        if (!movieData) return;

        const card = movieData.element.querySelector('.movie-card');
        const state = this.getMovieState(movieId);
        
        // Reset all classes
        card.classList.remove('selected', 'pre-selected', 'temporarily-removed', 'pre-selected-restored');
        
        // Add appropriate class based on state
        switch (state) {
            case 'selected':
                card.classList.add('selected');
                break;
            case 'pre-selected':
                card.classList.add('pre-selected');
                break;
            case 'temp-removed':
                card.classList.add('temporarily-removed');
                break;
            case 'pre-selected-restored':
                card.classList.add('pre-selected-restored');
                break;
            // 'unselected' doesn't need a special class
        }
    }

    selectAllVisible() {
        const visibleCheckboxes = document.querySelectorAll('.movie-item:not(.d-none) .movie-checkbox');
        visibleCheckboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                checkbox.checked = true;
                // Call toggleMovie without reapplying filters
                const movieId = checkbox.value;
                const isPreSelected = this.preSelectedMovies.has(movieId);
                
                this.selectedMovies.add(movieId);
                
                // If it was temporarily removed, remove it from temporarily removed set and mark as restored
                if (this.temporarilyRemovedMovies.has(movieId)) {
                    this.temporarilyRemovedMovies.delete(movieId);
                    this.restoredMovies.add(movieId);
                }
                
                this.updateCardState(movieId);
            }
        });
        this.updateCounts();
        // Don't reapply filters to preserve current filter state
    }

    clearSelection() {
        // Clear newly selected movies and restore pre-selected movies to their original state
        this.allMovies.forEach(movie => {
            const checkbox = movie.element.querySelector('.movie-checkbox');
            const isPreSelected = this.preSelectedMovies.has(movie.id);
            
            if (isPreSelected) {
                // Pre-selected movies should remain checked
                checkbox.checked = true;
            } else {
                // Newly selected movies should be unchecked
                checkbox.checked = false;
            }
        });
        
        // Reset sets
        this.selectedMovies = new Set(this.preSelectedMovies);
        this.temporarilyRemovedMovies.clear();
        this.restoredMovies.clear();
        
        // Update all card states
        this.allMovies.forEach(movie => {
            this.updateCardState(movie.id);
        });
        
        this.updateCounts();
        // Don't reapply filters to preserve current filter state
        // this.applyFilters();
    }

    updateCounts() {
        const newlySelectedCount = this.selectedMovies.size - this.preSelectedMovies.size + this.temporarilyRemovedMovies.size;
        const preSelectedCount = this.preSelectedMovies.size - this.temporarilyRemovedMovies.size;
        
        const selectedCountElement = document.getElementById('selectedCount');
        const preSelectedCountElement = document.getElementById('preSelectedCount');
        
        if (selectedCountElement) {
            selectedCountElement.textContent = Math.max(0, newlySelectedCount);
        }
        if (preSelectedCountElement) {
            preSelectedCountElement.textContent = Math.max(0, preSelectedCount);
        }
    }

    clearSearch() {
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.value = '';
            this.currentFilters.search = '';
            this.applyFilters();
        }
    }

    applyFilters() {
        let visibleCount = 0;
        
        this.allMovies.forEach(movie => {
            const isVisible = this.matchesFilters(movie);
            movie.element.classList.toggle('d-none', !isVisible);
            if (isVisible) visibleCount++;
        });

        const resultsCountElement = document.getElementById('resultsCount');
        if (resultsCountElement) {
            resultsCountElement.textContent = visibleCount;
        }
    }

    matchesFilters(movie) {
        const filters = this.currentFilters;
        
        // Basic filters
        if (filters.genre && !movie.genreIds.includes(filters.genre)) return false;
        if (filters.country && movie.countryId !== filters.country) return false;
        if (filters.year && movie.year !== parseInt(filters.year)) return false;
        if (filters.duration && !this.matchesDuration(movie.duration, filters.duration)) return false;
        if (filters.search && !this.matchesSearch(movie, filters.search)) return false;
        
        // Selection status filter
        if (filters.selectionStatus) {
            const state = this.getMovieState(movie.id);
            
            switch (filters.selectionStatus) {
                case 'selected':
                    return state === 'selected'; // Only newly selected
                case 'unselected':
                    return state === 'unselected'; // Not selected at all
                case 'pre-selected':
                    return state === 'pre-selected' || state === 'pre-selected-restored'; // Pre-selected states
                case 'temp-removed':
                    return state === 'temp-removed'; // Temporarily removed
                default:
                    return true;
            }
        }
        
        return true;
    }

    matchesDuration(duration, filter) {
        if (!filter) return true;
        const [min, max] = filter.split('-').map(val => val === '999' ? Infinity : Number(val));
        return duration >= min && duration <= max;
    }

    matchesSearch(movie, search) {
        if (!search) return true;
        const searchText = (movie.title + ' ' + movie.director).toLowerCase();
        return searchText.includes(search);
    }

    resetFilters() {
        // Reset filter UI elements
        document.querySelectorAll('#genre_id, #country_id, #year, #duration, #selection_status').forEach(select => {
            select.value = '';
        });
        
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.value = '';
        }
        
        // Reset current filters object
        this.currentFilters = {
            genre: '',
            country: '',
            year: '',
            duration: '',
            selectionStatus: '',
            search: ''
        };
        
        // Show all movies
        this.allMovies.forEach(movie => {
            movie.element.classList.remove('d-none');
        });
        
        const resultsCountElement = document.getElementById('resultsCount');
        if (resultsCountElement) {
            resultsCountElement.textContent = this.allMovies.length;
        }
    }

    debounce(func, wait) {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    window.movieSelector = new MovieSelector();
});
</script>
@endsection