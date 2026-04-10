@extends('layouts.main')
@section('title', 'My Profile - SpaLush')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    body { background: #FAF7F2; }

    .profile-page {
        max-width: 900px;
        margin: 60px auto;
        padding: 0 24px 80px;
    }

    .page-header { margin-bottom: 36px; }

    .page-header h1 {
        font-size: 32px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }

    .page-header p {
        color: rgba(28,16,8,0.5);
        font-size: 15px;
    }

    .alert-success {
        background: rgba(67,160,71,0.12);
        color: #6fcf72;
        border: 1px solid rgba(67,160,71,0.3);
        border-radius: 8px;
        padding: 14px 20px;
        margin-bottom: 28px;
        font-size: 14px;
    }

    .alert-error {
        background: rgba(229,57,53,0.12);
        color: #ef9a9a;
        border: 1px solid rgba(229,57,53,0.3);
        border-radius: 8px;
        padding: 14px 20px;
        margin-bottom: 28px;
        font-size: 14px;
    }

    /* Profile Header Card */
    .profile-hero {
        background: #FFFFFF;
        border-radius: 12px;
        border: 1px solid rgba(28,16,8,0.08);
        padding: 40px;
        display: flex;
        align-items: center;
        gap: 30px;
        margin-bottom: 24px;
        transition: border-color 0.2s;
    }

    .profile-hero:hover { border-color: rgba(200,145,106,0.25); }

    .photo-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .profile-photo {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(200,145,106,0.3);
    }

    .profile-photo-placeholder {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: #C8916A;
        color: #1C1008;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        font-weight: 600;
        font-family: 'Georgia', serif;
        border: 3px solid rgba(200,145,106,0.3);
    }

    .photo-edit-btn {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #C8916A;
        color: #1C1008;
        border: 2px solid #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 13px;
        transition: background 0.2s;
    }

    .photo-edit-btn:hover { background: #AE7A55; }

    .profile-hero-info { flex: 1; }

    .profile-hero-name {
        font-size: 26px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .profile-hero-email {
        font-size: 14px;
        color: rgba(28,16,8,0.45);
        margin-bottom: 12px;
    }

    .profile-hero-role {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        background: rgba(200,145,106,0.15);
        color: #C8916A;
        border: 1px solid rgba(200,145,106,0.3);
    }

    .profile-hero-joined {
        font-size: 12px;
        color: rgba(28,16,8,0.35);
        margin-top: 10px;
    }

    /* Quick Stats */
    .profile-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 600px) {
        .profile-stats { grid-template-columns: 1fr; }
        .profile-hero { flex-direction: column; text-align: center; }
    }

    .stat-card {
        background: #FFFFFF;
        border-radius: 10px;
        border: 1px solid rgba(28,16,8,0.08);
        padding: 20px;
        text-align: center;
        transition: border-color 0.2s;
    }

    .stat-card:hover { border-color: rgba(200,145,106,0.25); }

    .stat-card i {
        font-size: 22px;
        color: #C8916A;
        margin-bottom: 10px;
    }

    .stat-card .stat-value {
        font-size: 28px;
        font-weight: 300;
        color: #C8916A;
        font-family: 'Georgia', serif;
    }

    .stat-card .stat-label {
        font-size: 11px;
        color: rgba(28,16,8,0.4);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 4px;
    }

    /* Edit Form Card */
    .profile-edit-card {
        background: #FFFFFF;
        border-radius: 12px;
        border: 1px solid rgba(28,16,8,0.08);
        padding: 36px;
        transition: border-color 0.2s;
    }

    .profile-edit-card:hover { border-color: rgba(200,145,106,0.25); }

    .section-title {
        font-size: 20px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(200,145,106,0.2);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i { color: #C8916A; font-size: 18px; }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(28,16,8,0.5);
        margin-bottom: 8px;
        font-weight: 600;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"] {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid rgba(28,16,8,0.12);
        border-radius: 8px;
        font-size: 15px;
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
        font-size: 11px;
        color: rgba(28,16,8,0.35);
        margin-top: 6px;
        font-weight: 400;
        letter-spacing: 0;
        text-transform: none;
    }

    /* Photo Upload Area */
    .photo-upload-area {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
        padding: 20px;
        background: #FAF7F2;
        border-radius: 10px;
        border: 1px dashed rgba(200,145,106,0.35);
    }

    .photo-upload-preview {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(200,145,106,0.3);
    }

    .photo-upload-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #C8916A;
        color: #1C1008;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        font-weight: 600;
        font-family: 'Georgia', serif;
        border: 2px solid rgba(200,145,106,0.3);
        flex-shrink: 0;
    }

    .photo-upload-info { flex: 1; }

    .photo-upload-info p {
        font-size: 13px;
        color: rgba(28,16,8,0.5);
        margin-bottom: 10px;
    }

    .photo-upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        background: transparent;
        border: 1px solid rgba(200,145,106,0.4);
        border-radius: 6px;
        color: #C8916A;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }

    .photo-upload-btn:hover {
        background: rgba(200,145,106,0.08);
        border-color: #C8916A;
    }

    .photo-remove-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        background: transparent;
        border: 1px solid rgba(229,57,53,0.3);
        border-radius: 6px;
        color: #ef9a9a;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
        margin-left: 8px;
    }

    .photo-remove-btn:hover {
        background: rgba(229,57,53,0.08);
        border-color: rgba(229,57,53,0.5);
    }

    #photoInput { display: none; }

    .profile-save-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: #C8916A;
        color: #1C1008;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        font-weight: 700;
        transition: background 0.2s;
        font-family: inherit;
        margin-top: 10px;
    }

    .profile-save-btn:hover { background: #AE7A55; }
</style>

<div class="profile-page">

    <div class="page-header">
        <h1><i class="fas fa-user" style="color:#C8916A;font-size:26px;margin-right:10px;"></i> My Profile</h1>
        <p>Welcome back, {{ $user->name }}</p>
    </div>

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

    <!-- Profile Hero Card -->
    <div class="profile-hero">
        <div class="photo-wrapper">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" class="profile-photo">
            @else
                <div class="profile-photo-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            @endif
        </div>
        <div class="profile-hero-info">
            <div class="profile-hero-name">{{ $user->name }}</div>
            <div class="profile-hero-email"><i class="fas fa-envelope" style="margin-right:6px;color:rgba(28,16,8,0.3);"></i>{{ $user->email }}</div>
            <span class="profile-hero-role"><i class="fas fa-spa" style="margin-right:4px;"></i> Customer</span>
            <div class="profile-hero-joined"><i class="fas fa-calendar" style="margin-right:6px;"></i>Member since {{ $user->created_at->format('F Y') }}</div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="profile-stats">
        <div class="stat-card">
            <i class="fas fa-calendar-check"></i>
            <div class="stat-value">{{ $bookingsCount }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-credit-card"></i>
            <div class="stat-value">{{ $paymentsCount }}</div>
            <div class="stat-label">Payments Made</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-star"></i>
            <div class="stat-value">{{ $reviewsCount }}</div>
            <div class="stat-label">Reviews Given</div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="profile-edit-card">
        <div class="section-title"><i class="fas fa-pen"></i> Edit Profile</div>

        <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Photo Upload -->
            <div class="photo-upload-area">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" class="photo-upload-preview" id="photoPreview">
                @else
                    <div class="photo-upload-placeholder" id="photoPreview">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
                <div class="photo-upload-info">
                    <p>Upload a profile photo. JPG, PNG up to 2MB.</p>
                    <button type="button" class="photo-upload-btn" onclick="document.getElementById('photoInput').click()">
                        <i class="fas fa-camera"></i> {{ $user->photo ? 'Change Photo' : 'Upload Photo' }}
                    </button>
                    @if($user->photo)
                        <label class="photo-remove-btn">
                            <input type="checkbox" name="remove_photo" value="1" style="display:none">
                            <i class="fas fa-trash"></i> Remove
                        </label>
                    @endif
                    <input type="file" name="photo" id="photoInput" accept="image/jpeg,image/png,image/webp">
                </div>
            </div>

            <!-- Name & Email -->
            <div class="form-row">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <!-- Password -->
            <div class="section-title" style="margin-top:10px;"><i class="fas fa-lock"></i> Change Password</div>
            <div class="form-row">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" placeholder="Enter new password">
                    <div class="hint">Leave blank to keep current password</div>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm new password">
                </div>
            </div>

            <button type="submit" class="profile-save-btn">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>

<script>
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
                    img.className = 'photo-upload-preview';
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
