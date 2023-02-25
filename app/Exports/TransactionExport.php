<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\TransactionDetail;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */


    public function collection()
    {

        return TransactionDetail::select(
                                        'products.name',
                                        'transaction_details.size',
                                        'transaction_details.qty',
                                        'transaction_details.price',
                                        'transaction_details.total_price',
                                    )
                                    ->join('transactions', 'transactions.id', '=', 'transaction_details.transactions_id')
                                    ->join('products', 'products.id', '=', 'transaction_details.products_id')
                                    ->where('transactions.transaction_status', 'SUCCESS')
                                    ->whereMonth('transactions.created_at', Carbon::now()->month)
                                    ->get();
    }

    public function headings(): array
    {
        return [
            'Produk',
            'Ukuran',
            'Jumlah',
            'Harga Produk',
            'Total Harga Produk'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
