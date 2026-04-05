@extends('layouts.main')
@section('title', 'Bookings - SpaLush')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #FAF7F2; }
    .dashboard-container { display: flex; min-height: 100vh; background: #FAF7F2; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }

    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: #1C1008; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .page-header p { color: rgba(28,16,8,0.6); font-size: 15px; margin-top: 8px; }

    .alert-success {
        background: rgba(67,160,71,0.12); color: #6fcf72;
        border: 1px solid rgba(67,160,71,0.3); border-radius: 8px;
        padding: 12px 18px; margin-bottom: 24px; font-size: 14px;
    }

    .alert-warning {
        background: rgba(251,192,45,0.15); color: #9b6a00;
        border: 1px solid rgba(251,192,45,0.35); border-radius: 8px;
        padding: 12px 18px; margin-bottom: 24px; font-size: 14px;
    }

    /* Stats row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: #FFFFFF;
        border-radius: 10px;
        border: 1px solid rgba(28,16,8,0.07);
        padding: 20px;
        text-align: center;
    }

    .stat-card .stat-num {
        font-size: 30px;
        font-weight: 700;
        color: #C8916A;
        margin-bottom: 4px;
    }

    .stat-card .stat-label {
        font-size: 12px;
        color: rgba(28,16,8,0.45);
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    /* Filter tabs */
    .filter-tabs {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .filter-tab {
        padding: 7px 20px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid rgba(28,16,8,0.15);
        color: rgba(28,16,8,0.6);
        background: transparent;
        cursor: pointer;
        transition: all 0.2s;
        text-transform: capitalize;
    }

    .filter-tab:hover { border-color: #C8916A; color: #C8916A; }
    .filter-tab.active { background: #C8916A; border-color: #C8916A; color: #1C1008; }

    /* Booking table */
    .bookings-table-wrap {
        background: #FFFFFF;
        border-radius: 12px;
        border: 1px solid rgba(200,145,106,0.12);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    thead th {
        padding: 14px 18px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: rgba(28,16,8,0.45);
        border-bottom: 1px solid rgba(28,16,8,0.07);
        background: rgba(28,16,8,0.02);
    }

    tbody tr {
        border-bottom: 1px solid rgba(28,16,8,0.05);
        transition: background 0.15s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: rgba(28,16,8,0.03); }

    tbody td {
        padding: 14px 18px;
        color: rgba(28,16,8,0.8);
        vertical-align: middle;
    }

    .customer-name { font-weight: 600; color: #1C1008; }
    .customer-phone { font-size: 12px; color: rgba(28,16,8,0.45); margin-top: 2px; }

    .svc-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .svc-tag {
        background: rgba(200,145,106,0.1);
        color: #C8916A;
        font-size: 11px;
        padding: 3px 9px;
        border-radius: 10px;
        white-space: nowrap;
    }

    .price-cell { color: #C8916A; font-weight: 700; }

    .status-badge {
        padding: 4px 12px;
        border-radius: 14px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .status-pending   { background: rgba(200,145,106,0.15); color: #C8916A; }
    .status-confirmed { background: rgba(67,160,71,0.15);  color: #6fcf72; }
    .status-completed { background: rgba(100,181,246,0.15); color: #90caf9; }
    .status-cancelled { background: rgba(229,57,53,0.12);  color: #ef9a9a; }

    .action-form { display: inline; }

    .action-btn {
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        margin-right: 4px;
    }

    .btn-confirm  { background: rgba(67,160,71,0.2);   color: #6fcf72; border: 1px solid rgba(67,160,71,0.3); }
    .btn-complete { background: rgba(100,181,246,0.2); color: #90caf9; border: 1px solid rgba(100,181,246,0.3); }
    .btn-cancel   { background: rgba(229,57,53,0.12);  color: #ef9a9a; border: 1px solid rgba(229,57,53,0.3); }

    .btn-confirm:hover  { background: rgba(67,160,71,0.4); }
    .btn-complete:hover { background: rgba(100,181,246,0.35); }
    .btn-cancel:hover   { background: rgba(229,57,53,0.25); }

    .empty-row td {
        text-align: center;
        padding: 60px 20px;
        color: rgba(28,16,8,0.3);
        font-size: 15px;
    }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-calendar-check" style="color:#C8916A;"></i> Bookings</h1>
            <p>Manage customer appointments for {{ $spa->name }}</p>
        </div>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @if(session('warning'))
            <div class="alert-warning"><i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}</div>
        @endif

        @php
            $counts = [
                'all'       => $bookings->count(),
                'pending'   => $bookings->where('status','pending')->count(),
                'confirmed' => $bookings->where('status','confirmed')->count(),
                'completed' => $bookings->where('status','completed')->count(),
                'cancelled' => $bookings->where('status','cancelled')->count(),
            ];
            $totalRevenue = $bookings->where('status','completed')->sum('total_price');
        @endphp

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-num">{{ $counts['all'] }}</div>
                <div class="stat-label">Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#C8916A;">{{ $counts['pending'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#6fcf72;">{{ $counts['confirmed'] }}</div>
                <div class="stat-label">Confirmed</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#90caf9;">{{ $counts['completed'] }}</div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-num">Rs. {{ number_format($totalRevenue, 0) }}</div>
                <div class="stat-label">Revenue</div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="filter-tabs">
            @foreach(['all','pending','confirmed','completed','cancelled'] as $tab)
                <button class="filter-tab {{ $tab === 'all' ? 'active' : '' }}"
                        onclick="filterBookings('{{ $tab }}', this)">
                    {{ ucfirst($tab) }} ({{ $counts[$tab] }})
                </button>
            @endforeach
        </div>

        {{-- Bookings Table --}}
        <div class="bookings-table-wrap">
            <table id="bookingsTable">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Date & Time</th>
                        <th>Services</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr data-status="{{ $booking->status }}">
                            <td>
                                <div class="customer-name">{{ $booking->customer->name }}</div>
                                <div class="customer-phone"><i class="fas fa-phone" style="font-size:10px;color:#C8916A;"></i> {{ $booking->phone }}</div>
                            </td>
                            <td>
                                <div>{{ $booking->booking_date->format('d M Y') }}</div>
                                <div style="color:rgba(28,16,8,0.45);font-size:12px;">
                                    {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                                </div>
                            </td>
                            <td>
                                <div class="svc-tags">
                                    @foreach($booking->bookingServices as $bs)
                                        <span class="svc-tag">{{ $bs->service_name }}</span>
                                    @endforeach
                                </div>
                                <div style="font-size:11px;color:rgba(28,16,8,0.35);margin-top:4px;">
                                    {{ $booking->total_duration_minutes }} min total
                                </div>
                            </td>
                            <td>
                                <div class="price-cell">Rs. {{ number_format($booking->total_price, 0) }}</div>
                                @if($booking->payment_status === 'paid')
                                    <div style="font-size:11px;color:#6fcf72;margin-top:3px;"><i class="fas fa-check-circle"></i> Paid via eSewa</div>
                                @elseif(!$booking->payment_choice_made)
                                    <div style="font-size:11px;color:rgba(28,16,8,0.45);margin-top:3px;"><i class="fas fa-hourglass-half"></i> Awaiting customer payment choice</div>
                                @elseif($booking->payment_option === 'pay_now')
                                    <div style="font-size:11px;color:#6fcf72;margin-top:3px;"><i class="fas fa-credit-card"></i> Pay via eSewa</div>
                                @else
                                    <div style="font-size:11px;color:#C8916A;margin-top:3px;"><i class="fas fa-hand-holding-usd"></i> Pay at Spa</div>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                @if($booking->status === 'pending')
                                    <form class="action-form" method="POST"
                                          action="{{ route('spa_owner.bookings.status', $booking) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="action-btn btn-confirm">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                    </form>
                                    <form class="action-form" method="POST"
                                          action="{{ route('spa_owner.bookings.status', $booking) }}"
                                          onsubmit="return confirm('Cancel this booking?')">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="action-btn btn-cancel">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </form>
                                @elseif($booking->status === 'confirmed')
                                    <form class="action-form" method="POST"
                                          action="{{ route('spa_owner.bookings.status', $booking) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="action-btn btn-complete">
                                            <i class="fas fa-flag-checkered"></i> Complete
                                        </button>
                                    </form>
                                @else
                                    <span style="color:rgba(28,16,8,0.25);font-size:12px;">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="6">
                                <i class="fas fa-calendar-times" style="font-size:32px;margin-bottom:10px;display:block;color:rgba(200,145,106,0.3);"></i>
                                No bookings yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function filterBookings(status, btn) {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('#bookingsTable tbody tr[data-status]').forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

@endsection
