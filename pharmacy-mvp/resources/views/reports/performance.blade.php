<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">
                    ⚡ Performance Reports
                </h2>
                <p class="text-gray-600 mt-1">Staff performance, product analytics, and business insights</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-lg">
                    <span class="font-medium">Period:</span> {{ ucfirst($period) }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Period Filter -->
            <div class="mb-8">
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📅 Filter by Period</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('reports.performance', ['period' => 'today']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'today' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Today
                        </a>
                        <a href="{{ route('reports.performance', ['period' => 'week']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'week' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            This Week
                        </a>
                        <a href="{{ route('reports.performance', ['period' => 'month']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'month' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            This Month
                        </a>
                        <a href="{{ route('reports.performance', ['period' => 'year']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'year' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            This Year
                        </a>
                        <a href="{{ route('reports.performance', ['period' => 'all']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'all' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            All Time
                        </a>
                    </div>
                </div>
            </div>

            <!-- Staff Performance -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">👥 Staff Performance</h3>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        @if($staffPerformance->count() > 0)
                            <div class="space-y-4">
                                @foreach($staffPerformance as $index => $staff)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-blue-600">{{ $index + 1 }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $staff->server ? $staff->server->name : 'Unknown Staff' }}
                                                </p>
                                                <p class="text-xs text-gray-500">{{ number_format($staff->total_sales) }} sales</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">GH₵{{ number_format($staff->total_revenue, 2) }}</p>
                                            <p class="text-xs text-gray-500">Total revenue</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No staff performance data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Performance -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">🏆 Top Performing Products</h3>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        @if($productPerformance->count() > 0)
                            <div class="space-y-4">
                                @foreach($productPerformance as $index => $product)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-yellow-600">{{ $index + 1 }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $product->drug ? $product->drug->name : 'Unknown Product' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $product->drug ? $product->drug->manufacturer : 'Unknown Manufacturer' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($product->total_sold) }}</p>
                                            <p class="text-xs text-gray-500">units sold</p>
                                            <p class="text-sm font-semibold text-green-600">GH₵{{ number_format($product->total_revenue, 2) }}</p>
                                            <p class="text-xs text-gray-500">revenue</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No product performance data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Performance Metrics</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Staff Metrics -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">👥 Staff Overview</h4>
                        <div class="space-y-3">
                            @if($staffPerformance->count() > 0)
                                @php
                                    $totalStaffSales = $staffPerformance->sum('total_sales');
                                    $totalStaffRevenue = $staffPerformance->sum('total_revenue');
                                    $avgSalesPerStaff = $totalStaffSales / $staffPerformance->count();
                                    $avgRevenuePerStaff = $totalStaffRevenue / $staffPerformance->count();
                                @endphp
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Total Staff</span>
                                    <span class="text-sm font-semibold text-blue-600">{{ $staffPerformance->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Total Sales</span>
                                    <span class="text-sm font-semibold text-green-600">{{ number_format($totalStaffSales) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Total Revenue</span>
                                    <span class="text-sm font-semibold text-purple-600">GH₵{{ number_format($totalStaffRevenue, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Avg Sales/Staff</span>
                                    <span class="text-sm font-semibold text-orange-600">{{ number_format($avgSalesPerStaff, 1) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Avg Revenue/Staff</span>
                                    <span class="text-sm font-semibold text-green-600">GH₵{{ number_format($avgRevenuePerStaff, 2) }}</span>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">No staff data available</p>
                            @endif
                        </div>
                    </div>

                    <!-- Product Metrics -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">🏆 Product Overview</h4>
                        <div class="space-y-3">
                            @if($productPerformance->count() > 0)
                                @php
                                    $totalProductsSold = $productPerformance->sum('total_sold');
                                    $totalProductRevenue = $productPerformance->sum('total_revenue');
                                    $avgUnitsPerProduct = $totalProductsSold / $productPerformance->count();
                                    $avgRevenuePerProduct = $totalProductRevenue / $productPerformance->count();
                                @endphp
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Products Sold</span>
                                    <span class="text-sm font-semibold text-blue-600">{{ $productPerformance->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Total Units Sold</span>
                                    <span class="text-sm font-semibold text-green-600">{{ number_format($totalProductsSold) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Total Revenue</span>
                                    <span class="text-sm font-semibold text-purple-600">GH₵{{ number_format($totalProductRevenue, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Avg Units/Product</span>
                                    <span class="text-sm font-semibold text-orange-600">{{ number_format($avgUnitsPerProduct, 1) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Avg Revenue/Product</span>
                                    <span class="text-sm font-semibold text-green-600">GH₵{{ number_format($avgRevenuePerProduct, 2) }}</span>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">No product data available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Insights -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">💡 Performance Insights</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Top Performer -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">🥇 Top Performer</h4>
                        @if($staffPerformance->count() > 0)
                            @php $topStaff = $staffPerformance->first(); @endphp
                            <div class="text-center">
                                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $topStaff->server ? $topStaff->server->name : 'Unknown Staff' }}
                                </p>
                                <p class="text-sm text-gray-600">{{ number_format($topStaff->total_sales) }} sales</p>
                                <p class="text-lg font-bold text-green-600">GH₵{{ number_format($topStaff->total_revenue, 2) }}</p>
                            </div>
                        @else
                            <p class="text-gray-500 text-center">No staff data available</p>
                        @endif
                    </div>

                    <!-- Best Selling Product -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">🏆 Best Seller</h4>
                        @if($productPerformance->count() > 0)
                            @php $topProduct = $productPerformance->first(); @endphp
                            <div class="text-center">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $topProduct->drug ? $topProduct->drug->name : 'Unknown Product' }}
                                </p>
                                <p class="text-sm text-gray-600">{{ number_format($topProduct->total_sold) }} units sold</p>
                                <p class="text-lg font-bold text-green-600">GH₵{{ number_format($topProduct->total_revenue, 2) }}</p>
                            </div>
                        @else
                            <p class="text-gray-500 text-center">No product data available</p>
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

                    <a href="{{ route('reports.inventory') }}" class="group">
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md hover:border-green-300 transition-all duration-200">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-green-600 transition-colors">Inventory Reports</h4>
                                    <p class="text-sm text-gray-600">Stock management</p>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
