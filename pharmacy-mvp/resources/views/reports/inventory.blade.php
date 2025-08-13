<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">
                    📦 Inventory Reports
                </h2>
                <p class="text-gray-600 mt-1">Stock levels, expiry tracking, and inventory management</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-lg">
                    <span class="font-medium">Last updated:</span> {{ now()->format('M d, Y H:i') }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Inventory Overview Cards -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Inventory Overview</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Drugs -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-700">Total Drugs</p>
                                <p class="text-3xl font-bold text-blue-900">{{ number_format($inventoryOverview['total_drugs']) }}</p>
                                <p class="text-xs text-blue-600 mt-1">Products in stock</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Stock Value -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-700">Stock Value</p>
                                <p class="text-3xl font-bold text-green-900">GH₵{{ number_format($inventoryOverview['total_stock_value'], 2) }}</p>
                                <p class="text-xs text-green-600 mt-1">Total worth</p>
                            </div>
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Quantity -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-700">Total Quantity</p>
                                <p class="text-3xl font-bold text-purple-900">{{ number_format($inventoryOverview['total_quantity']) }}</p>
                                <p class="text-xs text-purple-600 mt-1">Units available</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Average Unit Price -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-orange-700">Avg Unit Price</p>
                                <p class="text-3xl font-bold text-orange-900">GH₵{{ number_format($inventoryOverview['average_unit_price'], 2) }}</p>
                                <p class="text-xs text-orange-600 mt-1">Per unit</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Status -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Stock Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($stockStatus['in_stock']) }}</div>
                        <div class="text-sm text-gray-600">In Stock</div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-red-600">{{ number_format($stockStatus['out_of_stock']) }}</div>
                        <div class="text-sm text-gray-600">Out of Stock</div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-orange-600">{{ number_format($stockStatus['low_stock']) }}</div>
                        <div class="text-sm text-gray-600">Low Stock</div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-red-600">{{ number_format($stockStatus['expired']) }}</div>
                        <div class="text-sm text-gray-600">Expired</div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ number_format($stockStatus['expiring_soon']) }}</div>
                        <div class="text-sm text-gray-600">Expiring Soon</div>
                    </div>
                </div>
            </div>

            <!-- Most Valuable Drugs -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">💰 Most Valuable Drugs</h3>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        @if($valuableDrugs->count() > 0)
                            <div class="space-y-4">
                                @foreach($valuableDrugs as $index => $drug)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-yellow-600">{{ $index + 1 }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">{{ $drug->name }}</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ number_format($drug->quantity) }} units • GH₵{{ number_format($drug->unit_price, 2) }} each
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">GH₵{{ number_format($drug->total_value, 2) }}</p>
                                            <p class="text-xs text-gray-500">Total value</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No inventory data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">⚠️ Low Stock Alerts</h3>
                <div class="bg-white border border-red-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        @if($lowStockDrugs->count() > 0)
                            <div class="space-y-4">
                                @foreach($lowStockDrugs as $drug)
                                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">{{ $drug->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $drug->manufacturer }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-red-600">{{ number_format($drug->quantity) }}</p>
                                            <p class="text-xs text-gray-500">units left</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No low stock alerts</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Expiring Soon -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📅 Expiring Soon</h3>
                <div class="bg-white border border-orange-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        @if($expiringDrugs->count() > 0)
                            <div class="space-y-4">
                                @foreach($expiringDrugs as $drug)
                                    <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">{{ $drug->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $drug->manufacturer }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-orange-600">{{ $drug->expiry_date->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500">Expires</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No expiring drugs</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Other Reports</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="{{ route('reports.index') }}" class="group">
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Dashboard</h4>
                                    <p class="text-sm text-gray-600">Main reports overview</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('reports.sales') }}" class="group">
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Sales Reports</h4>
                                    <p class="text-sm text-gray-600">Sales analytics</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('reports.financial') }}" class="group">
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md hover:border-yellow-300 transition-all duration-200">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-yellow-600 transition-colors">Financial Reports</h4>
                                    <p class="text-sm text-gray-600">Financial analysis</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('reports.performance') }}" class="group">
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md hover:border-purple-300 transition-all duration-200">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">Performance Reports</h4>
                                    <p class="text-sm text-gray-600">Performance insights</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
