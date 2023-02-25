<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Requests\Admin\CategoryRequest;

use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

class AdminCategoryController extends Controller
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
            $query = Category::query();

            return Datatables::of($query)
                ->addColumn('action', function($item) {
                    if($item->status == 'Aktif'){
                    return '
                        <div class="btn-group">
                            <form action="' . route('category-status',  $item->id) .'" method="POST">
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
                                    <a class="dropdown-item" href="' . route('category.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('category.destroy',  $item->id) .'" method="POST">
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
                            <form action="' . route('category-status',  $item->id) .'" method="POST">
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
                                    <a class="dropdown-item" href="' . route('category.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('category.destroy',  $item->id) .'" method="POST">
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
                ->editColumn('photo', function($item) {
                    return $item->photo ? '<img src="'. Storage::url($item->photo) .'" style="max-height: 40px;" />' : '';
                })
                ->rawColumns(['action','photo'])
                ->make()
                ;
        }

        return view('pages.admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        $data['slug']   = Str::slug($request->name);
    
        Category::create($data);

        return redirect()->route('category.index');
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
        $item = Category::findOrfail($id);

        return view('pages.admin.category.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();

        $data['slug']   = Str::slug($request->name);
    
        $item = Category::findOrfail($id);

        $item->update($data);

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Category::findOrfail($id);
        $item->delete();

        return redirect()->route('category.index');
    }

    public function status($id)
    {
        $item = Category::findOrfail($id);

        if($item->status == "Aktif"){
            $update = Category::where('id', $id)->update(['status' => 'Nonaktif']);
        } else {
            $update = Category::where('id', $id)->update(['status' => 'Aktif']);
        }

        return redirect()->route('category.index');
    }
}
