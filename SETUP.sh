#!/bin/bash

# Script Setup Resto Kemang Laravel Application
# Run this to setup the complete Laravel application

echo "=== Setting Up Resto Kemang Laravel Application ==="

# 1. Navigate to project directory
cd resto-kemang-laravel

# 2. Install dependencies (already done)
echo "✓ Dependencies already installed"

# 3. Update Migrations - Run migrations
echo "Running database migrations..."
php artisan migrate --force

# 4. Create menu items from seeder
echo "Creating initial menu data..."
php artisan tinker << 'EOF'
use App\Models\MenuItem;

$menus = [
    ['name' => 'Classic Sushi Roll', 'category' => 'sushi', 'price' => 50000, 'description' => 'Fresh sushi roll with salmon and cucumber', 'image' => 'sushi.jpg'],
    ['name' => 'Tuna Roll', 'category' => 'sushi', 'price' => 55000, 'description' => 'Premium tuna sushi roll', 'image' => 'sushi.jpg'],
    ['name' => 'Tonkotsu Ramen', 'category' => 'ramen', 'price' => 60000, 'description' => 'Rich pork broth ramen with tender chashu', 'image' => null],
    ['name' => 'Seafood Ramen', 'category' => 'ramen', 'price' => 65000, 'description' => 'Delicious seafood broth ramen', 'image' => 'seafoodramen.avif'],
    ['name' => 'Premium Wagyu A5', 'category' => 'wagyu', 'price' => 150000, 'description' => 'Japanese A5 Wagyu beef', 'image' => null],
    ['name' => 'Wagyu Steak', 'category' => 'wagyu', 'price' => 120000, 'description' => 'Grilled premium wagyu', 'image' => null],
    ['name' => 'Iced Tea', 'category' => 'drinks', 'price' => 15000, 'description' => 'Refreshing iced tea', 'image' => null],
    ['name' => 'Matcha Latte', 'category' => 'drinks', 'price' => 25000, 'description' => 'Traditional Japanese matcha latte', 'image' => null],
];

foreach ($menus as $menu) {
    MenuItem::create($menu);
}

echo "Menu items created successfully!";
EOF

echo "✓ Setup complete!"
echo ""
echo "=== To start the server, run: ==="
echo "php artisan serve"
echo ""
echo "=== Server will be available at: ==="
echo "http://localhost:8000"
