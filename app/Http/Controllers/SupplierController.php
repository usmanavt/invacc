<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Source;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $suppliers = Supplier::where(function($q) use ($search){
            $q->where('title','LIKE',"%$search%")
            ->orWhere('nick','LIKE',"%$search%")
            ->orWhere('phoneoff','LIKE',"%$search%")
            ->orWhere('phoneres','LIKE',"%$search%")
            ->orWhere('email','LIKE',"%$search%")
            ->orWhere('address','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(4);
        return view('suppliers.index')->with('suppliers',$suppliers);
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $suppliers = Supplier::where(function ($query) use ($search){
            $query->where('title','LIKE','%' . $search . '%')
            ->orWhere('address','LIKE','%' . $search . '%');

        })
        // ->with('Source:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $suppliers;
    }






    public function create()
    {
        return view('suppliers.create')->with('sources',Source::all());
    }

    public function store(Request $request)
    {
        $request->validate(
        [
             'title'=>'required|min:3|unique:suppliers'
        ]);

        DB::beginTransaction();
        //  dd($request->all());

        try {
            $supplier = new Supplier();
            $supplier->title = $request->title;
            $supplier->nick = $request->nick;
            $supplier->address = $request->address;
            $supplier->phoneoff = $request->phoneoff;
            $supplier->phoneres = $request->phoneres;
            $supplier->fax = $request->fax;
            $supplier->email = $request->email;
            if($request->has('status'))
            {
                $supplier->status = 1;
            }else {
                $supplier->status = 0;
            }
            $supplier->obalance = $request->obalance;
            $supplier->ntn = $request->ntn;
            $supplier->stax = $request->stax;
            $supplier->source_id = $request->source_id;
            $supplier->save();
            DB::commit();
            Session::flash('success','Supplier created');
            return redirect()->route('suppliers.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show')->with('supplier',$supplier);
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit')->with('supplier',$supplier)->with('sources',Source::all());
    }

    public function update(Supplier $supplier,Request $request )
    {
        $request->validate(
            [
                // 'title'=>'required|min:3|unique:suppliers,title,'.$supplier->id
            ]);
        DB::beginTransaction();
        try {
            $supplier->title = $request->title;
            $supplier->nick = $request->nick;
            $supplier->address = $request->address;
            $supplier->phoneoff = $request->phoneoff;
            $supplier->phoneres = $request->phoneres;
            $supplier->fax = $request->fax;
            $supplier->email = $request->email;
            if($request->has('status'))
            {
                $supplier->status =1;
            }else {
                $supplier->status = 0;
            }
            $supplier->obalance = $request->obalance;
            $supplier->ntn = $request->ntn;
            $supplier->stax = $request->stax;
            $supplier->source_id = $request->source_id;
            $supplier->save();
            DB::commit();
            Session::flash('info','Supplier updated');
            return redirect()->route('suppliers.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function destroy(Supplier $supplier)
    {

    }
}
