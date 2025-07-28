<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use App\Models\User;
use App\Models\Activity;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current date ranges
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();
        
        // Service Bookings Statistics
        $totalBookings = ServiceBooking::count();
        $pendingBookings = ServiceBooking::where('status', 'pending')->count();
        $approvedBookings = ServiceBooking::where('status', 'approved')->count();
        $paymentOnHoldBookings = ServiceBooking::where('status', 'payment_on_hold')->count();
        
        // Recent bookings (last 7 days)
        $recentBookings = ServiceBooking::with('user')
            ->where('created_at', '>=', $today->copy()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Revenue statistics
        $totalRevenue = ServiceBooking::where('payment_status', 'paid')->sum('amount');
        $monthlyRevenue = ServiceBooking::where('payment_status', 'paid')
            ->whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->sum('amount');
        
        // Service type statistics
        $serviceTypeStats = ServiceBooking::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [ucfirst(str_replace('_', ' ', $item->type)) => $item->count];
            });
        
        // Monthly booking trends (last 12 months)
        $monthlyTrends = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = ServiceBooking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyTrends->push([
                'month' => $date->format('M Y'),
                'short_month' => $date->format('M'),
                'count' => $count
            ]);
        }
        
        // Weekly booking trends (last 8 weeks)
        $weeklyTrends = collect();
        for ($i = 7; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            $count = ServiceBooking::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $weeklyTrends->push([
                'week' => $startOfWeek->format('M d') . ' - ' . $endOfWeek->format('M d'),
                'count' => $count
            ]);
        }
        
        // Daily bookings for current month
        $dailyTrends = collect();
        $daysInMonth = $thisMonth->daysInMonth;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $thisMonth->copy()->day($day);
            if ($date->lte(Carbon::now())) {
                $count = ServiceBooking::whereDate('created_at', $date)->count();
                $dailyTrends->push([
                    'day' => $date->format('M d'),
                    'count' => $count
                ]);
            }
        }
        
        // Revenue trends (last 6 months)
        $revenueTrends = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = ServiceBooking::where('payment_status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
            $revenueTrends->push([
                'month' => $date->format('M Y'),
                'short_month' => $date->format('M'),
                'revenue' => $revenue
            ]);
        }
        
        // User statistics
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $newUsersThisMonth = User::where('role', '!=', 'admin')
            ->whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->count();
        
        // Upcoming activities
        $upcomingActivities = Activity::where('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->limit(5)
            ->get();
        
        // Recent tickets if the Ticket model exists
        $recentTickets = collect();
        if (class_exists('App\Models\Ticket')) {
            $recentTickets = Ticket::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }
        
        // Payment verification queue
        $paymentsToVerify = ServiceBooking::where('status', 'payment_on_hold')
            ->where('payment_status', 'paid')
            ->count();
        
        // Today's approved bookings
        $todaysBookings = ServiceBooking::whereDate('preferred_date', $today)
            ->where('status', 'approved')
            ->with('user')
            ->get();
        
        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings', 
            'approvedBookings',
            'paymentOnHoldBookings',
            'recentBookings',
            'totalRevenue',
            'monthlyRevenue',
            'serviceTypeStats',
            'monthlyTrends',
            'weeklyTrends',
            'dailyTrends',
            'revenueTrends',
            'totalUsers',
            'newUsersThisMonth',
            'upcomingActivities',
            'recentTickets',
            'paymentsToVerify',
            'todaysBookings'
        ));
    }

    public function chartData()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Bookings Trend (last 6 months)
        $bookingsTrend = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = ServiceBooking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $bookingsTrend->push([
                'month' => $date->format('M'),
                'count' => $count
            ]);
        }

        // User Growth (last 6 months)
        $userGrowth = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = User::where('role', '!=', 'admin')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $userGrowth->push([
                'month' => $date->format('M'),
                'count' => $count
            ]);
        }

        // Revenue Trend (last 6 months)
        $revenueTrend = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = ServiceBooking::where('payment_status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
            $revenueTrend->push([
                'month' => $date->format('M'),
                'revenue' => $revenue
            ]);
        }

        // Service Type Pie
        $serviceTypeStats = ServiceBooking::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [ucfirst(str_replace('_', ' ', $item->type)) => $item->count];
            });

        return response()->json([
            'bookingsTrend' => $bookingsTrend,
            'userGrowth' => $userGrowth,
            'revenueTrend' => $revenueTrend,
            'serviceTypeStats' => $serviceTypeStats,
        ]);
    }
}
