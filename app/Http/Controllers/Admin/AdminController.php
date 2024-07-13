<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $customer               = User::where('roles', 'USER')->count();
        $revenue                = Transaction::where('transaction_status', 'SUCCESS')->sum('total_price');
        $transaction            = TransactionDetail::count();

        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $currentMonthRevenue = Transaction::where('transaction_status', 'SUCCESS')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_price');

        return view('pages.admin.dashboard', [
            'customer'              => $customer,
            'revenue'               => $revenue,
            'transaction'           => $transaction,
            'current_month_revenue' => $currentMonthRevenue,
            'start_of_month'        => $startOfMonth,
            'end_of_month'         => $endOfMonth
        ]);
    }
}
