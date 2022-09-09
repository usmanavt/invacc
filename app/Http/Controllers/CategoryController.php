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
            $q->where('title','LIKE',"%$search%")
            ->orWhere('nick','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('categories.index')->with('categories',$categories);
    }
 
    public function create()
    {
        return view('categories.create')->with('categories',Category::select('id','title')->get());
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|min:3|unique:categories',
                'nick' => 'required|min:3'
            ]);
        
        DB::beginTransaction();
        try {
            $category = new Category();
            $category->title = $request->title;
            $category->nick = $request->nick;
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
        return view('categories.edit')->with('category',Category::findOrFail($id));
    }

    public function update(Category $category,Request $request)
    {
        // dd($request->all());
        // dd($category);
        $request->validate(
        [
            'title' => 'required|min:3|unique:categories,title,' .$category->id,
            // 'nick' => 'required|min:3'
        ]);

        DB::beginTransaction();
        try {
            $category->title = $request->title;
            $category->nick = $request->nick;
            if($request->has('status'))
            {
                $category->status = 1;
            }else {
                $category->status = 0;
            }
            $category->save();
            DB::commit();
            Session::flash('info','Category updated');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
       
    }


    public function destroy(Category $category)
    {
        dd($category);
        return redirect()->back();
    }
}
