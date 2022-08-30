<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use DB;

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
            // ->orWhere('source','LIKE',"%$search%")
            ->orWhere('spaddress','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(6);
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
                'sname'=>'required',
                'sname'=>'required|unique:Tblesupplier',
                'email'=>'email'
            ]);


        $maxValue = DB::table('Tblesupplier')->max('scode')+1;
        // try {
            // DB::transaction(function () {
                $supplier = new Supplier();
                $supplier->scode = $maxValue;
                $supplier->sname = $request->sname;
                $supplier->snname = $request->snname;
                $supplier->spaddress = $request->spaddress;
                $supplier->sphoneoff = $request->sphoneoff;
                $supplier->sphoneres = $request->sphoneres;
                $supplier->sfax = $request->sfax;
                $supplier->semail = $request->semail;
                $supplier->sstatus = $request->sstatus;
                $supplier->obalance = $request->obalance;
                $supplier->ntnno = $request->ntnno;
                $supplier->staxNo = $request->staxNo;
                $supplier->srcId = $request->srcId;
                $supplier->save();
        //     });
        //     // return redirect()->route('suppliers.index');
            return redirect()->back();
        // } catch (\Throwable $th) {
        //     DB::rollback();
        //     throw $th;
        // }
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show')->with('supplier',$supplier);
    }

    public function edit($id)
    {

        // $data1['src']=DB::table('Tblesource')->get();
        $supplier=Supplier::find($id);
        if (is_null($supplier))
            {
                // NOT FOUND
                return redirect()->back();
            }
                else
            {


                $data=compact('supplier');
                return view('suppliers.edit')->with($data);
            };




        // return view('suppliers.edit')->with('supplier',$supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request )
    {
                $supplier=Supplier::find($id);
                $supplier->sname = $request->sname;
                $supplier->snname = $request->snname;
                $supplier->spaddress = $request->spaddress;
                $supplier->sphoneoff = $request->sphoneoff;
                $supplier->sphoneres = $request->sphoneres;
                $supplier->sfax = $request->sfax;
                $supplier->semail = $request->semail;
                $supplier->sstatus = $request->sstatus;
                $supplier->obalance = $request->obalance;
                $supplier->ntnno = $request->ntnno;
                $supplier->staxNo = $request->staxNo;
                $supplier->srcId = $request->srcId;
                $supplier->save();
             return redirect()->route('suppliers.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $supplier=Supplier::find($id);
        if(!is_null($supplier));
{
    ($supplier)->delete();


}
return redirect()->back();
}

}
