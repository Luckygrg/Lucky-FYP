@extends('layouts.main')

@section('title', 'Admin Dashboard - SpaLush')

@section('content')

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
        background: #FAF7F2;
        font-family: Arial, sans-serif;
    }

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
    .logo {
        font-size: 24px;
        font-weight: 300;
        color: #1C1008;
        margin: 0 30px 50px;
        letter-spacing: 3px;
        font-family: 'Georgia', serif;
    }
    .logo span { color: #C8916A; }
    .menu-item {
        padding: 15px 30px;
        margin-bottom: 5px;
        color: rgba(28,16,8,0.7);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s;
        font-size: 14px;
        letter-spacing: 0.5px;
    }
    .menu-item:hover { background: rgba(200,145,106,0.1); color: #C8916A; }
    .menu-item.active {
        background: rgba(200,145,106,0.15);
        color: #C8916A;
        border-left: 3px solid #C8916A;
    }
    .logout-btn {
        margin: auto 30px 0;
        padding: 12px 20px;
        border-radius: 4px;
        border: 1px solid rgba(28,16,8,0.2);
        background: transparent;
        color: rgba(28,16,8,0.7);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        font-size: 14px;
        letter-spacing: 0.5px;
        width: calc(100% - 60px);
    }
    .logout-btn:hover { background: #C8916A; border-color: #C8916A; color: #1C1008; }

    /* ── Main Content ── */
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .header { margin-bottom: 30px; }
    .header h1 {
        font-size: 32px;
        color: #1C1008;
        font-weight: 300;
        margin-bottom: 8px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    .header p { color: rgba(28,16,8,0.6); font-size: 15px; }

    /* ── Alert ── */
    .alert {
        padding: 14px 18px;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 14px;
        border-left: 4px solid;
    }
    .alert-success { background: rgba(200,145,106,0.1); color: #895D3E; border-color: #C8916A; }

    /* ── Stats Grid ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: #FFFFFF;
        padding: 24px 28px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        border: 1px solid rgba(200,145,106,0.15);
        border-left: 4px solid #C8916A;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(200,145,106,0.15); }
    .stat-card h3 {
        color: rgba(28,16,8,0.5);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }
    .stat-card .number {
        font-size: 36px;
        font-weight: 300;
        color: #C8916A;
        font-family: 'Georgia', serif;
        line-height: 1;
    }

    /* ── Chart Cards ── */
    .charts-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        margin-bottom: 16px;
    }
    .charts-section-header h2 {
        font-size: 17px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        letter-spacing: 0.5px;
        margin: 0;
    }
    .period-filter {
        display: flex;
        gap: 6px;
    }
    .period-btn {
        padding: 6px 16px;
        border-radius: 18px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid rgba(28,16,8,0.15);
        color: rgba(28,16,8,0.55);
        background: transparent;
        cursor: pointer;
        transition: all 0.2s;
        text-transform: capitalize;
    }
    .period-btn:hover { border-color: #C8916A; color: #C8916A; }
    .period-btn.active { background: #C8916A; border-color: #C8916A; color: #1C1008; }
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 30px;
        margin-bottom: 30px;
    }
    .chart-card {
        background: #FFFFFF;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        border: 1px solid rgba(200,145,106,0.15);
        overflow: hidden;
    }
    .chart-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid rgba(28,16,8,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .chart-card-header h2 {
        font-size: 17px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        letter-spacing: 0.5px;
    }
    .chart-card-header p {
        font-size: 12px;
        color: rgba(28,16,8,0.4);
        margin: 0;
    }
    .chart-card-body { padding: 24px; height: 280px; }

    /* ── Quick Actions Card ── */
    .actions-card {
        background: #FFFFFF;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        border: 1px solid rgba(200,145,106,0.15);
        overflow: hidden;
        margin-bottom: 0;
    }
    .actions-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid rgba(28,16,8,0.08);
    }
    .actions-card-header h2 {
        font-size: 17px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        letter-spacing: 0.5px;
    }
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        padding: 24px;
    }
    .action-btn {
        padding: 13px 18px;
        background: #C8916A;
        color: #1C1008;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
        transition: all 0.2s;
        font-weight: 500;
        font-size: 13px;
        letter-spacing: 0.4px;
    }
    .action-btn:hover { background: #AE7A55; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(200,145,106,0.3); }

    @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 900px)  { .charts-grid { grid-template-columns: 1fr; } .charts-section-header { flex-direction: column; gap: 10px; align-items: flex-start; } }
    @media (max-width: 768px) {
        .dashboard-container { flex-direction: column; }
        .sidebar { width: 100%; }
        .main-content { padding: 20px; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    /* ── Contact Messages Section ── */
    .messages-section { margin-top: 30px; margin-bottom: 30px; }
    .messages-card {
        background: #FFFFFF;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        border: 1px solid rgba(200,145,106,0.15);
        overflow: hidden;
    }
    .messages-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid rgba(28,16,8,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .messages-card-header h2 {
        font-size: 17px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        letter-spacing: 0.5px;
        margin: 0;
    }
    .unread-badge {
        background: #C8916A;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 12px;
        margin-left: 10px;
    }
    .msg-list { padding: 0; margin: 0; list-style: none; }
    .msg-item {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(28,16,8,0.06);
        display: flex;
        gap: 14px;
        align-items: flex-start;
        transition: background 0.2s;
    }
    .msg-item:last-child { border-bottom: none; }
    .msg-item:hover { background: rgba(200,145,106,0.04); }
    .msg-item.unread { background: rgba(200,145,106,0.06); }
    .msg-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(200,145,106,0.15);
        color: #C8916A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }
    .msg-content { flex: 1; min-width: 0; }
    .msg-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
    .msg-name { font-weight: 600; font-size: 14px; color: #1C1008; }
    .msg-time { font-size: 12px; color: rgba(28,16,8,0.35); }
    .msg-subject { font-size: 13px; color: #555; margin-bottom: 2px; }
    .msg-preview { font-size: 12px; color: rgba(28,16,8,0.4); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .msg-empty { padding: 40px; text-align: center; color: rgba(28,16,8,0.3); font-size: 14px; }
</style>

<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">SPA<span>LUSH</span></div>

        <a href="{{ route('admin.admin') }}" class="menu-item active">Dashboard</a>
        <a href="{{ route('admin.spa_owners') }}" class="menu-item">Spa Owners</a>
        <a href="{{ route('admin.services') }}" class="menu-item">Services</a>
        <a href="{{ route('admin.categories.index') }}" class="menu-item">Spa Categories</a>
        <a href="{{ route('admin.settings') }}" class="menu-item">Settings</a>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding: 0 30px;">
            @csrf
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <p>Welcome back, {{ Auth::user()->name }} — here's what's happening on SpaLush.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Stats -->
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
        <div class="actions-card">
            <div class="actions-card-header">
                <h2>Quick Actions</h2>
            </div>
            <div class="actions-grid">
                <a href="{{ route('admin.spa_owners') }}" class="action-btn">Manage Spa Owners</a>
                <a href="{{ route('admin.services') }}" class="action-btn">Manage Services</a>
                <a href="{{ route('admin.categories.index') }}" class="action-btn">Manage Spa Categories</a>
                <a href="{{ route('admin.settings') }}" class="action-btn">Settings</a>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-section-header">
            <h2>Analytics</h2>
            <div class="period-filter">
                <button class="period-btn" data-period="daily" onclick="switchPeriod('daily', this)">Daily</button>
                <button class="period-btn" data-period="weekly" onclick="switchPeriod('weekly', this)">Weekly</button>
                <button class="period-btn active" data-period="monthly" onclick="switchPeriod('monthly', this)">Monthly</button>
            </div>
        </div>
        <div class="charts-grid">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h2>Bookings per Spa</h2>
                    <p id="spaPeriodLabel">Top spa by month</p>
                </div>
                <div class="chart-card-body">
                    @if(empty($spaChart['labels']))
                        <div style="text-align:center;padding:40px 0;color:rgba(28,16,8,0.3);font-size:14px;">No booking data yet</div>
                    @else
                        <canvas id="spaChart"></canvas>
                    @endif
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-card-header">
                    <h2>Most Used Categories</h2>
                    <p id="categoryPeriodLabel">Top category by month</p>
                </div>
                <div class="chart-card-body">
                    @if(empty($categoryChart['labels']))
                        <div style="text-align:center;padding:40px 0;color:rgba(28,16,8,0.3);font-size:14px;">No category data yet</div>
                    @else
                        <canvas id="categoryChart"></canvas>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Messages -->
        <div class="messages-section">
            <div class="messages-card">
                <div class="messages-card-header">
                    <h2>Recent Contact Messages @if($unreadCount > 0)<span class="unread-badge">{{ $unreadCount }} new</span>@endif</h2>
                </div>
                @if($recentMessages->isEmpty())
                    <div class="msg-empty">No contact messages yet</div>
                @else
                    <ul class="msg-list">
                        @foreach($recentMessages as $msg)
                            <li class="msg-item {{ !$msg->is_read ? 'unread' : '' }}">
                                <div class="msg-avatar">{{ strtoupper(substr($msg->name, 0, 1)) }}</div>
                                <div class="msg-content">
                                    <div class="msg-top">
                                        <span class="msg-name">{{ $msg->name }}</span>
                                        <span class="msg-time">{{ $msg->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="msg-subject">{{ $msg->subject }}</div>
                                    <div class="msg-preview">{{ Str::limit($msg->message, 80) }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const palette = ['#C8916A','#AE7A55','#D4A882','#8B5E3C','#E6C4A8','#7A4F2D','#BF8A6A','#9E6B45','#5C3A1E','#F0DDD0'];
    const chartUrl = @json(route('admin.admin.chartData'));
    const periodLabels = {
        daily: {
            spa: 'Top spa by day',
            category: 'Top category by day'
        },
        weekly: {
            spa: 'Top spa by week',
            category: 'Top category by week'
        },
        monthly: {
            spa: 'Top spa by month',
            category: 'Top category by month'
        }
    };
    const spaPeriodLabel = document.getElementById('spaPeriodLabel');
    const categoryPeriodLabel = document.getElementById('categoryPeriodLabel');

    function updatePeriodLabels(period) {
        const labels = periodLabels[period] ?? periodLabels.monthly;
        spaPeriodLabel.textContent = labels.spa;
        categoryPeriodLabel.textContent = labels.category;
    }

    function buildDisplayLabels(labels, names) {
        return labels.map((label, index) => {
            const name = names[index];
            return name ? [label, name] : [label];
        });
    }

    // Top Spa trend chart
    const spaCtx = document.getElementById('spaChart');
    let spaNames = {!! json_encode($spaChart['names']) !!};
    let spaDisplayLabels = buildDisplayLabels({!! json_encode($spaChart['labels']) !!}, spaNames);
    let spaChart = spaCtx ? new Chart(spaCtx, {
        type: 'line',
        data: {
            labels: spaDisplayLabels,
            datasets: [{
                label: 'Bookings',
                data: {!! json_encode($spaChart['data']) !!},
                borderColor: palette[0],
                backgroundColor: 'rgba(200,145,106,0.16)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: palette[0],
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 2.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: ctx => {
                            const label = ctx[0]?.label;
                            return Array.isArray(label) ? label.join(' - ') : (label ?? '');
                        },
                        label: ctx => {
                            const name = spaNames[ctx.dataIndex];
                            return name ? `${name}: ${ctx.parsed.y} bookings` : `${ctx.parsed.y} bookings`;
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, color: 'rgba(28,16,8,0.45)' }, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { ticks: { color: 'rgba(28,16,8,0.55)' }, grid: { display: false } }
            }
        }
    }) : null;

    // Top Category bar chart
    const catCtx = document.getElementById('categoryChart');
    let categoryNames = {!! json_encode($categoryChart['names']) !!};
    let categoryDisplayLabels = buildDisplayLabels({!! json_encode($categoryChart['labels']) !!}, categoryNames);
    let categoryChart = catCtx ? new Chart(catCtx, {
        type: 'bar',
        data: {
            labels: categoryDisplayLabels,
            datasets: [{
                label: 'Bookings',
                data: {!! json_encode($categoryChart['data']) !!},
                backgroundColor: palette[1],
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: ctx => {
                            const label = ctx[0]?.label;
                            return Array.isArray(label) ? label.join(' - ') : (label ?? '');
                        },
                        label: ctx => {
                            const name = categoryNames[ctx.dataIndex];
                            return name ? `${name}: ${ctx.parsed.y} bookings` : `${ctx.parsed.y} bookings`;
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, color: 'rgba(28,16,8,0.45)' }, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { ticks: { color: 'rgba(28,16,8,0.55)', font: { size: 11 } }, grid: { display: false } }
            }
        }
    }) : null;

    function switchPeriod(period, btn) {
        document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        updatePeriodLabels(period);

        fetch(`${chartUrl}?period=${period}`)
            .then(r => r.json())
            .then(data => {
                if (spaChart) {
                    spaNames = data.spaNames;
                    spaDisplayLabels = buildDisplayLabels(data.spaLabels, spaNames);
                    spaChart.data.labels = spaDisplayLabels;
                    spaChart.data.datasets[0].data = data.spaData;
                    spaChart.update();
                }
                if (categoryChart) {
                    categoryNames = data.categoryNames;
                    categoryDisplayLabels = buildDisplayLabels(data.categoryLabels, categoryNames);
                    categoryChart.data.labels = categoryDisplayLabels;
                    categoryChart.data.datasets[0].data = data.categoryData;
                    categoryChart.data.datasets[0].backgroundColor = palette[1];
                    categoryChart.update();
                }
            });
    }
</script>

@endsection
