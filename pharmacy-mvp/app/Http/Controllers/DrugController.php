<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Drug::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('manufacturer', 'like', "%{$search}%")
                  ->orWhere('batch_number', 'like', "%{$search}%");
            });
        }

        // Filter by alerts
        if ($request->filled('filter')) {
            switch ($request->get('filter')) {
                case 'low_stock':
                    $query->lowStock();
                    break;
                case 'expired':
                    $query->expired();
                    break;
                case 'expiring_soon':
                    $query->expiringSoon();
                    break;
            }
        }

        $drugs = $query->orderBy('name')->paginate(15);

        // Get alert counts for dashboard
        $alerts = [
            'low_stock' => Drug::lowStock()->count(),
            'expired' => Drug::expired()->count(),
            'expiring_soon' => Drug::expiringSoon()->count(),
        ];

        return view('drugs.index', compact('drugs', 'alerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('drugs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date|after:today',
            'low_stock_threshold' => 'required|integer|min:1',
            'batch_number' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
        ]);

        Drug::create($validated);

        return redirect()->route('drugs.index')
            ->with('success', 'Drug added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Drug $drug): View
    {
        return view('drugs.show', compact('drug'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drug $drug): View
    {
        return view('drugs.edit', compact('drug'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drug $drug): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date|after:today',
            'low_stock_threshold' => 'required|integer|min:1',
            'batch_number' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
        ]);

        $drug->update($validated);

        return redirect()->route('drugs.index')
            ->with('success', 'Drug updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drug $drug): RedirectResponse
    {
        $drug->delete();

        return redirect()->route('drugs.index')
            ->with('success', 'Drug deleted successfully!');
    }

    /**
     * Export drugs to Excel
     */
    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DrugsExport, 'drugs.xlsx');
    }

    /**
     * Export drugs to PDF
     */
    public function exportPdf()
    {
        $drugs = Drug::orderBy('name')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('drugs.pdf', compact('drugs'));
        return $pdf->download('drugs.pdf');
    }
}
