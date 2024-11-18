<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Lifestyle',
            'Kids',
            'Performance'
        ];

        foreach ($categories as $ctg) {
            Category::create(['name' => ucfirst($ctg)]);
        }
    }
}
