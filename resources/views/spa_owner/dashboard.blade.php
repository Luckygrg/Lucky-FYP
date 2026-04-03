@extends('layouts.main')

@section('title', 'Spa Owner Dashboard - SpaLush')

@section('content')

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-container { display: flex; min-height: 100vh; background: #FAF7F2; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }

    .header { margin-bottom: 30px; }
    .header h1 { font-size: 28px; color: #1C1008; font-weight: 300; margin-bottom: 6px; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .header p { color: rgba(28,16,8,0.6); font-size: 14px; }

    .alert-success { background: rgba(200,145,106,0.1); color: #895D3E; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #C8916A; font-size: 14px; }

    /* Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: #FFFFFF;
        padding: 24px 28px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        border: 1px solid rgba(200,145,106,0.15);
        border-left: 4px solid #C8916A;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(200,145,106,0.15); }
    .stat-card h3 { color: rgba(28,16,8,0.5); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
    .stat-card .number { font-size: 34px; font-weight: 300; color: #C8916A; font-family: 'Georgia', serif; line-height: 1; }

    /* Card (shared) */
    .card {
        background: #FFFFFF;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        overflow: hidden;
        border: 1px solid rgba(200,145,106,0.15);
        margin-bottom: 25px;
    }
    .card-header {
        padding: 18px 24px;
        border-bottom: 1px solid rgba(28,16,8,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-header h2 { font-size: 17px; font-weight: 300; color: #1C1008; font-family: 'Georgia', serif; letter-spacing: 0.5px; margin: 0; }
    .card-header p { font-size: 12px; color: rgba(28,16,8,0.4); margin: 0; }

    /* Quick Actions */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        padding: 20px 24px;
    }
    .action-btn {
        padding: 11px 16px;
        background: #C8916A;
        color: #1C1008;
        text-decoration: none;
        border-radius: 6px;
        text-align: center;
        transition: all 0.2s;
        font-weight: 500;
        font-size: 13px;
        letter-spacing: 0.3px;
    }
    .action-btn:hover { background: #AE7A55; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(200,145,106,0.3); }

    /* Chart */
    .chart-body { padding: 20px 24px; height: 260px; }

    /* Table */
    table { width: 100%; border-collapse: collapse; }
    thead { background: #FAF7F2; }
    th, td { padding: 14px 18px; text-align: left; border-bottom: 1px solid rgba(28,16,8,0.08); }
    th { font-weight: 500; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: rgba(28,16,8,0.5); }
    td { color: rgba(28,16,8,0.7); font-size: 14px; }
    tbody tr:hover { background: rgba(200,145,106,0.05); }
    tbody tr:last-child td { border-bottom: none; }

    @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .dashboard-container { flex-direction: column; }
        .main-content { padding: 20px; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <div class="header">
            <h1>Welcome, {{ Auth::user()->name }}</h1>
            <p>Manage your spa business and track your performance</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <!-- Stats -->
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
        <div class="card">
            <div class="card-header">
                <h2>Quick Actions</h2>
            </div>
            <div class="actions-grid">
                @if(!$spa)
                    <a href="{{ route('spa_owner.spas.create') }}" class="action-btn">Add Your Spa</a>
                @else
                    <a href="{{ route('spas.show', $spa) }}" class="action-btn">View My Spa</a>
                    <a href="{{ route('spa_owner.spa.edit') }}" class="action-btn">Edit My Spa</a>
                @endif
                <a href="{{ route('spa_owner.services.create') }}" class="action-btn">Add New Service</a>
                <a href="{{ route('spa_owner.services') }}" class="action-btn">Manage Services</a>
                <a href="{{ route('spa_owner.bookings') }}" class="action-btn">View All Bookings</a>
                <a href="{{ route('spa_owner.payments') }}" class="action-btn">View Payments</a>
                <a href="{{ route('spa_owner.customers') }}" class="action-btn">View Customers</a>
            </div>
        </div>

        <!-- Most Booked Services Chart -->
        @if($topServices->isNotEmpty())
        <div class="card">
            <div class="card-header">
                <h2>Most Booked Services</h2>
                <p>Top services booked at your spa</p>
            </div>
            <div class="chart-body">
                <canvas id="servicesChart"></canvas>
            </div>
        </div>
        @endif

        <!-- Recent Customers -->
        <div class="card">
            <div class="card-header">
                <h2>Recent Customer Records</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
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
                        <td style="color:#aaa;font-size:12px;">C{{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $row->customer?->name ?? '—' }}</td>
                        <td>{{ $row->customer?->email ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->last_booking)->format('d M Y') }}</td>
                        <td>{{ $row->total_bookings }}</td>
                        <td><a href="{{ route('spa_owner.bookings') }}" style="color:#C8916A;text-decoration:none;font-size:13px;">View Bookings</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:rgba(28,16,8,0.35);padding:40px;">No customer records yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@if($topServices->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const palette = ['#C8916A','#AE7A55','#D4A882','#8B5E3C','#E6C4A8','#7A4F2D','#BF8A6A','#9E6B45'];

    new Chart(document.getElementById('servicesChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topServices->pluck('service_name')) !!},
            datasets: [{
                label: 'Times Booked',
                data: {!! json_encode($topServices->pluck('total')) !!},
                backgroundColor: palette,
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.x} bookings` } }
            },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1, color: 'rgba(28,16,8,0.45)' }, grid: { color: 'rgba(0,0,0,0.05)' } },
                y: { ticks: { color: 'rgba(28,16,8,0.65)', font: { size: 13 } }, grid: { display: false } }
            }
        }
    });
</script>
@endif

@endsection
