<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $suppliers = Supplier::where(function($q) use ($search){
            $q->where('sname','LIKE',"%$search%")
            ->orWhere('snname','LIKE',"%$search%")
            ->orWhere('sphoneoff','LIKE',"%$search%")
            ->orWhere('sphoneres','LIKE',"%$search%")
            ->orWhere('semail','LIKE',"%$search%")
            ->orWhere('spaddress','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('suppliers.index')->with('suppliers',$suppliers);
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate(
        [
            'sname'=>'required|min:3|unique:tblesupplier'
        ]);
        
        DB::beginTransaction();
        try {
            $supplier = new Supplier();
            $supplier->sname = $request->sname;
            $supplier->snname = $request->snname;
            $supplier->spaddress = $request->spaddress;
            $supplier->sphoneoff = $request->sphoneoff;
            $supplier->sphoneres = $request->sphoneres;
            $supplier->sfax = $request->sfax;
            $supplier->semail = $request->semail;
            if($request->has('sstatus'))
            {
                $supplier->sstatus = 'Active';
            }else {
                $supplier->sstatus = 'Deactive';
            }
            $supplier->obalance = $request->obalance;
            $supplier->ntnno = $request->ntnno;
            $supplier->staxNo = $request->staxNo;
            $supplier->srcId = $request->srcId == 1 ? 1:2;
            $supplier->save();
            DB::commit();
            Session::flash('success','Supplier created');
            return redirect()->back();
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
        return view('suppliers.edit')->with('supplier',$supplier);
    }

    public function update(Supplier $supplier,Request $request )
    {
        $request->validate(
            [
                'sname'=>'required|min:3|unique:tblesupplier,sname,'.$supplier->id 
            ]);
        DB::beginTransaction();
        try {
            $supplier->sname = $request->sname;
            $supplier->snname = $request->snname;
            $supplier->spaddress = $request->spaddress;
            $supplier->sphoneoff = $request->sphoneoff;
            $supplier->sphoneres = $request->sphoneres;
            $supplier->sfax = $request->sfax;
            $supplier->semail = $request->semail;
            if($request->has('sstatus'))
            {
                $supplier->sstatus = 'Active';
            }else {
                $supplier->sstatus = 'Deactive';
            }
            $supplier->obalance = $request->obalance;
            $supplier->ntnno = $request->ntnno;
            $supplier->staxNo = $request->staxNo;
            $supplier->srcId = $request->srcId;
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