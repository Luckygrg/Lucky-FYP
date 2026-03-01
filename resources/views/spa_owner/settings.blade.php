@extends('layouts.main')
@section('title', 'Settings - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #f8f9fa; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: #1a1a1a; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .page-header p { color: #888; font-size: 15px; margin-top: 8px; }
    .alert-success { background: rgba(201,169,97,0.1); color: #8b7644; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #c9a961; font-size: 14px; }
    .form-card { background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 35px 40px; max-width: 600px; }
    .section-title { font-size: 16px; font-weight: 600; color: #c9a961; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1px solid #f5f5f5; }
    .form-group { margin-bottom: 22px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #555; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group input {
        width: 100%; padding: 11px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 14px; color: #333; transition: border-color 0.2s; background: #fafafa;
    }
    .form-group input:focus { outline: none; border-color: #c9a961; background: white; }
    .invalid-feedback { color: #e53935; font-size: 12px; margin-top: 4px; }
    .hint { color: #aaa; font-size: 12px; margin-top: 4px; }
    .avatar-row { display: flex; align-items: center; gap: 18px; margin-bottom: 25px; }
    .avatar { width: 64px; height: 64px; background: linear-gradient(135deg, #c9a961, #8b7644); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; color: white; font-family: 'Georgia', serif; font-weight: bold; }
    .avatar-info strong { display: block; color: #1a1a1a; font-size: 16px; }
    .avatar-info span { color: #888; font-size: 13px; }
    .btn-gold { padding: 12px 28px; background: #c9a961; color: white; border: none; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
    .btn-gold:hover { background: #b8985a; transform: translateY(-1px); }
    .divider { border: none; border-top: 1px solid #f0f0f0; margin: 30px 0; }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <div class="page-header">
            <h1>⚙️ Settings</h1>
            <p>Manage your account information</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="form-card">
            <!-- Avatar -->
            <div class="avatar-row">
                <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="avatar-info">
                    <strong>{{ $user->name }}</strong>
                    <span>{{ $user->email }}</span>
                </div>
            </div>

            <form action="{{ route('spa_owner.settings.update') }}" method="POST">
                @csrf @method('PUT')

                <p class="section-title">Profile</p>

                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <hr class="divider">
                <p class="section-title">Change Password</p>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current password">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="hint">Minimum 8 characters.</div>
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat new password">
                </div>

                <button type="submit" class="btn-gold">Save Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection
