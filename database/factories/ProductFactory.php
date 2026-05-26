<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Tech product names and brands for realistic data
        $techProducts = [
            'iPhone 15 Pro Max', 'iPhone 15 Pro', 'iPhone 15', 'iPhone 14 Pro Max',
            'Samsung Galaxy S24 Ultra', 'Samsung Galaxy S24+', 'Samsung Galaxy S24',
            'Google Pixel 8 Pro', 'Google Pixel 8', 'Google Pixel 7 Pro',
            'ASUS ROG Phone 8', 'ASUS Zenfone 10', 'OnePlus 12', 'OnePlus 11',
            'Xiaomi 14 Ultra', 'Xiaomi 13 Pro', 'Xiaomi 12T Pro',
            'MacBook Pro 16" M3 Max', 'MacBook Pro 14" M3 Pro', 'MacBook Air 15" M3',
            'MacBook Air 13" M2', 'MacBook Pro 14" M2 Pro', 'MacBook Pro 16" M2 Max',
            'Dell XPS 15', 'Dell XPS 13', 'Dell Alienware m16', 'Dell Inspiron 16',
            'HP Spectre x360', 'HP Omen 16', 'HP Pavilion 15', 'HP EliteBook 860',
            'Lenovo ThinkPad X1 Carbon', 'Lenovo ThinkPad X1 Yoga', 'Lenovo Legion 9i',
            'Lenovo IdeaPad Gaming 3', 'Lenovo Yoga 9i', 'Lenovo ThinkPad T14',
            'ASUS ROG Strix G16', 'ASUS TUF Gaming F15', 'ASUS ZenBook Pro 14',
            'ASUS Vivobook Pro 15', 'ASUS ExpertBook B1', 'ASUS Chromebook Flip',
            'iPad Pro 12.9" M2', 'iPad Pro 11" M2', 'iPad Air 5', 'iPad 10',
            'Samsung Galaxy Tab S9 Ultra', 'Samsung Galaxy Tab S9+', 'Samsung Galaxy Tab S9',
            'Sony WH-1000XM5', 'Sony WF-1000XM5', 'Sony LinkBuds S', 'Sony WH-CH720N',
            'AirPods Pro 2', 'AirPods Max', 'AirPods 3', 'AirPods 2',
            'Samsung Galaxy Buds2 Pro', 'Samsung Galaxy Buds2', 'Samsung Galaxy Buds Live',
            'Bose QuietComfort Ultra', 'Bose QuietComfort Earbuds II', 'Bose Sport Earbuds',
            'JBL Tour One M2', 'JBL Tune Buds2', 'JBL Wave 200TWS', 'JBL Endurance Peak 3',
            'Logitech MX Master 3S', 'Logitech MX Keys Mini', 'Logitech G Pro X Superlight',
            'Logitech G915 TKL', 'Logitech MX Ergo', 'Logitech MX Vertical',
            'Razer DeathAdder V3 Pro', 'Razer BlackWidow V4 Pro', 'Razer Basilisk V3',
            'Razer Huntsman Mini', 'Razer Viper Ultimate', 'Razer Orochi V2',
            'Keychron K2 Pro', 'Keychron Q1 Pro', 'Keychron K8 Pro', 'Keychron V3',
            'Corsair K95 RGB Platinum', 'Corsair K70 RGB MK.2', 'Corsair K60 RGB Pro',
            'Samsung 990 Pro 2TB', 'Samsung 980 Pro 1TB', 'Samsung 870 EVO 4TB',
            'WD Black SN850X 2TB', 'WD Black SN770 1TB', 'WD Blue SN570 2TB',
            'Crucial T700 2TB', 'Crucial P5 Plus 2TB', 'Crucial MX500 2TB',
            'Kingston KC3000 2TB', 'Kingston NV2 2TB', 'Kingston A400 2TB',
            'Seagate FireCuda 530 2TB', 'Seagate Barracuda 4TB', 'Seagate IronWolf 8TB',
            'SanDisk Extreme Pro 2TB', 'SanDisk Extreme 2TB', 'SanDisk Ultra 2TB',
            'NVIDIA RTX 4090', 'NVIDIA RTX 4080 Super', 'NVIDIA RTX 4070 Ti Super',
            'NVIDIA RTX 4070 Super', 'NVIDIA RTX 4060 Ti', 'NVIDIA RTX 4060',
            'AMD Radeon RX 7900 XTX', 'AMD Radeon RX 7900 XT', 'AMD Radeon RX 7800 XT',
            'AMD Radeon RX 7700 XT', 'AMD Radeon RX 7600', 'AMD Radeon RX 6750 XT',
            'Intel Core i9-14900K', 'Intel Core i7-14700K', 'Intel Core i5-14600K',
            'Intel Core i9-13900K', 'Intel Core i7-13700K', 'Intel Core i5-13600K',
            'AMD Ryzen 9 7950X3D', 'AMD Ryzen 9 7950X', 'AMD Ryzen 9 7900X3D',
            'AMD Ryzen 9 7900X', 'AMD Ryzen 7 7800X3D', 'AMD Ryzen 7 7700X',
            'G.Skill Trident Z5 RGB 32GB', 'G.Skill Ripjaws V 32GB', 'Corsair Vengeance 32GB',
            'Kingston Fury Beast 32GB', 'Crucial Ballistix 32GB', 'Samsung DDR5 32GB',
        ];

        $brands = [
            'Apple', 'Samsung', 'Google', 'ASUS', 'OnePlus', 'Xiaomi', 'Dell', 'HP',
            'Lenovo', 'Sony', 'Bose', 'JBL', 'Logitech', 'Razer', 'Keychron', 'Corsair',
            'WD', 'Seagate', 'SanDisk', 'NVIDIA', 'AMD', 'Intel', 'G.Skill', 'Kingston',
            'Crucial',
        ];

        $productName = $this->faker->randomElement($techProducts);
        $brand = $this->faker->randomElement($brands);

        // Generate price in FCFA between 5,000 and 1,500,000 (no decimals)
        $price = $this->faker->numberBetween(5000, 1500000);

        // Generate SKU (unique reference)
        $sku = strtoupper($brand) . '-' . $this->faker->bothify('???-####');

        // Generate stock quantity (some at 0 for testing out of stock)
        $stockQuantity = $this->faker->numberBetween(0, 100);

        // Get random category
        $category = Category::inRandomOrder()->first();

        return [
            'name' => $productName,
            'brand' => $brand,
            'description' => $this->faker->paragraphs(3, true),
            'price' => $price,
            'stock_quantity' => $stockQuantity,
            'sku' => $sku,
            'image' => null, // Can be updated later
            'category_id' => $category ? $category->id : null,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
