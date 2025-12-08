# Authentication System Documentation

## Overview
The Resto Kemang application now includes a complete user authentication system with login, register, and logout functionality. All orders and reservations are automatically linked to authenticated users.

## Features

### 1. User Registration
- New users can create an account at `/register`
- Fields required:
  - Full Name
  - Email Address (must be unique)
  - Password (minimum 8 characters)
  - Password Confirmation
- Passwords are hashed using bcrypt for security
- New users are automatically logged in after registration

### 2. User Login
- Users can log in at `/login` with their email and password
- "Remember me" option for persistent sessions
- Session is regenerated on login for security

### 3. User Logout
- Users can log out via the user menu in the navbar
- Session is invalidated and regenerated after logout

### 4. Protected Routes
The following routes now require authentication:
- `POST /api/orders` - Create new orders
- `POST /api/reservations` - Create table reservations

Users attempting to access these routes without logging in will receive a 401 error.

## Database Schema

### Users Table
```
- id (Primary Key)
- name (string)
- email (string, unique)
- password (string, hashed)
- email_verified_at (timestamp, nullable)
- remember_token (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### Related Tables with Foreign Keys
- `orders.user_id` → `users.id`
- `table_reservations.user_id` → `users.id`

## Controllers

### AuthController
Located at: `app/Http/Controllers/AuthController.php`

**Methods:**
- `showLogin()` - Display login form
- `showRegister()` - Display registration form
- `login(Request $request)` - Handle login form submission
- `register(Request $request)` - Handle registration form submission
- `logout(Request $request)` - Handle logout
- `user()` - API endpoint to get current user (JSON response)
- `check()` - API endpoint to check authentication status (JSON response)

## Views

### Login View
- File: `resources/views/auth/login.blade.php`
- Displays email and password fields
- Link to registration page
- Responsive design with Tailwind CSS

### Register View
- File: `resources/views/auth/register.blade.php`
- Displays name, email, password, and password confirmation fields
- Link to login page
- Responsive design with Tailwind CSS

## Navbar Integration

The navbar component (`resources/components/navbar.blade.php`) has been updated to:

### When User is Logged In
- Display user's name with profile icon
- Dropdown menu showing email and logout button
- Mobile-friendly logout option

### When User is NOT Logged In
- Display "LOGIN" and "REGISTER" buttons
- Mobile-friendly layout with separate buttons

## Routes

All authentication routes are defined in `routes/web.php`:

```php
// Display forms
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Handle form submissions
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// API endpoints
Route::get('/api/user', [AuthController::class, 'user'])->middleware('auth');
Route::get('/api/auth/check', [AuthController::class, 'check']);
```

## Security Features

1. **Password Hashing** - All passwords are hashed with bcrypt
2. **CSRF Protection** - All forms include CSRF token validation
3. **Session Regeneration** - Session ID is regenerated on login/logout
4. **Email Uniqueness** - Duplicate emails are prevented at database level
5. **Protected Routes** - Sensitive operations require authentication
6. **Remember Me** - Secure persistent login option

## Validation Rules

### Login
- Email: required, valid email format
- Password: required, minimum 6 characters

### Registration
- Name: required, string, max 255 characters
- Email: required, valid email format, unique in users table
- Password: required, minimum 8 characters, must match confirmation

## User Experience Flow

### First Time User
1. Click "REGISTER" in navbar
2. Fill out registration form
3. Account created and automatically logged in
4. Redirected to homepage

### Existing User
1. Click "LOGIN" in navbar
2. Enter email and password
3. Logged in and redirected to homepage
4. User info displayed in navbar

### Placing Order/Reservation
1. Must be logged in
2. Click "Order Now" or "BOOKING"
3. Fill out order/reservation form
4. Order/reservation is linked to user's account
5. Can view order history via user profile (future feature)

## Future Enhancements

1. **User Dashboard** - View order history and reservations
2. **Email Verification** - Verify email before account activation
3. **Password Reset** - Allow users to reset forgotten passwords
4. **Social Login** - Login with Google/Facebook
5. **Two-Factor Authentication** - Additional security layer
6. **Admin Panel** - Manage users, orders, and reservations

## Testing Authentication

### Via Browser
1. Navigate to `/register` - Create new account
2. Navigate to `/login` - Log in with credentials
3. View navbar - Should show user name and logout option
4. Navigate to `/order/create` - Try placing order
5. Navigate to `/reservation` - Try making reservation
6. Click logout in navbar - Confirm session ends

### Via API
```bash
# Check authentication status
curl http://localhost:8000/api/auth/check

# Get current user (requires authentication)
curl -H "Authorization: Bearer {token}" http://localhost:8000/api/user
```

## Configuration

### Timeout Settings
Edit in `config/session.php`:
- `lifetime` - Session timeout in minutes (default: 120)
- `expire_on_close` - End session when browser closes

### Password Settings
Can be customized in AuthController:
- Minimum password length (currently: 8)
- Password hashing algorithm (currently: bcrypt)

## Troubleshooting

### "Unauthenticated" Error on Order/Reservation
- Ensure user is logged in
- Check if session is still valid
- Try logging out and logging back in

### Login Not Working
- Verify email exists in database
- Confirm password is correct
- Check that password field is in plain text before submission (not hashed on frontend)

### Session Not Persisting
- Clear browser cookies
- Ensure browser accepts cookies
- Check `config/session.php` settings

### CSRF Token Errors
- Ensure @csrf directive is in form
- Clear browser cache and cookies
- Try incognito/private browsing window
