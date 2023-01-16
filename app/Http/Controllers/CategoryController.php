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
        return view('categories.index');
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $categories = Category::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('title','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $categories;
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

}
