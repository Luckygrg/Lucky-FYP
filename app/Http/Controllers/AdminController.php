<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\ContactMessage;
use App\Models\Spa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function chartBuckets(string $period = 'monthly'): array
    {
        if ($period === 'daily') {
            return [
                'startDate' => now()->subDays(13)->toDateString(),
                'expression' => "DATE(bookings.booking_date)",
                'buckets' => collect(range(13, 0))->map(function ($i) {
                    $date = now()->subDays($i);

                    return [
                        'key' => $date->toDateString(),
                        'label' => $date->format('d M'),
                    ];
                }),
            ];
        }

        if ($period === 'weekly') {
            return [
                'startDate' => now()->subWeeks(7)->startOfWeek()->toDateString(),
                'expression' => "DATE_FORMAT(bookings.booking_date, '%x-%v')",
                'buckets' => collect(range(7, 0))->map(function ($i) {
                    $weekStart = now()->subWeeks($i)->startOfWeek();

                    return [
                        'key' => $weekStart->format('o') . '-' . $weekStart->format('W'),
                        'label' => $weekStart->format('d M'),
                    ];
                }),
            ];
        }

        return [
            'startDate' => now()->subMonths(5)->startOfMonth()->toDateString(),
            'expression' => "DATE_FORMAT(bookings.booking_date, '%Y-%m')",
            'buckets' => collect(range(5, 0))->map(function ($i) {
                $month = now()->subMonths($i);

                return [
                    'key' => $month->format('Y-m'),
                    'label' => $month->format('M Y'),
                ];
            }),
        ];
    }

    private function topSpaChartData(string $period = 'monthly'): array
    {
        $bucketMeta = $this->chartBuckets($period);

        $rows = Booking::query()
            ->join('spas', 'bookings.spa_id', '=', 'spas.id')
            ->where('bookings.booking_date', '>=', $bucketMeta['startDate'])
            ->selectRaw("{$bucketMeta['expression']} as bucket_key, spas.name as entity_name, count(*) as total")
            ->groupBy('bucket_key', 'spas.name')
            ->orderBy('bucket_key')
            ->orderByDesc('total')
            ->orderBy('spas.name')
            ->get();

        if ($rows->isEmpty()) {
            return [
                'labels' => [],
                'data' => [],
                'names' => [],
            ];
        }

        $topByBucket = [];
        foreach ($rows as $row) {
            if (! isset($topByBucket[$row->bucket_key]) || $row->total > $topByBucket[$row->bucket_key]['total']) {
                $topByBucket[$row->bucket_key] = [
                    'name' => $row->entity_name,
                    'total' => (int) $row->total,
                ];
            }
        }

        $labels = [];
        $data = [];
        $names = [];
        foreach ($bucketMeta['buckets'] as $bucket) {
            $labels[] = $bucket['label'];
            $names[] = $topByBucket[$bucket['key']]['name'] ?? 'No bookings';
            $data[] = $topByBucket[$bucket['key']]['total'] ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'names' => $names,
        ];
    }

    private function topCategoryChartData(string $period = 'monthly'): array
    {
        $bucketMeta = $this->chartBuckets($period);

        $rows = BookingService::query()
            ->join('services', 'booking_services.service_id', '=', 'services.id')
            ->join('spa_categories', 'services.spa_category_id', '=', 'spa_categories.id')
            ->join('bookings', 'booking_services.booking_id', '=', 'bookings.id')
            ->where('bookings.booking_date', '>=', $bucketMeta['startDate'])
            ->selectRaw("{$bucketMeta['expression']} as bucket_key, spa_categories.name as entity_name, count(*) as total")
            ->groupBy('bucket_key', 'spa_categories.name')
            ->orderBy('bucket_key')
            ->orderByDesc('total')
            ->orderBy('spa_categories.name')
            ->get();

        if ($rows->isEmpty()) {
            return [
                'labels' => [],
                'data' => [],
                'names' => [],
            ];
        }

        $topByBucket = [];
        foreach ($rows as $row) {
            if (! isset($topByBucket[$row->bucket_key]) || $row->total > $topByBucket[$row->bucket_key]['total']) {
                $topByBucket[$row->bucket_key] = [
                    'name' => $row->entity_name,
                    'total' => (int) $row->total,
                ];
            }
        }

        $labels = [];
        $data = [];
        $names = [];
        foreach ($bucketMeta['buckets'] as $bucket) {
            $labels[] = $bucket['label'];
            $names[] = $topByBucket[$bucket['key']]['name'] ?? 'No bookings';
            $data[] = $topByBucket[$bucket['key']]['total'] ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'names' => $names,
        ];
    }

    /**
     * Show admin dashboard with real stats
     */
    public function dashboard()
    {
        $totalSpaOwners  = User::where('role', 'spa_owner')->count();
        $totalCustomers  = User::where('role', 'customer')->count();
        $totalSpas       = Spa::where('status', 'approved')->count();
        $pendingSpas     = Spa::where('status', 'pending')->count();

        $spaChart = $this->topSpaChartData('monthly');
        $categoryChart = $this->topCategoryChartData('monthly');

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $unreadCount    = ContactMessage::where('is_read', false)->count();

        return view('admin.dashboard', compact(
            'totalSpaOwners',
            'totalCustomers',
            'totalSpas',
            'pendingSpas',
            'spaChart',
            'categoryChart',
            'recentMessages',
            'unreadCount'
        ));
    }

    /**
     * Chart data for admin dashboard (AJAX)
     */
    public function chartData(Request $request)
    {
        $period = $request->query('period', 'monthly');

        $spaChart = $this->topSpaChartData($period);
        $categoryChart = $this->topCategoryChartData($period);

        return response()->json([
            'spaLabels'      => $spaChart['labels'],
            'spaData'        => $spaChart['data'],
            'spaNames'       => $spaChart['names'],
            'categoryLabels' => $categoryChart['labels'],
            'categoryData'   => $categoryChart['data'],
            'categoryNames'  => $categoryChart['names'],
        ]);
    }

    /**
     * List all spa owners with their spa
     */
    public function spaOwners(Request $request)
    {
        $spaOwners = User::where('role', 'spa_owner')
            ->with('spa')
            ->latest()
            ->get();

        return view('admin.spa_owners', compact('spaOwners'));
    }

    /**
     * Show a single spa owner and their spa details
     */
    public function showSpaOwner(User $user)
    {
        $user->load('spa');
        return view('admin.spa_owner_show', compact('user'));
    }

    /**
     * Approve a spa — and sync all existing services from other approved spas into it.
     */
    public function approveSpa(Spa $spa)
    {
        $spa->update(['status' => 'approved', 'is_active' => true]);

        return back()->with('success', "Spa '{$spa->name}' has been approved.");
    }

    /**
     * Disapprove a spa
     */
    public function disapproveSpa(Spa $spa)
    {
        $spa->update(['status' => 'disapproved', 'is_active' => false]);
        return back()->with('error', "Spa '{$spa->name}' has been disapproved.");
    }

    /**
     * Show all approved spas and their services.
     * Auto-syncs any approved spa that has zero services.
     */
    public function services()
    {
        $spas = Spa::where('status', 'approved')
            ->with('services.spaCategory')
            ->orderBy('name')
            ->get();

        return view('admin.services', compact('spas'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}
