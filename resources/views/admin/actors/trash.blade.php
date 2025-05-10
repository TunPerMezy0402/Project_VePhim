@extends('admin.layouts.AdminLayout')

@section('content')
<a href="{{ route('admin.actors.index') }}" class="btn btn-danger btn-sm mt-3">Back</a>
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card mb-3 mt-3" id="customersTable" {{--
    data-list='{"valueNames":["name","email","phone","address","joined","status"]} --}}'>
    <div class="card-header">
        <div class="row flex-between-center">
            <div class="col-12 col-md-6 col-xl-5 d-flex align-items-center gap-3 flex-wrap">
                <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Customers</h5>
                <form action="{{ route('admin.actors.trash') }}" method="GET" class="w-100 w-md-auto">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="Search ..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Tìm</button>
                    </div>
                </form>
            </div>
            <div class="col-8 col-sm-auto text-end ps-2">
                <div id="table-customers-replace-element">
                    <!-- Nút Danh Sách Diễn Viên -->
                    <a href="{{ route('admin.actors.index') }}" class="btn btn-falcon-default btn-sm me-2">
                        <span class="fas fa-list" data-fa-transform="shrink-3 down-2"></span>
                        <span class="d-none d-sm-inline-block ms-1">Danh Sách Diễn Viên</span>
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
                <tbody class="list" id="table-customers-body">
                    @foreach ($actors as $actor)
                    <tr class="btn-reveal-trigger">
                        <td class="align-middle py-2" style="width: 28px;">
                            {{ $loop->iteration + ($actors->currentPage() - 1) * $actors->perPage() }}
                        </td>
                        <td class="name align-middle white-space-nowrap py-2">
                            <div class="d-flex d-flex align-items-center">
                                <div class="avatar avatar-xl me-2">
                                    <img class="rounded-circle" src="../../assets/img/team/2.jpg" alt="" />
                                </div>
                                <div class="flex-1">
                                    <h5 class="mb-0 fs-10">{{ $actor->name }}</h5>
                                </div>
                            </div>
                        </td>
                        <td class="joined align-middle py-2">
                            {{ optional($actor->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="joined align-middle py-2">
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.actors.restore', $actor->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn khôi phục diễn viên này không?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-undo-alt me-1"></i> Khôi phục
                                    </button>
                                </form>

                                <form action="{{ route('admin.actors.forceDelete', $actor->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn diễn viên này không?');">
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
        {!! $actors->links('pagination::bootstrap-5') !!}
    </div>
</div>

@endsection