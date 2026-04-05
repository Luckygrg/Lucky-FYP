@extends('layouts.main')
@section('title', 'Settings - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #FAF7F2; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: #1C1008; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .page-header p { color: rgba(28,16,8,0.6); font-size: 15px; margin-top: 8px; }
    .alert-success { background: rgba(200,145,106,0.1); color: #895D3E; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #C8916A; font-size: 14px; }
    .form-card { background: #FFFFFF; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); padding: 35px 40px; max-width: 600px; border: 1px solid rgba(200,145,106,0.15); }
    .section-title { font-size: 16px; font-weight: 600; color: #C8916A; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1px solid #f5f5f5; }
    .form-group { margin-bottom: 22px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: rgba(28,16,8,0.7); margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group input {
        width: 100%; padding: 11px 14px; border: 1px solid rgba(28,16,8,0.15); border-radius: 6px; font-size: 14px; color: rgba(28,16,8,0.9); transition: border-color 0.2s; background: #F5EEE4;
    }
    .form-group input:focus { outline: none; border-color: #C8916A; background: #F5EEE4; }
    .invalid-feedback { color: #e53935; font-size: 12px; margin-top: 4px; }
    .hint { color: #aaa; font-size: 12px; margin-top: 4px; }
    .avatar-row { display: flex; align-items: center; gap: 18px; margin-bottom: 25px; }
    .avatar { width: 110px; height: 110px; background: linear-gradient(135deg, #C8916A, #895D3E); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 44px; color: #1C1008; font-family: 'Georgia', serif; font-weight: bold; }
    .avatar-info strong { display: block; color: #1C1008; font-size: 16px; }
    .avatar-info span { color: rgba(28,16,8,0.6); font-size: 13px; }
    .btn-gold { padding: 12px 28px; background: #C8916A; color: #1C1008; border: none; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
    .btn-gold:hover { background: #AE7A55; transform: translateY(-1px); }
    .divider { border: none; border-top: 1px solid rgba(28,16,8,0.1); margin: 30px 0; }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <div class="page-header">
            <h1> Settings</h1>
            <p>Manage your account information</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="form-card">
            <!-- Avatar -->
            {{-- <div class="avatar-row" style="flex-direction:column;align-items:center;gap:10px;">
                <div>
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Avatar" class="avatar" style="object-fit:cover;width:64px;height:64px;border-radius:50%;border:2px solid #C8916A;" />
                    @else
                        <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    @endif
                </div>
                <label for="photo-upload" style="cursor:pointer;display:flex;flex-direction:column;align-items:center;margin-top:8px;">
                    <i class="fas fa-camera" style="font-size:22px;color:#C8916A;"></i>
                    <span style="font-size:12px;color:#C8916A;">Change Photo</span>
                    <input id="photo-upload" type="file" name="photo" accept="image/*" style="display:none;">
                </label>
                <div class="avatar-info" style="margin-top:10px;">
                    <strong>{{ $user->name }}</strong>
                    <span>{{ $user->email }}</span>
                </div>
            </div> --}}

            <form action="{{ route('spa_owner.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <p class="section-title">Profile</p>

                <!-- Avatar -->
    <div class="avatar-row" style="flex-direction:column;align-items:center;gap:10px;">
        <div>
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" class="avatar" style="width:110px;height:110px;object-fit:cover;border-radius:50%;border:2px solid #C8916A;" />
            @else
                <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            @endif
        </div>

        <label for="photo-upload" style="
            cursor:pointer;
            display:flex;
            flex-direction:row;
            align-items:center;
            justify-content:center;
            margin-top:10px;
            gap:10px;
            padding:10px 22px;
            background:#fff7f0;
            border:2px solid #C8916A;
            border-radius:30px;
            font-size:16px;
            font-family:'Georgia',serif;
            color:#C8916A;
            font-weight:600;
            letter-spacing:0.5px;
            transition:background 0.2s, color 0.2s, border 0.2s;
        "
        onmouseover="this.style.background='#C8916A';this.style.color='#fff';this.style.borderColor='#AE7A55';"
        onmouseout="this.style.background='#fff7f0';this.style.color='#C8916A';this.style.borderColor='#C8916A';"
        >
            <i class="fas fa-camera" style="font-size:22px;"></i>
            <span>Change Photo</span>
        </label>
        <div class="avatar-info" style="margin-top:10px;">
                    <strong>{{ $user->name }}</strong>
                    <span>{{ $user->email }}</span>
                </div>

        <!-- MOVE THIS HERE -->
        <input id="photo-upload" type="file" name="photo" accept="image/*" style="display:none;">
    </div>

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
