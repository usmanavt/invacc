<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $brands = Brand::where(function($q) use ($search){
            $q->where('brandname','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('brands.index')->with('brands',$brands);
    }

    public function create()
    {
        return view('brands.create')->with('brands',Brand::all());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'brandname'=>'required|min:2|unique:tblebrand',
        ]);

        DB::beginTransaction();
        try {
            $brand = new Brand();
            $brand->brandname = $request->brandname;
            if($request->has('sstatus'))
            {
                $brand->sstatus = 'Active';
            }
            else {
                $brand->sstatus = 'Deactive';
            }
            $brand->save();
            DB::commit();
            Session::flash('success','Brand created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
   
    public function edit(Brand $brand)
    {
        return view('brands.edit')->with('brand',$brand);
    }


    public function update(Brand $brand,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'brandname'=>'required|min:3|unique:tblebrand,brandname,'. $brand->id ,
        ]);

        DB::beginTransaction();
        try {
            $brand->brandname = $request->brandname;
            if($request->has('sstatus'))
            {
                $brand->sstatus = 'Active';
            }
            else {
                $brand->sstatus = 'Deactive';
            }
            $brand->save();
            DB::commit();
            Session::flash('info','Brand updated');
            return redirect()->route('brands.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function destroy($id)
    {
        return redirect()->back();
    }
}
