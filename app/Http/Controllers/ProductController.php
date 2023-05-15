<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Product::select('*'))
            ->addColumn('image', 'products.image')
            ->addColumn('action', 'products.action')
            ->rawColumns(['action','image'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('products.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::get()->pluck('name','id')->toArray();    
        return view('products.edit',compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|numeric|between:0,49999.99',
            'category_id' => 'required',
            'options.size' => 'required|array|min:1',
            'options.price' => 'required|array|min:1',
        ]);
        $input = $request->all();
        $newData = [
            'name' => $input['name'],
            'slug' => str()->slug($input['name'].date('-YmdHis')),
            'price' => $input['price'],
            'category_id' => $input['category_id'],
            'description' => $input['description'],
            'options' => $input['options']
        ];
        Product::create($newData);
        return redirect()->route('products.index')
        ->with('success','Product has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('products.show',compact('product'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $parentCategories = Category::ParentNull()->get()->pluck('name','id')->toArray();
            return view('products.edit',compact('product','parentCategories'));
        } catch (\Exception $e) {
            abort(404);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|numeric|between:0,49999.99',
            'category_id' => 'required',
            'options.size' => 'required|array|min:1',
            'options.price' => 'required|array|min:1',
        ]);
        $input = $request->all();
        $newData = [
            'name' => $input['name'],
            'slug' => str()->slug($input['name'].date('-YmdHis')),
            'price' => $input['price'],
            'category_id' => $input['category_id'],
            'description' => $input['description'],
            'options' => $input['options']
        ];
        try {
            $role = Product::findOrFail($id);
            if($role){
                $role->update($newData);
            }
            return redirect()
                ->route('products.index')
                ->with('success','Product Has Been updated successfully');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)// string $id
    {
        $input = $request->only('id');
        $category = Product::where('id',$input['id']);
        if($category){
            $category->delete();
        }
        return response()->json($category);
    }

    public function productImage(Request $request)// string $id
    {
        $input = $request->all();
        $image = ProductImage::where('id',$input['id']);
        if($image){
            $image->delete();
        }
        return response()->json($image);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function uploadImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|max:255',
        ]);
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('storage/products'), $filename);
            $newData = [
                'product_id' => $id,
                'image' => $filename,
            ];
        try {
            $image = ProductImage::create($newData);
            return response()->json([
                'message' => 'Category Has Been updated successfully',
                'data' => [
                    'id' => $image->id,
                    'image' => $image->image_url
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => []
            ], 200);
        }        
    }
}
