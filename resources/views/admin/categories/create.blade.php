@extends('layouts.main')

@section('title', 'Add Category - Admin | SpaLush')

@section('content')

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-container {
        display: flex; min-height: 100vh; background: #1a1a1a; font-family: Arial, sans-serif;
    }

    /* ── Sidebar ── */
    .sidebar {
        width: 260px; background: #1a1a1a; padding: 30px 0;
        display: flex; flex-direction: column;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1); flex-shrink: 0;
    }
    .logo { font-size: 24px; font-weight: 300; color: white; margin: 0 30px 50px; letter-spacing: 3px; font-family: 'Georgia', serif; text-decoration: none; display: block; }
    .logo span { color: #c9a961; }
    .menu-item {
        padding: 15px 30px; margin-bottom: 5px; color: rgba(255,255,255,0.7);
        text-decoration: none; display: flex; align-items: center; gap: 12px;
        transition: all 0.3s; font-size: 14px; letter-spacing: 0.5px;
    }
    .menu-item:hover { background: rgba(201,169,97,0.1); color: #c9a961; }
    .menu-item.active { background: rgba(201,169,97,0.15); color: #c9a961; border-left: 3px solid #c9a961; }
    .logout-btn {
        margin: auto 30px 0; padding: 12px 20px; border-radius: 4px;
        border: 1px solid rgba(255,255,255,0.2); background: transparent;
        color: rgba(255,255,255,0.7); cursor: pointer; display: flex;
        align-items: center; gap: 10px; transition: all 0.3s; font-size: 14px; width: calc(100% - 60px);
    }
    .logout-btn:hover { background: #c9a961; border-color: #c9a961; color: white; }

    /* ── Main Content ── */
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }

    .page-header { margin-bottom: 30px; }
    .page-header h1 {
        font-size: 32px; color: white; font-weight: 300;
        font-family: 'Georgia', serif; letter-spacing: 1px; margin-bottom: 6px;
    }
    .page-header p { color: rgba(255,255,255,0.6); font-size: 15px; }

    /* ── Form Card ── */
    .form-card {
        background: #2a2a2a; border-radius: 8px; padding: 36px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        border: 1px solid rgba(201,169,97,0.15);
        max-width: 620px;
    }

    .form-group { margin-bottom: 22px; }
    .form-group label { display: block; font-size: 13px; color: rgba(255,255,255,0.6); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.6px; }
    .form-control {
        width: 100%; padding: 11px 14px; background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.15); border-radius: 5px;
        color: white; font-size: 14px; transition: border-color 0.2s;
    }
    .form-control:focus { outline: none; border-color: #c9a961; }
    textarea.form-control { resize: vertical; min-height: 90px; }

    .toggle-label {
        display: flex; align-items: center; gap: 10px;
        cursor: pointer; font-size: 14px; color: rgba(255,255,255,0.75);
    }
    .toggle-label input[type="checkbox"] { width: 16px; height: 16px; accent-color: #c9a961; cursor: pointer; }

    .invalid-feedback { color: #f8a0a5; font-size: 12.5px; margin-top: 5px; }

    .form-actions { display: flex; gap: 12px; margin-top: 10px; }
    .btn-gold {
        background: #c9a961; color: #1a1a1a; border: none;
        padding: 11px 26px; border-radius: 6px; font-size: 14px;
        font-weight: 600; cursor: pointer; transition: background 0.2s;
    }
    .btn-gold:hover { background: #b8985a; }
    .btn-cancel {
        background: transparent; color: rgba(255,255,255,0.6);
        border: 1px solid rgba(255,255,255,0.2); padding: 11px 22px;
        border-radius: 6px; font-size: 14px; text-decoration: none;
        transition: all 0.2s;
    }
    .btn-cancel:hover { border-color: #c9a961; color: #c9a961; }

    @media (max-width: 768px) {
        .dashboard-container { flex-direction: column; }
        .sidebar { width: 100%; }
        .main-content { padding: 20px; }
    }
</style>

<div class="dashboard-container">
    <div class="sidebar">
        <a href="{{ route('admin.admin') }}" class="logo">SPA<span>LUSH</span></a>

        <a href="{{ route('admin.admin') }}" class="menu-item">Dashboard</a>
        <a href="{{ route('admin.spa_owners') }}" class="menu-item">Spa Owners</a>
        <a href="{{ route('admin.services') }}" class="menu-item">Services</a>
        <a href="{{ route('admin.categories.index') }}" class="menu-item active">Spa Categories</a>
        <a href="#" class="menu-item">System Activity</a>
        <a href="#" class="menu-item">Settings</a>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding: 0 30px;">
            @csrf
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>

    <div class="main-content">
        <div class="page-header">
            <h1>Add Category</h1>
            <p>Create a new spa service category.</p>
        </div>

        <div class="form-card">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Category Name <span style="color:#c9a961;">*</span></label>
                    <input type="text" id="name" name="name" class="form-control"
                           value="{{ old('name') }}" placeholder="e.g. Massage, Facial, Yoga" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-gold">Create Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
