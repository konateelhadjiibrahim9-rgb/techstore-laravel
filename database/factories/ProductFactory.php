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
        // Tech products with their correct brands for consistency
        $techProducts = [
            // Apple products
            ['name' => 'iPhone 15 Pro Max', 'brand' => 'Apple'],
            ['name' => 'iPhone 15 Pro', 'brand' => 'Apple'],
            ['name' => 'iPhone 15', 'brand' => 'Apple'],
            ['name' => 'iPhone 14 Pro Max', 'brand' => 'Apple'],
            ['name' => 'MacBook Pro 16" M3 Max', 'brand' => 'Apple'],
            ['name' => 'MacBook Pro 14" M3 Pro', 'brand' => 'Apple'],
            ['name' => 'MacBook Air 15" M3', 'brand' => 'Apple'],
            ['name' => 'MacBook Air 13" M2', 'brand' => 'Apple'],
            ['name' => 'MacBook Pro 14" M2 Pro', 'brand' => 'Apple'],
            ['name' => 'MacBook Pro 16" M2 Max', 'brand' => 'Apple'],
            ['name' => 'iPad Pro 12.9" M2', 'brand' => 'Apple'],
            ['name' => 'iPad Pro 11" M2', 'brand' => 'Apple'],
            ['name' => 'iPad Air 5', 'brand' => 'Apple'],
            ['name' => 'iPad 10', 'brand' => 'Apple'],
            ['name' => 'AirPods Pro 2', 'brand' => 'Apple'],
            ['name' => 'AirPods Max', 'brand' => 'Apple'],
            ['name' => 'AirPods 3', 'brand' => 'Apple'],
            ['name' => 'AirPods 2', 'brand' => 'Apple'],
            
            // Samsung products
            ['name' => 'Samsung Galaxy S24 Ultra', 'brand' => 'Samsung'],
            ['name' => 'Samsung Galaxy S24+', 'brand' => 'Samsung'],
            ['name' => 'Samsung Galaxy S24', 'brand' => 'Samsung'],
            ['name' => 'Samsung Galaxy Tab S9 Ultra', 'brand' => 'Samsung'],
            ['name' => 'Samsung Galaxy Tab S9+', 'brand' => 'Samsung'],
            ['name' => 'Samsung Galaxy Tab S9', 'brand' => 'Samsung'],
            ['name' => 'Samsung Galaxy Buds2 Pro', 'brand' => 'Samsung'],
            ['name' => 'Samsung Galaxy Buds2', 'brand' => 'Samsung'],
            ['name' => 'Samsung Galaxy Buds Live', 'brand' => 'Samsung'],
            ['name' => 'Samsung 990 Pro 2TB', 'brand' => 'Samsung'],
            ['name' => 'Samsung 980 Pro 1TB', 'brand' => 'Samsung'],
            ['name' => 'Samsung 870 EVO 4TB', 'brand' => 'Samsung'],
            
            // Google products
            ['name' => 'Google Pixel 8 Pro', 'brand' => 'Google'],
            ['name' => 'Google Pixel 8', 'brand' => 'Google'],
            ['name' => 'Google Pixel 7 Pro', 'brand' => 'Google'],
            
            // ASUS products
            ['name' => 'ASUS ROG Phone 8', 'brand' => 'ASUS'],
            ['name' => 'ASUS Zenfone 10', 'brand' => 'ASUS'],
            ['name' => 'ASUS ROG Strix G16', 'brand' => 'ASUS'],
            ['name' => 'ASUS TUF Gaming F15', 'brand' => 'ASUS'],
            ['name' => 'ASUS ZenBook Pro 14', 'brand' => 'ASUS'],
            ['name' => 'ASUS Vivobook Pro 15', 'brand' => 'ASUS'],
            ['name' => 'ASUS ExpertBook B1', 'brand' => 'ASUS'],
            ['name' => 'ASUS Chromebook Flip', 'brand' => 'ASUS'],
            
            // OnePlus products
            ['name' => 'OnePlus 12', 'brand' => 'OnePlus'],
            ['name' => 'OnePlus 11', 'brand' => 'OnePlus'],
            
            // Xiaomi products
            ['name' => 'Xiaomi 14 Ultra', 'brand' => 'Xiaomi'],
            ['name' => 'Xiaomi 13 Pro', 'brand' => 'Xiaomi'],
            ['name' => 'Xiaomi 12T Pro', 'brand' => 'Xiaomi'],
            
            // Dell products
            ['name' => 'Dell XPS 15', 'brand' => 'Dell'],
            ['name' => 'Dell XPS 13', 'brand' => 'Dell'],
            ['name' => 'Dell Alienware m16', 'brand' => 'Dell'],
            ['name' => 'Dell Inspiron 16', 'brand' => 'Dell'],
            
            // HP products
            ['name' => 'HP Spectre x360', 'brand' => 'HP'],
            ['name' => 'HP Omen 16', 'brand' => 'HP'],
            ['name' => 'HP Pavilion 15', 'brand' => 'HP'],
            ['name' => 'HP EliteBook 860', 'brand' => 'HP'],
            
            // Lenovo products
            ['name' => 'Lenovo ThinkPad X1 Carbon', 'brand' => 'Lenovo'],
            ['name' => 'Lenovo ThinkPad X1 Yoga', 'brand' => 'Lenovo'],
            ['name' => 'Lenovo Legion 9i', 'brand' => 'Lenovo'],
            ['name' => 'Lenovo IdeaPad Gaming 3', 'brand' => 'Lenovo'],
            ['name' => 'Lenovo Yoga 9i', 'brand' => 'Lenovo'],
            ['name' => 'Lenovo ThinkPad T14', 'brand' => 'Lenovo'],
            
            // Sony products
            ['name' => 'Sony WH-1000XM5', 'brand' => 'Sony'],
            ['name' => 'Sony WF-1000XM5', 'brand' => 'Sony'],
            ['name' => 'Sony LinkBuds S', 'brand' => 'Sony'],
            ['name' => 'Sony WH-CH720N', 'brand' => 'Sony'],
            
            // Bose products
            ['name' => 'Bose QuietComfort Ultra', 'brand' => 'Bose'],
            ['name' => 'Bose QuietComfort Earbuds II', 'brand' => 'Bose'],
            ['name' => 'Bose Sport Earbuds', 'brand' => 'Bose'],
            
            // JBL products
            ['name' => 'JBL Tour One M2', 'brand' => 'JBL'],
            ['name' => 'JBL Tune Buds2', 'brand' => 'JBL'],
            ['name' => 'JBL Wave 200TWS', 'brand' => 'JBL'],
            ['name' => 'JBL Endurance Peak 3', 'brand' => 'JBL'],
            
            // Logitech products
            ['name' => 'Logitech MX Master 3S', 'brand' => 'Logitech'],
            ['name' => 'Logitech MX Keys Mini', 'brand' => 'Logitech'],
            ['name' => 'Logitech G Pro X Superlight', 'brand' => 'Logitech'],
            ['name' => 'Logitech G915 TKL', 'brand' => 'Logitech'],
            ['name' => 'Logitech MX Ergo', 'brand' => 'Logitech'],
            ['name' => 'Logitech MX Vertical', 'brand' => 'Logitech'],
            
            // Razer products
            ['name' => 'Razer DeathAdder V3 Pro', 'brand' => 'Razer'],
            ['name' => 'Razer BlackWidow V4 Pro', 'brand' => 'Razer'],
            ['name' => 'Razer Basilisk V3', 'brand' => 'Razer'],
            ['name' => 'Razer Huntsman Mini', 'brand' => 'Razer'],
            ['name' => 'Razer Viper Ultimate', 'brand' => 'Razer'],
            ['name' => 'Razer Orochi V2', 'brand' => 'Razer'],
            
            // Keychron products
            ['name' => 'Keychron K2 Pro', 'brand' => 'Keychron'],
            ['name' => 'Keychron Q1 Pro', 'brand' => 'Keychron'],
            ['name' => 'Keychron K8 Pro', 'brand' => 'Keychron'],
            ['name' => 'Keychron V3', 'brand' => 'Keychron'],
            
            // Corsair products
            ['name' => 'Corsair K95 RGB Platinum', 'brand' => 'Corsair'],
            ['name' => 'Corsair K70 RGB MK.2', 'brand' => 'Corsair'],
            ['name' => 'Corsair K60 RGB Pro', 'brand' => 'Corsair'],
            
            // WD products
            ['name' => 'WD Black SN850X 2TB', 'brand' => 'WD'],
            ['name' => 'WD Black SN770 1TB', 'brand' => 'WD'],
            ['name' => 'WD Blue SN570 2TB', 'brand' => 'WD'],
            
            // Crucial products
            ['name' => 'Crucial T700 2TB', 'brand' => 'Crucial'],
            ['name' => 'Crucial P5 Plus 2TB', 'brand' => 'Crucial'],
            ['name' => 'Crucial MX500 2TB', 'brand' => 'Crucial'],
            
            // Kingston products
            ['name' => 'Kingston KC3000 2TB', 'brand' => 'Kingston'],
            ['name' => 'Kingston NV2 2TB', 'brand' => 'Kingston'],
            ['name' => 'Kingston A400 2TB', 'brand' => 'Kingston'],
            
            // Seagate products
            ['name' => 'Seagate FireCuda 530 2TB', 'brand' => 'Seagate'],
            ['name' => 'Seagate Barracuda 4TB', 'brand' => 'Seagate'],
            ['name' => 'Seagate IronWolf 8TB', 'brand' => 'Seagate'],
            
            // SanDisk products
            ['name' => 'SanDisk Extreme Pro 2TB', 'brand' => 'SanDisk'],
            ['name' => 'SanDisk Extreme 2TB', 'brand' => 'SanDisk'],
            ['name' => 'SanDisk Ultra 2TB', 'brand' => 'SanDisk'],
            
            // NVIDIA products
            ['name' => 'NVIDIA RTX 4090', 'brand' => 'NVIDIA'],
            ['name' => 'NVIDIA RTX 4080 Super', 'brand' => 'NVIDIA'],
            ['name' => 'NVIDIA RTX 4070 Ti Super', 'brand' => 'NVIDIA'],
            ['name' => 'NVIDIA RTX 4070 Super', 'brand' => 'NVIDIA'],
            ['name' => 'NVIDIA RTX 4060 Ti', 'brand' => 'NVIDIA'],
            ['name' => 'NVIDIA RTX 4060', 'brand' => 'NVIDIA'],
            
            // AMD products
            ['name' => 'AMD Radeon RX 7900 XTX', 'brand' => 'AMD'],
            ['name' => 'AMD Radeon RX 7900 XT', 'brand' => 'AMD'],
            ['name' => 'AMD Radeon RX 7800 XT', 'brand' => 'AMD'],
            ['name' => 'AMD Radeon RX 7700 XT', 'brand' => 'AMD'],
            ['name' => 'AMD Radeon RX 7600', 'brand' => 'AMD'],
            ['name' => 'AMD Radeon RX 6750 XT', 'brand' => 'AMD'],
            
            // Intel products
            ['name' => 'Intel Core i9-14900K', 'brand' => 'Intel'],
            ['name' => 'Intel Core i7-14700K', 'brand' => 'Intel'],
            ['name' => 'Intel Core i5-14600K', 'brand' => 'Intel'],
            ['name' => 'Intel Core i9-13900K', 'brand' => 'Intel'],
            ['name' => 'Intel Core i7-13700K', 'brand' => 'Intel'],
            ['name' => 'Intel Core i5-13600K', 'brand' => 'Intel'],
            
            // AMD CPU products
            ['name' => 'AMD Ryzen 9 7950X3D', 'brand' => 'AMD'],
            ['name' => 'AMD Ryzen 9 7950X', 'brand' => 'AMD'],
            ['name' => 'AMD Ryzen 9 7900X3D', 'brand' => 'AMD'],
            ['name' => 'AMD Ryzen 9 7900X', 'brand' => 'AMD'],
            ['name' => 'AMD Ryzen 7 7800X3D', 'brand' => 'AMD'],
            ['name' => 'AMD Ryzen 7 7700X', 'brand' => 'AMD'],
            
            // RAM products
            ['name' => 'G.Skill Trident Z5 RGB 32GB', 'brand' => 'G.Skill'],
            ['name' => 'G.Skill Ripjaws V 32GB', 'brand' => 'G.Skill'],
            ['name' => 'Corsair Vengeance 32GB', 'brand' => 'Corsair'],
            ['name' => 'Kingston Fury Beast 32GB', 'brand' => 'Kingston'],
            ['name' => 'Crucial Ballistix 32GB', 'brand' => 'Crucial'],
            ['name' => 'Samsung DDR5 32GB', 'brand' => 'Samsung'],
        ];

        $product = $this->faker->randomElement($techProducts);
        $productName = $product['name'];
        $brand = $product['brand'];

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
            'image_path' => null, // Correct column name from migration
            'category_id' => $category ? $category->id : null,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
