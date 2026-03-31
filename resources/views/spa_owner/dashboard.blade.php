@extends('layouts.main')

@section('title', 'Spa Owner Dashboard - SpaLush')

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
        background: #FAF7F2;
        font-family: Arial, sans-serif;
    }
    
    /* sidebar styles live in the partial */
    
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
        color: #1C1008;
        font-weight: 300;
        margin-bottom: 10px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .header p {
        color: rgba(28,16,8,0.6);
        font-size: 15px;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .stat-card {
        background: #FFFFFF;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        border-left: 4px solid #C8916A;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(200, 145, 106, 0.15);
    }
    
    .stat-card h3 {
        color: rgba(28,16,8,0.6);
        font-size: 13px;
        font-weight: normal;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .stat-card .number {
        font-size: 36px;
        font-weight: 300;
        color: #C8916A;
        font-family: 'Georgia', serif;
    }
    
    .quick-actions {
        background: #FFFFFF;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        margin-bottom: 40px;
    }
    
    .quick-actions h2 {
        color: #1C1008;
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
        background: #C8916A;
        color: #1C1008;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
        transition: all 0.3s;
        font-weight: 500;
        font-size: 14px;
        letter-spacing: 0.5px;
    }
    
    .action-btn:hover {
        background: #AE7A55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(200, 145, 106, 0.3);
    }
    
    .customer-list {
        background: #FFFFFF;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    
    .customer-list h2 {
        color: #1C1008;
        margin-bottom: 25px;
        font-size: 20px;
        font-weight: 300;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    thead {
        background: #FAF7F2;
        color: #1C1008;
    }
    
    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid rgba(28,16,8,0.1);
    }
    
    th {
        font-weight: 500;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    td {
        color: rgba(28,16,8,0.7);
        font-size: 14px;
    }
    
    tbody tr:hover {
        background: rgba(200,145,106,0.05);
    }
    
    .success-message {
        background: rgba(200, 145, 106, 0.1);
        color: #895D3E;
        padding: 15px 20px;
        border-radius: 4px;
        margin-bottom: 25px;
        border-left: 4px solid #C8916A;
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
    @include('spa_owner.partials.sidebar')
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Welcome, {{ Auth::user()->name }}</h1>
            <p>Manage your spa business and track your performance</p>
        </div>
        
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Services</h3>
                <div class="number">{{ $servicesCount }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Bookings</h3>
                <div class="number">{{ $bookingsCount }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Customers</h3>
                <div class="number">{{ $customersCount }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Earning</h3>
                <div class="number">Rs. {{ number_format($totalEarning, 0) }}</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="actions-grid">
                @if(!$spa)
                    <a href="{{ route('spa_owner.spas.create') }}" class="action-btn"> Add Your Spa</a>
                @else
                    <a href="{{ route('spas.show', $spa) }}" class="action-btn"> View My Spa</a>
                    <a href="{{ route('spa_owner.spa.edit') }}" class="action-btn"> Edit My Spa</a>
                @endif
                <a href="{{ route('spa_owner.services.create') }}" class="action-btn"> Add New Service</a>
                <a href="{{ route('spa_owner.services') }}" class="action-btn"> Manage Services</a>
                <a href="{{ route('spa_owner.bookings') }}" class="action-btn"> View All Bookings</a>
                <a href="{{ route('spa_owner.payments') }}" class="action-btn"> View Payments</a>
                <a href="{{ route('spa_owner.customers') }}" class="action-btn"> View Customers</a>
            </div>
        </div>
        
        <!-- Customer List -->
        <div class="customer-list">
            <h2>Recent Customer Records</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Last Booking</th>
                            <th>Total Bookings</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCustomers as $i => $row)
                        <tr>
                            <td style="color:rgba(28,16,8,0.4);font-size:12px;">C{{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $row->customer?->name ?? '—' }}</td>
                            <td>{{ $row->customer?->email ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->last_booking)->format('d M Y') }}</td>
                            <td>{{ $row->total_bookings }}</td>
                            <td>
                                <a href="{{ route('spa_owner.bookings') }}" style="color:#C8916A;text-decoration:none;">View Bookings</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center;color:rgba(28,16,8,0.35);padding:30px;">No customer records yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
