@extends('layouts.main')
@section('title', 'My Profile - SpaLush')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    body { background: #FAF7F2; }

    .profile-layout {
        max-width: 1200px;
        width: 100%;
        margin: 40px auto;
        padding: 0 24px 80px;
    }

    .profile-heading {
        color: #C8916A;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 1px;
        margin-bottom: 16px;
    }

    .profile-container {
        display: flex;
        gap: 0;
        background: #FFFFFF;
        border-radius: 14px;
        border: 1px solid rgba(28,16,8,0.08);
        overflow: hidden;
        height: 620px;
        width: 100%;
    }

    /* Sidebar */
    .profile-sidebar {
        width: 300px;
        min-width: 300px;
        max-width: 300px;
        flex-shrink: 0;
        border-right: 1px solid rgba(28,16,8,0.07);
        padding: 8px 0;
        overflow-y: auto;
    }

    .sidebar-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 28px;
        font-size: 14.5px;
        color: rgba(28,16,8,0.55);
        cursor: pointer;
        transition: all 0.2s;
        border-left: 3px solid transparent;
        text-decoration: none;
        font-weight: 500;
    }

    .sidebar-item:hover {
        background: rgba(200,145,106,0.04);
        color: #1C1008;
    }

    .sidebar-item.active {
        border-left-color: #C8916A;
        color: #1C1008;
        background: rgba(200,145,106,0.06);
        font-weight: 600;
    }

    .sidebar-item i {
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #C8916A;
        opacity: 0.7;
    }

    .sidebar-item.active i {
        opacity: 1;
    }

    /* Content Area */
    .profile-content {
        flex: 1;
        min-width: 0;
        padding: 44px 50px;
        overflow-y: auto;
    }

    .content-section {
        display: none;
    }

    .content-section.active {
        display: block;
    }

    /* Form inside content */
    .form-with-photo {
        display: flex;
        gap: 50px;
    }

    .form-fields {
        flex: 1;
    }

    .photo-side {
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding-top: 10px;
    }

    .photo-side-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(200,145,106,0.25);
    }

    .photo-side-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(200,145,106,0.12);
        color: #C8916A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 44px;
        font-weight: 600;
        font-family: 'Georgia', serif;
        border: 3px solid rgba(200,145,106,0.25);
        position: relative;
    }

    .photo-edit-icon {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #FFFFFF;
        border: 1px solid rgba(28,16,8,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        color: rgba(28,16,8,0.5);
        transition: all 0.2s;
    }

    .photo-edit-icon:hover {
        border-color: #C8916A;
        color: #C8916A;
    }

    .photo-side-text {
        font-size: 12px;
        color: rgba(28,16,8,0.4);
        text-align: center;
        margin-top: 4px;
    }

    .photo-remove-link {
        font-size: 11px;
        color: #e57373;
        cursor: pointer;
        background: none;
        border: none;
        text-decoration: underline;
        font-family: inherit;
    }

    .photo-remove-link:hover { color: #ef5350; }

    #photoInput { display: none; }

    /* Form fields */
    .form-group {
        margin-bottom: 28px;
    }

    .form-group label {
        display: block;
        font-size: 14.5px;
        color: rgba(28,16,8,0.6);
        margin-bottom: 10px;
        font-weight: 500;
        font-family: 'Georgia', serif;
        letter-spacing: 0.3px;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"],
    .form-group input[type="tel"] {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid rgba(28,16,8,0.12);
        border-radius: 8px;
        font-size: 16px;
        color: #1C1008;
        background: #FAF7F2;
        transition: border-color 0.3s;
        font-family: inherit;
        box-sizing: border-box;
    }

    .form-group input:focus {
        outline: none;
        border-color: #C8916A;
        background: #FFFFFF;
    }

    .form-group .hint {
        font-size: 13px;
        color: rgba(28,16,8,0.4);
        margin-top: 8px;
        line-height: 1.5;
    }

    .form-group .hint a {
        color: #C8916A;
        text-decoration: none;
        font-weight: 500;
    }

    .form-group .hint a:hover { text-decoration: underline; }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .section-divider {
        font-size: 15px;
        font-weight: 600;
        color: rgba(28,16,8,0.5);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin: 34px 0 24px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(200,145,106,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Georgia', serif;
    }

    .section-divider i { color: #C8916A; font-size: 16px; }

    .profile-save-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 38px;
        background: #C8916A;
        color: #FFFFFF;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        letter-spacing: 0.5px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s;
        font-family: inherit;
        margin-top: 16px;
    }

    .profile-save-btn:hover { background: #AE7A55; }

    /* Stats inside sidebar bottom */
    .sidebar-stats {
        margin: 12px 20px;
        padding: 16px;
        background: rgba(200,145,106,0.06);
        border-radius: 10px;
        border: 1px solid rgba(200,145,106,0.1);
    }

    .sidebar-stats-title {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(28,16,8,0.35);
        margin-bottom: 12px;
        font-weight: 600;
    }

    .sidebar-stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
    }

    .sidebar-stat-row span {
        font-size: 13px;
        color: rgba(28,16,8,0.5);
    }

    .sidebar-stat-row strong {
        font-size: 16px;
        color: #C8916A;
        font-family: 'Georgia', serif;
        font-weight: 400;
    }

    /* Alerts */
    .alert-success {
        background: rgba(67,160,71,0.08);
        color: #43A047;
        border: 1px solid rgba(67,160,71,0.2);
        border-radius: 8px;
        padding: 12px 18px;
        margin-bottom: 24px;
        font-size: 14px;
    }

    .alert-error {
        background: rgba(229,57,53,0.08);
        color: #E53935;
        border: 1px solid rgba(229,57,53,0.2);
        border-radius: 8px;
        padding: 12px 18px;
        margin-bottom: 24px;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-container { flex-direction: column; }
        .profile-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid rgba(28,16,8,0.07);
            display: flex;
            overflow-x: auto;
            padding: 0;
        }
        .sidebar-item {
            padding: 14px 20px;
            white-space: nowrap;
            border-left: none;
            border-bottom: 3px solid transparent;
            font-size: 13px;
        }
        .sidebar-item.active {
            border-left-color: transparent;
            border-bottom-color: #C8916A;
        }
        .sidebar-stats { display: none; }
        .profile-content { padding: 24px 20px; }
        .form-with-photo { flex-direction: column-reverse; }
        .photo-side { flex-direction: row; gap: 16px; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<div class="profile-layout">

    <div class="profile-heading">My Profile</div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle" style="margin-right:8px;"></i>{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle" style="margin-right:8px;"></i>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="profile-container">

        <!-- Sidebar Navigation -->
        <div class="profile-sidebar">
            <div class="sidebar-item active" data-tab="basic">
                <i class="fas fa-user-circle"></i> Basic Information
            </div>
            <div class="sidebar-item" data-tab="password">
                <i class="fas fa-lock"></i> Password
            </div>
            <div class="sidebar-item" data-tab="bookings">
                <i class="fas fa-calendar-check"></i> My Bookings
            </div>
            <div class="sidebar-item" data-tab="payments">
                <i class="fas fa-credit-card"></i> Payment History
            </div>
            <div class="sidebar-item" data-tab="notifications">
                <i class="fas fa-bell"></i> Notifications
            </div>

            <!-- Quick Stats -->
            <div class="sidebar-stats">
                <div class="sidebar-stats-title">Quick Stats</div>
                <div class="sidebar-stat-row">
                    <span>Bookings</span>
                    <strong>{{ $bookingsCount }}</strong>
                </div>
                <div class="sidebar-stat-row">
                    <span>Payments</span>
                    <strong>{{ $paymentsCount }}</strong>
                </div>
                <div class="sidebar-stat-row">
                    <span>Reviews</span>
                    <strong>{{ $reviewsCount }}</strong>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="profile-content">

            <!-- Basic Information Tab -->
            <div class="content-section active" id="tab-basic">
                <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-with-photo">
                        <div class="form-fields">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                <div class="hint">This is your primary email address and will be used to send notifications.</div>
                            </div>

                            <div class="form-group">
                                <label>Member Since</label>
                                <input type="text" value="{{ $user->created_at->format('F d, Y') }}" disabled style="opacity:0.6;cursor:not-allowed;">
                            </div>
                        </div>

                        <!-- Photo Upload Side -->
                        <div class="photo-side">
                            <div style="position:relative;">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" class="photo-side-avatar" id="photoPreview">
                                @else
                                    <div class="photo-side-placeholder" id="photoPreview">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                @endif
                                <div class="photo-edit-icon" onclick="document.getElementById('photoInput').click()">
                                    <i class="fas fa-pen"></i>
                                </div>
                            </div>
                            <div class="photo-side-text">Max Image Size = 2 MB</div>
                            @if($user->photo)
                                <label class="photo-remove-link">
                                    <input type="checkbox" name="remove_photo" value="1" style="display:none">
                                    <i class="fas fa-trash" style="margin-right:3px;"></i> Remove Photo
                                </label>
                            @endif
                            <input type="file" name="photo" id="photoInput" accept="image/jpeg,image/png,image/webp">
                        </div>
                    </div>

                    <button type="submit" class="profile-save-btn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>
            </div>

            <!-- Password Tab -->
            <div class="content-section" id="tab-password">
                <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" placeholder="Enter current password">
                        <div class="hint">Required to verify your identity</div>
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" placeholder="Enter new password">
                        <div class="hint">Must be at least 8 characters long</div>
                    </div>

                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="Re-enter new password">
                    </div>

                    <button type="submit" class="profile-save-btn">
                        <i class="fas fa-save"></i> Update Password
                    </button>
                </form>
            </div>

            <!-- Bookings Tab -->
            <div class="content-section" id="tab-bookings">
                @if($bookings->isEmpty())
                    <div style="text-align:center;padding:60px 20px;">
                        <i class="fas fa-calendar-times" style="font-size:52px;color:rgba(200,145,106,0.35);margin-bottom:18px;display:block;"></i>
                        <div style="font-size:20px;font-family:'Georgia',serif;color:#1C1008;margin-bottom:8px;">No Bookings Yet</div>
                        <p style="color:rgba(28,16,8,0.45);font-size:14px;margin-bottom:24px;">Discover our spas and book your first experience</p>
                        <a href="{{ route('spas.index') }}" class="profile-save-btn" style="text-decoration:none;display:inline-flex;"><i class="fas fa-spa"></i> Explore Spas</a>
                    </div>
                @else
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        @foreach($bookings as $booking)
                        <div style="border:1px solid rgba(28,16,8,0.08);border-radius:10px;overflow:hidden;">
                            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid rgba(28,16,8,0.05);flex-wrap:wrap;gap:10px;">
                                <div>
                                    <div style="font-size:17px;font-weight:600;color:#1C1008;font-family:'Georgia',serif;">{{ $booking->spa->name }}</div>
                                    <div style="font-size:13px;color:rgba(28,16,8,0.45);margin-top:2px;"><i class="fas fa-map-marker-alt" style="color:#C8916A;margin-right:4px;"></i>{{ $booking->spa->city }}</div>
                                </div>
                                @php
                                    $bStatusColors = ['pending' => 'rgba(200,145,106,0.15);color:#C8916A;border:1px solid rgba(200,145,106,0.3)', 'confirmed' => 'rgba(67,160,71,0.15);color:#6fcf72;border:1px solid rgba(67,160,71,0.3)', 'completed' => 'rgba(100,181,246,0.15);color:#64b5f6;border:1px solid rgba(100,181,246,0.3)', 'cancelled' => 'rgba(229,57,53,0.12);color:#ef9a9a;border:1px solid rgba(229,57,53,0.3)'];
                                @endphp
                                <span style="padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700;letter-spacing:0.5px;text-transform:uppercase;background:{{ $bStatusColors[$booking->status] ?? $bStatusColors['pending'] }}">{{ ucfirst($booking->status) }}</span>
                            </div>
                            <div style="padding:16px 20px;">
                                <div style="display:flex;flex-wrap:wrap;gap:18px;margin-bottom:14px;font-size:14px;color:rgba(28,16,8,0.6);">
                                    <span><i class="fas fa-calendar" style="color:#C8916A;margin-right:6px;"></i>{{ $booking->booking_date->format('D, d M Y') }}</span>
                                    <span><i class="fas fa-clock" style="color:#C8916A;margin-right:6px;"></i>{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                                    <span><i class="fas fa-hourglass-half" style="color:#C8916A;margin-right:6px;"></i>{{ $booking->total_duration_minutes }} min</span>
                                </div>
                                @foreach($booking->bookingServices as $bs)
                                    <div style="display:flex;justify-content:space-between;padding:8px 14px;background:rgba(28,16,8,0.03);border-radius:6px;font-size:14px;color:rgba(28,16,8,0.7);margin-bottom:6px;">
                                        <span>{{ $bs->service_name }} <span style="color:rgba(28,16,8,0.35);">· {{ $bs->duration_minutes }} min</span></span>
                                        <span style="color:#C8916A;font-weight:600;">Rs. {{ number_format($bs->price, 0) }}</span>
                                    </div>
                                @endforeach
                                <div style="display:flex;justify-content:space-between;padding:12px 14px;background:rgba(200,145,106,0.07);border:1px solid rgba(200,145,106,0.15);border-radius:6px;font-size:15px;font-weight:600;color:#1C1008;margin-top:8px;">
                                    <span>Total</span>
                                    <span style="color:#C8916A;">Rs. {{ number_format($booking->total_price, 0) }}</span>
                                </div>
                                {{-- Payment & cancel actions --}}
                                <div style="margin-top:12px;display:flex;align-items:center;gap:8px;font-size:13px;flex-wrap:wrap;">
                                    @if($booking->payment_status === 'paid')
                                        <span style="background:rgba(67,160,71,0.12);color:#6fcf72;border:1px solid rgba(67,160,71,0.3);padding:4px 12px;border-radius:12px;font-weight:600;">
                                            <i class="fas fa-check-circle"></i> Paid
                                        </span>
                                    @elseif($booking->status === 'confirmed')
                                        @if(!$booking->payment_choice_made)
                                            <form method="POST" action="{{ route('payment.chooseAtSpa', $booking) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" style="background:rgba(200,145,106,0.1);color:#C8916A;border:1px solid rgba(200,145,106,0.35);padding:5px 14px;border-radius:12px;font-weight:600;cursor:pointer;font-size:12px;">
                                                    <i class="fas fa-hand-holding-usd"></i> Pay at Spa
                                                </button>
                                            </form>
                                            <a href="{{ route('payment.pay', $booking) }}" style="background:#C8916A;color:#fff;padding:5px 14px;border-radius:12px;font-weight:700;text-decoration:none;font-size:12px;">
                                                <i class="fas fa-credit-card"></i> Pay via eSewa
                                            </a>
                                        @elseif($booking->payment_option === 'pay_now')
                                            <a href="{{ route('payment.pay', $booking) }}" style="background:#C8916A;color:#fff;padding:5px 14px;border-radius:12px;font-weight:700;text-decoration:none;font-size:12px;">
                                                <i class="fas fa-credit-card"></i> Continue eSewa
                                            </a>
                                        @else
                                            <span style="background:rgba(200,145,106,0.1);color:#C8916A;border:1px solid rgba(200,145,106,0.35);padding:5px 14px;border-radius:12px;font-weight:600;">
                                                <i class="fas fa-hand-holding-usd"></i> Pay at Spa
                                            </span>
                                        @endif
                                    @elseif($booking->status === 'pending')
                                        <span style="background:rgba(200,145,106,0.1);color:#C8916A;border:1px solid rgba(200,145,106,0.25);padding:4px 12px;border-radius:12px;font-weight:600;">
                                            <i class="fas fa-hourglass-half"></i> Awaiting confirmation
                                        </span>
                                    @endif

                                    @if($booking->status === 'pending')
                                        <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}" onsubmit="return confirm('Cancel this booking?')" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button type="submit" style="background:transparent;border:1px solid rgba(229,57,53,0.4);color:#ef9a9a;padding:5px 14px;border-radius:12px;font-weight:600;cursor:pointer;font-size:12px;">
                                                <i class="fas fa-times"></i> Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Payments Tab -->
            <div class="content-section" id="tab-payments">
                @if($payments->isEmpty())
                    <div style="text-align:center;padding:60px 20px;">
                        <i class="fas fa-credit-card" style="font-size:52px;color:rgba(200,145,106,0.35);margin-bottom:18px;display:block;"></i>
                        <div style="font-size:20px;font-family:'Georgia',serif;color:#1C1008;margin-bottom:8px;">No Payments Yet</div>
                        <p style="color:rgba(28,16,8,0.45);font-size:14px;">Your transaction history will appear here once you make a payment.</p>
                    </div>
                @else
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        @foreach($payments as $payment)
                        <div style="border:1px solid rgba(28,16,8,0.08);border-radius:10px;overflow:hidden;">
                            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid rgba(28,16,8,0.05);flex-wrap:wrap;gap:10px;">
                                <div>
                                    @if($payment->booking && $payment->booking->spa)
                                        <div style="font-size:17px;font-weight:600;color:#1C1008;font-family:'Georgia',serif;">{{ $payment->booking->spa->name }}</div>
                                        <div style="font-size:13px;color:rgba(28,16,8,0.45);margin-top:2px;"><i class="fas fa-map-marker-alt" style="color:#C8916A;margin-right:4px;"></i>{{ $payment->booking->spa->city }}</div>
                                    @else
                                        <div style="font-size:17px;font-weight:600;color:#1C1008;font-family:'Georgia',serif;">Payment #{{ $payment->id }}</div>
                                    @endif
                                </div>
                                @php
                                    $pStatusStyle = match(strtolower($payment->status)) {
                                        'paid', 'completed', 'success' => 'rgba(67,160,71,0.15);color:#6fcf72;border:1px solid rgba(67,160,71,0.3)',
                                        'pending' => 'rgba(200,145,106,0.15);color:#C8916A;border:1px solid rgba(200,145,106,0.3)',
                                        default => 'rgba(229,57,53,0.12);color:#ef9a9a;border:1px solid rgba(229,57,53,0.3)',
                                    };
                                @endphp
                                <span style="padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700;letter-spacing:0.5px;text-transform:uppercase;background:{{ $pStatusStyle }}">{{ ucfirst($payment->status) }}</span>
                            </div>
                            <div style="padding:16px 20px;">
                                <div style="display:flex;flex-wrap:wrap;gap:18px;margin-bottom:14px;font-size:14px;color:rgba(28,16,8,0.6);">
                                    <span><i class="fas fa-calendar" style="color:#C8916A;margin-right:6px;"></i>{{ $payment->created_at->format('D, d M Y') }}</span>
                                    <span><i class="fas fa-wallet" style="color:#C8916A;margin-right:6px;"></i>{{ $payment->method ?? 'N/A' }}</span>
                                    @if($payment->booking)
                                        <span><i class="fas fa-hashtag" style="color:#C8916A;margin-right:6px;"></i>Booking #{{ $payment->booking->id }}</span>
                                    @endif
                                </div>
                                @if($payment->booking && $payment->booking->bookingServices->count())
                                    @foreach($payment->booking->bookingServices as $bs)
                                        <div style="display:flex;justify-content:space-between;padding:8px 14px;background:rgba(28,16,8,0.03);border-radius:6px;font-size:14px;color:rgba(28,16,8,0.7);margin-bottom:6px;">
                                            <span>{{ $bs->service_name }} <span style="color:rgba(28,16,8,0.35);">· {{ $bs->duration_minutes }} min</span></span>
                                            <span style="color:#C8916A;font-weight:600;">Rs. {{ number_format($bs->price, 0) }}</span>
                                        </div>
                                    @endforeach
                                @endif
                                <div style="display:flex;justify-content:space-between;padding:12px 14px;background:rgba(200,145,106,0.07);border:1px solid rgba(200,145,106,0.15);border-radius:6px;font-size:15px;font-weight:600;color:#1C1008;margin-top:8px;">
                                    <span>Total Paid</span>
                                    <span style="color:#C8916A;">Rs. {{ number_format($payment->amount, 0) }}</span>
                                </div>
                                @if($payment->transaction_id)
                                    <div style="margin-top:10px;font-size:13px;color:rgba(28,16,8,0.4);">
                                        <i class="fas fa-receipt" style="margin-right:4px;"></i> TXN: {{ $payment->transaction_id }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Notifications Tab -->
            <div class="content-section" id="tab-notifications">
                @if($notifications->isEmpty())
                    <div style="text-align:center;padding:60px 20px;">
                        <i class="fas fa-bell-slash" style="font-size:52px;color:rgba(200,145,106,0.35);margin-bottom:18px;display:block;"></i>
                        <div style="font-size:20px;font-family:'Georgia',serif;color:#1C1008;margin-bottom:8px;">No Notifications Yet</div>
                        <p style="color:rgba(28,16,8,0.45);font-size:14px;">You'll be notified about bookings, payments, and updates here.</p>
                    </div>
                @else
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        @foreach($notifications as $notification)
                        <div style="padding:16px 20px;border:1px solid rgba(200,145,106,0.12);border-radius:10px;background:{{ $notification->read_at ? '#fff' : 'rgba(200,145,106,0.04)' }};">
                            <div style="display:flex;align-items:flex-start;gap:14px;">
                                <div style="width:36px;height:36px;border-radius:50%;background:rgba(200,145,106,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @if(str_contains($notification->type, 'BookingConfirmed'))
                                        <i class="fas fa-check-circle" style="color:#43A047;font-size:15px;"></i>
                                    @elseif(str_contains($notification->type, 'BookingCreated'))
                                        <i class="fas fa-calendar-plus" style="color:#C8916A;font-size:15px;"></i>
                                    @else
                                        <i class="fas fa-bell" style="color:#C8916A;font-size:15px;"></i>
                                    @endif
                                </div>
                                <div style="flex:1;">
                                    <div style="font-size:15px;color:#1C1008;line-height:1.5;">
                                        {{ $notification->data['message'] ?? 'You have a new notification.' }}
                                    </div>
                                    <div style="font-size:12px;color:rgba(28,16,8,0.35);margin-top:6px;">
                                        <i class="fas fa-clock" style="margin-right:4px;"></i>{{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                @if(!$notification->read_at)
                                    <span style="width:8px;height:8px;border-radius:50%;background:#C8916A;flex-shrink:0;margin-top:6px;"></span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    // Auto-open tab from URL param (e.g. ?tab=bookings)
    (function() {
        const params = new URLSearchParams(window.location.search);
        const tab = params.get('tab');
        if (tab && document.getElementById('tab-' + tab)) {
            document.querySelectorAll('.sidebar-item').forEach(function(el) { el.classList.remove('active'); });
            document.querySelectorAll('.content-section').forEach(function(s) { s.classList.remove('active'); });
            document.getElementById('tab-' + tab).classList.add('active');
            var sidebarItem = document.querySelector('.sidebar-item[data-tab="' + tab + '"]');
            if (sidebarItem) sidebarItem.classList.add('active');
        }
    })();

    // Tab switching - all sidebar items with data-tab
    document.querySelectorAll('.sidebar-item[data-tab]').forEach(function(item) {
        item.addEventListener('click', function() {
            const tab = this.getAttribute('data-tab');

            // Update active sidebar item (all sidebar items, not just data-tab ones)
            document.querySelectorAll('.sidebar-item').forEach(function(el) {
                el.classList.remove('active');
            });
            this.classList.add('active');

            // Show corresponding content
            document.querySelectorAll('.content-section').forEach(function(section) {
                section.classList.remove('active');
            });
            document.getElementById('tab-' + tab).classList.add('active');
        });
    });

    // Photo preview
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const preview = document.getElementById('photoPreview');
                if (preview.tagName === 'IMG') {
                    preview.src = ev.target.result;
                } else {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.className = 'photo-side-avatar';
                    img.id = 'photoPreview';
                    img.alt = 'Photo';
                    preview.parentNode.replaceChild(img, preview);
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
