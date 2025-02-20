<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Cash', 'description' => 'cash description', 'phone' => null],
            ['name' => 'Vodafone', 'description' => 'Vodafone description', 'phone' => '01010101'],
            ['name' => 'Insta-pay', 'description' => 'Insta-pay description', 'phone' => '010101010'],
        ];

        Payment::insert($data);
    }
}
