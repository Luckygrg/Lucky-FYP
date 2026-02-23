# Password Reset System - SpaLush

## Overview
Complete forgot password functionality with email verification, time-limited reset links, and request throttling.

## Features Implemented

### 1. Forgot Password Flow
1. User clicks "Forgot Password?" on login page
2. Enters email address
3. System checks if email exists
4. Sends reset link via email
5. Link expires in 40 seconds
6. User can't request again for 40 seconds

### 2. Reset Password Flow
1. User clicks link in email
2. System validates token and expiration
3. User enters new password
4. Password is updated in database
5. Token is deleted
6. User redirected to login

### 3. Security Features

**Time Limits:**
- Reset link expires in 40 seconds
- User must wait 40 seconds between requests
- Expired tokens are automatically deleted

**Validation:**
- Email must exist in database
- Token must be valid and not expired
- Password must be minimum 8 characters
- Password confirmation required

**Protection:**
- One active token per email
- Old tokens deleted when new request made
- Tokens deleted after successful reset
- Rate limiting prevents spam

### 4. Email Configuration

**Gmail SMTP Settings:**
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=luckygrxx@gmail.com
MAIL_PASSWORD="ccdf djpx nyfa nwoo"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="luckygrxx@gmail.com"
```

**Email Template Features:**
- Professional design with SpaLush branding
- Champagne gold color scheme
- Clear reset button
- Warning about 40-second expiration
- Fallback link if button doesn't work
- Responsive design

### 5. Database Structure

**password_reset_requests table:**
- `id` - Primary key
- `email` - User email
- `token` - Unique reset token
- `expires_at` - Token expiration time
- `last_request_at` - Last request timestamp
- `created_at` / `updated_at` - Timestamps

### 6. Routes

```php
GET  /forgot-password           → Show forgot password form
POST /forgot-password           → Send reset link email
GET  /reset-password/{token}    → Show reset password form
POST /reset-password            → Update password
```

### 7. User Interface

**Forgot Password Page:**
- Clean, professional design
- Email input field
- "Send Reset Link" button
- Link back to login
- Success/error messages
- Matches luxury theme

**Reset Password Page:**
- New password field
- Confirm password field
- "Reset Password" button
- Validation messages
- Matches luxury theme

**Login Page:**
- "Forgot Password?" link added
- Positioned below password field
- Champagne gold color
- Hover effect

## How to Use

### For Users:
1. Go to login page
2. Click "Forgot Password?"
3. Enter your email
4. Check your email inbox
5. Click the reset link (within 40 seconds)
6. Enter new password
7. Login with new password

### For Testing:
1. Register a test account
2. Go to login page
3. Click "Forgot Password?"
4. Enter your email
5. Check email (luckygrxx@gmail.com inbox)
6. Click reset link quickly (40 seconds!)
7. Set new password
8. Login

## Error Messages

**User-Friendly Messages:**
- "No account found with this email address"
- "Please wait X seconds before requesting again"
- "Password reset link has been sent to your email"
- "Invalid password reset link"
- "Password reset link has expired"
- "Password has been reset successfully!"

## Email Content

**Subject:** Reset Your Password - SpaLush

**Content:**
- Personalized greeting
- Clear instructions
- Prominent reset button
- 40-second expiration warning
- Fallback link
- Security notice
- SpaLush branding

## Technical Details

**Controller:** `PasswordResetController`
- `showForgotForm()` - Display forgot password form
- `sendResetLink()` - Send email with reset link
- `showResetForm()` - Display reset password form
- `resetPassword()` - Update user password

**Views:**
- `auth/forgot-password.blade.php`
- `auth/reset-password.blade.php`
- `emails/reset-password.blade.php`

**Middleware:** None (public routes)

**Validation:**
- Email format validation
- Password minimum 8 characters
- Password confirmation match
- Token existence and validity
- Expiration time check

## Color Scheme
All pages use the luxury champagne gold theme:
- Primary: #c9a961 (Champagne Gold)
- Secondary: #1a1a1a (Dark Charcoal)
- Background: #f8f9fa (Light Gray)
- Success: #d4edda (Light Green)
- Error: #f8d7da (Light Red)

## Notes
- Email sending uses Gmail SMTP
- App password required (not regular password)
- 40-second expiration for security
- Rate limiting prevents abuse
- Tokens are single-use
- Old tokens automatically cleaned up

## Troubleshooting

**Email not sending:**
1. Check Gmail app password is correct
2. Verify SMTP settings in .env
3. Run `php artisan config:clear`
4. Check Gmail "Less secure app access" settings

**Link expired:**
- User must click link within 40 seconds
- Request new link if expired

**Can't request again:**
- Wait 40 seconds between requests
- Prevents spam and abuse
