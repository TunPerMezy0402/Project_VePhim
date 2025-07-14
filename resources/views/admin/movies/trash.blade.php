@extends('admin.layouts.AdminLayout')

@section('content')

<a href="{{ route('admin.movies.index') }}" class="btn btn-danger btn-sm mt-3">Back</a>

@if(session('success'))
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif

<div class="card mb-3 mt-3" id="moviesTable">
    <div class="card-header">
        <div class="row flex-between-center">
            <div class="col-12 col-md-6 col-xl-5 d-flex align-items-center gap-3 flex-wrap">
                <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Movies Trash</h5>
                <form action="{{ route('admin.movies.trash') }}" method="GET" class="w-100 w-md-auto">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="Search..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="col-8 col-sm-auto text-end ps-2">
                <a href="{{ route('admin.movies.index') }}" class="btn btn-falcon-default btn-sm me-2">
                    <span class="fas fa-list me-1"></span>
                    <span class="d-none d-sm-inline-block">Danh Sách Phim</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive scrollbar">
            <table class="table table-sm table-striped fs-10 mb-0">
                <thead class="bg-200">
                    <tr>
                        <th class="text-900 align-middle white-space-nowrap">STT</th>
                        <th class="text-900 align-middle white-space-nowrap">Tên phim</th>
                        <th class="text-900 align-middle white-space-nowrap">Ngày tạo</th>
                        <th class="text-900 align-middle white-space-nowrap">Ngày xóa</th>
                        <th class="text-900 align-middle white-space-nowrap">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movies as $movie)
                    <tr>
                        <td class="align-middle py-2">
                            {{ $loop->iteration + ($movies->currentPage() - 1) * $movies->perPage() }}
                        </td>
                        <td class="name align-middle white-space-nowrap py-2"><a
                                href="{{ route('admin.movies.showTrash', $movie->id) }}">
                                <div class="d-flex d-flex align-items-center">
                                    <div class="avatar avatar-xl me-2">
                                        @if (!empty($movie->image) && file_exists(storage_path('app/public/' .
                                        $movie->image)))
                                        <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}"
                                            class="img-fluid rounded-3">
                                        @else
                                        <img src="{{ asset('assets/img/generic/imgphim.jpg') }}"
                                            alt="{{ $movie->title }}" class="img-fluid rounded-3">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mb-0 fs-10">{{ $movie->title }}</h5>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td class="align-middle py-2">
                            {{ optional($movie->created_at)->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="align-middle py-2">
                            {{ optional($movie->deleted_at)->format('d/m/Y H:i:s') }}
                        </td>

                        <td class="align-middle py-2">
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.movies.restore', $movie->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn khôi phục phim này không?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-undo-alt me-1"></i> Khôi phục
                                    </button>
                                </form>

                                <form action="{{ route('admin.movies.forceDelete', $movie->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn phim này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt me-1"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {!! $movies->links('pagination::bootstrap-5') !!}
    </div>
</div>

@endsection