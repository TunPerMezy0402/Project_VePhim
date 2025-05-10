@extends('admin.layouts.AdminLayout')

@section('content')
@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

<div class="card mb-3 mt-3">
    <div class="card-header">
        <div class="row flex-between-center">
            <div class="col-12 col-md-6 col-xl-5 d-flex align-items-center gap-3 flex-wrap">
                <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Thùng rác - Thể loại</h5>

                <form action="{{ route('admin.genres.trash') }}" method="GET" class="w-100 w-md-auto">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Tìm</button>
                    </div>
                </form>
            </div>

            <div class="col-auto text-end">
                <a href="{{ route('admin.genres.index') }}" class="btn btn-falcon-default btn-sm me-2">
                    <span class="fas fa-list" data-fa-transform="shrink-3 down-2"></span>
                    <span class="d-none d-sm-inline-block ms-1">Danh sách thể loại</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive scrollbar">
            <table class="table table-sm table-striped fs-10 mb-0">
                <thead class="bg-200">
                    <tr>
                        <th class="text-900 pe-1 align-middle">STT</th>
                        <th class="text-900 pe-1 align-middle">Tên thể loại</th>
                        <th class="text-900 pe-1 align-middle">Ngày tạo</th>
                        <th class="text-900 pe-1 align-middle">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($genres as $genre)
                        <tr>
                            <td class="align-middle py-2">
                                {{ $loop->iteration + ($genres->currentPage() - 1) * $genres->perPage() }}
                            </td>
                            <td class="align-middle py-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl me-2">
                                        <img class="rounded-circle" src="{{ asset('assets/img/team/2.jpg') }}" alt="avatar" />
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mb-0 fs-10">{{ $genre->name }}</h5>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle py-2">
                                {{ optional($genre->created_at)->format('d/m/Y') }}
                            </td>
                            <td class="align-middle py-2">
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.genres.restore', $genre->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn khôi phục thể loại này không?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-undo-alt me-1"></i> Khôi phục
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.genres.forceDelete', $genre->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xoá vĩnh viễn thể loại này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt me-1"></i> Xoá
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

    <div class="card-footer d-flex justify-content-center">
        {!! $genres->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection
