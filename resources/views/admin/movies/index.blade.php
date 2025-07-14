@extends('admin.layouts.AdminLayout')

@section('content')
<div class="content">
    <div class="card mb-3 mb-lg-0">
        {{-- Header Section --}}
        <div class="card-header bg-body-tertiary d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Movies Management</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.movies.create') }}" class="btn btn-sm btn-dark">
                    <i class="fas fa-plus me-1"></i>Add Movie
                </a>
                <a href="{{ route('admin.movies.trash') }}" class="btn btn-sm btn-outline-dark">
                    <i class="fas fa-trash me-1"></i>Trash
                </a>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Filter Section --}}
        <div class="card-body border-bottom">
            <form action="{{ route('admin.movies.index') }}" method="GET" class="filter-form">
                <div class="row g-3">
                    {{-- Genre Filter --}}
                    <div class="col-md-3">
                        <label for="genre_id" class="form-label fw-semibold">Genre</label>
                        <select class="form-select form-select-sm" name="genre_id" id="genre_id">
                            <option value="">All Genres</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Country Filter --}}
                    <div class="col-md-3">
                        <label for="country_id" class="form-label fw-semibold">Country</label>
                        <select class="form-select form-select-sm" name="country_id" id="country_id">
                            <option value="">All Countries</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Director Filter --}}
                    <div class="col-md-3">
                        <label for="director_id" class="form-label fw-semibold">Director</label>
                        <select class="form-select form-select-sm" name="director_id" id="director_id">
                            <option value="">All Directors</option>
                            @foreach($directors as $director)
                            <option value="{{ $director->id }}" {{ request('director_id') == $director->id ? 'selected' : '' }}>
                                {{ $director->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Actor Filter --}}
                    <div class="col-md-3">
                        <label for="actor_id" class="form-label fw-semibold">Actor</label>
                        <select class="form-select form-select-sm" name="actor_id" id="actor_id">
                            <option value="">All Actors</option>
                            @foreach($actors as $actor)
                            <option value="{{ $actor->id }}" {{ request('actor_id') == $actor->id ? 'selected' : '' }}>
                                {{ $actor->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Filter Buttons --}}
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-filter me-1"></i>Apply Filter
                    </button>
                    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-undo me-1"></i>Clear All
                    </a>
                </div>
            </form>
        </div>

        {{-- Movies List --}}
        <div class="card-body">
            @if($movies->count() > 0)
            <div class="row g-4">
                @foreach($movies as $movie)
                <div class="col-lg-6 col-xl-4">
                    <div class="movie-card border rounded-3 shadow-sm h-100">
                        {{-- Movie Image --}}
                        <div class="movie-image-container position-relative">
                            @if (!empty($movie->image))
                            <img src="{{ asset('storage/' . $movie->image) }}" 
                                 alt="{{ $movie->title }}"
                                 class="movie-image img-fluid rounded-top">
                            @else
                            <img src="{{ asset('assets/img/generic/notimage.png') }}" 
                                 alt="{{ $movie->title }}"
                                 class="movie-image img-fluid rounded-top">
                            @endif
                            
                            {{-- Release Date Badge --}}
                            @php
                            \Carbon\Carbon::setLocale('vi');
                            $date = \Carbon\Carbon::parse($movie->release_date);
                            @endphp
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-dark bg-opacity-75 text-light">
                                    {{ $date->format('Y') }}
                                </span>
                            </div>
                        </div>

                        {{-- Movie Content --}}
                        <div class="movie-content p-3">
                            {{-- Movie Title --}}
                            <h6 class="movie-title fw-bold mb-2">
                                <a href="{{ route('admin.movies.show', $movie->id) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ \Illuminate\Support\Str::limit($movie->title, 30) }}
                                </a>
                            </h6>

                            {{-- Movie Info --}}
                            <div class="movie-info mb-3">
                                <div class="info-item d-flex align-items-center mb-1">
                                    <i class="fas fa-user-tie text-muted me-2"></i>
                                    <span class="text-muted small">Director:</span>
                                    <span class="text-primary ms-1 small">{{ $movie->director->name ?? 'Unknown' }}</span>
                                </div>
                                
                                <div class="info-item d-flex align-items-center mb-1">
                                    <i class="fas fa-flag text-muted me-2"></i>
                                    <span class="text-muted small">Country:</span>
                                    <span class="text-primary ms-1 small">{{ $movie->country->name ?? 'Unknown' }}</span>
                                </div>
                                
                                <div class="info-item d-flex align-items-center mb-1">
                                    <i class="fas fa-calendar text-muted me-2"></i>
                                    <span class="text-muted small">Released:</span>
                                    <span class="text-primary ms-1 small">{{ $date->format('M d, Y') }}</span>
                                </div>
                                
                                <div class="info-item d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-muted me-2"></i>
                                    <span class="text-muted small">Duration:</span>
                                    <span class="text-primary ms-1 small">{{ $movie->duration }} min</span>
                                </div>
                            </div>

                            {{-- Actors --}}
                            @if($movie->actors->count() > 0)
                            <div class="mb-2">
                                <div class="small text-muted mb-1">
                                    <i class="fas fa-users me-1"></i>Cast:
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($movie->actors->take(3) as $actor)
                                    <span class="badge bg-secondary bg-opacity-75 text-dark">{{ $actor->name }}</span>
                                    @endforeach
                                    @if($movie->actors->count() > 3)
                                    <span class="badge bg-secondary bg-opacity-75 text-dark">+{{ $movie->actors->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            {{-- Genres --}}
                            @if($movie->genres->count() > 0)
                            <div class="mb-3">
                                <div class="small text-muted mb-1">
                                    <i class="fas fa-tags me-1"></i>Genres:
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($movie->genres->take(3) as $genre)
                                    <span class="badge bg-primary bg-opacity-75 text-dark">{{ $genre->name }}</span>
                                    @endforeach
                                    @if($movie->genres->count() > 3)
                                    <span class="badge bg-primary bg-opacity-75 text-dark">+{{ $movie->genres->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            {{-- Action Buttons --}}
                            <div class="d-flex gap-2 mt-auto">
                                <a href="{{ route('admin.movies.show', $movie->id) }}" 
                                   class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <a href="{{ route('admin.movies.edit', $movie->id) }}" 
                                   class="btn btn-sm btn-outline-secondary flex-fill">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-film fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No movies found</h5>
                <p class="text-muted mb-3">Try adjusting your filters or add some movies to get started.</p>
                <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add First Movie
                </a>
            </div>
            @endif
        </div>

        {{-- Pagination --}}
        @if($movies->hasPages())
        <div class="card-footer bg-transparent">
            <div class="d-flex justify-content-center">
                {{ $movies->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.movie-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    overflow: hidden;
}

.movie-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

.movie-image-container {
    height: 200px;
    overflow: hidden;
}

.movie-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.movie-card:hover .movie-image {
    transform: scale(1.05);
}

.movie-content {
    display: flex;
    flex-direction: column;
    height: calc(100% - 200px);
}

.movie-title a:hover {
    color: var(--bs-primary) !important;
}

.info-item {
    font-size: 0.85rem;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.filter-form .form-select {
    border-radius: 0.375rem;
}

.filter-form .form-select:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
}

@media (max-width: 768px) {
    .movie-card {
        margin-bottom: 1rem;
    }
    
    .movie-image-container {
        height: 150px;
    }
}
</style>
@endsection