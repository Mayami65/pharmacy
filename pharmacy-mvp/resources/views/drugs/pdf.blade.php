<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Drug Inventory Report - {{ now()->format('Y-m-d') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 30px;
            margin-bottom: 10px;
        }
        .summary-label {
            font-weight: bold;
            color: #333;
        }
        .summary-value {
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }
        .status-expired {
            background-color: #fee;
            color: #c53030;
        }
        .status-expiring {
            background-color: #fef7e0;
            color: #d69e2e;
        }
        .status-low-stock {
            background-color: #fef2e0;
            color: #dd6b20;
        }
        .status-ok {
            background-color: #f0fff4;
            color: #38a169;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ikehorn Pharmacy</h1>
        <h2>Drug Inventory Report</h2>
        <p>Generated on {{ now()->format('F d, Y \a\t g:i A') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Drugs:</span>
            <span class="summary-value">{{ $drugs->count() }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Value:</span>
            <span class="summary-value">GH₵{{ number_format($drugs->sum(function($drug) { return $drug->quantity * $drug->unit_price; }), 2) }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Low Stock Items:</span>
            <span class="summary-value">{{ $drugs->filter(function($drug) { return $drug->isLowStock(); })->count() }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Expired Items:</span>
            <span class="summary-value">{{ $drugs->filter(function($drug) { return $drug->isExpired(); })->count() }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Expiring Soon:</span>
            <span class="summary-value">{{ $drugs->filter(function($drug) { return $drug->isExpiringSoon(); })->count() }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Manufacturer</th>
                <th>Quantity</th>
                <th>Unit Price (GH₵)</th>
                <th>Total Value (GH₵)</th>
                <th>Expiry Date</th>
                <th>Batch Number</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($drugs as $drug)
                <tr>
                    <td>{{ $drug->name }}</td>
                    <td>{{ $drug->manufacturer ?: 'N/A' }}</td>
                    <td>{{ $drug->quantity }}</td>
                    <td>GH₵{{ number_format($drug->unit_price, 2) }}</td>
                    <td>GH₵{{ number_format($drug->quantity * $drug->unit_price, 2) }}</td>
                    <td>{{ $drug->expiry_date ? $drug->expiry_date->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $drug->batch_number ?: 'N/A' }}</td>
                    <td>
                        @if($drug->isExpired())
                            <span class="status status-expired">EXPIRED</span>
                        @elseif($drug->isExpiringSoon())
                            <span class="status status-expiring">EXPIRING SOON</span>
                        @elseif($drug->isLowStock())
                            <span class="status status-low-stock">LOW STOCK</span>
                        @else
                            <span class="status status-ok">OK</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report contains {{ $drugs->count() }} drug(s) from Ikehorn Pharmacy inventory system.</p>
        <p>Report generated by Computerized Drug Monitoring System</p>
    </div>
</body>
</html>
