<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;

use App\Models\Cart;
use Midtrans\Config;
use App\Models\City2;
use App\Models\Product;
use App\Models\Province2;
use Midtrans\Notification;
use App\Models\Transaction;

use Illuminate\Http\Request;
use App\Models\ProductQuantity;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckoutController extends Controller
{
    public function index()
    {
        $data = [];

        $provinces  = Province2::pluck('name', 'province_id');
        $provinces2 = Province2::where('province_id', 9)->get();
        $cities2    = City2::where('city_id', 78)->get();

        $old_carts = Cart::with(['product.galleries', 'user'])->where('users_id', Auth::user()->id)->get();

        foreach ($old_carts as $cart)
        {
            if(!ProductQuantity::where('products_id', $cart->products_id)->where('size', $cart->size)->where('quantity', '>=', $cart->qty)->exists())
            {
                $remove_cart = Cart::where('users_id', Auth::user()->id)->where('products_id', $cart->products_id)->first();
                $remove_cart->delete();
            }
        }

        $new_carts = Cart::with(['product.galleries', 'user'])->where('users_id', Auth::user()->id)->get();

        $data['carts']      = $new_carts;
        $data['provinces']  = $provinces;
        $data['provinces2'] = $provinces2;
        $data['cities2']    = $cities2;

        $view = 'pages.checkout';

        return response()->view($view, $data);
    }

    public function getCities($id)
    {
        $city2 = City2::where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city2);
    }

    public function check_ongkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $request->city_origin, // ID kota/kabupaten asal
            'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
            'weight'        => $request->weight, // berat barang dalam gram
            'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        return response()->json($cost);   
    }
    
    public function proses(Request $request)
    {   
        // save users data
        $user = Auth::user()->update([
            'address_one'   => $request->address_one,
            'address_two'   => $request->address_two,
            'provinces_id'  => $request->province_origin,
            'regencies_id'  => $request->city_origin,
            'zip_code'      => $request->zip_code,
            'country'       => $request->country,
            'phone_number'  => $request->phone_number,
        ]);
        // $user->update($request->except('total_price'));

        $code = 'UMKM Universitas Gunadarma -' . mt_rand(0000, 9999);
        $carts = Cart::with(['product', 'user'])->where('users_id', Auth::user()->id)->get();

        // transaction create
        $transaction = Transaction::create([
            'users_id'              => Auth::user()->id,
            'product_price'         => (int) $request->product_price,
            'shipping_price'        => (int) $request->shipping_price,
            'total_price'           => (int) $request->total_price,
            'transaction_status'    => 'PENDING',
            'code'                  => $code,
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(0000, 9999);

            TransactionDetail::create([
                'transactions_id'   => $transaction->id,
                'products_id'       => $cart->product->id,
                'price'             => $cart->product->price,
                'shipping_status'   => 'PENDING',
                'resi'              => '',
                'code'              => $trx,
                'size'              => $cart->size,
                'qty'               => $cart->qty,
                'total_price'       => $cart->product->price * $cart->qty,
                'courier'           => $request->courier ?? '',
                'service'           => $request->service,
            ]);

            $quantity = ProductQuantity::where('products_id', $cart->product->id)->where('size', $cart->size)->firstOrfail();

            $quantity->update([
                'quantity' => $quantity->quantity - $cart->qty,
            ]);

            if($quantity->quantity == '0')
            {
                $quantity->update([
                    'status' => 'Nonaktif'
                ]);
            }
        }

        // delete cart
        Cart::where('users_id', Auth::user()->id)->delete();
        
        // configuration midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // buat array utk dikirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id'      => $code,
                'gross_amount'  => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name'    => Auth::user()->name,
                'email'         => Auth::user()->email,
            ],
            'enabled_payments' => [
                'gopay', 'permata_va', 'bank_transfer'
            ],
            'vtweb' => []
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            
            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback(Request $request)
    {
        // set konfigurasi midtrans
        Config::$serverKey      = config('services.midtrans.serverKey');
        Config::$isProduction   = config('services.midtrans.isProduction');
        Config::$isSanitized    = config('services.midtrans.isSanitized');
        Config::$is3ds          = config('services.midtrans.is3ds');

        // midtrans notif
        $notification = new Notification();

        // assign ke variable
        $status     = $notification->transaction_status;
        $type       = $notification->payment_type;
        $fraud      = $notification->fraud_status;
        $order_id   = $notification->order_id;

        // cari transaksi berdasarkan id
        $transaction = Transaction::where('code', $order_id)->first();

        // handle notif
        if($status == 'capture') {
            if($type == 'credit_card') {
                if($fraud == 'challenge') {
                    $transaction->transaction_status = 'PENDING';
                } else {
                    $transaction->transaction_status = 'SUCCESS';
                }
            }
        }

        else if ($status == 'settlement') {
            $transaction->transaction_status = 'SUCCESS';
            echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
        }

        else if ($status == 'pending') {
            $transaction->transaction_status = 'PENDING';
        }

        else if ($status == 'deny') {
            $transaction->transaction_status = 'CANCELLED';
        }
        
        else if ($status == 'expire') {
            $transaction->transaction_status = 'CANCELLED';
        }

        else if ($status == 'cancel') {
            $transaction->transaction_status = 'CANCELLED';
        }

        // simpan transaksi
        $transaction->save();
    }
}
