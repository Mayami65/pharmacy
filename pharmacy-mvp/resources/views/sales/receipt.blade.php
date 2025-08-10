<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $sale->sale_number }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            width: 300px;
            color: #000;
        }
        .receipt {
            width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
        }
        .sale-info {
            margin-bottom: 15px;
            font-size: 11px;
        }
        .sale-info div {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }
        .items-header {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
            font-weight: bold;
            font-size: 11px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            font-size: 11px;
        }
        .item-name {
            flex: 2;
        }
        .item-qty {
            flex: 1;
            text-align: center;
        }
        .item-price {
            flex: 1;
            text-align: right;
        }
        .totals {
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 10px;
        }
        .totals div {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 11px;
        }
        .total-final {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            border-top: 2px dashed #000;
            padding-top: 10px;
            font-size: 10px;
        }
        .payment-info {
            margin: 10px 0;
            font-size: 11px;
        }
        .payment-info div {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <h1>IKEHORN PHARMACY</h1>
            <p>Professional Healthcare Services</p>
            <p>Ghana</p>
            <p>Tel: +233 XX XXX XXXX</p>
        </div>

        <!-- Sale Information -->
        <div class="sale-info">
            <div>
                <span>Receipt #:</span>
                <span>{{ $sale->sale_number }}</span>
            </div>
            <div>
                <span>Date:</span>
                <span>{{ $sale->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div>
                <span>Served by:</span>
                <span>{{ $sale->server->name }}</span>
            </div>
            @if($sale->customer_name)
            <div>
                <span>Customer:</span>
                <span>{{ $sale->customer_name }}</span>
            </div>
            @endif
            @if($sale->customer_phone)
            <div>
                <span>Phone:</span>
                <span>{{ $sale->customer_phone }}</span>
            </div>
            @endif
        </div>

        <!-- Items Header -->
        <div class="items-header">
            <div style="display: flex;">
                <div style="flex: 2;">ITEM</div>
                <div style="flex: 1; text-align: center;">QTY</div>
                <div style="flex: 1; text-align: right;">AMOUNT</div>
            </div>
        </div>

        <!-- Items -->
        @foreach($sale->items as $item)
        <div class="item">
            <div class="item-name">{{ $item->drug->name }}</div>
            <div class="item-qty">{{ $item->quantity }}</div>
            <div class="item-price">{{ number_format($item->line_total, 2) }}</div>
        </div>
        <div style="font-size: 10px; color: #666; margin-left: 10px;">
            @ GH₵{{ number_format($item->unit_price, 2) }} each
        </div>
        @endforeach

        <!-- Totals -->
        <div class="totals">
            <div>
                <span>Subtotal:</span>
                <span>GH₵{{ number_format($sale->subtotal, 2) }}</span>
            </div>
            @if($sale->discount_amount > 0)
            <div>
                <span>Discount:</span>
                <span>-GH₵{{ number_format($sale->discount_amount, 2) }}</span>
            </div>
            @endif
            @if($sale->tax_amount > 0)
            <div>
                <span>Tax:</span>
                <span>GH₵{{ number_format($sale->tax_amount, 2) }}</span>
            </div>
            @endif
        </div>

        <div class="total-final">
            <div>
                <span>TOTAL:</span>
                <span>GH₵{{ number_format($sale->total_amount, 2) }}</span>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="payment-info">
            <div>
                <span>Payment Method:</span>
                <span style="text-transform: capitalize;">{{ str_replace('_', ' ', $sale->payment_method) }}</span>
            </div>
            <div>
                <span>Amount Paid:</span>
                <span>GH₵{{ number_format($sale->amount_paid, 2) }}</span>
            </div>
            @if($sale->change_amount > 0)
            <div>
                <span>Change:</span>
                <span>GH₵{{ number_format($sale->change_amount, 2) }}</span>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Visit us again for quality healthcare</p>
            <p>{{ now()->format('d/m/Y H:i:s') }}</p>
            @if($sale->notes)
            <p style="margin-top: 10px; font-style: italic;">
                Note: {{ $sale->notes }}
            </p>
            @endif
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
