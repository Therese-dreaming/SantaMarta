<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get counts for dashboard stats
        $totalBookings = ServiceBooking::count();
        $pendingBookings = ServiceBooking::where('status', 'pending')->count();
        
        // Fix the today's bookings query - the issue is here
        // The current query is looking for preferred_date exactly matching today
        $today = Carbon::today(config('app.timezone'));
        $todayBookings = ServiceBooking::whereDate('preferred_date', $today)
            ->where('status', 'approved')
            ->count();
        
        $totalUsers = User::count();

        // Get recent bookings
        $recentBookings = ServiceBooking::latest()->take(5)->get();

        // Get upcoming events/activities - using 'date' instead of 'event_date'
        $upcomingEvents = Activity::where('date', '>=', Carbon::today())
            ->with('user')  // Eager load the user relationship
            ->orderBy('date')
            ->take(5)
            ->get();

        // Get service type distribution - using 'type' instead of 'service_type'
        $baptismCount = ServiceBooking::where('type', 'baptism')->count();
        $weddingCount = ServiceBooking::where('type', 'wedding')->count();
        $funeralCount = ServiceBooking::where('type', 'funeral')->count();
        $confirmationCount = ServiceBooking::where('type', 'confirmation')->count();
        $massIntentionCount = ServiceBooking::where('type', 'mass_intention')->count();

        // Calculate financial data
        $totalRevenue = ServiceBooking::where('status', 'approved')->sum('amount');
        $monthlyRevenue = ServiceBooking::where('status', 'approved')
            ->whereMonth('preferred_date', Carbon::now()->month)
            ->whereYear('preferred_date', Carbon::now()->year)
            ->sum('amount');

        // Calculate monthly revenue for the last 6 months
        $monthlyRevenueData = $this->getMonthlyRevenueData();
        
        // Calculate revenue by service type
        $revenueByServiceType = $this->getRevenueByServiceType();
        
        // Calculate booking completion rate
        $bookingCompletionRate = $this->getBookingCompletionRate();
        
        // Calculate peak booking times
        $peakBookingTimes = $this->getPeakBookingTimes();
        
        // Calculate user registration trends
        $userRegistrationTrends = $this->getUserRegistrationTrends();
        
        // Calculate year-over-year growth
        $yearOverYearGrowth = $this->getYearOverYearGrowth();

        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'todayBookings',
            'totalUsers',
            'recentBookings',
            'upcomingEvents',
            'baptismCount',
            'weddingCount',
            'funeralCount',
            'confirmationCount',
            'massIntentionCount',
            'totalRevenue',
            'monthlyRevenue',
            'monthlyRevenueData',
            'revenueByServiceType',
            'bookingCompletionRate',
            'peakBookingTimes',
            'userRegistrationTrends',
            'yearOverYearGrowth'
        ));
    }

    /**
     * Get monthly revenue for a specific month and year
     *
     * @param int $month
     * @param int $year
     * @return float
     */
    private function getMonthlyRevenue($month, $year)
    {
        return ServiceBooking::where('status', 'approved')
            ->whereMonth('preferred_date', $month)
            ->whereYear('preferred_date', $year)
            ->sum('amount');
    }

    /**
     * Get monthly revenue data for the last 6 months
     *
     * @return array
     */
    private function getMonthlyRevenueData()
    {
        $data = [];
        $labels = [];
        
        // Get data for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $revenue = $this->getMonthlyRevenue($month, $year);
            $data[] = $revenue;
            $labels[] = $date->format('M Y');
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get revenue breakdown by service type
     *
     * @return array
     */
    private function getRevenueByServiceType()
    {
        $serviceTypes = ['baptism', 'wedding', 'funeral', 'confirmation', 'mass_intention'];
        $revenueByType = [];
        
        foreach ($serviceTypes as $type) {
            $revenueByType[ucfirst(str_replace('_', ' ', $type))] = ServiceBooking::where('type', $type)
                ->where('status', 'approved')
                ->sum('amount');
        }
        
        return $revenueByType;
    }

    /**
     * Get booking completion rate statistics
     *
     * @return array
     */
    private function getBookingCompletionRate()
    {
        $approved = ServiceBooking::where('status', 'approved')->count();
        $pending = ServiceBooking::where('status', 'pending')->count();
        $cancelled = ServiceBooking::where('status', 'cancelled')->count();
        $total = $approved + $pending + $cancelled;
        
        $approvalRate = $total > 0 ? round(($approved / $total) * 100) : 0;
        
        return [
            'approved' => $approved,
            'pending' => $pending,
            'cancelled' => $cancelled,
            'approval_rate' => $approvalRate
        ];
    }

    /**
     * Get peak booking times by day of week
     *
     * @return array
     */
    private function getPeakBookingTimes()
    {
        $bookingsByDay = [
            'Sunday' => 0,
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0
        ];
        
        // Get all bookings with a preferred date
        $bookings = ServiceBooking::whereNotNull('preferred_date')->get();
        
        foreach ($bookings as $booking) {
            $dayOfWeek = Carbon::parse($booking->preferred_date)->format('l');
            $bookingsByDay[$dayOfWeek]++;
        }
        
        return $bookingsByDay;
    }

    /**
     * Get user registration trends for the last 6 months
     *
     * @return array
     */
    private function getUserRegistrationTrends()
    {
        $data = [];
        $labels = [];
        
        // Get data for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $count = User::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
                
            $data[] = $count;
            $labels[] = $date->format('M Y');
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Calculate year-over-year growth for key metrics
     *
     * @return array
     */
    private function getYearOverYearGrowth()
    {
        // Calculate revenue growth
        $thisYearRevenue = ServiceBooking::where('status', 'approved')
            ->whereYear('preferred_date', Carbon::now()->year)
            ->sum('amount');
            
        $lastYearRevenue = ServiceBooking::where('status', 'approved')
            ->whereYear('preferred_date', Carbon::now()->subYear()->year)
            ->sum('amount');
            
        $revenueGrowth = $lastYearRevenue > 0 
            ? round((($thisYearRevenue - $lastYearRevenue) / $lastYearRevenue) * 100) 
            : 100;
            
        // Calculate booking growth
        $thisYearBookings = ServiceBooking::whereYear('created_at', Carbon::now()->year)->count();
        $lastYearBookings = ServiceBooking::whereYear('created_at', Carbon::now()->subYear()->year)->count();
        
        $bookingGrowth = $lastYearBookings > 0 
            ? round((($thisYearBookings - $lastYearBookings) / $lastYearBookings) * 100) 
            : 100;
            
        return [
            'revenue_growth' => $revenueGrowth,
            'booking_growth' => $bookingGrowth
        ];
    }
}