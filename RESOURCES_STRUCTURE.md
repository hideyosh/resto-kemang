# Resources Structure Documentation

## Folder Organization

```
resources/
├── css/
│   ├── app.css (Main entry point)
│   └── components/
│       ├── navbar.css (Navbar styles)
│       ├── menu.css (Menu page styles)
│       └── utilities.css (Reusable utility styles)
├── js/
│   ├── app.js (Main entry point)
│   ├── bootstrap.js (Axios configuration)
│   └── modules/
│       ├── navbar.js (Navbar functionality)
│       ├── menu.js (Menu page logic)
│       ├── order.js (Order checkout logic)
│       └── reservation.js (Reservation form logic)
└── views/
    ├── layouts/
    │   └── app.blade.php (Main layout)
    ├── components/
    │   ├── navbar.blade.php (Navbar component)
    │   └── footer.blade.php (Footer component)
    ├── menu/
    │   └── index.blade.php (Menu page)
    ├── order/
    │   └── create.blade.php (Order checkout)
    ├── reservation/
    │   └── create.blade.php (Reservation form)
    └── welcome.blade.php (Homepage)
```

## JavaScript Modules

### navbar.js
- `initNavbar()`: Initialize mobile menu toggle

### menu.js
- `initMenu()`: Initialize menu page
- `setupFilterButtons()`: Filter menu by category
- `addToCart()`: Add item to cart
- `renderCart()`: Render cart items
- `removeFromCart()`: Remove item from cart
- `incrementQuantity()`: Increase quantity
- `decrementQuantity()`: Decrease quantity

### order.js
- `initOrder()`: Initialize order page
- `loadOrderSummary()`: Load cart items to summary
- `handleOrderSubmit()`: Process order submission

### reservation.js
- `initReservation()`: Initialize reservation page
- `handleReservationSubmit()`: Process reservation submission

## CSS Components

### navbar.css
Navbar styling and responsive mobile menu

### menu.css
Menu items grid, filter buttons, and cart sidebar

### utilities.css
Reusable utility classes for buttons, forms, cards, and badges

## Best Practices

1. **Modular JavaScript**: Each page has its own module in `resources/js/modules/`
2. **Component-based CSS**: Styles organized by component in `resources/css/components/`
3. **Separation of Concerns**: HTML structure is clean without inline JavaScript
4. **Local Storage**: Cart data persisted using browser localStorage
5. **Auto-initialization**: Page functionality initializes based on current URL path

## Adding New Features

1. Create new module file in `resources/js/modules/`
2. Import and call it in `resources/js/app.js`
3. Create corresponding CSS in `resources/css/components/`
4. Update blade template to use the new functionality
