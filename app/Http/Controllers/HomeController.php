<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $data = [];

        $categories = Category::take(6)->where('status', 'Aktif')->get();
        $products   = Product::with(['galleries'])->take(8)->where('status', 'Aktif')->orderBy('created_at', 'DESC')->get();

        $data['categories'] = $categories;
        $data['products']   = $products;

        $view = 'pages.home';

        return response()->view($view, $data);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
