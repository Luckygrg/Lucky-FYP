@extends('layouts.main')

@section('title', 'Settings - Admin | SpaLush')

@section('content')

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-container { display: flex; min-height: 100vh; background: #FAF7F2; font-family: Arial, sans-serif; }

    /* ── Sidebar ── */
    .sidebar {
        width: 260px;
        background: #FAF7F2;
        padding: 30px 0;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        flex-shrink: 0;
    }
    .logo { font-size: 24px; font-weight: 300; color: #1C1008; margin: 0 30px 50px; letter-spacing: 3px; font-family: 'Georgia', serif; }
    .logo span { color: #C8916A; }
    .menu-item {
        padding: 15px 30px; margin-bottom: 5px; color: rgba(28,16,8,0.7); text-decoration: none;
        display: flex; align-items: center; gap: 12px; transition: all 0.3s; font-size: 14px; letter-spacing: 0.5px;
    }
    .menu-item:hover { background: rgba(200,145,106,0.1); color: #C8916A; }
    .menu-item.active { background: rgba(200,145,106,0.15); color: #C8916A; border-left: 3px solid #C8916A; }
    .logout-btn {
        margin: auto 30px 0; padding: 12px 20px; border-radius: 4px; border: 1px solid rgba(28,16,8,0.2);
        background: transparent; color: rgba(28,16,8,0.7); cursor: pointer; display: flex; align-items: center;
        gap: 10px; transition: all 0.3s; font-size: 14px; letter-spacing: 0.5px; width: calc(100% - 60px);
    }
    .logout-btn:hover { background: #C8916A; border-color: #C8916A; color: #1C1008; }

    /* ── Main ── */
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: #1C1008; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; margin-bottom: 6px; }
    .page-header p { color: rgba(28,16,8,0.6); font-size: 14px; }

    /* Alerts */
    .alert-success {
        background: rgba(67,160,71,0.12); color: #43a047; border: 1px solid rgba(67,160,71,0.3);
        border-radius: 8px; padding: 12px 18px; margin-bottom: 24px; font-size: 14px;
    }
    .alert-error {
        background: rgba(229,57,53,0.12); color: #e53935; border: 1px solid rgba(229,57,53,0.3);
        border-radius: 8px; padding: 12px 18px; margin-bottom: 24px; font-size: 14px;
    }

    /* Settings cards */
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    .settings-card {
        background: #FFFFFF;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        border: 1px solid rgba(200,145,106,0.15);
        overflow: hidden;
    }
    .settings-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid rgba(28,16,8,0.08);
    }
    .settings-card-header h2 {
        font-size: 17px; font-weight: 300; color: #1C1008;
        font-family: 'Georgia', serif; letter-spacing: 0.5px; margin: 0;
    }
    .settings-card-header p {
        font-size: 12px; color: rgba(28,16,8,0.4); margin: 4px 0 0;
    }
    .settings-card-body { padding: 24px; }

    .form-group { margin-bottom: 18px; }
    .form-group label {
        display: block; font-size: 12px; font-weight: 600; text-transform: uppercase;
        letter-spacing: 0.8px; color: rgba(28,16,8,0.5); margin-bottom: 7px;
    }
    .form-group input {
        width: 100%; padding: 10px 14px; background: #FAF7F2;
        border: 1px solid rgba(28,16,8,0.15); border-radius: 6px;
        color: #1C1008; font-size: 14px; transition: border-color 0.2s;
    }
    .form-group input:focus { outline: none; border-color: #C8916A; }

    .field-error { color: #e53935; font-size: 12px; margin-top: 4px; }

    .btn-save {
        padding: 10px 28px; background: #C8916A; color: #1C1008;
        border: none; border-radius: 6px; font-size: 14px; font-weight: 600;
        cursor: pointer; letter-spacing: 0.4px; transition: background 0.2s;
    }
    .btn-save:hover { background: #AE7A55; }

    @media (max-width: 1024px) { .settings-grid { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .dashboard-container { flex-direction: column; }
        .sidebar { width: 100%; }
        .main-content { padding: 20px; }
    }
</style>

<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">SPA<span>LUSH</span></div>

        <a href="{{ route('admin.admin') }}" class="menu-item">Dashboard</a>
        <a href="{{ route('admin.spa_owners') }}" class="menu-item">Spa Owners</a>
        <a href="{{ route('admin.services') }}" class="menu-item">Services</a>
        <a href="{{ route('admin.categories.index') }}" class="menu-item">Spa Categories</a>
        <a href="{{ route('admin.settings') }}" class="menu-item active">Settings</a>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding: 0 30px;">
            @csrf
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1>Settings</h1>
            <p>Manage your admin profile</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="settings-grid">
            <!-- Profile Info -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2>Profile Information</h2>
                    <p>Update your name and email address</p>
                </div>
                <div class="settings-card-body">
                    <form method="POST" action="{{ route('admin.settings.updateProfile') }}">
                        @csrf @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn-save">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2>Change Password</h2>
                    <p>Ensure your account uses a strong password</p>
                </div>
                <div class="settings-card-body">
                    <form method="POST" action="{{ route('admin.settings.updatePassword') }}">
                        @csrf @method('PUT')

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" required>
                            @error('current_password') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" id="password" name="password" required>
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
