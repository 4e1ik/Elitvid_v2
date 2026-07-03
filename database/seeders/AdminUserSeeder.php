<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'el_vid@mail.ru'],
            [
                'username' => 'Admin',
                'password' => 'vT%Q0FAnv\2Xp$0',
                'role' => UserRole::Admin,
            ]
        );
    }
}
