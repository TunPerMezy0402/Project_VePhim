@extends('admin.layouts.AdminLayout')
@section('content')
<div class="content">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row flex-between-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">Create Movie</h5>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.movies.index') }}" class="btn btn-danger btn-sm mb-3">Back</a>

    <div class="card mb-3">
        <div class="row g-0">
            <!-- BÊN TRÁI: Ảnh poster -->
            <div class="col-md-4 p-3">
                <div class="h-100">
                    <img class="img-fluid rounded-start h-100 w-100" src="{{ asset('storage/' . $movie->image) }}"
                        alt="Movie Poster" style="object-fit: cover; min-height: 300px;">
                </div>
            </div>

            <!-- BÊN PHẢI: Nội dung -->
            <div class="col-md-8">
                <div class="card-body h-100 d-flex flex-column">
                    <!-- Video YouTube -->
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe src="{{ $embedUrl }}" title="YouTube video" allowfullscreen class="rounded"></iframe>
                    </div>

                    <!-- Thông tin phim -->
                    <div class="d-flex mb-3 flex-grow-1">
                        @php
                        \Carbon\Carbon::setLocale('vi');
                        $date = \Carbon\Carbon::parse($movie->release_date);
                        @endphp

                        <div class="calendar me-3 flex-shrink-0">
                            <span class="calendar-month">
                                <span class="p-2">{{ $date->format('Y') }}</span>
                                {{ ucfirst($date->translatedFormat('F')) }}
                            </span>
                            <span class="calendar-day">{{ $date->format('d') }}</span>
                        </div>

                        <div class="flex-grow-1">
                            <h5 class="fs-4 mb-2">{{ $movie->title }}</h5>
                            <div class="mb-2">
                                <span class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                                <span class="ms-2 text-muted">Đánh giá: 5/5</span>
                            </div>
                            <span class="fs-5 text-warning fw-bold">$49.99 – $89.99</span>
                        </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div>
                            <button class="btn btn-outline-danger btn-sm me-2" type="button">
                                <i class="fas fa-heart me-1"></i>235
                            </button>
                            <button class="btn btn-outline-primary btn-sm" type="button">
                                <i class="fas fa-share-alt me-1"></i>Share
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Nút cập nhật -->
                            <a href="{{ route('admin.movies.edit', $movie->id) }}"
                                class="btn btn-primary btn-sm d-flex align-items-center px-3">
                                <i class="fas fa-edit me-1"></i> Cập nhật
                            </a>

                            <!-- Nút xóa -->
                            <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa phim này không?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center px-3">
                                    <i class="fas fa-trash-alt me-1"></i> Xóa
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-0">
        <div class="col-lg-8 pe-lg-2">
            <div class="card mb-3 mb-lg-0">
                <div class="card-body">
                    <h5 class="fs-9 mb-3">Detail</h5>
                    <p>
                        {{ $movie->description }}
                    </p>
                    <h5 class="fs-9 mt-5 mb-2">Share with friends</h5>
                    <div class="icon-group"><a class="icon-item text-facebook" href="#!"><span
                                class="fab fa-facebook-f"></span></a><a class="icon-item text-twitter" href="#!"><span
                                class="fab fa-twitter"></span></a><a class="icon-item text-google-plus" href="#!"><span
                                class="fab fa-google-plus-g"></span></a><a class="icon-item text-linkedin"
                            href="#!"><span class="fab fa-linkedin-in"></span></a><a class="icon-item text-700"
                            href="#!"><span class="fab fa-medium-m"></span></a></div>

                </div>
            </div>
        </div>
        <div class="col-lg-4 ps-lg-2">
            <div class="sticky-sidebar">
                <div class="card mb-3 fs-10">
                    <div class="card-body">
                        <h5 class="mt-3">Đạo Diễn :</h5>
                        <a href="#!" class="me-1">{{ $movie->director->name }}</a>
                        <h5 class="mt-3">Quốc Gia :</h5>
                        <a href="#!" class="me-1">{{ $movie->country->name }}</a>
                        <h5 class="mt-3">Thể Loại :</h5>
                        @foreach ($movie->genres as $genre)
                        <a href="#!" class="me-1 fs-10">{{ $genre->name }}</a>@if(!$loop->last)|@endif
                        @endforeach
                        <h5 class="mt-3">Diễn Viên :</h5>
                        @foreach ($movie->actors as $actor)
                        <a href="#!" class="me-1 fs-10">{{ $actor->name }}</a>@if(!$loop->last)|@endif
                        @endforeach
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection