<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\Cart;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $data = [];

        $products           = Product::with(['galleries', 'user', 'quantity'])->where('slug', $id)->where('status', 'Aktif')->firstOrFail();
        $products_quantity  = ProductQuantity::where('products_id', $products->id)->where('status', 'Aktif')->get();

        $data['products']           = $products;
        $data['products_quantity']  = $products_quantity;

        $view = 'pages.detail';

        return response()->view($view, $data);
    }

    public function addToCart(Request $request, $id)
    {

        $data = [
            'products_id'   => $id,
            'size'          => $request->size,
            'qty'           => $request->qty,
            'users_id'      => Auth::user()->id,
        ];

        if(ProductQuantity::where('products_id', $id)->where('size', $request->size)->where('quantity', '>=', $request->qty)->exists())
        {
            if(Cart::where('products_id', $id)->where('size', $request->size)->where('users_id', Auth::user()->id)->exists())
            {
                $carts = Cart::where('products_id', $id)->where('size', $request->size)->where('users_id', Auth::user()->id)->firstOrfail();

                $carts->update([
                    'qty' => $carts->qty + $request->qty,
                ]);

                return redirect()->route('cart');
            } 
            else
            {
                Cart::create($data);
    
                return redirect()->route('cart');
            }
        } 
        else 
        {
            return redirect()->back()->with('error', 'Maaf, stok tidak cukup.');
        }

        // $data = [
        //     'products_id'   => $id,
        //     'size'          => $request->size,
        //     'qty'           => $request->qty,
        //     'users_id'      => Auth::user()->id,
        // ];

        // if(ProductQuantity::where('products_id', $id)->where('size', $request->size)->where('quantity', '>=', $request->qty)->exists())
        // {
        //     Cart::create($data);

        //     return redirect()->route('cart');
        // } 
        // else 
        // {
        //     return redirect()->back()->with('error', 'Sorry, not enough stock.');
        // }
    }
}
