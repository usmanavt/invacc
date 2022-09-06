<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Care;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $customers = Customer::where(function($q) use ($search){
            $q->where('cname','LIKE',"%$search%")
            ->orWhere('cemail','LIKE',"%$search%");
        })
        ->with('care')
        ->orderBy('id','desc')
        ->paginate(5);
        return view('customers.index')->with('customers',$customers);
    }

    public function create()
    {
        return view('customers.create')->with('careof',Care::all());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'cname'=>'required|min:3|unique:tblecustomer',
            'cemail'=>'required|unique:tblecustomer'
        ]);

        DB::beginTransaction();
        try {
            $customer = new Customer();
            $customer->cname = $request->cname;
            $customer->cnname = $request->cnname;
            $customer->cpaddress = $request->cpaddress;
            $customer->cphoneoff = $request->cphoneoff;
            $customer->cphoneres = $request->cphoneres;
            $customer->cfax = $request->cfax;
            $customer->cemail = $request->cemail;
            if($request->has('cstatus'))
            {
                $customer->cstatus = 'Active';
            }else {
                $customer->cstatus = 'Deactive';
            }
            $customer->obalance = $request->obalance;
            $customer->ntnno = $request->ntnno;
            $customer->staxNo = $request->staxno;
            $customer->cop = $request->cop;
            $customer->save();
            DB::commit();
            Session::flash('success','Customer created');
            return redirect()->route('customers.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
   
    public function edit($id)
    {
        return view('customers.edit')->with('customer',Customer::findOrFail($id))->with('careof',Care::all());
    }


    public function update(Customer $customer,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'cname'=>'required|min:3|unique:tblecustomer,cname,'. $customer->id ,
            'cemail'=>'required|unique:tblecustomer,cemail,'. $customer->id 
        ]);

        DB::beginTransaction();
        try {
            $customer->cname = $request->cname;
            $customer->cnname = $request->cnname;
            $customer->cpaddress = $request->cpaddress;
            $customer->cphoneoff = $request->cphoneoff;
            $customer->cphoneres = $request->cphoneres;
            $customer->cfax = $request->cfax;
            $customer->cemail = $request->cemail;
            if($request->has('cstatus'))
            {
                $customer->cstatus = 'Active';
            }else {
                $customer->cstatus = 'Deactive';
            }
            $customer->obalance = $request->obalance;
            $customer->ntnno = $request->ntnno;
            $customer->staxNo = $request->staxno;
            $customer->cop = $request->cop;
            $customer->save();
            DB::commit();
            Session::flash('info','Customer updated');
            return redirect()->route('customers.index');
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
