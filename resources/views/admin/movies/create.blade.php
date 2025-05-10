@extends('admin.layouts.AdminLayout')

@section('content')
<form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="card mb-3">
    <div class="card-body">
      <div class="row flex-between-center">
        <div class="col-md">
          <h5 class="mb-2 mb-md-0">Create Movie</h5>
        </div>
      </div>
    </div>
  </div>

  {{-- Cover Image --}}
  <div class="card cover-image mb-3">
    <img class="card-img-top" id="cover-preview" src="{{ asset('assets/img/generic/nophoto.png') }}" alt="Cover Preview" />
    <label class="cover-image-file-input btn btn-outline-secondary mt-2" for="upload-cover-image">
      <i class="fas fa-camera me-2"></i> Upload Cover Image
    </label>
    <input class="d-none" id="upload-cover-image" type="file" name="image" accept="image/*" onchange="previewImage(event)" />
    @error('image') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
  </div>

  <div class="row g-0">
    {{-- Left: Movie Details --}}
    <div class="col-lg-8 pe-lg-2">
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">Movie Details</h5>
        </div>
        <div class="card-body bg-body-tertiary">
          <div class="row gx-2">
            <div class="col-12 mb-3">
              <label class="form-label" for="title">Movie Title</label>
              <input class="form-control" id="title" type="text" name="title" value="{{ old('title') }}" />
              @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12 mb-3">
              <label class="form-label" for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="6">{{ old('description') }}</textarea>
              @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <label class="form-label" for="release_date">Release Date</label>
              <input class="form-control" id="release_date" type="date" name="release_date" value="{{ old('release_date') }}" />
              @error('release_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <label class="form-label" for="duration">Duration (in minutes)</label>
              <input class="form-control" id="duration" type="number" name="duration" value="{{ old('duration') }}" />
              @error('duration') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <label class="form-label" for="country_id">Country</label>
              <select class="form-select" id="country_id" name="country_id">
                <option value="">Select a country...</option>
                @foreach ($countries as $country)
                  <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                  </option>
                @endforeach
              </select>
              @error('country_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <label class="form-label" for="director_id">Director</label>
              <select class="form-select" id="director_id" name="director_id">
                <option value="">Select a director...</option>
                @foreach ($directors as $director)
                  <option value="{{ $director->id }}" {{ old('director_id') == $director->id ? 'selected' : '' }}>
                    {{ $director->name }}
                  </option>
                @endforeach
              </select>
              @error('director_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
              </div>
              @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12 mb-3">
              <label class="form-label" for="trailer_url">Trailer URL</label>
              <input class="form-control" id="trailer_url" type="url" name="trailer_url" value="{{ old('trailer_url') }}" />
              @error('trailer_url') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Right: Other Info --}}
    <div class="col-lg-4 ps-lg-2">
      <div class="sticky-sidebar">
        <div class="card mb-3">
          <div class="card-header">
            <h5 class="mb-0">Other Info</h5>
          </div>
          <div class="card-body bg-body-tertiary">
            <div class="mb-3">
              <label class="form-label" for="sponsors">Sponsors</label>
              <select class="form-select" id="sponsors" name="sponsors[]" multiple>
                <option value="Microsoft Corporation">Microsoft Corporation</option>
                <option value="Technext Limited">Technext Limited</option>
                <option value="Hewlett-Packard">Hewlett-Packard</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" for="event_type">Event Type</label>
              <select class="form-select" id="event_type" name="event_type">
                <option value="">Select event type...</option>
                <option value="Class, Training, or Workshop">Class, Training, or Workshop</option>
                <option value="Concert or Performance">Concert or Performance</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card-footer">
    <button type="submit" class="btn btn-primary">Create Movie</button>
  </div>
</form>
@endsection

@push('scripts')
<script>
  function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function(){
      document.getElementById('cover-preview').src = reader.result;
    };

    if (input.files && input.files[0]) {
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush
