<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Drug Details: ') . $drug->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('drugs.edit', $drug) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Drug
                </a>
                <a href="{{ route('drugs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Alerts -->
            @if($drug->isExpired() || $drug->isExpiringSoon() || $drug->isLowStock())
                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if($drug->isExpired())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-bold">EXPIRED</span>
                            </div>
                            <div class="text-sm">This drug expired on {{ $drug->expiry_date->format('M d, Y') }}</div>
                        </div>
                    @elseif($drug->isExpiringSoon())
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-bold">EXPIRING SOON</span>
                            </div>
                            <div class="text-sm">Expires on {{ $drug->expiry_date->format('M d, Y') }}</div>
                        </div>
                    @endif

                    @if($drug->isLowStock())
                        <div class="bg-orange-100 border border-orange-400 text-orange-700 px-4 py-3 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-bold">LOW STOCK</span>
                            </div>
                            <div class="text-sm">Only {{ $drug->quantity }} units left (threshold: {{ $drug->low_stock_threshold }})</div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Drug Information Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Basic Information</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Drug Name</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $drug->name }}</p>
                            </div>

                            @if($drug->manufacturer)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Manufacturer</label>
                                    <p class="mt-1 text-gray-900">{{ $drug->manufacturer }}</p>
                                </div>
                            @endif

                            @if($drug->description)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Description</label>
                                    <p class="mt-1 text-gray-900">{{ $drug->description }}</p>
                                </div>
                            @endif

                            @if($drug->batch_number)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Batch Number</label>
                                    <p class="mt-1 text-gray-900">{{ $drug->batch_number }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Stock & Pricing Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Stock & Pricing</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Current Quantity</label>
                                <p class="mt-1 text-lg font-semibold {{ $drug->isLowStock() ? 'text-orange-600' : 'text-gray-900' }}">
                                    {{ $drug->quantity }} units
                                    @if($drug->isLowStock())
                                        <span class="text-sm text-orange-600">(Low Stock)</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Unit Price</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">GH₵{{ number_format($drug->unit_price, 2) }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Total Value</label>
                                <p class="mt-1 text-lg font-semibold text-green-600">
                                    GH₵{{ number_format($drug->quantity * $drug->unit_price, 2) }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Low Stock Threshold</label>
                                <p class="mt-1 text-gray-900">{{ $drug->low_stock_threshold }} units</p>
                            </div>

                            @if($drug->expiry_date)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Expiry Date</label>
                                    <p class="mt-1 text-gray-900 {{ $drug->isExpired() ? 'text-red-600' : ($drug->isExpiringSoon() ? 'text-yellow-600' : '') }}">
                                        {{ $drug->expiry_date->format('M d, Y') }}
                                        @if($drug->isExpired())
                                            <span class="text-sm">(Expired)</span>
                                        @elseif($drug->isExpiringSoon())
                                            <span class="text-sm">({{ $drug->expiry_date->diffInDays(now()) }} days remaining)</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Record Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">Created:</span> {{ $drug->created_at->format('M d, Y \a\t g:i A') }}
                            </div>
                            <div>
                                <span class="font-medium">Last Updated:</span> {{ $drug->updated_at->format('M d, Y \a\t g:i A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('drugs.edit', $drug) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Drug
                            </a>
                            
                            <form action="{{ route('drugs.destroy', $drug) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this drug? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Drug
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
