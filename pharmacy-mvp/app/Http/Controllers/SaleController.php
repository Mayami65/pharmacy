<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Sale::with(['server', 'items'])
            ->withCount('items');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('sale_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->get('payment_method'));
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(15);

        $statusCounts = [
            'all' => Sale::count(),
            'completed' => Sale::where('status', 'completed')->count(),
            'pending' => Sale::where('status', 'pending')->count(),
            'cancelled' => Sale::where('status', 'cancelled')->count(),
            'refunded' => Sale::where('status', 'refunded')->count(),
        ];

        return view('sales.index', compact('sales', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $drugs = Drug::where('quantity', '>', 0)->orderBy('name')->get();
        return view('sales.create', compact('drugs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,card,mobile_money,insurance',
            'amount_paid' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.drug_id' => 'required|exists:drugs,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $sale = new Sale();
            $sale->sale_number = $sale->generateSaleNumber();
            $sale->customer_name = $validated['customer_name'];
            $sale->customer_phone = $validated['customer_phone'];
            $sale->payment_method = $validated['payment_method'];
            $sale->amount_paid = $validated['amount_paid'];
            $sale->discount_amount = $validated['discount_amount'] ?? 0;
            $sale->notes = $validated['notes'];
            $sale->served_by = Auth::id();

            $subtotal = 0;
            foreach ($validated['items'] as $itemData) {
                $lineTotal = $itemData['quantity'] * $itemData['unit_price'];
                $subtotal += $lineTotal;
            }

            $sale->subtotal = $subtotal;
            $sale->total_amount = $subtotal - $sale->discount_amount;
            $sale->change_amount = max(0, $sale->amount_paid - $sale->total_amount);
            $sale->save();

            foreach ($validated['items'] as $itemData) {
                $drug = Drug::find($itemData['drug_id']);
                
                // Check if enough stock is available
                if ($drug->quantity < $itemData['quantity']) {
                    throw new \Exception("Insufficient stock for {$drug->name}. Available: {$drug->quantity}");
                }

                $lineTotal = $itemData['quantity'] * $itemData['unit_price'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'drug_id' => $itemData['drug_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'line_total' => $lineTotal,
                    'batch_number' => $drug->batch_number,
                    'expiry_date' => $drug->expiry_date,
                ]);

                // Reduce drug inventory
                $drug->decrement('quantity', $itemData['quantity']);
            }
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale completed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale): View
    {
        $sale->load(['server', 'items.drug']);
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale): View|RedirectResponse
    {
        if ($sale->status !== 'pending') {
            return redirect()->route('sales.show', $sale)
                ->with('error', 'Only pending sales can be edited.');
        }

        $sale->load('items.drug');
        $drugs = Drug::where('quantity', '>', 0)->orderBy('name')->get();
        return view('sales.edit', compact('sale', 'drugs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale): RedirectResponse
    {
        if ($sale->status !== 'pending') {
            return redirect()->route('sales.show', $sale)
                ->with('error', 'Only pending sales can be updated.');
        }

        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,card,mobile_money,insurance',
            'amount_paid' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $sale->update($validated);

        return redirect()->route('sales.show', $sale)
            ->with('success', 'Sale updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale): RedirectResponse
    {
        if ($sale->status === 'completed') {
            return redirect()->route('sales.index')
                ->with('error', 'Completed sales cannot be deleted.');
        }

        DB::transaction(function () use ($sale) {
            // Restore inventory if sale was pending
            if ($sale->status === 'pending') {
                foreach ($sale->items as $item) {
                    $item->drug->increment('quantity', $item->quantity);
                }
            }

            $sale->delete();
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted successfully.');
    }

    /**
     * Point of Sale interface
     */
    public function pos(): View
    {
        $drugs = Drug::where('quantity', '>', 0)->orderBy('name')->get();
        return view('sales.pos', compact('drugs'));
    }

    /**
     * Process sale from POS
     */
    public function processSale(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'customer_name' => 'nullable|string|max:255',
                'customer_phone' => 'nullable|string|max:255',
                'payment_method' => 'required|in:cash,card,mobile_money,insurance',
                'amount_paid' => 'required|numeric|min:0',
                'discount_amount' => 'nullable|numeric|min:0',
                'items' => 'required|array|min:1',
                'items.*.drug_id' => 'required|exists:drugs,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',
            ]);

            $sale = DB::transaction(function () use ($validated) {
                $sale = new Sale();
                $sale->sale_number = $sale->generateSaleNumber();
                $sale->customer_name = $validated['customer_name'];
                $sale->customer_phone = $validated['customer_phone'];
                $sale->payment_method = $validated['payment_method'];
                $sale->amount_paid = $validated['amount_paid'];
                $sale->discount_amount = $validated['discount_amount'] ?? 0;
                $sale->served_by = Auth::id();

                $subtotal = 0;
                foreach ($validated['items'] as $itemData) {
                    $drug = Drug::find($itemData['drug_id']);
                    
                    if ($drug->quantity < $itemData['quantity']) {
                        throw new \Exception("Insufficient stock for {$drug->name}. Available: {$drug->quantity}");
                    }

                    $lineTotal = $itemData['quantity'] * $itemData['unit_price'];
                    $subtotal += $lineTotal;
                }

                $sale->subtotal = $subtotal;
                $sale->total_amount = $subtotal - $sale->discount_amount;
                $sale->change_amount = max(0, $sale->amount_paid - $sale->total_amount);
                $sale->save();

                foreach ($validated['items'] as $itemData) {
                    $drug = Drug::find($itemData['drug_id']);
                    $lineTotal = $itemData['quantity'] * $itemData['unit_price'];

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'drug_id' => $itemData['drug_id'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'line_total' => $lineTotal,
                        'batch_number' => $drug->batch_number,
                        'expiry_date' => $drug->expiry_date,
                    ]);

                    $drug->decrement('quantity', $itemData['quantity']);
                }

                return $sale;
            });

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'sale_number' => $sale->sale_number,
                'total_amount' => $sale->total_amount,
                'change_amount' => $sale->change_amount,
                'message' => 'Sale processed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Generate receipt
     */
    public function receipt(Sale $sale): View
    {
        $sale->load(['server', 'items.drug']);
        return view('sales.receipt', compact('sale'));
    }

    /**
     * Get drug info for POS (AJAX)
     */
    public function getDrugInfo(Request $request): JsonResponse
    {
        $drug = Drug::find($request->drug_id);
        
        if (!$drug) {
            return response()->json(['error' => 'Drug not found'], 404);
        }

        return response()->json([
            'id' => $drug->id,
            'name' => $drug->name,
            'unit_price' => $drug->unit_price,
            'available_quantity' => $drug->quantity,
            'expiry_date' => $drug->expiry_date ? $drug->expiry_date->format('Y-m-d') : null,
            'is_expired' => $drug->isExpired(),
            'is_expiring_soon' => $drug->isExpiringSoon(),
            'is_low_stock' => $drug->isLowStock()
        ]);
    }
}
