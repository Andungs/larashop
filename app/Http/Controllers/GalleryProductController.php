<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\GalleryProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class GalleryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gellery = GalleryProduct::latest()->get();
            return datatables()->of($gellery)
                ->addIndexColumn()
                ->addColumn('price', function ($row) {
                    return 'Rp.' . number_format($row->price, 2, ',', '.');
                })
                ->addColumn('product', function ($row) {
                    return $row->product->name;
                })
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm "> <i class="fas fa-trash-alt"></i></a>';
                })
                ->addColumn('is_default', function ($row) {
                    if ($row->is_default == 1) {
                        return '<span class="badge badge-info">Ya</span>';
                    } else {
                        return '<span class="badge badge-warning">Tidak</span>';
                    }
                })
                ->addColumn('photo', function ($row) {
                    return '<a href="javascript:void(0)" class="photo" data-id="' . $row->id . '"><img src="' . asset('storage') . '/' . $row->photo . '  " style="max-height:50px;" class="shadow-sm"></a>';
                })
                ->rawColumns(['action', 'is_default', 'photo'])
                ->make(true);
        }
        $product = Product::all();
        return view('pages.gallery', compact('product'));
    }

    public function getPhoto($id)
    {
        $gallery = GalleryProduct::findOrFail($id)->photo;
        return response()->json($gallery);
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
            'product_id' => 'required|integer',
            'photo' => 'required|image|max:1024',
            'is_default' => 'nullable|integer'
        ]);
        $data = $request->all();
        $data['photo'] = $request->photo->store('photo_product', 'public');
        $gallery = GalleryProduct::create($data);
        return response()->json($gallery);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = GalleryProduct::findOrFail($id);
        Storage::disk('public')->delete($gallery->photo);
        $gallery->delete();
    }
}
