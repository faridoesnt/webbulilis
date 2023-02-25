<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\TransactionDetail;

use App\Exports\TransactionExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdminTransactionController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            $query = TransactionDetail::with(['product', 'transaction']);

            return Datatables::of($query)
                ->addColumn('code', function($item) {
                    return $item->transaction->code;
                })
                ->addColumn('code_details', function($item) {
                    return $item->code;
                })
                ->addColumn('product', function($item) {
                    return $item->product->name;
                })
                ->addColumn('size', function($item) {
                    return $item->size;
                })
                ->addColumn('qty', function($item) {
                    return $item->qty;
                })
                ->addColumn('product_price', function($item) {
                    return $item->price;
                })
                ->addColumn('total_product_price', function($item) {
                    return $item->total_price;
                })
                ->addColumn('shipping_price', function($item) {
                    return $item->transaction->shipping_price;
                })
                ->addColumn('total_price', function($item) {
                    return $item->transaction->total_price;
                })
                ->addColumn('courier', function($item) {
                    return $item->courier;
                })
                ->addColumn('service', function($item) {
                    return $item->service;
                })
                ->addColumn('transaction_status', function($item) {
                    if($item->transaction->transaction_status == 'PENDING'){
                    return 
                        '
                        <div class="btn btn-danger">
                            PENDING
                        </div>
                        ';
                    }
                    elseif($item->transaction->transaction_status == 'SUCCESS'){
                        return 
                        '
                        <div class="btn btn-success">
                            SUCCESS
                        </div>
                        ';
                    }
                })
                ->addColumn('resi', function($item) {
                    return $item->resi;
                })
                ->addColumn('shipping_status', function($item) {
                    if($item->shipping_status == 'PENDING'){
                    return 
                        '
                        <div class="btn btn-danger">
                            PENDING
                        </div>
                        ';
                    }
                    elseif($item->shipping_status == 'SHIPPING'){
                        return 
                        '
                        <div class="btn btn-primary">
                            SHIPPING
                        </div>
                        ';
                    }
                    else {
                        return 
                        '
                        <div class="btn btn-success">
                            SUCCESS
                        </div>
                        ';
                    }
                })
                ->addColumn('action', function($item) {
                    return '
                        <div class="btn-group">
                            <a class="btn btn-dark" href="' . route('transactions.edit',  $item->id) .'">
                                Sunting
                            </a>
                        </div>
                    ';
                })
                ->rawColumns(['code', 'code_details', 'product', 'size', 'qty', 'product_price', 'total_product_price', 'shipping_price', 'total_price', 'resi', 'transaction_status', 'shipping_status', 'action'])
                ->make()
                ;
        }
        return view('pages.admin.transaction.index');
    }

    public function edit($id)
    {
        $item = TransactionDetail::with(['product', 'transaction'])->findOrfail($id);

        return view('pages.admin.transaction.edit', [
            'item'          => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = TransactionDetail::findOrfail($id);

        $item->update($data);

        return redirect()->route('transactions.index');
    }

    public function export()
    {
        $date = Carbon::now();
        $date2 = Carbon::parse($date)->format('F Y');

        return Excel::download(new TransactionExport, 'UMKM - Universitas Gunadarma '. $date2 .'.xlsx');
    }
}
