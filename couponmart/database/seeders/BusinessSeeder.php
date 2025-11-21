<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Business;
use App\Models\User;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        // Create a sample user with business role
        $user = User::factory()->create([
            'name' => 'Business Owner',
            'email' => 'business@example.com',
        ]);
        $user->assignRole('business');

        Business::create([
            'business_name' => 'Quick Deals Ltd',
            'image' => null,
            'bios' => 'We offer unbeatable discounts on fashion and electronics.',
            'user_id' => $user->id,
            'town_id' => 1,
            'location' => 'Central Plaza',
            'room' => 101,
            'floor' => 1,
            'building' => 'Central Towers',
            'phone_number' => 701234567,
            'verified' => 'yes',
            'status' => 'active',
        ]);
    }
}

