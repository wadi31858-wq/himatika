<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin HIMATIKA',
            'email' => 'admin@himatika.test',
            'password' => Hash::make('password'),
        ]);
    }
}
