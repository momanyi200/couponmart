<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TownSeeder extends Seeder
{
    public function run(): void
    {
        $towns = [
            'Nairobi',
            'Mombasa',
            'Kisumu',
            'Nakuru',
            'Eldoret',
            'Thika',
            'Naivasha',
            'Nyeri',
            'Meru',
            'Embu',
            'Kericho',
            'Kakamega',
            'Bungoma',
            'Kitale',
            'Machakos',
            'Kisii',
            'Garissa',
            'Wajir',
            'Mandera',
            'Isiolo',
            'Marsabit',
            'Narok',
            'Voi',
            'Malindi',
            'Lamu',
        ];

        foreach ($towns as $town) {
            DB::table('towns')->updateOrInsert(
                ['town_name' => $town],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
