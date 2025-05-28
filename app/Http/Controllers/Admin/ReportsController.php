<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $dateFrom = $request->input('date_from') ? Carbon::parse($request->input('date_from')) : Carbon::now()->subDays(30);
        $dateTo = $request->input('date_to') ? Carbon::parse($request->input('date_to'))->endOfDay() : Carbon::now()->endOfDay();
        $serviceType = $request->input('service_type');
        $status = $request->input('status');

        // Base query for bookings
        $bookingsQuery = ServiceBooking::whereBetween('created_at', [$dateFrom, $dateTo]);
        
        // Apply filters if provided
        if ($serviceType) {
            $bookingsQuery->where('type', $serviceType);
        }
        
        if ($status) {
            $bookingsQuery->where('status', $status);
        }

        // Get booking statistics
        $totalBookings = $bookingsQuery->count();
        $completedBookings = (clone $bookingsQuery)->where('status', 'approved')->count();
        $paidBookings = (clone $bookingsQuery)->where('payment_status', 'paid')->count();

        // Get revenue data
        $totalRevenue = ServiceBooking::whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($serviceType, function($query) use ($serviceType) {
                return $query->where('type', $serviceType);
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->where('payment_status', 'paid')
            ->sum('amount');

        // Calculate revenue growth (compare with previous period)
        $previousPeriodStart = (clone $dateFrom)->subDays($dateFrom->diffInDays($dateTo));
        $previousPeriodEnd = (clone $dateFrom)->subDay();
        
        $previousRevenue = ServiceBooking::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])
            ->when($serviceType, function($query) use ($serviceType) {
                return $query->where('type', $serviceType);
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->where('payment_status', 'paid')
            ->sum('amount');
        
        $revenueGrowth = $previousRevenue > 0
            ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 
            : ($totalRevenue > 0 ? 100 : 0);

        // Get user statistics
        $newUsers = User::whereBetween('created_at', [$dateFrom, $dateTo])->count();
        $previousPeriodUsers = User::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();
        $userGrowth = $previousPeriodUsers > 0 
            ? (($newUsers - $previousPeriodUsers) / $previousPeriodUsers) * 100 
            : ($newUsers > 0 ? 100 : 0);

        // Get service type breakdown
        $serviceStats = ServiceBooking::whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->select('type as service_type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get()
            ->map(function($item) use ($totalBookings, $totalRevenue, $dateFrom, $dateTo) {
                // Get revenue for this service type
                $revenue = ServiceBooking::where('type', $item->service_type)
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->where('payment_status', 'paid')
                    ->sum('amount');
                
                // Calculate percentage of total
                $percentage = $totalBookings > 0 ? ($item->count / $totalBookings) * 100 : 0;
                
                // Assign a color based on service type
                $colors = [
                    'baptism' => '#10B981', // emerald
                    'communion' => '#3B82F6', // blue
                    'confirmation' => '#8B5CF6', // purple
                    'wedding' => '#EC4899', // pink
                    'funeral' => '#6B7280', // gray
                    'blessing' => '#F59E0B', // amber
                    'mass' => '#EF4444', // red
                ];
                
                return [
                    'service_type' => $item->service_type,
                    'count' => $item->count,
                    'revenue' => $revenue,
                    'percentage' => $percentage,
                    'color' => $colors[$item->service_type] ?? '#6B7280'
                ];
            })->sortByDesc('count')->values()->all();
        
        // Generate revenue chart data
        $revenueChart = $this->generateRevenueChartData($dateFrom, $dateTo, $serviceType, $status);
        
        // Get transaction logs
        $transactions = ServiceBooking::with(['user'])
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($serviceType, function($query) use ($serviceType) {
                return $query->where('type', $serviceType);
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->all());
        
        return view('admin.reports', compact(
            'totalBookings', 
            'completedBookings', 
            'paidBookings', 
            'totalRevenue', 
            'revenueGrowth', 
            'newUsers', 
            'userGrowth', 
            'serviceStats', 
            'revenueChart', 
            'transactions'
        ));
    }
    
    /**
     * Generate data for the revenue chart
     */
    private function generateRevenueChartData($dateFrom, $dateTo, $serviceType = null, $status = null)
    {
        $diffInDays = $dateFrom->diffInDays($dateTo);
        
        // Determine the appropriate grouping based on date range
        if ($diffInDays <= 31) {
            // Daily grouping for ranges up to a month
            $groupBy = 'day';
            $format = 'M d';
        } elseif ($diffInDays <= 92) {
            // Weekly grouping for ranges up to 3 months
            $groupBy = 'week';
            $format = 'W/Y';
        } else {
            // Monthly grouping for longer ranges
            $groupBy = 'month';
            $format = 'M Y';
        }
        
        // Generate all periods in the date range
        $periods = [];
        $labels = [];
        $current = clone $dateFrom;
        
        while ($current <= $dateTo) {
            $key = $current->format('Y-m-d');
            $periods[$key] = 0;
            $labels[] = $current->format($format);
            
            if ($groupBy == 'day') {
                $current->addDay();
            } elseif ($groupBy == 'week') {
                $current->addWeek();
            } else {
                $current->addMonth();
            }
        }
        
        // Get revenue data grouped by the appropriate interval
        $query = ServiceBooking::whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('payment_status', 'paid');
            
        if ($serviceType) {
            $query = $query->where('type', $serviceType);
        }
        
        if ($status) {
            $query = $query->where('status', $status);
        }
        
        if ($groupBy == 'day') {
            $revenueData = $query->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->get();
        } elseif ($groupBy == 'week') {
            $revenueData = $query->select(
                DB::raw("DATE_FORMAT(DATE_ADD(DATE(created_at), INTERVAL(-WEEKDAY(created_at)) DAY), '%Y-%m-%d') as date"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy(DB::raw("YEARWEEK(created_at)"))
            ->get();
        } else {
            $revenueData = $query->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-01') as date"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();
        }
        
        // Map the revenue data to the periods
        $data = $periods;
        foreach ($revenueData as $item) {
            if (isset($data[$item->date])) {
                $data[$item->date] = (float) $item->total;
            }
        }
        
        return [
            'labels' => $labels,
            'data' => array_values($data)
        ];
    }
    
    /**
     * Download the report as PDF
     */
    public function download(Request $request)
    {
        // Get the same data as the index method
        $dateFrom = $request->input('date_from') ? Carbon::parse($request->input('date_from')) : Carbon::now()->subDays(30);
        $dateTo = $request->input('date_to') ? Carbon::parse($request->input('date_to'))->endOfDay() : Carbon::now()->endOfDay();
        $serviceType = $request->input('service_type');
        $status = $request->input('status');
        
        // Base query for bookings
        $bookingsQuery = ServiceBooking::whereBetween('created_at', [$dateFrom, $dateTo]);
        
        if ($serviceType) {
            $bookingsQuery->where('type', $serviceType);
        }
        
        if ($status) {
            $bookingsQuery->where('status', $status);
        }
        
        $totalBookings = $bookingsQuery->count();
        $completedBookings = (clone $bookingsQuery)->where('status', 'approved')->count();
        $paidBookings = (clone $bookingsQuery)->where('payment_status', 'paid')->count();
        
        $totalRevenue = ServiceBooking::whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($serviceType, function($query) use ($serviceType) {
                return $query->where('type', $serviceType);
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->where('payment_status', 'paid')
            ->sum('amount');
        
        // Get service type breakdown
        $serviceStats = ServiceBooking::whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->select('type as service_type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get()
            ->map(function($item) use ($totalBookings, $totalRevenue, $dateFrom, $dateTo) {
                $revenue = ServiceBooking::where('type', $item->service_type)
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->where('payment_status', 'paid')
                    ->sum('amount');
                
                $percentage = $totalBookings > 0 ? ($item->count / $totalBookings) * 100 : 0;
                
                return [
                    'service_type' => $item->service_type,
                    'count' => $item->count,
                    'revenue' => $revenue,
                    'percentage' => $percentage
                ];
            })->sortByDesc('count')->values()->all();
        
        // Get transaction logs (limited to 100 for PDF)
        $transactions = ServiceBooking::with(['user'])
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($serviceType, function($query) use ($serviceType) {
                return $query->where('type', $serviceType);
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();
        
        $pdf = PDF::loadView('admin.reports_pdf', compact(
            'dateFrom',
            'dateTo',
            'serviceType',
            'status',
            'totalBookings', 
            'completedBookings', 
            'paidBookings', 
            'totalRevenue',
            'serviceStats',
            'transactions'
        ));
        
        return $pdf->download('santa-marta-report-' . now()->format('Y-m-d') . '.pdf');
    }
}