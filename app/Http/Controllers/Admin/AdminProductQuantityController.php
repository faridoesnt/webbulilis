<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Requests\Admin\ProductQuantityRequest;

use App\Models\ProductQuantity;
use App\Models\Product;

use Yajra\DataTables\Facades\DataTables;

class AdminProductQuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = ProductQuantity::with(['product']);

            return Datatables::of($query)
                ->addColumn('action', function($item) {
                    if($item->status == 'Aktif'){
                    return '
                        <div class="btn-group">
                            <form action="' . route('product-quantity-status',  $item->id) .'" method="POST">
                                '. csrf_field() . '
                                <button type="submit" class="btn btn-danger mr-1 mb-1">
                                    Nonaktifkan
                                </button>
                            </form>
                        </div>
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle mr-1 mb-1"
                                        type="button"
                                        data-toggle="dropdown">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="' . route('product-quantity.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('product-quantity.destroy',  $item->id) .'" method="POST">
                                        '. method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                    } else {
                        return '
                        <div class="btn-group">
                            <form action="' . route('product-quantity-status',  $item->id) .'" method="POST">
                                '. csrf_field() . '
                                <button type="submit" class="btn btn-success mr-1 mb-1">
                                    Aktifkan
                                </button>
                            </form>
                        </div>
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle mr-1 mb-1"
                                        type="button"
                                        data-toggle="dropdown">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="' . route('product-quantity.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('product-quantity.destroy',  $item->id) .'" method="POST">
                                        '. method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                    }
                })
                ->rawColumns(['action'])
                ->make()
                ;
        }

        return view('pages.admin.product-quantity.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products     = Product::all()->where('status', 'Aktif');

        return view('pages.admin.product-quantity.create', [
            'products'    => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductQuantityRequest $request)
    {
        $data = $request->all();
    
        ProductQuantity::create($data);

        return redirect()->route('product-quantity.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = ProductQuantity::findOrfail($id);

        $products     = Product::all()->where('status', 'Aktif');

        return view('pages.admin.product-quantity.edit', [
            'item'          => $item,
            'products'      => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductQuantityRequest $request, $id)
    {
        $data = $request->all();
    
        $item = ProductQuantity::findOrfail($id);

        $item->update($data);

        return redirect()->route('product-quantity.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = ProductQuantity::findOrfail($id);
        $item->delete();

        return redirect()->route('product-quantity.index');
    }

    public function status($id)
    {
        $item = ProductQuantity::findOrfail($id);

        if($item->status == "Aktif"){
            $update = ProductQuantity::where('id', $id)->update(['status' => 'Nonaktif']);
        } else {
            $update = ProductQuantity::where('id', $id)->update(['status' => 'Aktif']);
        }

        return redirect()->route('product-quantity.index');
    }
}
