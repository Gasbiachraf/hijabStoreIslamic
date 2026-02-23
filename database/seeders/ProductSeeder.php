<?php

namespace Database\Seeders;

use App\Models\arrivalproduct;
use App\Models\Category;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Variant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Category
        $category = Category::create([
            'name' => 'Hijabs'
        ]);

        // Create Subcategory
        $subcategory = Subcategory::create([
            'name' => 'Cotton Hijabs',
            'category_id' => $category->id
        ]);

        // Create Product with multi-language support
        $product = Product::create([
            'name' => [
                'en' => 'Premium Cotton Hijab - Classic Collection',
                'fr' => 'Hijab Coton Premium - Collection Classique',
                'ar' => 'حجاب قطني ممتاز - مجموعة كلاسيكية'
            ],
            'subcategory_id' => $subcategory->id,
            'description' => [
                'en' => 'Beautiful premium cotton hijab with soft texture and comfortable fit. Perfect for everyday wear. Available in multiple colors and sizes.',
                'fr' => 'Magnifique hijab en coton premium avec une texture douce et un ajustement confortable. Parfait pour un usage quotidien. Disponible en plusieurs couleurs et tailles.',
                'ar' => 'حجاب قطني ممتاز جميل بملمس ناعم وملاءمة مريحة. مثالي للارتداء اليومي. متوفر بألوان وأحجام متعددة.'
            ]
        ]);

        // Create Inventory
        $inventory = Inventory::create([
            'product_id' => $product->id,
            'prePrice' => 1500, // Purchase price in cents or base currency unit
            'postPrice' => 2500, // Sale price
            'exPrice' => 3000, // Old price (for showing discount)
            'type' => [
                'en' => 'Premium Quality',
                'fr' => 'Qualité Premium',
                'ar' => 'جودة ممتازة'
            ]
        ]);

        // Create Variants (Colors)
        $colors = ['#000000', '#FFFFFF', '#8B4513', '#FF6347']; // Black, White, Brown, Tomato Red
        $colorNames = ['Black', 'White', 'Brown', 'Coral Red'];
        
        foreach ($colors as $index => $color) {
            $variant = Variant::create([
                'inventory_id' => $inventory->id,
                'color' => $color
            ]);

            // Create Images for variant (using placeholder paths - you'll need actual images)
            // Note: In production, you'd want to copy actual image files to storage/images/
            $imageName = 'hijab_' . strtolower(str_replace(' ', '_', $colorNames[$index])) . '_' . time() . '.jpg';
            Image::create([
                'path' => $imageName,
                'imageable_id' => $variant->id,
                'imageable_type' => Variant::class
            ]);

            // Create Sizes with quantities
            $sizes = ['XS', 'S', 'M', 'L', 'XL'];
            $quantities = [10, 15, 20, 18, 12]; // Different quantities per size
            
            foreach ($sizes as $sizeIndex => $size) {
                $sizeRecord = Size::create([
                    'variant_id' => $variant->id,
                    'size' => $size,
                    'quantity' => $quantities[$sizeIndex]
                ]);

                // Create arrival product record
                arrivalproduct::create([
                    'arrivalDate' => $sizeRecord->created_at,
                    'size_id' => $sizeRecord->id,
                    'quantity' => $quantities[$sizeIndex]
                ]);
            }
        }

        // Create a second product for more testing
        $product2 = Product::create([
            'name' => [
                'en' => 'Silk Hijab - Elegant Collection',
                'fr' => 'Hijab Soie - Collection Élégante',
                'ar' => 'حجاب حريري - مجموعة أنيقة'
            ],
            'subcategory_id' => $subcategory->id,
            'description' => [
                'en' => 'Luxurious silk hijab with elegant drape and premium finish. Perfect for special occasions.',
                'fr' => 'Hijab en soie luxueux avec un drapé élégant et une finition premium. Parfait pour les occasions spéciales.',
                'ar' => 'حجاب حريري فاخر بتدلي أنيق وإنهاء ممتاز. مثالي للمناسبات الخاصة.'
            ]
        ]);

        $inventory2 = Inventory::create([
            'product_id' => $product2->id,
            'prePrice' => 2500,
            'postPrice' => 4000,
            'exPrice' => 5000,
            'type' => [
                'en' => 'Luxury',
                'fr' => 'Luxe',
                'ar' => 'فاخر'
            ]
        ]);

        // Create variants for second product
        $colors2 = ['#4B0082', '#FF1493', '#00CED1']; // Indigo, Deep Pink, Dark Turquoise
        $colorNames2 = ['Indigo', 'Pink', 'Turquoise'];
        
        foreach ($colors2 as $index => $color) {
            $variant2 = Variant::create([
                'inventory_id' => $inventory2->id,
                'color' => $color
            ]);

            $imageName2 = 'silk_hijab_' . strtolower(str_replace(' ', '_', $colorNames2[$index])) . '_' . time() . '.jpg';
            Image::create([
                'path' => $imageName2,
                'imageable_id' => $variant2->id,
                'imageable_type' => Variant::class
            ]);

            // Create sizes
            $sizes2 = ['S', 'M', 'L', 'XL'];
            $quantities2 = [8, 12, 10, 6];
            
            foreach ($sizes2 as $sizeIndex => $size) {
                $sizeRecord2 = Size::create([
                    'variant_id' => $variant2->id,
                    'size' => $size,
                    'quantity' => $quantities2[$sizeIndex]
                ]);

                arrivalproduct::create([
                    'arrivalDate' => $sizeRecord2->created_at,
                    'size_id' => $sizeRecord2->id,
                    'quantity' => $quantities2[$sizeIndex]
                ]);
            }
        }

        $this->command->info('Products seeded successfully!');
        $this->command->info('Created 2 products with variants, sizes, and images.');
    }
}
