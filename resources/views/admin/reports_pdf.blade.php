<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Santa Marta Financial Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .header h1 {
            margin: 0;
            color: #10B981;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #6B7280;
        }
        .summary {
            margin-bottom: 20px;
        }
        .summary-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
            color: #10B981;
        }
        .summary-grid {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        .summary-item {
            width: 25%;
            padding: 10px;
            box-sizing: border-box;
        }
        .summary-card {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .summary-card-title {
            font-size: 12px;
            color: #6B7280;
            margin: 0 0 5px;
        }
        .summary-card-value {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #111827;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f3f4f6;
            border-radius: 5px;
        }
        .filters p {
            margin: 5px 0;
        }
        .page-break {
            page-break-after: always;
        }
        .currency {
            font-family: DejaVu Sans, Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Santa Marta Parish</h1>
            <p>Financial Report</p>
        </div>
        
        <div class="filters">
            <p><strong>Report Period:</strong> {{ $dateFrom->format('M d, Y') }} to {{ $dateTo->format('M d, Y') }}</p>
            @if($serviceType)
                <p><strong>Service Type:</strong> {{ ucfirst($serviceType) }}</p>
            @endif
            @if($status)
                <p><strong>Status:</strong> {{ ucfirst($status) }}</p>
            @endif
            <p><strong>Generated On:</strong> {{ now()->format('M d, Y h:i A') }}</p>
        </div>
        
        <div class="summary">
            <div class="summary-title">Summary</div>
            <table>
                <tr>
                    <td width="25%"><strong>Total Bookings:</strong></td>
                    <td width="25%">{{ $totalBookings }}</td>
                    <td width="25%"><strong>Completed Bookings:</strong></td>
                    <td width="25%">{{ $completedBookings }} ({{ $totalBookings > 0 ? round(($completedBookings / $totalBookings) * 100) : 0 }}%)</td>
                </tr>
                <tr>
                    <td><strong>Paid Bookings:</strong></td>
                    <td>{{ $paidBookings }} ({{ $totalBookings > 0 ? round(($paidBookings / $totalBookings) * 100) : 0 }}%)</td>
                    <td><strong>Total Revenue:</strong></td>
                    <td><span class="currency">PHP</span> {{ number_format($totalRevenue, 2) }}</td>
                </tr>
            </table>
        </div>
        
        <div class="summary">
            <div class="summary-title">Service Type Breakdown</div>
            <table>
                <thead>
                    <tr>
                        <th>Service Type</th>
                        <th>Bookings</th>
                        <th>Revenue</th>
                        <th>% of Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($serviceStats as $stat)
                    <tr>
                        <td>{{ ucfirst($stat['service_type']) }}</td>
                        <td>{{ $stat['count'] }}</td>
                        <td><span class="currency">PHP</span> {{ number_format($stat['revenue'], 2) }}</td>
                        <td>{{ number_format($stat['percentage'], 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="page-break"></div>
        
        <div class="summary">
            <div class="summary-title">Transaction Logs</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Ticket #</th>
                        <th>Service</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                        <td>{{ $transaction->ticket_number ?? 'N/A' }}</td>
                        <td>{{ ucfirst($transaction->type ?? 'N/A') }}</td>
                        <td>{{ $transaction->user ? $transaction->user->name : 'N/A' }}</td>
                        <td><span class="currency">PHP</span> {{ number_format($transaction->amount, 2) }}</td>
                        <td>{{ ucfirst($transaction->status ?? 'N/A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No transactions found for the selected period</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="footer">
            <p class="text-center">© {{ date('Y') }} Santa Marta Parish. All rights reserved.</p>
        </div>
    </div>
</body>
</html>