# SpaLush User Registration Flow

## Complete User Journey

### 1. Homepage (`/`)
- User sees "Get Started" or "Sign Up Now" buttons
- Clicks on any signup button

### 2. Role Selection Page (`/choose-role`)
- User sees two beautiful cards:
  - **Customer Card** 🧘‍♀️
    - Features: Browse services, Book appointments, View history, etc.
    - Button: "Sign Up as Customer"
  
  - **Spa Owner Card** 💼
    - Features: Manage services, Handle bookings, Set schedule, etc.
    - Button: "Sign Up as Spa Owner"

- User clicks on their preferred role

### 3. Role-Specific Signup Page (`/usersignup?role=customer` or `/usersignup?role=spa_owner`)
- Page title shows: "Sign Up as Customer" or "Sign Up as Spa Owner"
- Form fields:
  - Full Name
  - Email
  - Password
  - Confirm Password
- Role is automatically set (hidden field)
- Links:
  - "← Choose different role" (back to role selection)
  - "Login" (if already have account)

### 4. After Signup
- User is redirected to Login page with success message
- "Account created successfully! Please login."

### 5. Login Page (`/userlogin`)
- User enters email and password
- System authenticates

### 6. Role-Based Dashboard Redirect
After successful login, user is redirected based on their role:

- **Customer** → `/customer/dashboard`
  - Features: Book services, View bookings, Manage profile

- **Spa Owner** → `/spa-owner/dashboard`
  - Features: Manage services, Manage bookings, Manage schedule, View customers

- **Admin** → `/admin/dashboard`
  - Features: Manage spa owners, Manage customers, Manage services, Monitor system

## Routes Summary

```
GET  /                      → Homepage
GET  /choose-role           → Role Selection Page
GET  /usersignup?role=X     → Signup Form (role pre-selected)
POST /usersignup            → Process Registration
GET  /userlogin             → Login Form
POST /userlogin             → Process Login
POST /logout                → Logout

Protected Routes (require auth + role):
GET  /customer/dashboard    → Customer Dashboard
GET  /spa-owner/dashboard   → Spa Owner Dashboard
GET  /admin/dashboard       → Admin Dashboard
```

## Navigation Updates

All "Sign Up" links now point to `/choose-role`:
- ✓ Homepage hero section
- ✓ Homepage CTA section
- ✓ Navigation bar
- ✓ Login page (if needed)

## Test the Flow

1. Visit homepage: `http://localhost:8000/`
2. Click "Get Started" or "Sign Up Now"
3. Choose your role (Customer or Spa Owner)
4. Fill in registration details
5. Login with your credentials
6. Get redirected to your role-specific dashboard

## Admin Access

Admin users cannot register through the public flow. They are created via seeder:
- Email: `admin@spalush.com`
- Password: `admin123`
