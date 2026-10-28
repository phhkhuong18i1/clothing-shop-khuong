<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'name' => config('admin.name'),
            'email' => config('admin.email'),
            'password' => config('admin.password'),
        ];

        Validator::make($data, [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:12'],
        ])->validate();

        $existingUser = User::where('email', $data['email'])->first();

        if ($existingUser) {
            if (! $existingUser->is_admin) {
                throw new RuntimeException('Email này đã thuộc tài khoản thường. Seeder không tự nâng quyền tài khoản hiện có.');
            }

            $this->command?->info('Tài khoản admin đã tồn tại; không thay đổi thông tin đăng nhập.');
            return;
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => true,
        ]);

        $this->command?->info('Đã tạo tài khoản admin.');
    }
}
