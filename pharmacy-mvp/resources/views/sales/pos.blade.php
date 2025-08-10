<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Point of Sale') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('sales.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Sales History
                </a>
                <button id="clearCartBtn" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Clear Cart
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Drug Selection Panel -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Drug Inventory
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            <!-- Search Bar -->
                            <div class="mb-6">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           id="drugSearch" 
                                           placeholder="Search drugs by name, manufacturer, or batch..." 
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg">
                                </div>
                            </div>

                            <!-- Drugs Grid -->
                            <div id="drugsGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                                @foreach($drugs as $drug)
                                <div class="drug-card relative border border-gray-200 rounded-lg p-4 hover:border-blue-500 hover:shadow-lg transition-all duration-300 cursor-pointer transform hover:scale-105 hover:-translate-y-1 {{ $drug->isExpired() ? 'bg-red-50 border-red-200' : ($drug->isExpiringSoon() ? 'bg-yellow-50 border-yellow-200' : ($drug->isLowStock() ? 'bg-orange-50 border-orange-200' : 'hover:bg-blue-50')) }}"
                                      data-drug-id="{{ $drug->id }}"
                                      data-drug-name="{{ $drug->name }}"
                                      data-drug-price="{{ $drug->unit_price }}"
                                      data-drug-stock="{{ $drug->quantity }}"
                                      data-drug-manufacturer="{{ $drug->manufacturer ?? '' }}">
                                      
                                    <!-- Selection Indicator (hidden by default) -->
                                    <div class="selection-indicator absolute -top-2 -right-2 bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold opacity-0 transform scale-0 transition-all duration-300 z-10">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    
                                    <!-- Cart Quantity Badge (hidden by default) -->
                                    <div class="cart-badge absolute -top-2 -left-2 bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold opacity-0 transform scale-0 transition-all duration-300 z-10">
                                        <span class="cart-count">0</span>
                                    </div>
                                    
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 text-sm">{{ $drug->name }}</h4>
                                            @if($drug->manufacturer)
                                                <p class="text-xs text-gray-600 mt-1">{{ $drug->manufacturer }}</p>
                                            @endif
                                        </div>
                                        
                                        <div class="text-right ml-2">
                                            <div class="text-lg font-bold text-green-600">GH₵{{ number_format($drug->unit_price, 2) }}</div>
                                            <div class="text-xs {{ $drug->isLowStock() ? 'text-orange-600' : 'text-gray-500' }}">
                                                Stock: {{ $drug->quantity }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Indicators -->
                                    <div class="mt-3 flex flex-wrap gap-1">
                                        @if($drug->isExpired())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                🚫 Expired
                                            </span>
                                        @elseif($drug->isExpiringSoon())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                ⏰ Expiring Soon
                                            </span>
                                        @endif
                                        
                                        @if($drug->isLowStock())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                ⚠️ Low Stock
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Expiry Date -->
                                    @if($drug->expiry_date)
                                        <div class="mt-2 text-xs text-gray-500">
                                            Expires: {{ $drug->expiry_date->format('M d, Y') }}
                                        </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart and Checkout Panel -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200 sticky top-6">
                        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m1.5 6h9m-9 0L5.5 19M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                                </svg>
                                Shopping Cart
                            </h3>
                        </div>

                        <div class="p-6">
                            <!-- Customer Information -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Customer Information</h4>
                                <div class="space-y-3">
                                    <input type="text" 
                                           id="customerName" 
                                           placeholder="Customer Name (Optional)" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <input type="text" 
                                           id="customerPhone" 
                                           placeholder="Phone Number (Optional)" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                </div>
                            </div>

                            <!-- Cart Items -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Cart Items</h4>
                                <div id="cartItems" class="space-y-2 max-h-48 overflow-y-auto">
                                    <div id="emptyCart" class="text-center py-8 text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m1.5 6h9m-9 0L5.5 19M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                                        </svg>
                                        <p class="text-sm">Cart is empty</p>
                                        <p class="text-xs">Click on drugs to add them</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Cart Summary -->
                            <div class="border-t border-gray-200 pt-4 mb-6">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span>Subtotal:</span>
                                        <span id="subtotal" class="font-medium">GH₵0.00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Discount:</span>
                                        <input type="number" 
                                               id="discount" 
                                               value="0" 
                                               min="0" 
                                               step="0.01"
                                               class="w-20 px-2 py-1 text-right border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-green-500">
                                    </div>
                                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                                        <span>Total:</span>
                                        <span id="total" class="text-green-600">GH₵0.00</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Payment Method</h4>
                                <select id="paymentMethod" class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="insurance">Insurance</option>
                                </select>
                            </div>

                            <!-- Amount Paid -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Amount Paid</h4>
                                <input type="number" 
                                       id="amountPaid" 
                                       placeholder="0.00" 
                                       min="0" 
                                       step="0.01"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md text-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <div id="changeAmount" class="mt-2 text-sm font-medium text-green-600"></div>
                            </div>

                            <!-- Checkout Button -->
                            <button id="checkoutBtn" 
                                    disabled 
                                    class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold text-lg hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors duration-200">
                                <span id="checkoutText">Complete Sale</span>
                                <svg id="checkoutLoader" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Sale Completed!</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Sale #<span id="saleNumber"></span> has been processed successfully.
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Change: GH₵<span id="changeDisplay"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="printReceiptBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Print Receipt
                    </button>
                    <button id="closeModalBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        New Sale
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // POS JavaScript initialized
        
        let cart = [];
        let lastSaleId = null;

        // Drug search functionality will be added in DOMContentLoaded

        // Drug card click event delegation will be added in DOMContentLoaded

        // Add to cart
        function addToCart(drugId) {
            const drugCard = document.querySelector(`[data-drug-id="${drugId}"]`);
            
            if (!drugCard) {
                console.error('Drug card not found for ID:', drugId);
                return;
            }
            
            const drugName = drugCard.dataset.drugName;
            const drugPrice = parseFloat(drugCard.dataset.drugPrice);
            const drugStock = parseInt(drugCard.dataset.drugStock);

            // Check if drug is already in cart
            const existingItem = cart.find(item => item.id === drugId);
            
            if (existingItem) {
                if (existingItem.quantity < drugStock) {
                    existingItem.quantity++;
                    existingItem.total = existingItem.quantity * existingItem.price;
                } else {
                    alert('Insufficient stock available!');
                    return;
                }
            } else {
                if (drugStock > 0) {
                    cart.push({
                        id: drugId,
                        name: drugName,
                        price: drugPrice,
                        quantity: 1,
                        stock: drugStock,
                        total: drugPrice
                    });
                } else {
                    alert('This drug is out of stock!');
                    return;
                }
            }

            // Visual feedback - click animation
            drugCard.style.transform = 'scale(0.95)';
            setTimeout(() => {
                drugCard.style.transform = '';
            }, 150);
            
            updateCartDisplay();
            updateTotals();
            updateDrugVisualIndicators();
        }

        // Remove from cart
        function removeFromCart(drugId) {
            cart = cart.filter(item => item.id !== drugId);
            updateCartDisplay();
            updateTotals();
            updateDrugVisualIndicators();
        }

        // Update quantity in cart
        function updateQuantity(drugId, quantity) {
            const item = cart.find(item => item.id === drugId);
            if (item) {
                if (quantity > 0 && quantity <= item.stock) {
                    item.quantity = parseInt(quantity);
                    item.total = item.quantity * item.price;
                } else if (quantity <= 0) {
                    removeFromCart(drugId);
                    return;
                } else {
                    alert('Quantity exceeds available stock!');
                    return;
                }
            }
            updateCartDisplay();
            updateTotals();
            updateDrugVisualIndicators();
        }

        // Update cart display
        function updateCartDisplay() {
            const cartContainer = document.getElementById('cartItems');
            
            if (cart.length === 0) {
                cartContainer.innerHTML = '<div id="emptyCart" class="text-center py-8 text-gray-500"><svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m1.5 6h9m-9 0L5.5 19M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path></svg><p class="text-sm">Cart is empty</p><p class="text-xs">Click on drugs to add them</p></div>';
                return;
            }

            let html = '';
            cart.forEach(item => {
                html += `
                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                        <div class="flex-1">
                            <h5 class="text-sm font-medium text-gray-900">${item.name}</h5>
                            <p class="text-xs text-gray-600">GH₵${item.price.toFixed(2)} each</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="number" 
                                   value="${item.quantity}" 
                                   min="1" 
                                   max="${item.stock}"
                                   data-drug-id="${item.id}"
                                   class="cart-quantity w-16 px-2 py-1 text-center border border-gray-300 rounded text-sm">
                            <button data-drug-id="${item.id}" class="cart-remove text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            cartContainer.innerHTML = html;
        }

        // Update totals
        function updateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + item.total, 0);
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const total = subtotal - discount;

            document.getElementById('subtotal').textContent = `GH₵${subtotal.toFixed(2)}`;
            document.getElementById('total').textContent = `GH₵${total.toFixed(2)}`;

            // Enable/disable checkout button
            const checkoutBtn = document.getElementById('checkoutBtn');
            checkoutBtn.disabled = cart.length === 0;

            calculateChange();
        }

        // Calculate change
        function calculateChange() {
            const total = parseFloat(document.getElementById('total').textContent.replace('GH₵', ''));
            const amountPaid = parseFloat(document.getElementById('amountPaid').value) || 0;
            const change = Math.max(0, amountPaid - total);

            const changeDisplay = document.getElementById('changeAmount');
            if (amountPaid > 0) {
                changeDisplay.textContent = `Change: GH₵${change.toFixed(2)}`;
                changeDisplay.className = change >= 0 ? 'mt-2 text-sm font-medium text-green-600' : 'mt-2 text-sm font-medium text-red-600';
            } else {
                changeDisplay.textContent = '';
            }
        }

        // Clear cart
        function clearCart() {
            if (cart.length > 0 && confirm('Are you sure you want to clear the cart?')) {
                cart = [];
                updateCartDisplay();
                updateTotals();
                updateDrugVisualIndicators();
                document.getElementById('customerName').value = '';
                document.getElementById('customerPhone').value = '';
                document.getElementById('discount').value = '0';
                document.getElementById('amountPaid').value = '';
            }
        }

        // Update visual indicators on drug cards
        function updateDrugVisualIndicators() {
            // Reset all indicators first
            document.querySelectorAll('.drug-card').forEach(card => {
                const drugId = parseInt(card.dataset.drugId);
                const selectionIndicator = card.querySelector('.selection-indicator');
                const cartBadge = card.querySelector('.cart-badge');
                const cartCount = card.querySelector('.cart-count');
                
                // Find item in cart
                const cartItem = cart.find(item => item.id === drugId);
                
                if (cartItem) {
                    // Drug is in cart - show indicators
                    card.classList.add('ring-2', 'ring-green-400', 'border-green-300');
                    
                    // Preserve status background colors but add green tint
                    if (!card.classList.contains('bg-red-50') && !card.classList.contains('bg-yellow-50') && !card.classList.contains('bg-orange-50')) {
                        card.classList.add('bg-green-50');
                        card.classList.remove('hover:bg-blue-50');
                    }
                    
                    // Show selection indicator
                    selectionIndicator.classList.remove('opacity-0', 'scale-0');
                    selectionIndicator.classList.add('opacity-100', 'scale-100');
                    
                    // Show and update quantity badge
                    cartBadge.classList.remove('opacity-0', 'scale-0');
                    cartBadge.classList.add('opacity-100', 'scale-100');
                    cartCount.textContent = cartItem.quantity;
                } else {
                    // Drug is not in cart - hide indicators
                    card.classList.remove('ring-2', 'ring-green-400', 'bg-green-50', 'border-green-300');
                    
                    if (!card.classList.contains('bg-red-50') && !card.classList.contains('bg-yellow-50') && !card.classList.contains('bg-orange-50')) {
                        card.classList.add('hover:bg-blue-50');
                    }
                    
                    // Hide indicators
                    selectionIndicator.classList.add('opacity-0', 'scale-0');
                    selectionIndicator.classList.remove('opacity-100', 'scale-100');
                    
                    cartBadge.classList.add('opacity-0', 'scale-0');
                    cartBadge.classList.remove('opacity-100', 'scale-100');
                    cartCount.textContent = '0';
                }
            });
        }

        // Process sale
        async function processSale() {
            if (cart.length === 0) {
                alert('Cart is empty!');
                return;
            }

            const amountPaid = parseFloat(document.getElementById('amountPaid').value);
            const total = parseFloat(document.getElementById('total').textContent.replace('GH₵', ''));
            
            if (!amountPaid || amountPaid < total) {
                alert('Please enter a valid amount paid!');
                return;
            }

            // Show loading
            const checkoutBtn = document.getElementById('checkoutBtn');
            const checkoutText = document.getElementById('checkoutText');
            const checkoutLoader = document.getElementById('checkoutLoader');
            
            checkoutBtn.disabled = true;
            checkoutText.textContent = 'Processing...';
            checkoutLoader.classList.remove('hidden');

            try {
                const saleData = {
                    customer_name: document.getElementById('customerName').value,
                    customer_phone: document.getElementById('customerPhone').value,
                    payment_method: document.getElementById('paymentMethod').value,
                    amount_paid: amountPaid,
                    discount_amount: parseFloat(document.getElementById('discount').value) || 0,
                    items: cart.map(item => ({
                        drug_id: item.id,
                        quantity: item.quantity,
                        unit_price: item.price
                    }))
                };

                const response = await fetch('{{ route("sales.process") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(saleData)
                });

                const result = await response.json();

                if (result.success) {
                    lastSaleId = result.sale_id;
                    document.getElementById('saleNumber').textContent = result.sale_number;
                    document.getElementById('changeDisplay').textContent = parseFloat(result.change_amount || 0).toFixed(2);
                    document.getElementById('successModal').classList.remove('hidden');
                    
                    // Clear cart after successful sale (without confirmation)
                    cart = [];
                    updateCartDisplay();
                    updateTotals();
                    updateDrugVisualIndicators();
                } else {
                    alert(result.message || 'Sale processing failed!');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while processing the sale.');
            } finally {
                // Hide loading
                checkoutBtn.disabled = false;
                checkoutText.textContent = 'Complete Sale';
                checkoutLoader.classList.add('hidden');
            }
        }

        // Close success modal
        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
            // Clear cart and reset indicators
            cart = [];
            updateCartDisplay();
            updateTotals();
            updateDrugVisualIndicators();
            // Clear form fields
            document.getElementById('customerName').value = '';
            document.getElementById('customerPhone').value = '';
            document.getElementById('discount').value = '0';
            document.getElementById('amountPaid').value = '';
            document.getElementById('changeAmount').textContent = '';
        }

        // Print receipt
        function printReceipt() {
            if (lastSaleId) {
                window.open(`{{ url('/sales') }}/${lastSaleId}/receipt`, '_blank');
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize POS system
            const drugCards = document.querySelectorAll('.drug-card');
            console.log(`POS initialized with ${drugCards.length} drugs available`);
            
            updateCartDisplay();
            updateTotals();
            updateDrugVisualIndicators();
            
            // Add event listeners
            document.getElementById('clearCartBtn').addEventListener('click', clearCart);
            document.getElementById('checkoutBtn').addEventListener('click', processSale);
            document.getElementById('printReceiptBtn').addEventListener('click', printReceipt);
            document.getElementById('closeModalBtn').addEventListener('click', closeSuccessModal);
            document.getElementById('discount').addEventListener('input', updateTotals);
            document.getElementById('amountPaid').addEventListener('input', calculateChange);
            
            // Add drug search functionality
            document.getElementById('drugSearch').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const drugCards = document.querySelectorAll('.drug-card');
                
                drugCards.forEach(card => {
                    const drugName = card.dataset.drugName.toLowerCase();
                    const drugManufacturer = card.dataset.drugManufacturer ? card.dataset.drugManufacturer.toLowerCase() : '';
                    
                    if (drugName.includes(searchTerm) || drugManufacturer.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
            
            // Add drug grid click event listener
            const drugsGrid = document.getElementById('drugsGrid');
            if (drugsGrid) {
                drugsGrid.addEventListener('click', function(e) {
                    const drugCard = e.target.closest('.drug-card');
                    if (drugCard) {
                        const drugId = parseInt(drugCard.dataset.drugId);
                        addToCart(drugId);
                    }
                });
            }
            
            // Cart item event delegation
            document.getElementById('cartItems').addEventListener('click', function(e) {
                if (e.target.closest('.cart-remove')) {
                    const drugId = parseInt(e.target.closest('.cart-remove').dataset.drugId);
                    removeFromCart(drugId);
                }
            });
            
            document.getElementById('cartItems').addEventListener('input', function(e) {
                if (e.target.classList.contains('cart-quantity')) {
                    const drugId = parseInt(e.target.dataset.drugId);
                    const quantity = parseInt(e.target.value);
                    updateQuantity(drugId, quantity);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
