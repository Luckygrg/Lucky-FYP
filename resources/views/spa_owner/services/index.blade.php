@extends('layouts.main')
@section('title', 'My Services - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #f8f9fa; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-header h1 { font-size: 28px; color: #1a1a1a; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .btn-gold { padding: 11px 24px; background: #c9a961; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 7px; }
    .btn-gold:hover { background: #b8985a; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(201,169,97,0.3); }
    .alert-success { background: rgba(201,169,97,0.1); color: #8b7644; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #c9a961; font-size: 14px; }
    .alert-error { background: #fce4ec; color: #c62828; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #e53935; font-size: 14px; }
    .no-spa { background: white; border-radius: 10px; padding: 60px 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
    .no-spa p { color: #999; margin-bottom: 20px; font-size: 15px; }
    .card { background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #1a1a1a; color: white; }
    th, td { padding: 14px 18px; text-align: left; border-bottom: 1px solid #f0f0f0; }
    th { font-weight: 500; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
    td { color: #555; font-size: 14px; }
    tbody tr:hover { background: #fafafa; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; }
    .badge-green { background: #e8f5e9; color: #2e7d32; }
    .badge-gray { background: #f0f0f0; color: #888; }
    .action-links a { color: #c9a961; text-decoration: none; font-size: 13px; margin-right: 12px; }
    .action-links a:hover { color: #b8985a; text-decoration: underline; }
    .action-links form { display: inline; }
    .btn-del { background: none; border: none; color: #e53935; font-size: 13px; cursor: pointer; padding: 0; }
    .btn-del:hover { text-decoration: underline; }
    .empty-row td { text-align: center; color: #bbb; padding: 40px; }
    .category-chip { background: #f5f5f5; color: #666; padding: 3px 10px; border-radius: 10px; font-size: 12px; }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <div class="page-header">
            <h1>💆 Services</h1>
            @if($spa)
                <a href="{{ route('spa_owner.services.create') }}" class="btn-gold">➕ Add New Service</a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if(!$spa)
            <div class="no-spa">
                <p>You need to register a spa before adding services.</p>
                <a href="{{ route('spa_owner.spas.create') }}" class="btn-gold">➕ Create Your Spa First</a>
            </div>
        @else
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Category</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $i => $service)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $service->name }}</strong>
                                    @if($service->description)
                                        <br><small style="color:#aaa;">{{ Str::limit($service->description, 60) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($service->category)
                                        <span class="category-chip">{{ $service->category }}</span>
                                    @else
                                        <span style="color:#ccc;">—</span>
                                    @endif
                                </td>
                                <td>{{ $service->duration_minutes ? $service->duration_minutes . ' min' : '—' }}</td>
                                <td>{{ $service->price ? '$' . number_format($service->price, 2) : '—' }}</td>
                                <td>
                                    <span class="badge {{ $service->is_available ? 'badge-green' : 'badge-gray' }}">
                                        {{ $service->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </td>
                                <td class="action-links">
                                    <a href="{{ route('spa_owner.services.edit', $service) }}">Edit</a>
                                    <form action="{{ route('spa_owner.services.destroy', $service) }}" method="POST"
                                          onsubmit="return confirm('Delete this service?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-del">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="7">No services yet. <a href="{{ route('spa_owner.services.create') }}" style="color:#c9a961;">Add your first service →</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
