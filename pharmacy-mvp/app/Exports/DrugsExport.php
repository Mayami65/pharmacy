<?php

namespace App\Exports;

use App\Models\Drug;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DrugsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Drug::orderBy('name')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Quantity',
            'Unit Price (GH₵)',
            'Expiry Date',
            'Low Stock Threshold',
            'Batch Number',
            'Manufacturer',
            'Status',
            'Created At'
        ];
    }

    /**
     * @param mixed $drug
     * @return array
     */
    public function map($drug): array
    {
        $status = [];
        if ($drug->isExpired()) {
            $status[] = 'EXPIRED';
        } elseif ($drug->isExpiringSoon()) {
            $status[] = 'EXPIRING SOON';
        }
        if ($drug->isLowStock()) {
            $status[] = 'LOW STOCK';
        }
        
        return [
            $drug->id,
            $drug->name,
            $drug->description,
            $drug->quantity,
            $drug->unit_price,
            $drug->expiry_date ? $drug->expiry_date->format('Y-m-d') : '',
            $drug->low_stock_threshold,
            $drug->batch_number,
            $drug->manufacturer,
            implode(', ', $status) ?: 'OK',
            $drug->created_at->format('Y-m-d H:i:s')
        ];
    }
}
