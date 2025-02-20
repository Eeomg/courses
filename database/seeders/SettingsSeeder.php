<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['key' => 'name', 'value' => 'platform name'],
            ['key' => 'logo', 'value' => 'platform.logo'],
            ['key' => 'description', 'value' => 'platform description'],
            ['key' => 'mainColor', 'value' => '#000000'],
            ['key' => 'copyRight', 'value' => 'platform copyright'],
        ];

        Setting::insert($data);
    }
}
