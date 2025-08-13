<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">
                    💰 Financial Reports
                </h2>
                <p class="text-gray-600 mt-1">Revenue analysis, financial performance, and payment insights</p>
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
                        <a href="{{ route('reports.financial', ['period' => 'today']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'today' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Today
                        </a>
                        <a href="{{ route('reports.financial', ['period' => 'week']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'week' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            This Week
                        </a>
                        <a href="{{ route('reports.financial', ['period' => 'month']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'month' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            This Month
                        </a>
                        <a href="{{ route('reports.financial', ['period' => 'year']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'year' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            This Year
                        </a>
                        <a href="{{ route('reports.financial', ['period' => 'all']) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === 'all' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            All Time
                        </a>
                    </div>
                </div>
            </div>

            <!-- Revenue Analysis Cards -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Revenue Analysis</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Revenue -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-700">Total Revenue</p>
                                <p class="text-3xl font-bold text-green-900">GH₵{{ number_format($revenueAnalysis['total_revenue'], 2) }}</p>
                                <p class="text-xs text-green-600 mt-1">Earnings</p>
                            </div>
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Average Order Value -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-700">Avg Order Value</p>
                                <p class="text-3xl font-bold text-blue-900">GH₵{{ number_format($revenueAnalysis['average_order_value'], 2) }}</p>
                                <p class="text-xs text-blue-600 mt-1">Per transaction</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-700">Total Orders</p>
                                <p class="text-3xl font-bold text-purple-900">{{ number_format($revenueAnalysis['total_orders']) }}</p>
                                <p class="text-xs text-purple-600 mt-1">Transactions</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Value -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-orange-700">Inventory Value</p>
                                <p class="text-3xl font-bold text-orange-900">GH₵{{ number_format($revenueAnalysis['inventory_value'], 2) }}</p>
                                <p class="text-xs text-orange-600 mt-1">Stock worth</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Method Analysis -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">💳 Payment Method Analysis</h3>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        @if($paymentAnalysis->count() > 0)
                            <div class="space-y-4">
                                @foreach($paymentAnalysis as $payment)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                @if($payment->payment_method === 'cash')
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                    </svg>
                                                @elseif($payment->payment_method === 'card')
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                    </svg>
                                                @elseif($payment->payment_method === 'mobile_money')
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                                <p class="text-xs text-gray-500">{{ number_format($payment->count) }} transactions</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">GH₵{{ number_format($payment->total, 2) }}</p>
                                            <p class="text-xs text-gray-500">Total amount</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No payment data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Financial Insights -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">💡 Financial Insights</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Revenue Growth -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">📈 Revenue Trends</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Total Revenue</span>
                                <span class="text-sm font-semibold text-green-600">GH₵{{ number_format($revenueAnalysis['total_revenue'], 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Average Order Value</span>
                                <span class="text-sm font-semibold text-blue-600">GH₵{{ number_format($revenueAnalysis['average_order_value'], 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Total Orders</span>
                                <span class="text-sm font-semibold text-purple-600">{{ number_format($revenueAnalysis['total_orders']) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Metrics -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">📦 Inventory Metrics</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Inventory Value</span>
                                <span class="text-sm font-semibold text-orange-600">GH₵{{ number_format($revenueAnalysis['inventory_value'], 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Revenue to Inventory Ratio</span>
                                <span class="text-sm font-semibold text-green-600">
                                    {{ $revenueAnalysis['inventory_value'] > 0 ? number_format($revenueAnalysis['total_revenue'] / $revenueAnalysis['inventory_value'], 2) : '0.00' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Period</span>
                                <span class="text-sm font-semibold text-gray-600">{{ ucfirst($period) }}</span>
                            </div>
                        </div>
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
