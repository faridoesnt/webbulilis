<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\TransactionDetail;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [];

        // mengambil transaksi detail yg didalamnya ada produk, yang dimana transaksi detail itu milik user yg sedang login
        $transactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
                            ->whereHas('transaction', function($transaction){
                                $transaction->where('users_id', Auth::user()->id);
                            });

        $revenue = $transactions->get()->reduce(function($carry, $item){
            return $carry + $item->price;
        });

        $data['transactions_count'] = $transactions->count();
        $data['transactions_data'] = $transactions->orderBy('created_at', 'desc')->paginate(3);
        $data['revenue']   = $revenue;

        $view = 'pages.dashboard';

        return response()->view($view, $data);
    }
}
