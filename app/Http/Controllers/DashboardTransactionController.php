<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionDetail;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $data = [];

        // mengambil transaksi detail yg didalamnya ada produk, yang dimana transaksi detail itu milik user yg sedang login
        $transactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
                            ->whereHas('transaction', function($transaction){
                                $transaction->where('users_id', Auth::user()->id);
                            });

        $data['transactions_data'] = $transactions->orderBy('created_at', 'desc')->paginate(10);

        $view = 'pages.dashboard-transactions';

        return response()->view($view, $data);
    }

    public function details($id)
    {
        
        $data = [];

        $transaction_details = TransactionDetail::with(['transaction.user', 'product.galleries'])->where('id', $id)->firstOrfail();

        $data['transaction_data'] = $transaction_details;

        $view = 'pages.dashboard-transactions-details';

        return response()->view($view, $data);
    }
}
