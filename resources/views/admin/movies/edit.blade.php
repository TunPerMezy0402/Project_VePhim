@extends('admin.layouts.AdminLayout')

@section('content')

<form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="card mb-3">
    <div class="card-body">
      <div class="row flex-between-center">
        <div class="col-md">
          <h5 class="mb-2 mb-md-0">Update Movie</h5>
        </div>
      </div>
    </div>
  </div>

  <a href="{{ route('admin.movies.index') }}" class="btn btn-danger btn-sm mb-3">Back</a>

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
              <input class="form-control" id="title" type="text" name="title"
                value="{{ old('title', $movie->title) }}" />
              @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12 mb-3">
              <label class="form-label" for="description">Description</label>
              <textarea class="form-control" id="description" name="description"
                rows="8">{{ old('description', $movie->description) }}</textarea>
              @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <label class="form-label" for="release_date">Release Date</label>
              <input class="form-control" id="release_date" type="date" name="release_date"
                value="{{ old('release_date', $movie->release_date) }}" />
              @error('release_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <label class="form-label" for="duration">Duration (in minutes)</label>
              <input class="form-control" id="duration" type="number" name="duration"
                value="{{ old('duration', $movie->duration) }}" />
              @error('duration') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <label class="form-label" for="country_id">Country</label>
              <select class="form-select" id="country_id" name="country_id">
                <option value="">Select a country...</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}" {{ old('country_id', $movie->country_id) == $country->id ? 'selected'
                  : '' }}>{{ $country->name }}</option>
                @endforeach
              </select>
              @error('country_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <label class="form-label" for="director_id">Director</label>
              <select class="form-select" id="director_id" name="director_id">
                <option value="">Select a director...</option>
                @foreach ($directors as $director)
                <option value="{{ $director->id }}" {{ old('director_id', $movie->director_id) == $director->id ?
                  'selected' : '' }}>{{ $director->name }}</option>
                @endforeach
              </select>
              @error('director_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{
                  old('is_active', $movie->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
              </div>
              @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12 mb-3">
              <label class="form-label" for="trailer_url">Trailer URL</label>
              <input class="form-control" id="trailer_url" type="url" name="trailer_url"
                value="{{ old('trailer_url', $movie->trailer_url) }}" />
              @error('trailer_url') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Right: Cover Image + Other Info --}}
    <div class="col-lg-4 ps-lg-2">
      <div class="sticky-sidebar">

        {{-- Cover Image --}}
<div class="card mb-3 text-center">
  <div class="position-relative d-inline-block">
    <img
      id="cover-preview"
      src="{{ $movie->image ? asset('storage/' . $movie->image) : asset('assets/img/generic/nophoto.png') }}"
      alt="Cover Preview"
      class="img-fluid rounded mt-2"
      style="width: 200px; height: auto;"
    >
    <button type="button" id="remove-image"
      class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
      style="border-radius: 50%; width: 30px; height: 30px; line-height: 1; font-size: 18px; padding: 0; border: 2px solid #dc3545; background-color: white;"
      title="Remove image" onclick="removeImage()"
      {{ $movie->image ? '' : 'hidden' }}>
      <i class="fas fa-times" style="color: #dc3545;"></i>
    </button>
  </div>

  <label for="upload-cover-image" class="btn btn-outline-secondary mt-2">
    <i class="fas fa-camera me-2"></i> Upload Cover Image
  </label>
  <input type="file" id="upload-cover-image" name="image" accept="image/*" class="d-none"
    onchange="previewImage(event)">

  @error('image')
    <span class="text-danger d-block mt-1">{{ $message }}</span>
  @enderror
</div>



        {{-- Genres --}}
        <div class="card-body bg-body-tertiary p-3">
          <div class="mb-4">
            <label class="form-label fw-semibold">Thể loại</label>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
              @foreach($genres as $genre)
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="genres[]" id="genre_{{ $genre->id }}"
                    value="{{ $genre->id }}" {{ in_array($genre->id, old('genres',
                  $movie->genres->pluck('id')->toArray())) ? 'checked' : '' }}>
                  <label class="form-check-label" for="genre_{{ $genre->id }}">
                    <span class="d-block text-truncate" style="max-width: 150px;">{{ $genre->name }}</span>
                  </label>
                </div>
              </div>
              @endforeach
            </div>
            @error('genres') <div class="text-danger mt-2">{{ $message }}</div> @enderror
          </div>

          {{-- Actors --}}
          <div class="mb-4">
            <label class="form-label fw-semibold">Diễn viên</label>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
              @foreach($actors as $actor)
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="actors[]" id="actor_{{ $actor->id }}"
                    value="{{ $actor->id }}" {{ in_array($actor->id, old('actors',
                  $movie->actors->pluck('id')->toArray())) ? 'checked' : '' }}>
                  <label class="form-check-label" for="actor_{{ $actor->id }}">
                    <span class="d-block text-truncate" style="max-width: 150px;">{{ $actor->name }}</span>
                  </label>
                </div>
              </div>
              @endforeach
            </div>
            @error('actors') <div class="text-danger mt-2">{{ $message }}</div> @enderror
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="card-footer">
    <button type="submit" class="btn btn-primary">Update Movie</button>
  </div>
</form>

@endsection

<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
      const output = document.getElementById('cover-preview');
      output.src = reader.result;
      document.getElementById('remove-image').hidden = false;
    };
    reader.readAsDataURL(event.target.files[0]);
  }

  function removeImage() {
    const preview = document.getElementById('cover-preview');
    const input = document.getElementById('upload-cover-image');
    preview.src = "{{ asset('assets/img/generic/nophoto.png') }}";
    input.value = '';
    document.getElementById('remove-image').hidden = true;
  }
</script>
