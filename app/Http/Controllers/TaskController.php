<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller {
    // Danh sách tasks của user
    public function index() {
        $tasks = Task::with('user')->orderBy('due_date')->paginate(10);
        
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
}