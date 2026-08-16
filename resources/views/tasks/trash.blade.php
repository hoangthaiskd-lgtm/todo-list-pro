@extends('tasks.layout')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh sách công việc</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-primary">Quay lại</a>
                @if (request()->has('search') || request()->has('status') || request()->has('sort_option'))
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-warning">x Xóa bộ lọc</a>
                @endif
                <form action="{{ route('tasks.forceDeleteAll') }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa tất cả task không?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Xóa tất cả</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('tasks.index') }}" class="row mb-3">
                {{-- Tìm kiếm --}}
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Tìm kiếm task...">
                </div>

                {{-- Lọc theo trạng thái --}}
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Lọc theo trạng thái --</option>
                        <option value="0" @if (request('status') === '0') selected @endif>Chưa bắt đầu</option>
                        <option value="1" @if (request('status') === '1') selected @endif>Đang làm</option>
                        <option value="2" @if (request('status') === '2') selected @endif>Hoàn thành</option>
                    </select>
                </div>

                {{-- Sắp xếp --}}
                <div class="col-md-3">
                    <select name="sort_option" class="form-select">
                        <option value="">-- Sắp xếp theo --</option>
                        <option value="due_date_asc" @if (request('sort_option') === 'due_date_asc') selected @endif>Sắp đến hạn chót</option>
                        <option value="due_date_desc" @if (request('sort_option') === 'due_date_desc') selected @endif>Chưa đến hạn chót</option>
                        <option value="created_at_desc" @if (request('sort_option') === 'created_at_desc') selected @endif>Ngày tạo mới nhất</option>
                        <option value="created_at_asc" @if (request('sort_option') === 'created_at_asc') selected @endif>Ngày tạo cũ nhất</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </div>
            </form>
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Công việc</th>
                        <th>Hạn chót</th>
                        <th>Trạng thái</th>
                        <th></th>
                        <th>Thời gian tạo</th>
                        <th>Người tạo</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Demo static -->
                    @forelse ($tasks as $task)
                        <tr data-id="{{ $task->id }}">
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->due_date }}</td>
                            <td>
                                @switch ($task->status)
                                    @case(0)
                                        <span class="badge bg-primary badge-status">Chưa bắt đầu</span>
                                    @break

                                    @case(1)
                                        <span class="badge bg-warning  badge-status">Đang làm</span>
                                    @break

                                    @case(2)
                                        <span class="badge bg-success  badge-status">Hoàn thành</span>
                                    @break

                                    @default
                                        <span class="badge bg-primary">Chưa bắt đầu</span>
                                    @break
                                @endswitch
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">Đổi trạng thái</button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item change-status" data-status="0" href="#">Chưa bắt đầu</a>
                                            <a class="dropdown-item change-status" data-status="1" href="#">Đang làm</a>
                                            <a class="dropdown-item change-status" data-status="2" href="#">Hoàn thành</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $task->created_at->format('d-m-Y') }}</td>
                            <td>{{ $task->user->name }}</td>
                            <td class="text-end">
                                <form action="{{ route('tasks.restore', $task->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn khôi phục task này không?')">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-success">Khôi phục</button>
                                </form>
                                <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa task này không?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa khỏi thùng rác</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" align="center">Hiện tại chưa có task nào</td>
                        </tr>
                    @endforelse 
                </tbody>
            </table>
            <div>
                {{ $tasks->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection