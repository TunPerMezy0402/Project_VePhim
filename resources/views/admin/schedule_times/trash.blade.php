@extends('admin.layouts.AdminLayout')

@section('content')
<a href="{{ route('admin.cinemas.schedule_times.index', $cinema->id) }}" class="btn btn-danger btn-sm mt-3">
    <i class="fas fa-arrow-left me-1"></i> Quay lại
</a>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card mb-3 mt-3">
    <div class="card-header">
        <div class="row flex-between-center">
            <div class="col-12 col-md-6 col-xl-5 d-flex align-items-center gap-3 flex-wrap">
                <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">
                    <i class="fas fa-trash me-2"></i> Thùng Rác - Giờ Chiếu
                </h5>
                <form action="{{ route('admin.cinemas.schedule_times.trash', $cinema->id) }}" method="GET" class="w-100 w-md-auto">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm ca chiếu..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="col-8 col-sm-auto text-end ps-2">
                <a href="{{ route('admin.cinemas.schedule_times.index', $cinema->id) }}" class="btn btn-falcon-default btn-sm me-2">
                    <span class="fas fa-list" data-fa-transform="shrink-3 down-2"></span>
                    <span class="d-none d-sm-inline-block ms-1">Danh Sách Giờ Chiếu</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive scrollbar">
            <table class="table table-sm table-striped fs-10 mb-0 overflow-hidden">
                <thead class="bg-200">
                    <tr>
                        <th class="text-900 pe-1 align-middle white-space-nowrap">STT</th>
                        <th class="text-900 pe-1 align-middle white-space-nowrap">Ca Chiếu</th>
                        <th class="text-900 pe-1 align-middle white-space-nowrap">Giờ Bắt Đầu</th>
                        <th class="text-900 pe-1 align-middle white-space-nowrap">Ngày Xóa</th>
                        <th class="text-900 pe-1 align-middle white-space-nowrap">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($scheduleTimes as $scheduleTime)
                    <tr>
                        <td class="align-middle py-2" style="width: 28px;">
                            {{ $loop->iteration + ($scheduleTimes->currentPage() - 1) * $scheduleTimes->perPage() }}
                        </td>
                        <td class="align-middle py-2">
                            {{ $scheduleTime->label }}
                        </td>
                        <td class="align-middle py-2">
                                {{ \Carbon\Carbon::parse($scheduleTime->start_time)->format('H:i') }}
                        </td>
                        <td class="align-middle py-2">
                            {{ optional($scheduleTime->deleted_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="align-middle py-2">
                            <div class="d-flex gap-2">
                                <form
                                    action="{{ route('admin.cinemas.schedule_times.restore', ['cinema' => $cinema->id, 'schedule' => $scheduleTime->id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn khôi phục giờ chiếu này không?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-undo-alt me-1"></i> Khôi phục
                                    </button>
                                </form>

                                <form
                                    action="{{ route('admin.cinemas.schedule_times.forceDelete', ['cinema' => $cinema->id, 'schedule' => $scheduleTime->id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn giờ chiếu này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt me-1"></i> Xóa vĩnh viễn
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <div>Không có giờ chiếu nào trong thùng rác.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        {!! $scheduleTimes->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection
