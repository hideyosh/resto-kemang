<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        MenuItem::create([
            'name' => 'Classic Sushi Roll',
            'description' => 'Fresh sushi roll with salmon and cucumber',
            'category' => 'sushi',
            'price' => 50000,
            'image' => 'sushi.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Tuna Roll',
            'description' => 'Premium tuna sushi roll',
            'category' => 'sushi',
            'price' => 55000,
            'image' => 'uramaki.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Inarizushi',
            'description' => 'Sweet fried tofu wrapper sushi',
            'category' => 'sushi',
            'price' => 45000,
            'image' => 'inarizushi.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Chirashi Bowl',
            'description' => 'Mixed sushi rice bowl with toppings',
            'category' => 'sushi',
            'price' => 65000,
            'image' => 'Chirashi.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Tonkotsu Ramen',
            'description' => 'Rich pork broth ramen with tender chashu',
            'category' => 'ramen',
            'price' => 60000,
            'image' => 'ramen.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Seafood Ramen',
            'description' => 'Delicious seafood broth ramen',
            'category' => 'ramen',
            'price' => 65000,
            'image' => 'seafoodramen.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Miso Ramen',
            'description' => 'Traditional miso flavored ramen',
            'category' => 'ramen',
            'price' => 58000,
            'image' => 'misoramen.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Ebi Ramen',
            'description' => 'Shrimp broth ramen with fresh ebi',
            'category' => 'ramen',
            'price' => 62000,
            'image' => 'ebiramen.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Chicken Ramen Done',
            'description' => 'Creamy chicken ramen with soft egg',
            'category' => 'ramen',
            'price' => 59000,
            'image' => 'cikenramendone.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Seafood Ramen Special',
            'description' => 'Premium seafood with rich broth',
            'category' => 'ramen',
            'price' => 68000,
            'image' => 'sifudramen.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Premium Wagyu A5',
            'description' => 'Japanese A5 Wagyu beef premium cut',
            'category' => 'wagyu',
            'price' => 150000,
            'image' => 'wagyu.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Wagyu Yakiniku Donburi',
            'description' => 'Deluxe Wagyu with caviar on rice bowl',
            'category' => 'wagyu',
            'price' => 140000,
            'image' => 'Deluxe-Wagyu-Yakiniku-Donburi-with-Cavier-1-scaled.webp',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Wagyu Steak',
            'description' => 'Grilled premium wagyu wagyu1',
            'category' => 'wagyu',
            'price' => 120000,
            'image' => 'wagyu1.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Wagyu Slice Set',
            'description' => 'Wagyu sliced thin and perfectly grilled',
            'category' => 'wagyu',
            'price' => 125000,
            'image' => 'wagyu (1).jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Premium Wagyu Set',
            'description' => 'Assorted premium wagyu cuts',
            'category' => 'wagyu',
            'price' => 130000,
            'image' => 'wagyu (2).jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Wagyu Selection',
            'description' => 'Finest wagyu selection platter',
            'category' => 'wagyu',
            'price' => 135000,
            'image' => 'wagyu (3).jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Donburi Bowl',
            'description' => 'Rice bowl with premium toppings',
            'category' => 'wagyu',
            'price' => 75000,
            'image' => 'donburi.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Ebi Donburi',
            'description' => 'Shrimp rice bowl with egg',
            'category' => 'wagyu',
            'price' => 72000,
            'image' => 'ebidone.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Curry Katsu Don',
            'description' => 'Crispy katsu with curry sauce on rice',
            'category' => 'wagyu',
            'price' => 68000,
            'image' => 'currykatsudone.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Karaage',
            'description' => 'Japanese fried chicken karaage',
            'category' => 'wagyu',
            'price' => 55000,
            'image' => 'karaage.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Gyoza',
            'description' => 'Pan-fried dumplings',
            'category' => 'wagyu',
            'price' => 45000,
            'image' => 'gyoza.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Potato Korokke',
            'description' => 'Crispy potato croquettes',
            'category' => 'wagyu',
            'price' => 35000,
            'image' => 'potato-korokke.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Beef Curry',
            'description' => 'Rich Japanese curry with beef',
            'category' => 'wagyu',
            'price' => 70000,
            'image' => 'beefcurry.jpeg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Spicy Curry Roka',
            'description' => 'Spicy curry speciality',
            'category' => 'wagyu',
            'price' => 75000,
            'image' => 'spicy-curry-roka.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Curry Katsu',
            'description' => 'Crispy katsu with curry sauce',
            'category' => 'wagyu',
            'price' => 65000,
            'image' => 'currykatsu.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Sushi Donburi',
            'description' => 'Premium sushi rice bowl',
            'category' => 'sushi',
            'price' => 85000,
            'image' => 'sushidone.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Nasi Putih',
            'description' => 'Plain white steamed rice',
            'category' => 'sushi',
            'price' => 10000,
            'image' => 'nasiputih.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Nasi Putih with Sauce',
            'description' => 'White rice with sauce',
            'category' => 'sushi',
            'price' => 15000,
            'image' => 'nasipuithdone.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Iced Tea',
            'description' => 'Refreshing iced tea',
            'category' => 'drinks',
            'price' => 15000,
            'image' => 'uurocha.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Matcha Latte',
            'description' => 'Traditional Japanese matcha latte',
            'category' => 'drinks',
            'price' => 25000,
            'image' => 'ocha.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Genmaicha',
            'description' => 'Green tea with roasted rice',
            'category' => 'drinks',
            'price' => 20000,
            'image' => 'genmaicha.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Royal Milk Tea',
            'description' => 'Premium royal milk tea',
            'category' => 'drinks',
            'price' => 28000,
            'image' => 'Royal-Milk-Tea.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Aqua',
            'description' => 'Fresh water',
            'category' => 'drinks',
            'price' => 8000,
            'image' => 'aqua3.jpeg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Sashimi Platter',
            'description' => 'Assorted fresh sashimi',
            'category' => 'sushi',
            'price' => 95000,
            'image' => 'sashimi.jpeg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Maki Roll',
            'description' => 'Traditional maki roll',
            'category' => 'sushi',
            'price' => 48000,
            'image' => 'maki.webp',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Yakisoba',
            'description' => 'Stir-fried noodles with vegetables',
            'category' => 'ramen',
            'price' => 52000,
            'image' => 'yakisoba-receita.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Udon',
            'description' => 'Thick noodle soup',
            'category' => 'ramen',
            'price' => 50000,
            'image' => 'udon.jpeg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Soba',
            'description' => 'Buckwheat noodle soup',
            'category' => 'ramen',
            'price' => 48000,
            'image' => 'soba.jpeg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Omlet',
            'description' => 'Japanese style omelet',
            'category' => 'wagyu',
            'price' => 40000,
            'image' => 'omlet.jpg',
            'is_available' => true,
        ]);

        MenuItem::create([
            'name' => 'Chanko Nabe',
            'description' => 'Sumo wrestler stew',
            'category' => 'wagyu',
            'price' => 80000,
            'image' => 'Chanko-Nabe-Recipe.jpeg.jpg',
            'is_available' => true,
        ]);
    }
}
