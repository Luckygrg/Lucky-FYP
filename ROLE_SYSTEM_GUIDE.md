# SpaLush Role-Based Access Control System

## Overview
The SpaLush application now has a complete role-based access control system with three user roles:
- **Customer**: Can book services, view bookings, and manage their profile
- **Spa Owner**: Can manage services, bookings, schedules, and view customer records
- **Admin**: Can manage spa owners, customers, services, and monitor system activity

## User Roles & Permissions

### Customer Role
**Capabilities:**
- Register and login
- Browse spa services
- View service details
- Check availability
- Make bookings
- View booking history
- Cancel bookings
- Manage profile

**Dashboard:** `/customer/dashboard`

### Spa Owner Role
**Capabilities:**
- Login
- Manage services (add, edit, delete)
- Manage bookings
- Manage schedule
- View customer records

**Dashboard:** `/spa-owner/dashboard`

### Admin Role
**Capabilities:**
- Login
- Manage spa owners
- Manage customers
- Manage services
- Monitor system activity

**Dashboard:** `/admin/dashboard`

## Technical Implementation

### Database
- Added `role` column to `users` table (enum: customer, spa_owner, admin)
- Default role: customer

### Middleware
- Created `RoleMiddleware` to protect routes based on user roles
- Registered as 'role' alias in `bootstrap/app.php`

### Controllers
- `CustomerController`: Handles customer dashboard
- `SpaOwnerController`: Handles spa owner dashboard
- `AdminController`: Handles admin dashboard
- `UserController`: Updated to handle role-based registration and login redirection

### Routes
Protected routes using middleware:
```php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});
```

### Views
Created dashboard views for each role:
- `resources/views/customer/dashboard.blade.php`
- `resources/views/spa_owner/dashboard.blade.php`
- `resources/views/admin/dashboard.blade.php`

## Registration Process
1. User visits signup page
2. Selects role (Customer or Spa Owner)
3. Fills in registration details
4. Account is created with selected role
5. Redirected to login page

## Login Process
1. User enters credentials
2. System authenticates user
3. User is redirected to role-specific dashboard:
   - Admin → `/admin/dashboard`
   - Spa Owner → `/spa-owner/dashboard`
   - Customer → `/customer/dashboard`

## Test Credentials

### Admin Account
- Email: `admin@spalush.com`
- Password: `admin123`

### Creating Test Users
You can register new users through the signup page:
- Customer: Select "Customer" role during registration
- Spa Owner: Select "Spa Owner" role during registration

## Next Steps
1. Implement service management for spa owners
2. Create booking system for customers
3. Build admin management panels
4. Add schedule management for spa owners
5. Implement customer profile management
