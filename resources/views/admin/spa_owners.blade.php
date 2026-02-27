@extends('layouts.main')

@section('title', 'Spa Owners - Admin | SpaLush')

@section('content')

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
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
    .logo {
        font-size: 24px;
        font-weight: 300;
        color: white;
        margin: 0 30px 50px;
        letter-spacing: 3px;
        font-family: 'Georgia', serif;
    }
    .logo span { color: #c9a961; }
    .menu-item {
        padding: 15px 30px;
        margin-bottom: 5px;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s;
        font-size: 14px;
        letter-spacing: 0.5px;
    }
    .menu-item:hover { background: rgba(201,169,97,0.1); color: #c9a961; }
    .menu-item.active {
        background: rgba(201,169,97,0.15);
        color: #c9a961;
        border-left: 3px solid #c9a961;
    }
    .logout-btn {
        margin: auto 30px 0;
        padding: 12px 20px;
        border-radius: 4px;
        border: 1px solid rgba(255,255,255,0.2);
        background: transparent;
        color: rgba(255,255,255,0.7);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        font-size: 14px;
        letter-spacing: 0.5px;
        width: calc(100% - 60px);
    }
    .logout-btn:hover { background: #c9a961; border-color: #c9a961; color: white; }

    /* ── Main Content ── */
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .header { margin-bottom: 30px; }
    .header h1 {
        font-size: 32px;
        color: #1a1a1a;
        font-weight: 300;
        margin-bottom: 8px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    .header p { color: #666; font-size: 15px; }

    /* ── Alert Messages ── */
    .alert {
        padding: 14px 18px;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 14px;
        border-left: 4px solid;
    }
    .alert-success { background: rgba(201,169,97,0.1); color: #8b7644; border-color: #c9a961; }
    .alert-error   { background: rgba(220,53,69,0.08); color: #842029; border-color: #dc3545; }

    /* ── Filter Bar ── */
    .filter-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .filter-btn {
        padding: 8px 18px;
        border: 1px solid #ddd;
        border-radius: 20px;
        background: white;
        color: #555;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .filter-btn:hover, .filter-btn.active {
        background: #c9a961;
        border-color: #c9a961;
        color: white;
    }

    /* ── Table Card ── */
    .table-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .table-card-header {
        padding: 20px 25px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .table-card-header h2 {
        font-size: 18px;
        font-weight: 300;
        color: #1a1a1a;
        font-family: 'Georgia', serif;
        letter-spacing: 0.5px;
    }
    .badge-count {
        background: #c9a961;
        color: white;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8f9fa;
        padding: 14px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-bottom: 1px solid #eee;
    }
    tbody tr { border-bottom: 1px solid #f5f5f5; transition: background 0.15s; }
    tbody tr:hover { background: #fafafa; }
    tbody tr:last-child { border-bottom: none; }
    td { padding: 16px; font-size: 14px; color: #333; vertical-align: middle; }

    .owner-info { display: flex; align-items: center; gap: 12px; }
    .avatar {
        width: 38px; height: 38px;
        background: linear-gradient(135deg, #c9a961, #b8985a);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 15px; font-weight: 600; flex-shrink: 0;
    }
    .owner-name { font-weight: 500; color: #1a1a1a; }
    .owner-email { font-size: 12px; color: #888; margin-top: 2px; }

    .spa-name { font-weight: 500; color: #1a1a1a; }
    .no-spa { color: #aaa; font-style: italic; font-size: 13px; }

    /* Status badges */
    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.3px;
    }
    .badge-pending      { background: #fff3cd; color: #856404; }
    .badge-approved     { background: #d1e7dd; color: #0a5239; }
    .badge-disapproved  { background: #f8d7da; color: #842029; }
    .badge-no-spa       { background: #e2e8f0; color: #64748b; }

    /* Action buttons */
    .actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .btn {
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.3px;
    }
    .btn-view     { background: #1a1a1a; color: white; }
    .btn-view:hover { background: #333; }
    .btn-approve  { background: #198754; color: white; }
    .btn-approve:hover { background: #157347; }
    .btn-disapprove { background: #dc3545; color: white; }
    .btn-disapprove:hover { background: #bb2d3b; }

    .joined-date { color: #888; font-size: 13px; }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #aaa;
    }
    .empty-state p { font-size: 15px; margin-top: 10px; }

    @media (max-width: 768px) {
        .dashboard-container { flex-direction: column; }
        .sidebar { width: 100%; }
        .main-content { padding: 20px; }
        table { display: block; overflow-x: auto; }
    }
</style>

<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">SPA<span>LUSH</span></div>

        <a href="{{ route('admin.admin') }}" class="menu-item">
            <span>📊</span> Dashboard
        </a>
        <a href="{{ route('admin.spa_owners') }}" class="menu-item active">
            <span>🏢</span> Spa Owners
        </a>
        <a href="#" class="menu-item">
            <span>👥</span> Customers
        </a>
        <a href="#" class="menu-item">
            <span>💆</span> Services
        </a>
        <a href="#" class="menu-item">
            <span>📈</span> System Activity
        </a>
        <a href="#" class="menu-item">
            <span>⚙️</span> Settings
        </a>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding: 0 30px;">
            @csrf
            <button type="submit" class="logout-btn"><span>🚪</span> Log Out</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Spa Owners</h1>
            <p>Manage spa owner accounts and approve or disapprove their spas.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✕ {{ session('error') }}</div>
        @endif

        <!-- Filter Tabs -->
        @php
            $filter = request('filter', 'all');
        @endphp
        <div class="filter-bar">
            <a href="{{ route('admin.spa_owners') }}"
               class="filter-btn {{ $filter === 'all' ? 'active' : '' }}">
                All ({{ $spaOwners->count() }})
            </a>
            <a href="{{ route('admin.spa_owners', ['filter' => 'pending']) }}"
               class="filter-btn {{ $filter === 'pending' ? 'active' : '' }}">
                Pending ({{ $spaOwners->filter(fn($u) => $u->spa && $u->spa->status === 'pending')->count() }})
            </a>
            <a href="{{ route('admin.spa_owners', ['filter' => 'approved']) }}"
               class="filter-btn {{ $filter === 'approved' ? 'active' : '' }}">
                Approved ({{ $spaOwners->filter(fn($u) => $u->spa && $u->spa->status === 'approved')->count() }})
            </a>
            <a href="{{ route('admin.spa_owners', ['filter' => 'disapproved']) }}"
               class="filter-btn {{ $filter === 'disapproved' ? 'active' : '' }}">
                Disapproved ({{ $spaOwners->filter(fn($u) => $u->spa && $u->spa->status === 'disapproved')->count() }})
            </a>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-card-header">
                <h2>Spa Owner Accounts</h2>
                <span class="badge-count">{{ $spaOwners->count() }} Total</span>
            </div>

            @php
                $filtered = $spaOwners;
                if ($filter === 'pending')     $filtered = $spaOwners->filter(fn($u) => $u->spa && $u->spa->status === 'pending');
                if ($filter === 'approved')    $filtered = $spaOwners->filter(fn($u) => $u->spa && $u->spa->status === 'approved');
                if ($filter === 'disapproved') $filtered = $spaOwners->filter(fn($u) => $u->spa && $u->spa->status === 'disapproved');
            @endphp

            @if($filtered->isEmpty())
                <div class="empty-state">
                    <div style="font-size:40px;">🏢</div>
                    <p>No spa owners found for this filter.</p>
                </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Owner</th>
                        <th>Spa Name</th>
                        <th>City</th>
                        <th>Spa Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($filtered as $index => $owner)
                    <tr>
                        <td style="color:#aaa; font-size:13px;">{{ $index + 1 }}</td>

                        <td>
                            <div class="owner-info">
                                <div class="avatar">{{ strtoupper(substr($owner->name, 0, 1)) }}</div>
                                <div>
                                    <div class="owner-name">{{ $owner->name }}</div>
                                    <div class="owner-email">{{ $owner->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            @if($owner->spa)
                                <span class="spa-name">{{ $owner->spa->name }}</span>
                            @else
                                <span class="no-spa">No spa yet</span>
                            @endif
                        </td>

                        <td>
                            @if($owner->spa)
                                {{ $owner->spa->city }}
                            @else
                                <span style="color:#aaa;">—</span>
                            @endif
                        </td>

                        <td>
                            @if($owner->spa)
                                @if($owner->spa->status === 'approved')
                                    <span class="badge badge-approved">✓ Approved</span>
                                @elseif($owner->spa->status === 'disapproved')
                                    <span class="badge badge-disapproved">✕ Disapproved</span>
                                @else
                                    <span class="badge badge-pending">⏳ Pending</span>
                                @endif
                            @else
                                <span class="badge badge-no-spa">No Spa</span>
                            @endif
                        </td>

                        <td class="joined-date">{{ $owner->created_at->format('M d, Y') }}</td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.spa_owner_show', $owner) }}" class="btn btn-view">
                                    👁 View
                                </a>

                                @if($owner->spa)
                                    @if($owner->spa->status !== 'approved')
                                        <form action="{{ route('admin.spa.approve', $owner->spa) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-approve">✓ Approve</button>
                                        </form>
                                    @endif

                                    @if($owner->spa->status !== 'disapproved')
                                        <form action="{{ route('admin.spa.disapprove', $owner->spa) }}" method="POST" style="display:inline;"
                                              onsubmit="return confirm('Disapprove this spa?')">
                                            @csrf
                                            <button type="submit" class="btn btn-disapprove">✕ Disapprove</button>
                                        </form>
                                    @endif
                                @endif
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
