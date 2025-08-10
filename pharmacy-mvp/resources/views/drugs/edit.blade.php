<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Drug: ') . $drug->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('drugs.show', $drug) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    View Details
                </a>
                <a href="{{ route('drugs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('drugs.update', $drug) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Drug Name -->
                            <div>
                                <x-input-label for="name" :value="__('Drug Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $drug->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Manufacturer -->
                            <div>
                                <x-input-label for="manufacturer" :value="__('Manufacturer')" />
                                <x-text-input id="manufacturer" name="manufacturer" type="text" class="mt-1 block w-full" :value="old('manufacturer', $drug->manufacturer)" />
                                <x-input-error class="mt-2" :messages="$errors->get('manufacturer')" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $drug->description) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <!-- Quantity -->
                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="number" min="0" class="mt-1 block w-full" :value="old('quantity', $drug->quantity)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                                @if($drug->isLowStock())
                                    <p class="mt-1 text-sm text-yellow-600">⚠️ Current stock is below threshold ({{ $drug->low_stock_threshold }})</p>
                                @endif
                            </div>

                            <!-- Unit Price -->
                            <div>
                                <x-input-label for="unit_price" :value="__('Unit Price (GH₵)')" />
                                <x-text-input id="unit_price" name="unit_price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('unit_price', $drug->unit_price)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('unit_price')" />
                            </div>

                            <!-- Low Stock Threshold -->
                            <div>
                                <x-input-label for="low_stock_threshold" :value="__('Low Stock Threshold')" />
                                <x-text-input id="low_stock_threshold" name="low_stock_threshold" type="number" min="1" class="mt-1 block w-full" :value="old('low_stock_threshold', $drug->low_stock_threshold)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('low_stock_threshold')" />
                                <p class="mt-1 text-sm text-gray-600">Alert when quantity falls below this number</p>
                            </div>

                            <!-- Expiry Date -->
                            <div>
                                <x-input-label for="expiry_date" :value="__('Expiry Date')" />
                                <x-text-input id="expiry_date" name="expiry_date" type="date" class="mt-1 block w-full" :value="old('expiry_date', $drug->expiry_date?->format('Y-m-d'))" />
                                <x-input-error class="mt-2" :messages="$errors->get('expiry_date')" />
                                @if($drug->expiry_date)
                                    @if($drug->isExpired())
                                        <p class="mt-1 text-sm text-red-600">🚫 This drug has expired</p>
                                    @elseif($drug->isExpiringSoon())
                                        <p class="mt-1 text-sm text-yellow-600">⏰ This drug is expiring soon</p>
                                    @endif
                                @endif
                            </div>

                            <!-- Batch Number -->
                            <div>
                                <x-input-label for="batch_number" :value="__('Batch Number')" />
                                <x-text-input id="batch_number" name="batch_number" type="text" class="mt-1 block w-full" :value="old('batch_number', $drug->batch_number)" />
                                <x-input-error class="mt-2" :messages="$errors->get('batch_number')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('drugs.show', $drug) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Drug') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
