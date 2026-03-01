@extends('layouts.main')

@section('title', 'Admin Dashboard - SpaLush')

@section('content')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    .dashboard-container {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    
    .sidebar {
        width: 260px;
        background: #1a1a1a;
        padding: 30px 0;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }
    
    .logo {
        font-size: 24px;
        font-weight: 300;
        color: white;
        margin: 0 30px 50px;
        letter-spacing: 3px;
        font-family: 'Georgia', serif;
    }
    
    .logo span {
        color: #c9a961;
    }
    
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
    
    .menu-item:hover {
        background: rgba(201, 169, 97, 0.1);
        color: #c9a961;
    }
    
    .menu-item.active {
        background: rgba(201, 169, 97, 0.15);
        color: #c9a961;
        border-left: 3px solid #c9a961;
    }
    
    .logout-btn {
        margin-top: auto;
        margin-left: 30px;
        margin-right: 30px;
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
    }
    
    .logout-btn:hover {
        background: #c9a961;
        border-color: #c9a961;
        color: white;
    }
    
    .main-content {
        flex: 1;
        padding: 40px;
        overflow-y: auto;
    }
    
    .header {
        margin-bottom: 40px;
    }
    
    .header h1 {
        font-size: 32px;
        color: #1a1a1a;
        font-weight: 300;
        margin-bottom: 10px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .header p {
        color: #666;
        font-size: 15px;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .stat-card {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid #c9a961;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(201, 169, 97, 0.15);
    }
    
    .stat-card h3 {
        color: #666;
        font-size: 13px;
        font-weight: normal;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .stat-card .number {
        font-size: 36px;
        font-weight: 300;
        color: #c9a961;
        font-family: 'Georgia', serif;
    }
    
    .quick-actions {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 40px;
    }
    
    .quick-actions h2 {
        color: #1a1a1a;
        margin-bottom: 25px;
        font-size: 20px;
        font-weight: 300;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .action-btn {
        padding: 15px 20px;
        background: #c9a961;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
        transition: all 0.3s;
        font-weight: 500;
        font-size: 14px;
        letter-spacing: 0.5px;
    }
    
    .action-btn:hover {
        background: #b8985a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(201, 169, 97, 0.3);
    }
    
    .admin-features {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .admin-features h2 {
        color: #1a1a1a;
        margin-bottom: 25px;
        font-size: 20px;
        font-weight: 300;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .admin-features ul {
        list-style: none;
        padding: 0;
    }
    
    .admin-features li {
        color: #666;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
        line-height: 1.6;
    }
    
    .admin-features li:last-child {
        border-bottom: none;
    }
    
    .success-message {
        background: rgba(201, 169, 97, 0.1);
        color: #8b7644;
        padding: 15px 20px;
        border-radius: 4px;
        margin-bottom: 25px;
        border-left: 4px solid #c9a961;
        font-size: 14px;
    }
    
    @media (max-width: 768px) {
        .dashboard-container {
            flex-direction: column;
        }
        
        .sidebar {
            width: 100%;
        }
        
        .main-content {
            padding: 20px;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">SPA<span>LUSH</span></div>
        
        <a href="{{ route('admin.admin') }}" class="menu-item active">
            <span>📊</span> Dashboard
        </a>
        <a href="{{ route('admin.spa_owners') }}" class="menu-item">
            <span>🏢</span> Spa Owners
        </a>
        <a href="{{ route('admin.services') }}" class="menu-item">
            <span>💆</span> Services
        </a>
        <a href="#" class="menu-item">
            <span>📈</span> System Activity
        </a>
        <a href="#" class="menu-item">
            <span>⚙️</span> Settings
        </a>
        
        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
            @csrf
            <button type="submit" class="logout-btn">
                <span>🚪</span> Log Out
            </button>
        </form>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <p>Welcome, {{ Auth::user()->name }} - System Administrator</p>
        </div>
        
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Spa Owners</h3>
                <div class="number">{{ $totalSpaOwners }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Customers</h3>
                <div class="number">{{ $totalCustomers }}</div>
            </div>
            <div class="stat-card">
                <h3>Approved Spas</h3>
                <div class="number">{{ $totalSpas }}</div>
            </div>
            <div class="stat-card">
                <h3>Pending Approvals</h3>
                <div class="number">{{ $pendingSpas }}</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="actions-grid">
                <a href="{{ route('admin.spa_owners') }}" class="action-btn">🏢 Manage Spa Owners</a>
                <a href="{{ route('admin.services') }}" class="action-btn">💆 Manage Services</a>
                <a href="#" class="action-btn">📈 View System Activity</a>
                <a href="#" class="action-btn">⚙️ Settings</a>
            </div>
        </div>
        
        <!-- Admin Features -->
        <div class="admin-features">
            <h2>Administrator Capabilities</h2>
            <ul>
                <li>✓ Login to admin panel with secure authentication</li>
                <li>✓ Manage spa owners (view, approve, suspend accounts)</li>
                <li>✓ Manage all services across the platform</li>
                <li>✓ Monitor system activity and access logs</li>
                <li>✓ View platform statistics and generate reports</li>
                <li>✓ System configuration and global settings management</li>
            </ul>
        </div>
    </div>
</div>

@endsection
