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
        <div class="row g-0 align-items-center">
            <!-- BÊN TRÁI: Hình ảnh -->
            <div class="col-md-4">
                <img class="img-fluid rounded-start" src="{{ asset('storage/' . $movie->image) }}" alt="Event Image">
            </div>

            <!-- BÊN PHẢI: Nội dung và nút -->
            <div class="col-md-8">
                <div class="card-body h-100 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Video YouTube -->
                        <div class="ratio ratio-16x9 mb-3">
                            <iframe src="{{ $embedUrl }}" title="YouTube video" allowfullscreen></iframe>
                        </div>

                        <div class="d-flex mb-3">
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
                            <div class="flex-grow-1">
                                <h5 class="fs-9"> {{ $movie->title }} </h5>
                                <h4 class="mt-3">Đánh giá: ★★★★★</h4>
                                <span class="fs-9 text-warning fw-semi-bold">$49.99 – $89.99</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-end d-flex flex-wrap justify-content-end gap-2">
                        <!-- Like button -->
                        <button class="btn btn-falcon-default btn-sm d-flex align-items-center" type="button">
                            <i class="fas fa-heart text-danger me-1"></i> 235
                        </button>

                        <!-- Share button -->
                        <button class="btn btn-falcon-default btn-sm d-flex align-items-center" type="button">
                            <i class="fas fa-share-alt me-1"></i> Share
                        </button>

                        <!-- Update button -->
                        <a href="{{ route('admin.movies.edit', $movie->id) }}"
                            class="btn btn-falcon-primary btn-sm px-3">
                            <i class="fas fa-edit me-1"></i> Update
                        </a>

                        <!-- Delete button inside form -->
                        <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa phim này không?')">
                                <i class="fas fa-trash-alt me-1"></i> Xóa
                            </button>
                        </form>
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