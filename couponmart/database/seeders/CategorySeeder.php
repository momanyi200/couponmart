<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Food & Drinks', 'Fashion', 'Electronics', 'Travel', 'Health'];

        foreach ($categories as $cat) {
            Category::create([
                'cat_name' => $cat,
            ]);
        }
    }
}

