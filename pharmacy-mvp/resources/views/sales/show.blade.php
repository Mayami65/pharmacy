<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sale Details') }} - {{ $sale->sale_number }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('sales.receipt', $sale) }}" target="_blank" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    View Receipt
                </a>
                @if($sale->status === 'pending')
                    <a href="{{ route('sales.edit', $sale) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Sale
                    </a>
                @endif
                <a href="{{ route('sales.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Sales
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Transaction Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaction Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Sale Number</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $sale->sale_number }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date & Time</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $sale->created_at->format('M d, Y H:i:s') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $sale->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($sale->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($sale->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800')) }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Served By</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $sale->server->name ?? 'Unknown' }}</p>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-900 mb-3">Customer Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $sale->customer_name ?: 'Walk-in Customer' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $sale->customer_phone ?: 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Items Sold -->
                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-900 mb-3">Items Sold</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Drug</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Line Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($sale->items as $item)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $item->drug->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $item->drug->manufacturer }}</div>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">GH₵{{ number_format($item->unit_price, 2) }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">GH₵{{ number_format($item->line_total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if($sale->notes)
                                <div class="mb-6">
                                    <h4 class="text-md font-semibold text-gray-900 mb-3">Notes</h4>
                                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $sale->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $sale->payment_method === 'cash' ? 'bg-green-100 text-green-800' : 
                                           ($sale->payment_method === 'card' ? 'bg-blue-100 text-blue-800' : 
                                           ($sale->payment_method === 'mobile_money' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}
                                    </span>
                                </div>

                                <div class="border-t pt-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Subtotal:</span>
                                        <span class="font-medium">GH₵{{ number_format($sale->subtotal, 2) }}</span>
                                    </div>
                                    @if($sale->discount_amount > 0)
                                        <div class="flex justify-between text-sm mt-1">
                                            <span class="text-gray-600">Discount:</span>
                                            <span class="font-medium text-green-600">-GH₵{{ number_format($sale->discount_amount, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($sale->tax_amount > 0)
                                        <div class="flex justify-between text-sm mt-1">
                                            <span class="text-gray-600">Tax:</span>
                                            <span class="font-medium">GH₵{{ number_format($sale->tax_amount, 2) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between text-lg font-bold mt-3 pt-3 border-t">
                                        <span>Total:</span>
                                        <span>GH₵{{ number_format($sale->total_amount, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm mt-2">
                                        <span class="text-gray-600">Amount Paid:</span>
                                        <span class="font-medium">GH₵{{ number_format($sale->amount_paid, 2) }}</span>
                                    </div>
                                    @if($sale->change_amount > 0)
                                        <div class="flex justify-between text-sm mt-1">
                                            <span class="text-gray-600">Change:</span>
                                            <span class="font-medium text-blue-600">GH₵{{ number_format($sale->change_amount, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <a href="{{ route('sales.receipt', $sale) }}" target="_blank" 
                                   class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Print Receipt
                                </a>
                                @if($sale->status === 'pending')
                                    <a href="{{ route('sales.edit', $sale) }}" 
                                       class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Sale
                                    </a>
                                @endif
                                <a href="{{ route('sales.index') }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Back to Sales
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
