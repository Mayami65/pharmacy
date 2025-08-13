<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Sale;
use App\Models\SaleItem;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Main analytics dashboard
     */
    public function index(Request $request): View
    {
        $days = $request->get('days', 30);
        $startDate = now()->subDays($days);
        $previousStartDate = $startDate->copy()->subDays($days);

        // Calculate current period metrics
        $currentPeriodSales = Sale::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->sum('total_amount');
        
        $currentPeriodOrders = Sale::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->count();

        // Calculate previous period metrics for growth
        $previousPeriodSales = Sale::where('status', 'completed')
            ->whereBetween('created_at', [$previousStartDate, $startDate])
            ->sum('total_amount');
        
        $previousPeriodOrders = Sale::where('status', 'completed')
            ->whereBetween('created_at', [$previousStartDate, $startDate])
            ->count();

        // Calculate growth percentages
        $salesGrowth = $previousPeriodSales > 0 ? 
            round((($currentPeriodSales - $previousPeriodSales) / $previousPeriodSales) * 100, 1) : 0;
        
        $ordersGrowth = $previousPeriodOrders > 0 ? 
            round((($currentPeriodOrders - $previousPeriodOrders) / $previousPeriodOrders) * 100, 1) : 0;

        // Average order value
        $averageOrderValue = $currentPeriodOrders > 0 ? $currentPeriodSales / $currentPeriodOrders : 0;
        $previousAOV = $previousPeriodOrders > 0 ? $previousPeriodSales / $previousPeriodOrders : 0;
        $aovGrowth = $previousAOV > 0 ? round((($averageOrderValue - $previousAOV) / $previousAOV) * 100, 1) : 0;

        // Inventory metrics
        $inventoryValue = Drug::sum(DB::raw('quantity * unit_price'));
        $totalDrugs = Drug::count();
        $lowStockCount = Drug::lowStock()->count();
        $expiredCount = Drug::expired()->count();
        $expiringCount = Drug::expiringSoon()->count();

        // Top selling products
        $topProducts = SaleItem::select(
                'drug_id',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(line_total) as revenue')
            )
            ->with('drug:id,name,manufacturer')
            ->whereHas('sale', function($query) use ($startDate) {
                $query->where('status', 'completed')
                      ->where('created_at', '>=', $startDate);
            })
            ->groupBy('drug_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $item->name = $item->drug->name;
                $item->manufacturer = $item->drug->manufacturer;
                return $item;
            });

        // Sales chart data
        $salesChartData = [];
        $salesChartLabels = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailySales = Sale::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            
            $salesChartLabels[] = $date->format('M d');
            $salesChartData[] = $dailySales;
        }

        // Recent activity (mock data for now)
        $recentActivity = collect([
            (object) [
                'description' => 'New sale completed - GH₵125.50',
                'created_at' => now()->subMinutes(5)
            ],
            (object) [
                'description' => 'Low stock alert for Paracetamol',
                'created_at' => now()->subMinutes(15)
            ],
            (object) [
                'description' => 'Purchase order received from MediGen Inc',
                'created_at' => now()->subHours(2)
            ],
            (object) [
                'description' => 'Expiry alert for 3 items',
                'created_at' => now()->subHours(4)
            ]
        ]);

        return view('analytics.index', compact(
            'currentPeriodSales', 'currentPeriodOrders', 'averageOrderValue', 'inventoryValue', 'totalDrugs',
            'salesGrowth', 'ordersGrowth', 'aovGrowth',
            'lowStockCount', 'expiredCount', 'expiringCount',
            'topProducts', 'salesChartLabels', 'salesChartData', 'recentActivity'
        ));
    }

    /**
     * Sales analytics
     */
    public function sales(Request $request): View
    {
        $period = $request->get('period', '30');
        $startDate = now()->subDays($period);

        // Sales overview
        $salesOverview = [
            'total_sales' => Sale::where('status', 'completed')->count(),
            'total_revenue' => Sale::where('status', 'completed')->sum('total_amount'),
            'avg_sale_value' => Sale::where('status', 'completed')->avg('total_amount'),
            'total_customers' => Sale::where('status', 'completed')
                ->whereNotNull('customer_name')->distinct('customer_name')->count(),
        ];

        // Sales by period (SQLite compatible)
        $salesByMonth = Sale::select(
                DB::raw('strftime("%Y", created_at) as year'),
                DB::raw('strftime("%m", created_at) as month'),
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Top customers
        $topCustomers = Sale::select('customer_name', 
                DB::raw('COUNT(*) as purchase_count'),
                DB::raw('SUM(total_amount) as total_spent')
            )
            ->where('status', 'completed')
            ->whereNotNull('customer_name')
            ->groupBy('customer_name')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // Sales by payment method
        $salesByPayment = Sale::select('payment_method',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->where('status', 'completed')
            ->groupBy('payment_method')
            ->get();

        return view('analytics.sales', compact(
            'salesOverview', 'salesByMonth', 'topCustomers', 'salesByPayment', 'period'
        ));
    }

    /**
     * Inventory analytics
     */
    public function inventory(Request $request): View
    {
        // Inventory overview
        $inventoryOverview = [
            'total_drugs' => Drug::count(),
            'total_stock_value' => Drug::sum(DB::raw('quantity * unit_price')),
            'total_quantity' => Drug::sum('quantity'),
            'avg_unit_price' => Drug::avg('unit_price'),
        ];

        // Stock status breakdown
        $stockStatus = [
            'in_stock' => Drug::where('quantity', '>', 0)->count(),
            'out_of_stock' => Drug::where('quantity', '=', 0)->count(),
            'low_stock' => Drug::lowStock()->count(),
            'expired' => Drug::expired()->count(),
            'expiring_soon' => Drug::expiringSoon()->count(),
        ];

        // Most valuable drugs
        $valuableDrugs = Drug::select('*', DB::raw('quantity * unit_price as total_value'))
            ->orderByDesc('total_value')
            ->limit(10)
            ->get();

        // Low stock alerts
        $lowStockDrugs = Drug::lowStock()
            ->orderBy('quantity')
            ->limit(20)
            ->get();

        // Expiry alerts
        $expiringDrugs = Drug::expiringSoon()
            ->orderBy('expiry_date')
            ->limit(20)
            ->get();

        return view('analytics.inventory', compact(
            'inventoryOverview', 'stockStatus', 'valuableDrugs', 
            'lowStockDrugs', 'expiringDrugs'
        ));
    }

}
