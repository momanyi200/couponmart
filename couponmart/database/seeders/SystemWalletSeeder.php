<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wallet;


class SystemWalletSeeder extends Seeder
{
    public function run()
    {
        Wallet::firstOrCreate(
            ['is_system' => true],
            ['balance' => 0]
        );
    }
}
