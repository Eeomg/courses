<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'owner@owner.com',
            'phone' => '1234567890',
            'password' => Hash::make('password123'),
            'provider' => 'email',
            'provider_id' => null,
            'activated' => true,
        ]);
    }
}
