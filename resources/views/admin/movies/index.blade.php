@extends('admin.layouts.AdminLayout')

@section('content')
<div class="content">
    <div class="card mb-3 mb-lg-0">
        <div class="card-header bg-body-tertiary d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Movies</h5>
            <a href="{{ route('admin.movies.create') }}" class="btn btn-sm btn-dark">
                + Add Movie
            </a>
        </div>

        <!-- Filter Form -->
        <div class="card-body">
            <form action="{{ route('admin.movies.index') }}" method="GET">
                <div class="row g-3">
                    <!-- Genre Filter -->
                    <div class="col-md-3">
                        <label for="genre_id" class="form-label">Genre</label>
                        <select class="form-select form-select-sm" name="genre_id" id="genre_id">
                            <option value="">Select Genre</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ request('genre_id')==$genre->id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Country Filter -->
                    <div class="col-md-3">
                        <label for="country_id" class="form-label">Country</label>
                        <select class="form-select form-select-sm" name="country_id" id="country_id">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id')==$country->id ? 'selected' : ''
                                }}>
                                {{ $country->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Director Filter -->
                    <div class="col-md-3">
                        <label for="director_id" class="form-label">Director</label>
                        <select class="form-select form-select-sm" name="director_id" id="director_id">
                            <option value="">Select Director</option>
                            @foreach($directors as $director)
                            <option value="{{ $director->id }}" {{ request('director_id')==$director->id ? 'selected' :
                                '' }}>
                                {{ $director->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Actor Filter -->
                    <div class="col-md-3">
                        <label for="actor_id" class="form-label">Actor</label>
                        <select class="form-select form-select-sm" name="actor_id" id="actor_id">
                            <option value="">Select Actor</option>
                            @foreach($actors as $actor)
                            <option value="{{ $actor->id }}" {{ request('actor_id')==$actor->id ? 'selected' : '' }}>
                                {{ $actor->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                </div>
            </form>
        </div>

        <!-- Movies List -->
        <div class="card-body fs-9">
            <div class="row g-4">
                @foreach($movies as $movie)
                <div class="col-md-6">
                    <div class="d-flex border p-3 rounded-3 shadow-sm">
                        @php
                        \Carbon\Carbon::setLocale('vi');
                        $date = \Carbon\Carbon::parse($movie->release_date);
                        @endphp

                        <div class="calendar me-3">
                            <span class="calendar-month">
                                <span class="p-2">{{ $date->format('Y') }}</span> {{
                                ucfirst($date->translatedFormat('F')) }}
                            </span>
                            <span class="calendar-day">{{ $date->format('d') }}</span>
                        </div>

                        <div class="flex-1">
                            <h6 class="fs-6 fw-bold mb-3">
                                <a href="{{ route('admin.movies.show', $movie->id) }}" class="badge bg-success text-light rounded-3 p-2 px-3 shadow-sm">
                                    {{ \Illuminate\Support\Str::limit($movie->title, 15) }}
                                </a>
                            </h6>

                            <p class="mb-1">Directed by: <span class="text-primary">{{ $movie->director->name ??
                                    'Unknown' }}</span></p>
                            <p class="text-muted mb-1">Country: <span class="text-primary">{{ $movie->country->name ??
                                    'Unknown' }}</span></p>

                            <p class="text-muted mb-1">Actors:
                                @foreach($movie->actors as $actor)
                                <span class="badge bg-light text-primary me-1">{{ $actor->name }}</span>
                                @endforeach
                            </p>

                            <p class="text-muted mb-1">Genres:
                                @foreach($movie->genres as $genre)
                                <span class="badge bg-secondary me-1">{{ $genre->name }}</span>
                                @endforeach
                            </p>

                            <p class="text-muted mb-1">Release Date: {{ $date->format('M d, Y') }}</p>
                            <p class="text-muted mb-1">Duration: {{ $movie->duration }} minutes</p>
                        </div>

                        <div class="flex-shrink-0">
                            @if (!empty($movie->image))
                            <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}"
                                class="img-fluid rounded-3" style="width: 135px;">
                            @else
                            <img src="{{ asset('assets/img/generic/imgphim.jpg') }}" alt="{{ $movie->title }}"
                                class="img-fluid rounded-3" style="width: 135px;">
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {!! $movies->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</div>
@endsection