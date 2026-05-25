<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laptopsCategory = Category::where('slug', 'ordinateurs-portables')->first();
        $componentsCategory = Category::where('slug', 'composants-cpu-gpu-ram')->first();
        $peripheralsCategory = Category::where('slug', 'peripheriques-accessoires')->first();

        $products = [
            [
                'name' => 'ASUS ROG Strix G16',
                'brand' => 'ASUS',
                'sku' => 'ASUS-ROG-G16-2024',
                'description' => 'Ordinateur portable gaming haute performance avec processeur Intel Core i9-13980HX, carte graphique NVIDIA RTX 4070, 32GB RAM, écran 16" QHD 240Hz.',
                'price' => 1899.99,
                'stock_quantity' => 15,
                'image_path' => 'images/asus-rog-strix-g16.jpg',
                'category_id' => $laptopsCategory->id,
            ],
            [
                'name' => 'Intel Core i7-14700K',
                'brand' => 'Intel',
                'sku' => 'INTL-I7-14700K',
                'description' => 'Processeur de 20ème génération avec 20 cœurs (8 Performance + 12 Efficient), fréquence jusqu\'à 5.6GHz, compatible socket LGA1700.',
                'price' => 449.99,
                'stock_quantity' => 25,
                'image_path' => 'images/intel-core-i7-14700k.jpg',
                'category_id' => $componentsCategory->id,
            ],
            [
                'name' => 'Logitech G Pro X Superlight',
                'brand' => 'Logitech',
                'sku' => 'LOGI-GPRO-X-SUPERLIGHT',
                'description' => 'Souris gaming ultra-légère (63g) avec capteur HERO 25K, 25600 DPI, sans fil LIGHTSPEED, 70 heures d\'autonomie.',
                'price' => 149.99,
                'stock_quantity' => 40,
                'image_path' => 'images/logitech-g-pro-x-superlight.jpg',
                'category_id' => $peripheralsCategory->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
