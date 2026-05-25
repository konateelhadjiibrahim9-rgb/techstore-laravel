<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Ordinateurs Portables',
                'slug' => 'ordinateurs-portables',
            ],
            [
                'name' => 'Composants (CPU/GPU/RAM)',
                'slug' => 'composants-cpu-gpu-ram',
            ],
            [
                'name' => 'Périphériques & Accessoires',
                'slug' => 'peripheriques-accessoires',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
