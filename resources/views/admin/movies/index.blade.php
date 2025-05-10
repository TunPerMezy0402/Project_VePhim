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


        <!-- Form tìm kiếm (Filter) nằm dưới tiêu đề -->
        <div class="card-body">
            <form action="{{ route('admin.movies.index') }}" method="GET">
                <div class="row g-3">
                    <!-- Lọc theo thể loại (Genres) -->
                    <div class="col-md-3">
                        <label for="genre_id" class="form-label">Genre</label>
                        <select class="form-select form-select-sm" name="genre_id" id="genre_id">
                            <option value="">Select Genre</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ request('genre_id')==$genre->id ? 'selected' : '' }}>{{
                                $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lọc theo quốc gia -->
                    <div class="col-md-3">
                        <label for="country_id" class="form-label">Country</label>
                        <select class="form-select form-select-sm" name="country_id" id="country_id">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id')==$country->id ? 'selected' : ''
                                }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lọc theo đạo diễn -->
                    <div class="col-md-3">
                        <label for="director_id" class="form-label">Director</label>
                        <select class="form-select form-select-sm" name="director_id" id="director_id">
                            <option value="">Select Director</option>
                            @foreach($directors as $director)
                            <option value="{{ $director->id }}" {{ request('director_id')==$director->id ? 'selected' :
                                '' }}>{{ $director->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lọc theo diễn viên -->
                    <div class="col-md-3">
                        <label for="actor_id" class="form-label">Actor</label>
                        <select class="form-select form-select-sm" name="actor_id" id="actor_id">
                            <option value="">Select Actor</option>
                            @foreach($actors as $actor)
                            <option value="{{ $actor->id }}" {{ request('actor_id')==$actor->id ? 'selected' : '' }}>{{
                                $actor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Nút tìm kiếm và Reset -->
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                </div>

            </form>

        </div>

        <div class="card-body fs-9">
            <div class="row g-4">
                @foreach($movies as $movie)
                <div class="col-md-6">
                    <div class="d-flex border p-3 rounded-3 shadow-sm">
                        <!-- Lịch chiếu -->
                        <div class="calendar me-3">
                            <span class="calendar-month">{{ \Carbon\Carbon::parse($movie->release_date)->format('M')
                                }}</span>
                            <span class="calendar-day">{{ \Carbon\Carbon::parse($movie->release_date)->format('d')
                                }}</span>
                        </div>
                        <div class="flex-1">
                            <h6 class="fs-6 fw-bold mb-3">
                                <a href=""
                                    class="badge bg-success text-light rounded-3 p-2 px-3 shadow-sm hover:bg-success-dark transition-all duration-300">
                                    {{ \Illuminate\Support\Str::limit($movie->title, 15) }}
                                </a>
                            </h6>



                            {{-- Đạo diễn --}}
                            <p class="mb-1">
                                Directed by:
                                <a href="#!" class="text-primary">{{ $movie->director->name ?? 'Unknown' }}</a>
                            </p>

                            {{-- Quốc gia --}}
                            <p class="text-muted mb-1">
                                Country:
                                <span class="text-primary">{{ $movie->country->name ?? 'Unknown' }}</span>
                            </p>

                            {{-- Diễn viên --}}
                            <p class="text-muted mb-1">
                                Actors:
                                @foreach($movie->actors as $actor)
                                <span class="badge bg-light text-primary me-1">{{ $actor->name }}</span>
                                @endforeach
                            </p>

                            {{-- Thể loại --}}
                            <p class="text-muted mb-1">
                                Genres:
                                @foreach($movie->genres as $genre)
                                <span class="badge bg-secondary me-1">{{ $genre->name }}</span>
                                @endforeach
                            </p>

                            {{-- Ngày phát hành và thời lượng --}}
                            <p class="text-muted mb-1">Release Date: {{
                                \Carbon\Carbon::parse($movie->release_date)->format('M d, Y') }}</p>
                            <p class="text-muted mb-1">Duration: {{ $movie->duration }} minutes</p>
                        </div>

                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/'.$movie->image) }}" alt="{{ $movie->title }}"
                                class="img-fluid rounded-3" style="width: 100px; height: auto;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="row g-0 justify-content-between fs-10 mt-4 mb-3">
            <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">Thank you for creating with Falcon <span
                        class="d-none d-sm-inline-block">|</span><br class="d-sm-none" /> 2024 &copy; <a
                        href="https://themewagon.com/">Themewagon</a></p>
            </div>
            <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">v3.23.0</p>
            </div>
        </div>
    </footer>
</div>
@endsection