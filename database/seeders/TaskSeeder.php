<?php
namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Xoá toàn bộ dữ liệu cũ trước khi seed
        DB::table('tasks')->truncate();

        $user = User::first();

        DB::table('tasks')->insert([
            [
                'title' => 'Học Laravel cơ bản',
                'description' => 'Hoàn thành series Laravel Basic để nắm vững MVC.',
                'due_date' => '2025-09-30',
                'status' => Task::IN_PROGRESS,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'title' => 'Cài đặt Breeze Auth',
                'description' => 'Cấu hình đăng nhập, đăng ký, reset password bằng Breeze.',
                'due_date' => '2025-10-01',
                'status' => Task::NOT_STARTED,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'title' => 'Thiết kế UI Todo App',
                'description' => 'Sử dụng Bootstrap 5 để tạo UI hiện đại cho Todo List Pro.',
                'due_date' => '2025-10-03',
                'status' => Task::COMPLETED,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'title' => 'Viết Seeder cho Tasks',
                'description' => 'Tạo dữ liệu mẫu cho bảng tasks để test ứng dụng.',
                'due_date' => '2025-10-05',
                'status' => Task::IN_PROGRESS,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'title' => 'Tích hợp CRUD Task',
                'description' => 'Xây dựng đầy đủ Create, Read, Update, Delete.',
                'due_date' => '2025-10-07',
                'status' => Task::NOT_STARTED,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'title' => 'Thêm tính năng Search',
                'description' => 'Cho phép tìm task theo tiêu đề và ngày hết hạn.',
                'due_date' => '2025-10-10',
                'status' => Task::IN_PROGRESS,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'title' => 'Xây dựng API cho Mobile',
                'description' => 'Cung cấp API JSON để Todo App có thể chạy trên mobile.',
                'due_date' => '2025-10-15',
                'status' => Task::IN_PROGRESS,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'title' => 'Hoàn thiện tính năng Filter',
                'description' => 'Lọc task theo trạng thái: Chưa làm, Đang làm, Đã làm.',
                'due_date' => '2025-10-18',
                'status' => Task::COMPLETED,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'title' => 'Triển khai lên Hosting',
                'description' => 'Deploy ứng dụng Todo List Pro lên VPS/Shared Hosting.',
                'due_date' => '2025-10-20',
                'status' => Task::IN_PROGRESS,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'title' => 'Viết Document sử dụng',
                'description' => 'Soạn hướng dẫn chi tiết cho người dùng cuối.',
                'due_date' => '2025-10-25',
                'status' => Task::NOT_STARTED,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
        ]);

        Task::factory(100)->create();
    }
}