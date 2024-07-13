<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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

    public function receivedOrder(Request $request, $id)
    {
        $transactionDetail = TransactionDetail::where('transactions_id', $id)->first();
        $transactionDetail->shipping_status = 'SUCCESS';
        $transactionDetail->update();

        $transaction = Transaction::where('id', $id)->first();
        $transaction->transaction_status = 'SUCCESS';
        $transaction->update();

        $data = [];

        $transaction_details = TransactionDetail::with(['transaction.user', 'product.galleries'])->where('transactions_id', $id)->firstOrfail();

        $data['transaction_data'] = $transaction_details;

        return redirect()->route('dashboard-transaction-details', ['id' => $transaction_details->id]);
    }
}
