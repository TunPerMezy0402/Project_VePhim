@extends('admin.layouts.AdminLayout')

@section('content')
<div class="content">
    <!-- Card for Movie Header -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row flex-between-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">View Movie</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Movie Details Card -->
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-6">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <div class="d-flex">
                                <div class="calendar me-2">
                                    <span class="calendar-month">{{ $movie->release_month }}</span>
                                    <span class="calendar-day">{{ $movie->release_day }}</span>
                                </div>
                                <div class="flex-1 fs-10">
                                    <h5 class="fs-9">{{ $movie->title }}</h5>
                                    <p class="mb-0">by <a href="#!">{{ $movie->director->name }}</a></p>
                                    <span class="fs-9 text-warning fw-semi-bold">${{ $movie->price }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto mt-4 mt-md-0">
                            <button class="btn btn-falcon-default btn-sm me-2" type="button">
                                <span class="fas fa-heart text-danger me-1"></span>{{ $movie->likes }}
                            </button>
                            <button class="btn btn-falcon-default btn-sm me-2" type="button">
                                <span class="fas fa-share-alt me-1"></span>Share
                            </button>
                            <button class="btn btn-falcon-primary btn-sm px-4 px-sm-5" type="button">Buy Ticket</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Image aligned to the right -->
            <div class="col-md-6">
                <img class="card-img-top" src="{{ asset('path/to/movie-image.jpg') }}" alt="Movie Poster" />
            </div>
        </div>
    </div>

    <!-- Movie Description and Tags -->
    <div class="row g-0">
        <div class="col-lg-8 pe-lg-2">
            <div class="card mb-3 mb-lg-0">
                <div class="card-body">
                    <h5 class="fs-9 mb-3">{{ $movie->description_title }}</h5>
                    <p>{{ $movie->description }}</p>
                    <h5 class="fs-9 mt-5 mb-2">Tags</h5>
                    @foreach($movie->tags as $tag)
                        <a class="badge border link-secondary me-1 text-decoration-none" href="#!">{{ $tag->name }}</a>
                    @endforeach
                    <h5 class="fs-9 mt-5 mb-2">Share with friends</h5>
                    <div class="icon-group">
                        <a class="icon-item text-facebook" href="#!"><span class="fab fa-facebook-f"></span></a>
                        <a class="icon-item text-twitter" href="#!"><span class="fab fa-twitter"></span></a>
                        <a class="icon-item text-google-plus" href="#!"><span class="fab fa-google-plus-g"></span></a>
                        <a class="icon-item text-linkedin" href="#!"><span class="fab fa-linkedin-in"></span></a>
                    </div>
                    <div class="googlemap min-vh-50 rounded-3 mt-5" id="view-map" data-latlng="{{ $movie->location_latlng }}" data-scrollwheel="false" data-icon="{{ asset('assets/img/icons/map-marker.png') }}" data-zoom="17" data-theme="Default">
                        <div class="marker-content pb-3" data-bs-theme="light">
                            <h5>{{ $movie->location }}</h5>
                            <p>{{ $movie->location_description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar with Additional Info -->
        <div class="col-lg-4 ps-lg-2">
            <div class="sticky-sidebar">
                <!-- Event Date & Time -->
                <div class="card mb-3 fs-10">
                    <div class="card-body">
                        <h6>Date And Time</h6>
                        <p class="mb-1">{{ $movie->event_start_date }} – {{ $movie->event_end_date }}</p>
                        <a href="#!">Add to Calendar</a>
                        <h6 class="mt-4">Location</h6>
                        <div class="mb-1">{{ $movie->location }}<br />{{ $movie->address }}<br />{{ $movie->city }}, {{ $movie->state }}</div>
                        <a href="#view-map">View Map</a>
                        <h6 class="mt-4">Refund Policy</h6>
                        <p class="fs-10 mb-0">{{ $movie->refund_policy }}</p>
                    </div>
                </div>

                <!-- Suggested Events -->
                <div class="card mb-3 mb-lg-0">
                    <div class="card-header bg-body-tertiary">
                        <h5 class="mb-0">Events you may like</h5>
                    </div>
                    <div class="card-body fs-10">
                        @foreach($suggestedEvents as $event)
                            <div class="d-flex btn-reveal-trigger">
                                <div class="calendar">
                                    <span class="calendar-month">{{ $event->month }}</span>
                                    <span class="calendar-day">{{ $event->day }}</span>
                                </div>
                                <div class="flex-1 position-relative ps-3">
                                    <h6 class="fs-9 mb-0"><a href="{{ route('event.show', $event->id) }}">{{ $event->title }}</a></h6>
                                    <p class="mb-1">Organized by <a href="#!" class="text-700">{{ $event->organizer }}</a></p>
                                    <p class="text-1000 mb-0">{{ $event->start_time }} – {{ $event->end_time }}</p>
                                    <p class="text-1000 mb-0">{{ $event->location }}</p>
                                </div>
                            </div>
                            <div class="border-bottom border-dashed my-3"></div>
                        @endforeach
                    </div>
                    <div class="card-footer bg-body-tertiary p-0 border-top">
                        <a class="btn btn-link d-block w-100" href="{{ route('events.index') }}">All Events<span class="fas fa-chevron-right ms-1 fs-11"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
