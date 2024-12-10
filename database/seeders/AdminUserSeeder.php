<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'tri',
            'email' => 'tri@admin.com',
            'password' => Hash::make('makanbang'),
            'status' => 1,
            'role' => "admin",
        ]);
    }
}
