<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $product = Product::latest()->get();
            return datatables()->of($product)
                ->addIndexColumn()
                ->addColumn('price', function ($row) {
                    return 'Rp.' . number_format($row->price, 2, ',', '.');
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" data-id="' . $row->id . '" class="gallery btn btn-info mr-1 btn-sm " > <i class="fas fa-photo-video"></i></a><a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-warning mr-1 btn-sm " > <i class="fas fa-pen"></i></a><a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm "> <i class="fas fa-trash-alt"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $category = Category::all();
        return view('pages.product', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer'
        ]);
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $product = Product::create($data);
        return response()->json($product);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|between:0,99.99',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer'
        ]);
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $product = Product::findOrFail($id)->update($data);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id)->delete();
        return response()->json($product);
    }
}
