@extends('layouts.main')
@section('title', 'Customers - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #FAF7F2; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: #1C1008; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .page-header p { color: rgba(28,16,8,0.6); font-size: 15px; margin-top: 8px; }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: #FFFFFF;
        border: 1px solid rgba(200,145,106,0.15);
        border-radius: 10px;
        padding: 18px 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .summary-label {
        font-size: 12px;
        color: rgba(28,16,8,0.45);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 6px;
    }

    .summary-value {
        font-size: 30px;
        color: #C8916A;
        font-weight: 300;
        font-family: 'Georgia', serif;
        line-height: 1;
    }

    .table-card {
        background: #FFFFFF;
        border: 1px solid rgba(200,145,106,0.15);
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    table { width: 100%; border-collapse: collapse; }
    thead { background: #FAF7F2; }
    th, td { padding: 14px 18px; text-align: left; border-bottom: 1px solid rgba(28,16,8,0.08); }
    th { font-size: 12px; text-transform: uppercase; letter-spacing: 0.8px; color: rgba(28,16,8,0.45); }
    td { font-size: 14px; color: rgba(28,16,8,0.75); }
    tbody tr:hover { background: rgba(200,145,106,0.05); }
    tbody tr:last-child td { border-bottom: none; }

    .customer-name { color: #1C1008; font-weight: 600; }
    .empty-cell { text-align: center; padding: 60px 20px; color: rgba(28,16,8,0.35); }

    @media (max-width: 768px) {
        .main-content { padding: 20px; }
        .table-card { overflow-x: auto; }
        table { min-width: 760px; }
    }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <div class="page-header">
            <h1> Customers</h1>
            <p>View and manage your spa's customer records</p>
        </div>

        @php
            $totalCustomers = $customers->count();
            $totalBookings = $customers->sum('bookings_count');
            $totalRevenue = $customers->sum('total_spent');
        @endphp

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Customers</div>
                <div class="summary-value">{{ $totalCustomers }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Total Bookings</div>
                <div class="summary-value">{{ $totalBookings }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Estimated Revenue</div>
                <div class="summary-value">Rs. {{ number_format($totalRevenue, 0) }}</div>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total Bookings</th>
                        <th>Total Spent</th>
                        <th>Last Booking</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="customer-name">{{ $row->customer?->name ?? 'N/A' }}</td>
                            <td>{{ $row->customer?->email ?? 'N/A' }}</td>
                            <td>{{ $row->bookings_count }}</td>
                            <td>Rs. {{ number_format((float) $row->total_spent, 0) }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->last_booking_date)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-cell">No customer records found yet for {{ $spa ? $spa->name : 'your spa' }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
