@extends('admin.layouts.AdminLayout')

@section('content')

@include('admin.layouts.partials.cinemas')


<div class="card mb-3" id="customersTable">
    <div class="card-header">
        <div class="row flex-between-center">
            <div class="col-12 col-md-6 col-xl-5 d-flex align-items-center gap-3 flex-wrap">
                <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Danh sách thời gian chiếu</h5>
                <form action="{{ route('admin.cinemas.schedule_times.index', $cinema->id) }}" method="GET" class="d-flex gap-2 w-100 w-md-auto">
    <div class="input-group input-group-sm">
        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm ..."
            value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Tìm</button>
    </div>
    <select name="sort" onchange="this.form.submit()" class="form-select form-select-sm w-auto">
        <option value="">Mới Nhất</option>
        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
    </select>
</form>

            </div>
            <div class="col-8 col-sm-auto text-end ps-2">
                <div id="table-customers-replace-element">
                    <!-- Nút New -->
                    <a href="{{ route('admin.cinemas.schedule_times.create', $cinema->id) }}" class="btn btn-falcon-default btn-sm me-2">
                        <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                        <span class="d-none d-sm-inline-block ms-1">Thêm mới</span>
                    </a>

                    <!-- Nút Thùng Rác -->
                    <a href="{{ route('admin.cinemas.schedule_times.trash', $cinema->id) }}" class="btn btn-falcon-default btn-sm me-2">
                        <span class="fas fa-trash-alt" data-fa-transform="shrink-3 down-2"></span>
                        <span class="d-none d-sm-inline-block ms-1">Thùng Rác</span>
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
                        <th class="text-900 sort pe-1 align-middle white-space-nowrap">Ca Chiếu</th>
                        <th class="text-900 sort pe-1 align-middle white-space-nowrap">Giờ Bắt Đầu</th>
                        <th class="text-900 sort pe-1 align-middle white-space-nowrap">Ngày tạo</th>
                        <th class="text-900 sort pe-1 align-middle white-space-nowrap">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="list" id="table-customers-body">
                    @foreach ($scheduleTimes as $scheduleTime)
                    <tr class="btn-reveal-trigger">
                        <td class="align-middle py-2">
                            {{ $loop->iteration + ($scheduleTimes->currentPage() - 1) * $scheduleTimes->perPage() }}
                        </td>
                        <td class="align-middle white-space-nowrap py-2">
                            {{ $scheduleTime->label }}
                        </td>
                        <td class="align-middle white-space-nowrap py-2">
                            {{ $scheduleTime->start_time }}
                        </td>
                        <td class="align-middle py-2">
                            {{ optional($scheduleTime->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="align-middle py-2">
                            <a href="{{ route('admin.cinemas.schedule_times.edit', [$cinema->id, $scheduleTime->id]) }}">Chỉnh Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        {!! $scheduleTimes->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection
