<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index(): View
    {
        // Get summary statistics
        $totalDrugs = Drug::count();
        $totalValue = Drug::sum(DB::raw('quantity * unit_price'));
        
        // Get alert counts
        $alerts = [
            'low_stock' => Drug::lowStock()->count(),
            'expired' => Drug::expired()->count(),
            'expiring_soon' => Drug::expiringSoon()->count(),
        ];

        // Get recent activities (latest drugs added/updated)
        $recentDrugs = Drug::orderBy('updated_at', 'desc')->limit(5)->get();

        // Get low stock items for quick action
        $lowStockDrugs = Drug::lowStock()->orderBy('quantity')->limit(5)->get();

        // Get expired drugs for immediate attention
        $expiredDrugs = Drug::expired()->orderBy('expiry_date')->limit(5)->get();

        // Get drugs expiring soon
        $expiringSoonDrugs = Drug::expiringSoon()->orderBy('expiry_date')->limit(5)->get();

        return view('dashboard', compact(
            'totalDrugs',
            'totalValue',
            'alerts',
            'recentDrugs',
            'lowStockDrugs',
            'expiredDrugs',
            'expiringSoonDrugs'
        ));
    }
}
