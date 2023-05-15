<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Category::select('*'))
            ->addColumn('parent', function ($user) {
                return optional($user->parent)->name;
            })
            ->addColumn('action', 'categories.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('categories.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::ParentNull()->get()->pluck('name','id')->toArray();
        
        return view('categories.edit',compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $input = $request->only('name','parent_id');
        $newData = [
            'name' => $input['name'],
            'slug' => str()->slug($input['name'].date('-YmdHis')),
        ];
        if(!empty($input['parent_id'])){
            $newData['parent_id'] = $input['parent_id'];
        }
        Category::create($newData);
        return response()->json([
            'message' => 'Category has been created successfully.'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $role = Category::findOrFail($id);
            return view('categories.show',compact('role'));
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
            $category = Category::findOrFail($id);
            $parentCategories = Category::ParentNull()->get()->pluck('name','id')->toArray();

            return view('categories.edit',compact('category','parentCategories'));
        } catch (\Exception $e) {
            abort(404);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->only('name','parent_id');
        $newData = [
            'name' => $input['name'],
            'slug' => str()->slug($input['name'].date('-YmdHis')),
        ];
        if(!empty($input['parent_id'])){
            $newData['parent_id'] = $input['parent_id'];
        }
        try {
            $role = Category::findOrFail($id);
            if($role){
                $role->update($newData);
            }
            return response()->json([
                'message' => 'Category Has Been updated successfully'
            ], 200);
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
        $category = Category::where('id',$input['id']);
        if($category){
            $category->delete();
        }
        return response()->json($category);
    }
}
