@extends('admin.layouts.AdminLayout')

@section('content')
<a href="{{ route('admin.directors.index') }}" class="btn btn-danger btn-sm mt-3">Back</a>
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card mb-3 mt-3" id="directorsTable">
    <div class="card-header">
        <div class="row flex-between-center">
            <div class="col-12 col-md-6 col-xl-5 d-flex align-items-center gap-3 flex-wrap">
                <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Directors</h5>
                <form action="{{ route('admin.directors.trash') }}" method="GET" class="w-100 w-md-auto">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="Search ..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="col-8 col-sm-auto text-end ps-2">
                <div id="table-directors-replace-element">
                    <!-- Nút Danh Sách Đạo Diễn -->
                    <a href="{{ route('admin.directors.index') }}" class="btn btn-falcon-default btn-sm me-2">
                        <span class="fas fa-list" data-fa-transform="shrink-3 down-2"></span>
                        <span class="d-none d-sm-inline-block ms-1">Danh Sách Đạo Diễn</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive scrollbar">
            <table class="table table-sm table-striped fs-10 mb-0 overflow-hidden">
                <thead class="bg-200">
                    <tr>
                        <th class="text-900 sort pe-1 align-middle white-space-nowrap">STT</th>
                        <th class="text-900 sort pe-1 align-middle white-space-nowrap" data-sort="name">Name</th>
                        <th class="text-900 sort pe-1 align-middle white-space-nowrap" data-sort="joined">Ngày Tạo</th>
                        <th class="text-900 sort pe-1 align-middle white-space-nowrap" data-sort="status">Status</th>
                    </tr>
                </thead>
                <tbody class="list" id="table-directors-body">
                    @foreach ($directors as $director)
                    <tr class="btn-reveal-trigger">
                        <td class="align-middle py-2" style="width: 28px;">
                            {{ $loop->iteration + ($directors->currentPage() - 1) * $directors->perPage() }}
                        </td>
                        <td class="name align-middle white-space-nowrap py-2">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl me-2">
                                    <img class="rounded-circle" src="../../assets/img/team/2.jpg" alt="Ảnh đạo diễn" />
                                </div>
                                <div class="flex-1">
                                    <h5 class="mb-0 fs-10">{{ $director->name }}</h5>
                                </div>
                            </div>
                        </td>
                        <td class="joined align-middle py-2">
                            {{ optional($director->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="joined align-middle py-2">
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.directors.restore', $director->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn khôi phục đạo diễn này không?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-undo-alt me-1"></i> Khôi phục
                                    </button>
                                </form>

                                <form action="{{ route('admin.directors.forceDelete', $director->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đạo diễn này không?');">
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
    <div class="d-flex justify-content-center">
        {!! $directors->links('pagination::bootstrap-5') !!}
    </div>
</div>

@endsection
