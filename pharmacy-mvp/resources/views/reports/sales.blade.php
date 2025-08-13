<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">
                    📊 Sales Reports
                </h2>
                <p class="text-gray-600 mt-1">Detailed sales analytics and performance insights</p>
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
            
            <!-- Sales Overview Cards -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📈 Sales Overview</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Sales -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-700">Total Sales</p>
                                <p class="text-3xl font-bold text-blue-900">{{ number_format($salesOverview['total_sales']) }}</p>
                                <p class="text-xs text-blue-600 mt-1">Transactions</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-700">Total Revenue</p>
                                <p class="text-3xl font-bold text-green-900">GH₵{{ number_format($salesOverview['total_revenue'], 2) }}</p>
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
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-700">Average Order</p>
                                <p class="text-3xl font-bold text-purple-900">GH₵{{ number_format($salesOverview['average_order_value'], 2) }}</p>
                                <p class="text-xs text-purple-600 mt-1">Per transaction</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Customers -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">👥 Top Customers</h3>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        @if($topCustomers->count() > 0)
                            <div class="space-y-4">
                                @foreach($topCustomers as $index => $customer)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-blue-600">{{ $index + 1 }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">{{ $customer->customer_name ?: 'Walk-in Customer' }}</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ number_format($customer->total_orders) }} orders
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">GH₵{{ number_format($customer->total_spent, 2) }}</p>
                                            <p class="text-xs text-gray-500">Total spent</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-500">No customer data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Period Filter -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📅 Filter by Period</h3>
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('reports.sales', ['period' => 'today']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium {{ $period === 'today' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Today
                        </a>
                        <a href="{{ route('reports.sales', ['period' => 'week']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium {{ $period === 'week' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            This Week
                        </a>
                        <a href="{{ route('reports.sales', ['period' => 'month']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium {{ $period === 'month' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            This Month
                        </a>
                        <a href="{{ route('reports.sales', ['period' => 'year']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium {{ $period === 'year' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            This Year
                        </a>
                        <a href="{{ route('reports.sales', ['period' => 'all']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium {{ $period === 'all' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            All Time
                        </a>
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

                    <a href="{{ route('reports.inventory') }}" class="group">
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md hover:border-green-300 transition-all duration-200">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-green-600 transition-colors">Inventory</h4>
                                    <p class="text-sm text-gray-600">Stock & inventory reports</p>
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
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-yellow-600 transition-colors">Financial</h4>
                                    <p class="text-sm text-gray-600">Revenue & financial reports</p>
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
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">Performance</h4>
                                    <p class="text-sm text-gray-600">Staff & product performance</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
