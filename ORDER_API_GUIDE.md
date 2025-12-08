# Order dan Reservation API - Troubleshooting Guide

## Issue: "Order Failed - An error occurred while placing your order"

### Root Cause
API endpoint `/api/orders` harus di-route dengan CSRF middleware support karena request berasal dari web form, bukan stateless API.

### Solutions Applied

1. **Move Routes to Web Routes**
   - Orders: `POST /api/orders` → di-route melalui web routes dengan CSRF
   - Reservations: `POST /api/reservations` → di-route melalui web routes dengan CSRF

2. **Enhanced Error Handling**
   - Try-catch block di OrderController
   - Detailed error logging
   - Proper JSON response even on errors
   - Client-side error parsing yang lebih robust

3. **Request Headers**
   - Added `'Accept': 'application/json'` header
   - CSRF token properly extracted dari DOM
   - Content-Type set to application/json

## Testing Order Flow

### Step 1: Add Items to Cart
1. Buka `/menu`
2. Click "Add to Cart" pada beberapa items
3. Cart akan tersimpan di localStorage

### Step 2: Go to Checkout
1. Click "Checkout" button di cart sidebar
2. Atau akses langsung `/order/create`

### Step 3: Fill Form & Submit
1. Isi Full Name, Email, Phone
2. Click "Place Order"
3. Success message muncul → order tersimpan di database

### Step 4: Verify Order
```sql
SELECT o.*,
       JSON_ARRAYAGG(JSON_OBJECT('name', mi.name, 'qty', oi.quantity)) as items
FROM orders o
LEFT JOIN order_items oi ON o.id = oi.order_id
LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id
WHERE o.customer_email = 'your@email.com'
GROUP BY o.id
ORDER BY o.created_at DESC;
```

## API Endpoints

### Web Routes (CSRF Protected)
```
POST /api/orders        # Create order (dari web form)
POST /api/reservations  # Create reservation (dari web form)
```

### API Routes (Stateless)
```
GET  /api/menu          # List all menu items
POST /api/menu          # Create menu via API
GET  /api/menu/{id}     # Get menu detail
PUT  /api/menu/{id}     # Update menu
DELETE /api/menu/{id}   # Delete menu
```

## Debugging Tips

### 1. Check Browser Console (F12)
```javascript
// Network tab → Filter "orders"
// Look for POST /api/orders request
// Check Response tab for error details
```

### 2. Check Server Logs
```bash
# Tail Laravel log
Get-Content storage/logs/laravel.log -Tail 50
```

### 3. Check Database
```sql
-- Check if order was created
SELECT * FROM orders ORDER BY created_at DESC LIMIT 5;

-- Check order items
SELECT o.id, oi.menu_item_id, oi.quantity, oi.price
FROM order_items oi
JOIN orders o ON oi.order_id = o.id
ORDER BY o.created_at DESC LIMIT 10;
```

## Common Errors & Solutions

### Error: "CSRF token mismatch"
- Solution: Ensure CSRF token is in form via `@csrf`
- Check: `<input name="_token" value="{{ csrf_token() }}">` in form

### Error: "Invalid JSON response"
- Solution: API must return JSON, not HTML
- Check: Response header `Content-Type: application/json`
- Verify: No HTML output before JSON response

### Error: "Connection refused"
- Solution: Laravel server not running
- Fix: `php artisan serve` in separate terminal

### Error: "Vite manifest not found"
- Solution: Vite dev server not running
- Fix: `npm run dev` in separate terminal

## Success Indicators

✅ Order successfully created when:
1. Success alert appears
2. Order appears in database
3. `orders` table has new record
4. `order_items` table has corresponding items
5. Customer can see order history
