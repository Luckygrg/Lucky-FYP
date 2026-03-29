@extends('layouts.main')
@section('title', 'Payments - SpaLush')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #1a1a1a; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }

    .page-header { margin-bottom: 32px; }
    .page-header h1 { font-size: 28px; color: white; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .page-header p { color: rgba(255,255,255,0.5); font-size: 14px; margin-top: 6px; }

    /* Stats */
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 36px; }
    .stat-card {
        background: #2a2a2a;
        border-radius: 10px;
        padding: 24px 28px;
        border: 1px solid rgba(201,169,97,0.15);
    }
    .stat-label { font-size: 12px; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
    .stat-value { font-size: 28px; color: #c9a961; font-weight: 300; font-family: 'Georgia', serif; }
    .stat-sub { font-size: 12px; color: rgba(255,255,255,0.35); margin-top: 4px; }

    /* Table */
    .table-card {
        background: #2a2a2a;
        border-radius: 10px;
        border: 1px solid rgba(201,169,97,0.15);
        overflow: hidden;
    }
    .table-card-header {
        padding: 20px 28px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .table-card-header h2 { font-size: 17px; color: white; font-weight: 400; font-family: 'Georgia', serif; }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 14px 20px;
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.4);
        background: rgba(255,255,255,0.03);
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    tbody tr { border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: rgba(201,169,97,0.04); }
    td { padding: 16px 20px; font-size: 14px; color: rgba(255,255,255,0.75); vertical-align: middle; }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-completed  { background: rgba(67,160,71,0.15);  color: #6fcf72; border: 1px solid rgba(67,160,71,0.3); }
    .badge-pending    { background: rgba(201,169,97,0.12); color: #c9a961; border: 1px solid rgba(201,169,97,0.3); }
    .badge-failed     { background: rgba(229,57,53,0.12);  color: #ef9a9a; border: 1px solid rgba(229,57,53,0.3); }
    .badge-esewa      { background: rgba(0,160,80,0.12);   color: #4caf6e; border: 1px solid rgba(0,160,80,0.25); }
    .badge-cash       { background: rgba(201,169,97,0.1);  color: #c9a961; border: 1px solid rgba(201,169,97,0.25); }

    .tx-id { font-size: 11px; color: rgba(255,255,255,0.35); font-family: monospace; }

    .empty-state {
        padding: 80px 40px;
        text-align: center;
        color: rgba(255,255,255,0.4);
    }
    .empty-state i { font-size: 48px; color: rgba(201,169,97,0.25); margin-bottom: 16px; display: block; }
    .empty-state p { font-size: 15px; }

    /* Filter tabs */
    .filter-tabs { display: flex; gap: 6px; }
    .filter-tab {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.5);
        transition: all 0.2s;
    }
    .filter-tab.active, .filter-tab:hover {
        background: rgba(201,169,97,0.15);
        border-color: rgba(201,169,97,0.4);
        color: #c9a961;
    }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">

        <div class="page-header">
            <h1><i class="fas fa-receipt" style="color:#c9a961;font-size:22px;margin-right:10px;"></i> Payments</h1>
            <p>All payment transactions for {{ $spa?->name ?? 'your spa' }}</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">Rs. {{ number_format($totalRevenue, 0) }}</div>
                <div class="stat-sub">from completed payments</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Completed</div>
                <div class="stat-value">{{ $totalPaid }}</div>
                <div class="stat-sub">successful transactions</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pending</div>
                <div class="stat-value">{{ $totalPending }}</div>
                <div class="stat-sub">awaiting confirmation</div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-card-header">
                <h2>Transaction History</h2>
                <div class="filter-tabs">
                    <button class="filter-tab active" onclick="filterPayments('all', this)">All</button>
                    <button class="filter-tab" onclick="filterPayments('completed', this)">Completed</button>
                    <button class="filter-tab" onclick="filterPayments('pending', this)">Pending</button>
                    <button class="filter-tab" onclick="filterPayments('failed', this)">Failed</button>
                </div>
            </div>

            @if($payments->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-receipt"></i>
                    <p>No payment records yet. Completed eSewa payments will appear here.</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Booking</th>
                            <th>Services</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Transaction ID</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $i => $payment)
                        <tr class="payment-row" data-status="{{ $payment->status }}">
                            <td style="color:rgba(255,255,255,0.3);font-size:12px;">{{ $i + 1 }}</td>

                            <td>
                                <div style="font-weight:600;color:white;">{{ $payment->user?->name ?? '—' }}</div>
                                @if($payment->booking?->phone)
                                    <div style="font-size:12px;color:rgba(255,255,255,0.35);margin-top:2px;">
                                        <i class="fas fa-phone" style="font-size:10px;"></i> {{ $payment->booking->phone }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                @if($payment->booking)
                                    <div>{{ \Carbon\Carbon::parse($payment->booking->booking_date)->format('d M Y') }}</div>
                                    <div style="font-size:12px;color:rgba(255,255,255,0.4);margin-top:2px;">
                                        {{ \Carbon\Carbon::parse($payment->booking->booking_time)->format('h:i A') }}
                                    </div>
                                @else
                                    <span style="color:rgba(255,255,255,0.3);">—</span>
                                @endif
                            </td>

                            <td>
                                @if($payment->booking?->bookingServices)
                                    <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                        @foreach($payment->booking->bookingServices as $bs)
                                            <span style="background:rgba(201,169,97,0.1);color:#c9a961;border:1px solid rgba(201,169,97,0.2);padding:2px 8px;border-radius:10px;font-size:11px;">
                                                {{ $bs->service_name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span style="color:rgba(255,255,255,0.3);">—</span>
                                @endif
                            </td>

                            <td>
                                <div style="font-size:16px;font-weight:600;color:#c9a961;">
                                    Rs. {{ number_format($payment->amount, 0) }}
                                </div>
                            </td>

                            <td>
                                @if($payment->method === 'esewa')
                                    <span class="badge badge-esewa"><i class="fas fa-mobile-alt"></i> eSewa</span>
                                @else
                                    <span class="badge badge-cash"><i class="fas fa-money-bill"></i> Cash</span>
                                @endif
                            </td>

                            <td>
                                @if($payment->status === 'completed')
                                    <span class="badge badge-completed"><i class="fas fa-check-circle"></i> Completed</span>
                                @elseif($payment->status === 'pending')
                                    <span class="badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
                                @else
                                    <span class="badge badge-failed"><i class="fas fa-times-circle"></i> Failed</span>
                                @endif
                            </td>

                            <td>
                                @if($payment->transaction_id)
                                    <span class="tx-id">{{ $payment->transaction_id }}</span>
                                @else
                                    <span style="color:rgba(255,255,255,0.2);">—</span>
                                @endif
                            </td>

                            <td>
                                @if($payment->paid_at)
                                    <div>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}</div>
                                    <div style="font-size:12px;color:rgba(255,255,255,0.35);margin-top:2px;">
                                        {{ \Carbon\Carbon::parse($payment->paid_at)->format('h:i A') }}
                                    </div>
                                @else
                                    <span style="color:rgba(255,255,255,0.2);">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</div>

<script>
function filterPayments(status, btn) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.payment-row').forEach(row => {
        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
    });
}
</script>
@endsection
