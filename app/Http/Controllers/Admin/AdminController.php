<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class AdminController extends Controller
{
    public function index()
    {
        $customer       = User::where('roles', 'USER')->count();
        $revenue        = Transaction::where('transaction_status', 'SUCCESS')->sum('total_price');
        $transaction    = TransactionDetail::count();

        return view('pages.admin.dashboard', [
            'customer'      => $customer,
            'revenue'       => $revenue,
            'transaction'   => $transaction
        ]);
    }
}
