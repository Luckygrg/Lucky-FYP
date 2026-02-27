@extends('layouts.main')

@section('title', '{{ $user->name }} - Admin | SpaLush')

@section('content')

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    /* Sidebar */
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

    /* Main */
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }

    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        color: #c9a961; text-decoration: none; font-size: 14px;
        margin-bottom: 24px; transition: color 0.2s;
    }
    .back-link:hover { color: #b8985a; }

    .page-header { margin-bottom: 30px; }
    .page-header h1 {
        font-size: 28px; color: #1a1a1a; font-weight: 300;
        font-family: 'Georgia', serif; letter-spacing: 1px; margin-bottom: 6px;
    }
    .page-header p { color: #888; font-size: 14px; }

    .alert { padding: 14px 18px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid; }
    .alert-success { background: rgba(201,169,97,0.1); color: #8b7644; border-color: #c9a961; }
    .alert-error   { background: rgba(220,53,69,0.08); color: #842029; border-color: #dc3545; }

    /* Cards grid */
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } }

    .card {
        background: white; border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;
    }
    .card-header {
        padding: 18px 24px; border-bottom: 1px solid #f0f0f0;
        display: flex; justify-content: space-between; align-items: center;
    }
    .card-header h2 { font-size: 16px; font-weight: 500; color: #1a1a1a; }
    .card-body { padding: 24px; }

    .detail-row { display: flex; padding: 10px 0; border-bottom: 1px solid #f5f5f5; font-size: 14px; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { width: 140px; color: #888; flex-shrink: 0; }
    .detail-value { color: #1a1a1a; font-weight: 500; flex: 1; }

    /* Owner profile card */
    .owner-profile {
        display: flex; align-items: center; gap: 18px; margin-bottom: 24px;
    }
    .avatar-lg {
        width: 60px; height: 60px;
        background: linear-gradient(135deg, #c9a961, #b8985a);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        color: white; font-size: 24px; font-weight: 600; flex-shrink: 0;
    }
    .owner-meta .owner-name { font-size: 20px; font-weight: 500; color: #1a1a1a; }
    .owner-meta .owner-email { color: #888; font-size: 14px; margin-top: 4px; }

    /* Badge */
    .badge {
        display: inline-block; padding: 4px 12px; border-radius: 12px;
        font-size: 12px; font-weight: 600; text-transform: capitalize;
    }
    .badge-pending     { background: #fff3cd; color: #856404; }
    .badge-approved    { background: #d1e7dd; color: #0a5239; }
    .badge-disapproved { background: #f8d7da; color: #842029; }
    .badge-no-spa      { background: #e2e8f0; color: #64748b; }

    /* Spa status big section */
    .spa-status-section {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px; border-radius: 6px; margin-bottom: 20px;
    }
    .spa-status-section.pending     { background: #fffbeb; border: 1px solid #fde68a; }
    .spa-status-section.approved    { background: #f0fdf4; border: 1px solid #bbf7d0; }
    .spa-status-section.disapproved { background: #fff1f2; border: 1px solid #fecdd3; }
    .status-text { font-size: 14px; font-weight: 500; }
    .status-actions { display: flex; gap: 8px; }

    .btn {
        padding: 7px 16px; border-radius: 4px; font-size: 13px; font-weight: 500;
        text-decoration: none; cursor: pointer; border: none; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-approve    { background: #198754; color: white; }
    .btn-approve:hover { background: #157347; }
    .btn-disapprove { background: #dc3545; color: white; }
    .btn-disapprove:hover { background: #bb2d3b; }

    .tags-list { display: flex; flex-wrap: wrap; gap: 6px; }
    .tag-chip {
        background: #f1f5f9; color: #475569;
        padding: 3px 10px; border-radius: 12px; font-size: 12px;
    }

    .no-spa-card {
        text-align: center; padding: 50px 20px; color: #aaa;
    }
    .no-spa-card p { margin-top: 10px; font-size: 15px; }

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
        <a href="{{ route('admin.spa_owners') }}" class="menu-item active"><span>🏢</span> Spa Owners</a>
        <a href="#" class="menu-item"><span>👥</span> Customers</a>
        <a href="#" class="menu-item"><span>💆</span> Services</a>
        <a href="#" class="menu-item"><span>📈</span> System Activity</a>
        <a href="#" class="menu-item"><span>⚙️</span> Settings</a>
        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding: 0 30px;">
            @csrf
            <button type="submit" class="logout-btn"><span>🚪</span> Log Out</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <a href="{{ route('admin.spa_owners') }}" class="back-link">← Back to Spa Owners</a>

        <div class="page-header">
            <h1>{{ $user->name }}</h1>
            <p>Spa owner profile and spa details</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✕ {{ session('error') }}</div>
        @endif

        <div class="detail-grid">

            <!-- Owner Details Card -->
            <div class="card">
                <div class="card-header"><h2>👤 Owner Details</h2></div>
                <div class="card-body">
                    <div class="owner-profile">
                        <div class="avatar-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <div class="owner-meta">
                            <div class="owner-name">{{ $user->name }}</div>
                            <div class="owner-email">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Role</span>
                        <span class="detail-value">Spa Owner</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Joined</span>
                        <span class="detail-value">{{ $user->created_at->format('F d, Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Has Spa</span>
                        <span class="detail-value">
                            @if($user->spa)
                                <span style="color:#198754;">✓ Yes</span>
                            @else
                                <span style="color:#aaa;">No spa registered</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Spa Details Card -->
            <div class="card">
                <div class="card-header">
                    <h2>🏢 Spa Details</h2>
                    @if($user->spa)
                        <span class="badge badge-{{ $user->spa->status }}">
                            @if($user->spa->status === 'approved') ✓ Approved
                            @elseif($user->spa->status === 'disapproved') ✕ Disapproved
                            @else ⏳ Pending
                            @endif
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    @if($user->spa)
                        @php $spa = $user->spa; @endphp

                        <!-- Approval Actions -->
                        <div class="spa-status-section {{ $spa->status }}">
                            <span class="status-text">
                                @if($spa->status === 'approved')   ✓ This spa is currently approved
                                @elseif($spa->status === 'disapproved') ✕ This spa is disapproved
                                @else ⏳ This spa is awaiting approval
                                @endif
                            </span>
                            <div class="status-actions">
                                @if($spa->status !== 'approved')
                                    <form action="{{ route('admin.spa.approve', $spa) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-approve">✓ Approve</button>
                                    </form>
                                @endif
                                @if($spa->status !== 'disapproved')
                                    <form action="{{ route('admin.spa.disapprove', $spa) }}" method="POST"
                                          onsubmit="return confirm('Disapprove this spa?')">
                                        @csrf
                                        <button type="submit" class="btn btn-disapprove">✕ Disapprove</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Spa Name</span>
                            <span class="detail-value">{{ $spa->name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Location</span>
                            <span class="detail-value">{{ $spa->location }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">City</span>
                            <span class="detail-value">{{ $spa->city }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Price Range</span>
                            <span class="detail-value">{{ $spa->price_range }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Phone</span>
                            <span class="detail-value">{{ $spa->phone ?? '—' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email</span>
                            <span class="detail-value">{{ $spa->email ?? '—' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Rating</span>
                            <span class="detail-value">{{ $spa->rating }} ⭐ ({{ $spa->review_count }} reviews)</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Is Active</span>
                            <span class="detail-value">
                                @if($spa->is_active)
                                    <span style="color:#198754;">✓ Active</span>
                                @else
                                    <span style="color:#dc3545;">✕ Inactive</span>
                                @endif
                            </span>
                        </div>
                        @if($spa->tags && count($spa->tags))
                        <div class="detail-row">
                            <span class="detail-label">Tags</span>
                            <span class="detail-value">
                                <div class="tags-list">
                                    @foreach($spa->tags as $tag)
                                        <span class="tag-chip">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </span>
                        </div>
                        @endif
                        <div class="detail-row">
                            <span class="detail-label">Description</span>
                            <span class="detail-value" style="font-weight:normal; color:#555; line-height:1.6;">
                                {{ $spa->description }}
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Registered</span>
                            <span class="detail-value">{{ $spa->created_at->format('F d, Y') }}</span>
                        </div>
                    @else
                        <div class="no-spa-card">
                            <div style="font-size:36px;">🏢</div>
                            <p>This spa owner has not registered a spa yet.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
