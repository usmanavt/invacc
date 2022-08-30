<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $categories = Category::where(function($q) use ($search){
            $q->where('iname0','LIKE',"%$search%")
            ->orWhere('inname0','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('categories.index')->with('categories',$categories);
    }
 
    public function create()
    {
        return view('categories.create')->with('categories',Category::select('id','iname0')->get());
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'iname0' => 'required|min:3|unique:tbleItem0',
                'inname0' => 'required|min:3'
            ]);
        
        DB::beginTransaction();
        try {
            $category = new Category();
            $category->iname0 = $request->iname0;
            $category->inname0 = $request->inname0;
            $category->save();
            DB::commit();
            Session::flash('success','Category created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function show(Itemcategory $itemcategory)
    {
        //
    }

    public function edit($id)
    {
        $category=Category::find($id);
        if (is_null($category))
        {
            // NOT FOUND
            return redirect()->back();
        }
            else
        {
            $data=compact('category');
            return view('categories.edit')->with($data);
        };
    }

    public function update(Category $category,Request $request)
    {
        // dd($request->all());
        // dd($category);
        $request->validate(
        [
            'iname0' => 'required|min:3|unique:tbleItem0,iname0,' .$category->id,
            // 'inname0' => 'required|min:3'
        ]);

        DB::beginTransaction();
        try {
            $category->iname0 = $request->iname0;
            $category->inname0 = $request->inname0;
            $category->save();
            DB::commit();
            Session::flash('info','Category updated');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Itemcategory  $itemcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        dd($category);
    //     $itemcategory=Itemcategory::find($id);
    //         if(!is_null($itemcategory));
    // {
    //     ($itemcategory)->delete();


    // }
    return redirect()->back();
    }
}
