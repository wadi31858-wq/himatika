<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@himatika.test'],
            [
                'name' => 'Admin HIMATIKA',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );
    }
}
