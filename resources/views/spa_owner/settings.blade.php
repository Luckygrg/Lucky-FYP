@extends('layouts.main')
@section('title', 'Settings - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
        background: #FAF7F2;
        font-family: Arial, sans-serif;
    }

    .main-content {
        flex: 1;
        padding: 40px;
        overflow-y: auto;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 28px;
        color: #1C1008;
        font-weight: 300;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }

    .page-header p {
        color: rgba(28,16,8,0.6);
        font-size: 14px;
    }

    .alert-success {
        background: rgba(67,160,71,0.12);
        color: #43a047;
        border: 1px solid rgba(67,160,71,0.3);
        border-radius: 8px;
        padding: 12px 18px;
        margin-bottom: 24px;
        font-size: 14px;
    }

    .alert-error {
        background: rgba(229,57,53,0.12);
        color: #e53935;
        border: 1px solid rgba(229,57,53,0.3);
        border-radius: 8px;
        padding: 12px 18px;
        margin-bottom: 24px;
        font-size: 14px;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
    }

    .settings-card {
        background: #FFFFFF;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        border: 1px solid rgba(200,145,106,0.15);
        overflow: hidden;
        align-self: start;
    }

    .settings-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid rgba(28,16,8,0.08);
    }

    .settings-card-header h2 {
        font-size: 17px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        letter-spacing: 0.5px;
        margin: 0;
    }

    .settings-card-header p {
        font-size: 12px;
        color: rgba(28,16,8,0.4);
        margin: 4px 0 0;
    }

    .settings-card-body {
        padding: 24px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: rgba(28,16,8,0.5);
        margin-bottom: 7px;
    }

    .form-group input {
        width: 100%;
        padding: 10px 14px;
        background: #FAF7F2;
        border: 1px solid rgba(28,16,8,0.15);
        border-radius: 6px;
        color: #1C1008;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #C8916A;
    }

    .field-error {
        color: #e53935;
        font-size: 12px;
        margin-top: 4px;
    }

    .field-hint {
        color: rgba(28,16,8,0.45);
        font-size: 12px;
        margin-top: 6px;
    }

    .profile-photo-block {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 24px;
        padding: 18px;
        border-radius: 8px;
        background: #FAF7F2;
        border: 1px solid rgba(200,145,106,0.12);
    }

    .profile-avatar,
    .profile-avatar-placeholder {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .profile-avatar {
        object-fit: cover;
        border: 2px solid rgba(200,145,106,0.3);
    }

    .profile-avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #C8916A, #895D3E);
        color: #1C1008;
        font-size: 38px;
        font-family: 'Georgia', serif;
        font-weight: 700;
    }

    .profile-photo-meta {
        min-width: 0;
    }

    .profile-photo-meta strong {
        display: block;
        color: #1C1008;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .profile-photo-meta span {
        display: block;
        color: rgba(28,16,8,0.6);
        font-size: 13px;
        margin-bottom: 12px;
        word-break: break-word;
    }

    .photo-input {
        display: block;
        width: 100%;
        font-size: 13px;
        color: rgba(28,16,8,0.6);
    }

    .photo-input::file-selector-button {
        margin-right: 12px;
        padding: 9px 14px;
        background: rgba(200,145,106,0.12);
        border: 1px solid rgba(200,145,106,0.3);
        border-radius: 6px;
        color: #1C1008;
        cursor: pointer;
    }

    .btn-save {
        padding: 10px 28px;
        background: #C8916A;
        color: #1C1008;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        letter-spacing: 0.4px;
        transition: background 0.2s;
    }

    .btn-save:hover {
        background: #AE7A55;
    }

    @media (max-width: 1024px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            flex-direction: column;
        }

        .main-content {
            padding: 20px;
        }

        .profile-photo-block {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <div class="page-header">
            <h1>Settings</h1>
            <p>Manage your spa owner profile</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="settings-grid">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2>Profile Information</h2>
                    <p>Update your name, email address, and profile photo</p>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('spa_owner.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="profile-photo-block">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile photo" class="profile-avatar">
                            @else
                                <div class="profile-avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            @endif

                            <div class="profile-photo-meta">
                                <strong>{{ $user->name }}</strong>
                                <span>{{ $user->email }}</span>
                                <input id="photo-upload" class="photo-input" type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                <div class="field-hint">Accepted formats: JPG, PNG, GIF, WEBP. Max size 2 MB.</div>
                                @error('photo') <div class="field-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="owner_name">Name</label>
                            <input type="text" id="owner_name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="owner_email">Email</label>
                            <input type="email" id="owner_email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn-save">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="settings-card">
                <div class="settings-card-header">
                    <h2>Change Password</h2>
                    <p>Use your current password to set a new one</p>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('spa_owner.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" required>
                            @error('current_password') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" id="password" name="password" required>
                            <div class="field-hint">Choose at least 8 characters.</div>
                            @error('password') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn-save">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
