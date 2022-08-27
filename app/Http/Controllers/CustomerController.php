<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Tbleco;
use Illuminate\Http\Request;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->search;

        // $data['co']=DB::table('Tbleco')->get();
        $Myqry="select a.*,b.coid,b.coname from Tblecustomer as a left outer join tbleco as b
        on a.cop=b.coid   where cname like '%$search%' order by a.id desc ";

         $customers=  DB::select ($Myqry);
         return view('customers.index')->with('customers',$customers);
        // Paginator::make(DB::select($query));
        // $customers = Paginate::make(DB::select($query), 1);



        // $customers = Customer::where(function($q) use ($search){
        //     $q->where('cname','LIKE',"%$search%")
        //     ->orWhere('cemail','LIKE',"%$search%");
        //    })
        // ->orderBy('id','desc')
        // ->paginate(6);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['co']=DB::table('Tbleco')->get();
        return view('customers.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'cname'=>'required',
                'cname'=>'required|unique:Tblecustomer',
                'email'=>'email'
            ]
            );


        $maxValue = DB::table('Tblecustomer')->max('ccode')+1;
        // dd($maxValue);
        // try {
            // DB::transaction(function () {
                $customer = new Customer();
                $customer->ccode = $maxValue;
                $customer->cname = $request->cname;
                $customer->cnname = $request->cnname;
                $customer->cpaddress = $request->cpaddress;
                $customer->cphoneoff = $request->cphoneoff;
                $customer->cphoneres = $request->cphoneres;
                $customer->cfax = $request->sfax;
                $customer->cemail = $request->cemail;
                $customer->cstatus = $request->cstatus;
                $customer->obalance = $request->obalance;
                $customer->ntnno = $request->ntnno;
                $customer->staxNo = $request->staxno;
                $customer->cop = $request->cop;
                $customer->save();
        //     });
        //     // return redirect()->route('suppliers.index');
            return redirect()->back();
        // } catch (\Throwable $th) {
        //     DB::rollback();
        //     throw $th;
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data1['co']=DB::table('Tbleco')->get();
        $customer=Customer::find($id);
       if (is_null($customer))
           {
               // NOT FOUND
               return redirect()->back();
           }
               else
           {

               $data=compact('customer');
               return view('customers.edit')->with($data1)->with($data);
           };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
                $customer=Customer::find($id);
                $customer->cname = $request->cname;
                $customer->cnname = $request->cnname;
                $customer->cpaddress = $request->cpaddress;
                $customer->cphoneoff = $request->cphoneoff;
                $customer->cphoneres = $request->cphoneres;
                $customer->cfax = $request->sfax;
                $customer->cemail = $request->cemail;
                $customer->cstatus = $request->cstatus;
                $customer->obalance = $request->obalance;
                $customer->ntnno = $request->ntnno;
                $customer->staxNo = $request->staxno;
                $customer->cop = $request->cop;
                $customer->save();
                return redirect()->route('customers.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer=Customer::find($id);
            if(!is_null($customer));
    {
        ($customer)->delete();


    }
    return redirect()->back();
    }
}
