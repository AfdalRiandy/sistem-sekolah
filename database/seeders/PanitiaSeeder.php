<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PanitiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Panitia',
            'email' => 'panitia@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'panitia',
        ]);
    }
}