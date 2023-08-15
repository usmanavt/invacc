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
            $q->where('title','LIKE',"%$search%")

            ->orWhere('email','LIKE',"%$search%");

        })
        // ->with('care')
        ->with('care:id,title')
        ->orderBy('id','desc')
        ->paginate(5);
        return view('customers.index')
        ->with('customers',$customers);

    }


    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $customers = Customer::Where('id', '>', 1)->where(function ($query) use ($search){
            $query->where('title','LIKE','%' . $search . '%')
            ->orWhere('address2','LIKE','%' . $search . '%');

        })
        // ->with('Source:id,title')
        ->with('care:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $customers;
    }






    public function create()
    {
        return view('customers.create')->with('care',Care::all());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:3|unique:customers',
            // 'email'=>'required|unique:customers'
        ]);

        DB::beginTransaction();
        try {
            $customer = new Customer();
            $customer->title = $request->title;
            $customer->nick = $request->nick;
            $customer->address2 = $request->address2;
            $customer->phoneoff = $request->phoneoff;
            $customer->phoneres = $request->phoneres;
            $customer->fax = $request->fax;
            $customer->email = $request->email;
            if($request->has('status'))
            {
                $customer->status = 1;
            }else {
                $customer->status = 0;
            }
            $customer->obalance = $request->obalance;
            $customer->ntn = $request->ntn;
            $customer->stax = $request->stax;
            $customer->care_id = $request->care_id;
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
        return view('customers.edit')->with('customer',Customer::findOrFail($id))->with('care',Care::all());
    }


    public function update(Customer $customer,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:3|unique:customers,title,'. $customer->id ,
            // 'email'=>'required|unique:customers,email,'. $customer->id
        ]);

        DB::beginTransaction();
        try {
            $customer->title = $request->title;
            $customer->nick = $request->nick;
            $customer->address = $request->address;
            $customer->address2 = $request->address2;
            $customer->phoneoff = $request->phoneoff;
            $customer->phoneres = $request->phoneres;
            $customer->fax = $request->fax;
            $customer->email = $request->email;
            if($request->has('status'))
            {
                $customer->status = 1;
            }else {
                $customer->status = 0;
            }
            $customer->obalance = $request->obalance;
            $customer->ntn = $request->ntn;
            $customer->stax = $request->stax;
            $customer->care_id = $request->care_id;
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
