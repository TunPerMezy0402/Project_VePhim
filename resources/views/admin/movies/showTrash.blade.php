@extends('admin.layouts.AdminLayout')

@section('content')
<div class="content">
    <div class="card mb-3 mb-lg-0">
        <div class="card-header bg-body-tertiary d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Chi Tiết Phim ( Xóa mềm )</h5>
            <div>
                <a href="{{ route('admin.movies.index') }}" class="btn btn-sm btn-dark">
                    &laquo; Trang Chủ Phim
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success my-3">
            {{ session('success') }}
        </div>
        @endif

        @php
        \Carbon\Carbon::setLocale('vi');
        $date = $movie->release_date ? \Carbon\Carbon::parse($movie->release_date) : null;
        @endphp

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4">
                    @if (!empty($movie->image) && file_exists(storage_path('app/public/' . $movie->image)))
                    <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}"
                        class="img-fluid rounded-3">
                    @else
                    <img src="{{ asset('assets/img/generic/imgphim.jpg') }}" alt="{{ $movie->title }}"
                        class="img-fluid rounded-3">
                    @endif
                </div>
                <div class="col-md-8">
                    <h3>{{ $movie->title }}</h3>
                    <p><strong>Directed by:</strong> {{ $movie->director->name ?? 'Unknown' }}</p>
                    <p><strong>Country:</strong> {{ $movie->country->name ?? 'Unknown' }}</p>

                    <p><strong>Actors:</strong>
                        @foreach($movie->actors as $actor)
                        <span class="badge bg-secondary text-white me-1">{{ $actor->name }}</span>
                        @endforeach
                    </p>

                    <p><strong>Genres:</strong>
                        @foreach($movie->genres as $genre)
                        <span class="badge bg-primary text-white me-1">{{ $genre->name }}</span>
                        @endforeach
                    </p>

                    <p><strong>Release Date:</strong> {{ $date ? $date->format('M d, Y') : 'Unknown' }}</p>
                    <p><strong>Duration:</strong> {{ $movie->duration ?? 'N/A' }} minutes</p>
                    <p><strong>Deleted At:</strong> {{ $movie->deleted_at ? $movie->deleted_at->format('M d, Y H:i') :
                        'N/A' }}</p>

                    <div class="mt-4 d-flex gap-2">
                        <form action="{{ route('admin.movies.restore', $movie->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn khôi phục phim này không?');" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success d-flex align-items-center">
                                <i class="fas fa-undo-alt me-1"></i> Khôi phục
                            </button>
                        </form>

                        <form action="{{ route('admin.movies.forceDelete', $movie->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn phim này không?');"
                            class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center">
                                <i class="fas fa-trash-alt me-1"></i> Xóa
                            </button>
                        </form>
                    </div>


                </div>
            </div>
        </div>

    </div>
</div>
@endsection