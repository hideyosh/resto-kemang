# Database Relationships Documentation

## Entity Relationship Diagram (ERD)

```
users
├── id (PK)
├── name
├── email
├── password
└── timestamps
    ├─── orders (1:N)
    └─── table_reservations (1:N)

menu_items
├── id (PK)
├── name
├── description
├── category
├── price
├── image
├── is_available
└── timestamps
    └─── order_items (1:N)

orders
├── id (PK)
├── customer_name
├── customer_email
├── customer_phone
├── items (JSON)
├── total_price
├── status
├── payment_status
├── notes
├── user_id (FK)
└── timestamps
    ├─── user (N:1)
    ├─── order_items (1:N)
    └─── menu_items (N:N through order_items)

order_items (Pivot Table)
├── id (PK)
├── order_id (FK)
├── menu_item_id (FK)
├── quantity
├── price
└── timestamps

table_reservations
├── id (PK)
├── customer_name
├── customer_email
├── customer_phone
├── number_of_guests
├── reservation_date
├── status
├── notes
├── user_id (FK)
└── timestamps
    └─── user (N:1)
```

## Model Relationships

### User Model
```php
// One-to-Many: User -> Orders
public function orders()
{
    return $this->hasMany(Order::class);
}

// One-to-Many: User -> TableReservations
public function reservations()
{
    return $this->hasMany(TableReservation::class);
}
```

### MenuItem Model
```php
// One-to-Many: MenuItem -> OrderItems
public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'menu_item_id');
}
```

### Order Model
```php
// Many-to-One: Order -> User
public function user()
{
    return $this->belongsTo(User::class);
}

// One-to-Many: Order -> OrderItems
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

// Many-to-Many: Order <-> MenuItem (through OrderItems)
public function menuItems()
{
    return $this->belongsToMany(MenuItem::class, 'order_items')
        ->withPivot('quantity', 'price')
        ->withTimestamps();
}
```

### OrderItem Model
```php
// Many-to-One: OrderItem -> Order
public function order()
{
    return $this->belongsTo(Order::class);
}

// Many-to-One: OrderItem -> MenuItem
public function menuItem()
{
    return $this->belongsTo(MenuItem::class);
}
```

### TableReservation Model
```php
// Many-to-One: TableReservation -> User
public function user()
{
    return $this->belongsTo(User::class);
}
```

## Usage Examples

### Creating an Order with Items
```php
// Create order
$order = Order::create([
    'customer_name' => 'John Doe',
    'customer_email' => 'john@example.com',
    'customer_phone' => '08123456789',
    'total_price' => 150000,
    'status' => 'pending',
    'user_id' => auth()->id(),
]);

// Create order items
$order->orderItems()->create([
    'menu_item_id' => 1,
    'quantity' => 2,
    'price' => 50000,
]);
```

### Retrieving Order with Items
```php
// Get order with all menu items
$order = Order::with('orderItems.menuItem')->find($id);

// Iterate through menu items
foreach ($order->menuItems as $item) {
    echo $item->name . ' x' . $item->pivot->quantity;
}
```

### Get User's Orders
```php
$user = User::with('orders.orderItems.menuItem')->find($id);

foreach ($user->orders as $order) {
    echo $order->total_price;
}
```

### Create Menu Item
```php
$menu = MenuItem::create([
    'name' => 'Spicy Tuna Roll',
    'description' => 'Fresh tuna with spicy mayo',
    'category' => 'sushi',
    'price' => 55000,
    'image' => 'spicy-tuna-roll.jpg',
    'is_available' => true,
]);
```

## API Endpoints

### Menu Management
- `GET /menu` - List all menus
- `GET /menu/create` - Show create form
- `POST /menu` - Create menu (multipart/form-data with image)
- `GET /menu/{id}` - Get menu detail
- `PUT /menu/{id}` - Update menu
- `DELETE /menu/{id}` - Delete menu

### API Endpoints
- `POST /api/menu` - Create menu (JSON)
- `GET /api/menu` - List menus
- `GET /api/menu/{id}` - Get menu
- `PUT /api/menu/{id}` - Update menu
- `DELETE /api/menu/{id}` - Delete menu

## Features Implemented

✅ **Table Relationships**
- User → Orders (1:N)
- User → TableReservations (1:N)
- Order → OrderItems (1:N)
- MenuItem → OrderItems (1:N)
- Order ↔ MenuItem (N:N through OrderItems)

✅ **Menu Management**
- Create menu with image upload
- Form validation with error messages
- Store to database automatically
- Image handling in `/public/img/`

✅ **Order Enhancement**
- Store items in order_items table with quantity and price
- Link orders to menu items through pivot table
- Link orders to users

✅ **Database Integrity**
- Foreign key constraints with cascading delete
- Proper data normalization
- Transaction support for order creation
