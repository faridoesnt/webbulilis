<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Requests\Admin\ProductRequest;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;

use Yajra\DataTables\Facades\DataTables;

class AdminProductController extends Controller
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
            $query = Product::with(['user', 'category'], ['name', 'desc']);

            return Datatables::of($query)
                ->addColumn('action', function($item) {
                    if($item->status == 'Aktif'){
                    return '
                        <div class="btn-group">
                            <form action="' . route('product-status',  $item->id) .'" method="POST">
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
                                    <a class="dropdown-item" href="' . route('product.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('product.destroy',  $item->id) .'" method="POST">
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
                            <form action="' . route('product-status',  $item->id) .'" method="POST">
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
                                    <a class="dropdown-item" href="' . route('product.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('product.destroy',  $item->id) .'" method="POST">
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

        return view('pages.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users          = User::where('roles', 'ADMIN')->get();
        $categories     = Category::all()->where('status', 'Aktif');

        return view('pages.admin.product.create', [
            'users'         => $users,
            'categories'    => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug']       = Str::slug($request->name);
        $data['price']      = preg_replace('/\D/','',$data['price']); // menghilangkan format rupiah (example Rp. 1.000 menjadi 1000)

        Product::create($data);

        return redirect()->route('product.index');
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
        $item = Product::findOrfail($id);

        $users          = User::all();
        $categories     = Category::all()->where('status', 'Aktif');

        return view('pages.admin.product.edit', [
            'item'          => $item,
            'users'         => $users,
            'categories'    => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrfail($id);

        $data['slug']   = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::findOrfail($id);
        $item->delete();

        return redirect()->route('product.index');
    }

    public function status($id)
    {
        $item = Product::findOrfail($id);

        if($item->status == "Aktif"){
            $update = Product::where('id', $id)->update(['status' => 'Nonaktif']);
        } else {
            $update = Product::where('id', $id)->update(['status' => 'Aktif']);
        }

        return redirect()->route('product.index');
    }
}
