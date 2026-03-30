@extends('layouts.main')

@section('title', 'Spa Categories - Admin | SpaLush')

@section('content')

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
        background: #1a1a1a;
        font-family: Arial, sans-serif;
    }

    /* ── Sidebar ── */
    .sidebar {
        width: 260px;
        background: #1a1a1a;
        padding: 30px 0;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        flex-shrink: 0;
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

    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-header h1 {
        font-size: 32px; color: white; font-weight: 300;
        font-family: 'Georgia', serif; letter-spacing: 1px; margin-bottom: 6px;
    }
    .page-header p { color: rgba(255,255,255,0.6); font-size: 15px; }

    .btn-gold {
        background: #c9a961; color: #1a1a1a; border: none;
        padding: 11px 22px; border-radius: 6px; font-size: 14px;
        font-weight: 600; cursor: pointer; text-decoration: none;
        transition: background 0.2s;
    }
    .btn-gold:hover { background: #b8985a; }

    /* ── Alert ── */
    .alert {
        padding: 14px 18px; border-radius: 6px; margin-bottom: 24px;
        font-size: 14px; font-weight: 500;
    }
    .alert-success { background: #d1e7dd; color: #0a5239; }
    .alert-error   { background: #f8d7da; color: #842029; }

    /* ── Summary Bar ── */
    .summary-bar { display: flex; gap: 16px; margin-bottom: 28px; flex-wrap: wrap; }
    .summary-pill {
        background: #2a2a2a; border-radius: 8px; padding: 16px 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2); border-left: 4px solid #c9a961; min-width: 140px;
    }
    .summary-pill .label { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; }
    .summary-pill .value { font-size: 28px; font-weight: 300; color: #c9a961; font-family: 'Georgia', serif; }

    /* ── Table Card ── */
    .table-card {
        background: #2a2a2a; border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        border: 1px solid rgba(201,169,97,0.15);
        overflow: hidden;
    }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #111111; padding: 13px 18px;
        text-align: left; font-size: 11px; font-weight: 600;
        color: rgba(255,255,255,0.5); text-transform: uppercase;
        letter-spacing: 0.8px; border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    tbody tr { border-bottom: 1px solid rgba(255,255,255,0.06); transition: background 0.15s; }
    tbody tr:hover { background: rgba(201,169,97,0.05); }
    tbody tr:last-child { border-bottom: none; }
    td { padding: 14px 18px; font-size: 13.5px; color: rgba(255,255,255,0.7); vertical-align: middle; }

    .cat-name { font-weight: 500; color: white; }
    .cat-slug { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 3px; font-family: monospace; }
    .cat-desc { font-size: 12.5px; color: rgba(255,255,255,0.5); max-width: 340px; }

    .badge { display: inline-block; padding: 3px 11px; border-radius: 10px; font-size: 11px; font-weight: 600; }
    .badge-active   { background: #d1e7dd; color: #0a5239; }
    .badge-inactive { background: #f8d7da; color: #842029; }

    .action-btns { display: flex; gap: 8px; }
    .btn-edit {
        padding: 6px 14px; border-radius: 5px; font-size: 12px; font-weight: 600;
        background: rgba(201,169,97,0.15); color: #c9a961;
        border: 1px solid rgba(201,169,97,0.35); text-decoration: none;
        transition: all 0.2s;
    }
    .btn-edit:hover { background: #c9a961; color: #1a1a1a; }
    .btn-delete {
        padding: 6px 14px; border-radius: 5px; font-size: 12px; font-weight: 600;
        background: rgba(220,53,69,0.12); color: #dc3545;
        border: 1px solid rgba(220,53,69,0.3); cursor: pointer;
        transition: all 0.2s;
    }
    .btn-delete:hover { background: #dc3545; color: white; }

    .empty-state {
        padding: 70px 20px; text-align: center; color: rgba(255,255,255,0.35); font-size: 15px;
    }

    @media (max-width: 768px) {
        .dashboard-container { flex-direction: column; }
        .sidebar { width: 100%; }
        .main-content { padding: 20px; }
    }
</style>

<div class="dashboard-container">
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <div>
                <h1>Spa Categories</h1>
                <p>Manage all spa service categories on the platform.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn-gold">+ Add Category</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Summary -->
        <div class="summary-bar">
            <div class="summary-pill">
                <div class="label">Total Categories</div>
                <div class="value">{{ $categories->count() }}</div>
            </div>
        
        </div>

        <div class="table-card">
            @if($categories->isEmpty())
                <div class="empty-state">No categories found. Add one to get started.</div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
        
          
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $i => $category)
                    <tr>
                        <td style="color:#bbb; font-size:12px;">{{ $i + 1 }}</td>
                        <td>
                            <div class="cat-name">{{ $category->name }}</div>
                
                        </td>
                    
    
                        <td style="font-size:12.5px; color:rgba(255,255,255,0.5);">
                            {{ $category->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Delete this category? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>

@endsection
