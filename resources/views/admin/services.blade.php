@extends('layouts.main')

@section('title', 'Services - Admin | SpaLush')

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
    .logo { font-size: 24px; font-weight: 300; color: white; margin: 0 30px 50px; letter-spacing: 3px; font-family: 'Georgia', serif; }
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
        font-size: 32px; color: #1a1a1a; font-weight: 300;
        font-family: 'Georgia', serif; letter-spacing: 1px; margin-bottom: 8px;
    }
    .page-header p { color: #888; font-size: 15px; }

    /* ── Summary Bar ── */
    .summary-bar {
        display: flex; gap: 16px; margin-bottom: 30px; flex-wrap: wrap;
    }
    .summary-pill {
        background: white;
        border-radius: 8px;
        padding: 16px 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        border-left: 4px solid #c9a961;
        min-width: 150px;
    }
    .summary-pill .label { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; }
    .summary-pill .value { font-size: 28px; font-weight: 300; color: #c9a961; font-family: 'Georgia', serif; }

    /* ── Spa Block ── */
    .spa-block {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 28px;
        overflow: hidden;
    }

    .spa-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        gap: 16px;
        flex-wrap: wrap;
    }
    .spa-header-left { display: flex; align-items: center; gap: 14px; }
    .spa-avatar {
        width: 46px; height: 46px;
        background: linear-gradient(135deg, #c9a961, #b8985a);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;
    }
    .spa-info .spa-name { font-size: 17px; font-weight: 500; color: white; }
    .spa-info .spa-meta {
        font-size: 12px; color: rgba(255,255,255,0.55); margin-top: 3px;
        display: flex; gap: 14px; flex-wrap: wrap;
    }
    .spa-info .spa-meta span::before { content: '• '; }
    .spa-info .spa-meta span:first-child::before { content: ''; }

    .spa-header-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
    .service-count-badge {
        background: rgba(201,169,97,0.2);
        color: #c9a961;
        border: 1px solid rgba(201,169,97,0.4);
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    /* ── Services Table ── */
    .services-table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8f9fa;
        padding: 12px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-bottom: 1px solid #eee;
    }
    tbody tr { border-bottom: 1px solid #f5f5f5; transition: background 0.15s; }
    tbody tr:hover { background: #fafafa; }
    tbody tr:last-child { border-bottom: none; }
    td { padding: 14px 16px; font-size: 13.5px; color: #333; vertical-align: middle; }

    .service-name { font-weight: 500; color: #1a1a1a; }
    .service-desc { font-size: 12px; color: #888; margin-top: 3px; line-height: 1.5; }

    .category-chip {
        background: #f1f5f9;
        color: #475569;
        padding: 3px 10px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 500;
    }

    .price { font-weight: 600; color: #1a1a1a; }
    .duration { color: #666; font-size: 13px; }

    .badge {
        display: inline-block; padding: 3px 10px; border-radius: 10px;
        font-size: 11px; font-weight: 600;
    }
    .badge-available   { background: #d1e7dd; color: #0a5239; }
    .badge-unavailable { background: #f8d7da; color: #842029; }

    /* No services */
    .no-services {
        text-align: center;
        padding: 30px 20px;
        color: #bbb;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    /* Empty state (no spas) */
    .empty-state {
        background: white; border-radius: 8px; padding: 70px 20px;
        text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        color: #aaa;
    }
    .empty-state p { margin-top: 12px; font-size: 15px; }

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

        <a href="{{ route('admin.admin') }}" class="menu-item"><span>📊</span> Dashboard</a>
        <a href="{{ route('admin.spa_owners') }}" class="menu-item"><span>🏢</span> Spa Owners</a>
        <a href="{{ route('admin.services') }}" class="menu-item active"><span>💆</span> Services</a>
        <a href="#" class="menu-item"><span>📈</span> System Activity</a>
        <a href="#" class="menu-item"><span>⚙️</span> Settings</a>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding: 0 30px;">
            @csrf
            <button type="submit" class="logout-btn"><span>🚪</span> Log Out</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1>Services</h1>
            <p>View all services offered by approved spas on the platform.</p>
        </div>

        @php
            $totalServices = $spas->sum(fn($s) => $s->services->count());
        @endphp

        <!-- Summary Bar -->
        <div class="summary-bar">
            <div class="summary-pill">
                <div class="label">Approved Spas</div>
                <div class="value">{{ $spas->count() }}</div>
            </div>
            <div class="summary-pill">
                <div class="label">Total Services</div>
                <div class="value">{{ $totalServices }}</div>
            </div>
        </div>

        @if($spas->isEmpty())
            <div class="empty-state">
                <div style="font-size:40px;">💆</div>
                <p>No approved spas yet. Approve a spa to see their services here.</p>
            </div>
        @else
            @foreach($spas as $spa)
            <div class="spa-block">
                <!-- Spa Header -->
                <div class="spa-header">
                    <div class="spa-header-left">
                        <div class="spa-avatar">{{ strtoupper(substr($spa->name, 0, 1)) }}</div>
                        <div class="spa-info">
                            <div class="spa-name">{{ $spa->name }}</div>
                            <div class="spa-meta">
                                <span>{{ $spa->city }}</span>
                                <span>{{ $spa->location }}</span>
                                <span>{{ $spa->price_range }}</span>
                                @if($spa->phone)<span>{{ $spa->phone }}</span>@endif
                            </div>
                        </div>
                    </div>
                    <div class="spa-header-right">
                        <span class="service-count-badge">
                            {{ $spa->services->count() }} {{ Str::plural('Service', $spa->services->count()) }}
                        </span>
                    </div>
                </div>

                <!-- Services Table -->
                @if($spa->services->isEmpty())
                    <div class="no-services">
                        <span>📋</span> This spa has not added any services yet.
                    </div>
                @else
                <div class="services-table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service</th>
                                <th>Category</th>
                                <th>Duration</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($spa->services as $i => $service)
                            <tr>
                                <td style="color:#bbb; font-size:12px;">{{ $i + 1 }}</td>
                                <td>
                                    <div class="service-name">{{ $service->name }}</div>
                                    @if($service->description)
                                        <div class="service-desc">{{ Str::limit($service->description, 80) }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($service->category)
                                        <span class="category-chip">{{ $service->category }}</span>
                                    @else
                                        <span style="color:#ccc;">—</span>
                                    @endif
                                </td>
                                <td class="duration">
                                    @if($service->duration_minutes)
                                        {{ $service->duration_minutes }} min
                                    @else
                                        <span style="color:#ccc;">—</span>
                                    @endif
                                </td>
                                <td class="price">
                                    @if($service->price)
                                        ${{ number_format($service->price, 2) }}
                                    @else
                                        <span style="color:#ccc;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service->is_available)
                                        <span class="badge badge-available">✓ Available</span>
                                    @else
                                        <span class="badge badge-unavailable">✕ Unavailable</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            @endforeach
        @endif
    </div>
</div>

@endsection
