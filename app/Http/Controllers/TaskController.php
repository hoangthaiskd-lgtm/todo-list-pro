<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller {
    // Danh sách tasks của user
    public function index(Request $request) {
        $query = Task::query();

        // Tìm kiếm
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%'. $request->search .'%')->orWhere('description', 'LIKE', '%'. $request->search .'%');
            });
        }

        // Lọc theo trạng thái
        $isStatus = in_array($request->status, [
            Task::NOT_STARTED,
            Task::IN_PROGRESS,
            Task::COMPLETED
        ]);
        if ($request->filled('status') && $isStatus) {
            $query->where('status', $request->status);
        }

        // Sắp xếp
        switch ($request->sort_option) {
            case 'due_date_asc':
                $query->orderBy('due_date');
                break;
            case 'due_date_desc':
                $query->orderBy('due_date', 'desc');
                break;
            case 'created_at_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at');
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        $tasks = $query->with('user')->paginate(10)->appends($request->all());
        
        return view('tasks.index', compact('tasks'));
    }

    // Tạo task mới
    public function create() {
        return view('tasks.create');
    }

    // Lưu task mới
    public function store(StoreTaskRequest $request) {
        $data = array_merge($request->all(), [
            'user_id' => Auth::id()
        ]);

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Tạo task mới thành công!');
    }

    // Xem chi tiết task
    public function show(string $id) {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    // Hiển thị form sửa task
    public function edit(string $id) {
        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('task'));
    }

    // Cập nhật task
    public function update(StoreTaskRequest $request, string $id) {
        $task = Task::findOrFail($id);

        $task->update($request->only('title', 'description', 'due_date', 'status'));

        return redirect()->route('tasks.index')->with('success', 'Cập nhật task thành công!');
    }

    // Xóa task
    public function destroy(string $id) {
        Task::findOrFail($id)->delete();

        return redirect()->route('tasks.index')->with('success', 'Xóa task thành công!');
    }

    // Cập nhật trạng thái
    public function updateStatus(Request $request, $id) {
        $validated = $request->validate([
            'status' => 'required|in:0,1,2'
        ]);
        
        $task = Task::findOrFail($id);

        $task->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!',
            'status' => $task->status
        ]);
    }
}