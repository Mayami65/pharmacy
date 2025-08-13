<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Sales reports
     */
    public function sales(Request $request): View
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        
        $salesOverview = [
            'total_sales' => Sale::where('status', 'completed')
                ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
                ->count(),
            'total_revenue' => Sale::where('status', 'completed')
                ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
                ->sum('total_amount'),
            'average_order_value' => Sale::where('status', 'completed')
                ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
                ->avg('total_amount'),
        ];

        $topCustomers = Sale::select('customer_name', DB::raw('COUNT(*) as total_orders'), DB::raw('SUM(total_amount) as total_spent'))
            ->where('status', 'completed')
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
            ->whereNotNull('customer_name')
            ->groupBy('customer_name')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        return view('reports.sales', compact('salesOverview', 'topCustomers', 'period'));
    }

    /**
     * Inventory reports
     */
    public function inventory(Request $request): View
    {
        $inventoryOverview = [
            'total_drugs' => Drug::count(),
            'total_stock_value' => Drug::sum(DB::raw('quantity * unit_price')),
            'total_quantity' => Drug::sum('quantity'),
            'average_unit_price' => Drug::avg('unit_price'),
        ];

        $stockStatus = [
            'in_stock' => Drug::where('quantity', '>', 0)->count(),
            'out_of_stock' => Drug::where('quantity', '=', 0)->count(),
            'low_stock' => Drug::lowStock()->count(),
            'expired' => Drug::expired()->count(),
            'expiring_soon' => Drug::expiringSoon()->count(),
        ];

        $valuableDrugs = Drug::select('*', DB::raw('quantity * unit_price as total_value'))
            ->orderByDesc('total_value')
            ->limit(10)
            ->get();

        $lowStockDrugs = Drug::lowStock()->orderBy('quantity')->limit(20)->get();
        $expiringDrugs = Drug::expiringSoon()->orderBy('expiry_date')->limit(20)->get();

        return view('reports.inventory', compact(
            'inventoryOverview',
            'stockStatus',
            'valuableDrugs',
            'lowStockDrugs',
            'expiringDrugs'
        ));
    }

    /**
     * Financial reports
     */
    public function financial(Request $request): View
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        
        $revenueAnalysis = [
            'total_revenue' => Sale::where('status', 'completed')
                ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
                ->sum('total_amount'),
            'average_order_value' => Sale::where('status', 'completed')
                ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
                ->avg('total_amount'),
            'total_orders' => Sale::where('status', 'completed')
                ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
                ->count(),
            'inventory_value' => Drug::sum(DB::raw('quantity * unit_price')),
        ];

        $paymentAnalysis = Sale::select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->where('status', 'completed')
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
            ->groupBy('payment_method')
            ->get();

        return view('reports.financial', compact('revenueAnalysis', 'paymentAnalysis', 'period'));
    }

    /**
     * Performance reports
     */
    public function performance(Request $request): View
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        
        $staffPerformance = Sale::select('server_id', DB::raw('COUNT(*) as total_sales'), DB::raw('SUM(total_amount) as total_revenue'))
            ->where('status', 'completed')
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
            ->with('server:id,name')
            ->groupBy('server_id')
            ->orderByDesc('total_revenue')
            ->get();

        $productPerformance = SaleItem::select(
                'drug_id',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(line_total) as total_revenue')
            )
            ->with('drug:id,name,manufacturer')
            ->whereHas('sale', function($query) use ($startDate) {
                $query->where('status', 'completed');
                if ($startDate) {
                    $query->where('created_at', '>=', $startDate);
                }
            })
            ->groupBy('drug_id')
            ->orderByDesc('total_revenue')
            ->limit(20)
            ->get();

        return view('reports.performance', compact('staffPerformance', 'productPerformance', 'period'));
    }

    /**
     * Export reports
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'inventory');
        $format = $request->get('format', 'excel');
        
        switch ($type) {
            case 'inventory':
                return $this->exportInventory($format);
            case 'sales':
                return $this->exportSales($format, $request);
            default:
                return redirect()->back()->with('error', 'Invalid export type');
        }
    }

    /**
     * Get start date based on period
     */
    private function getStartDate(string $period): ?Carbon
    {
        return match($period) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            'year' => Carbon::now()->subYear(),
            default => null,
        };
    }

    /**
     * Export inventory
     */
    private function exportInventory(string $format)
    {
        $drugs = Drug::all();
        
        if ($format === 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DrugsExport($drugs), 'inventory.xlsx');
        } else {
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DrugsExport($drugs), 'inventory.pdf');
        }
    }

    /**
     * Export sales
     */
    private function exportSales(string $format, Request $request)
    {
        return redirect()->back()->with('info', 'Sales export feature coming soon');
    }
}
