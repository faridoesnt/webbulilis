<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data =  [];

        $categories = Category::all()->where('status', 'Aktif');
        $products   = Product::with(['galleries'])->where('status', 'Aktif')->paginate(32);

        $data['categories'] = $categories;
        $data['products']   = $products;

        $view = 'pages.category';

        return response()->view($view, $data);
    }
    
    public function detail(Request $request, $slug)
    {
        $data =  [];

        $categories = Category::all()->where('status', 'Aktif');
        $category   = Category::where('slug', $slug)->firstOrfail();
        $products   = Product::with(['galleries'])->where('status', 'Aktif')->where('categories_id', $category->id)->paginate(32);

        $data['categories'] = $categories;
        $data['products']   = $products;

        $view = 'pages.category';

        return response()->view($view, $data);
    }
}
