<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BankController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $banks = Bank::where(function($q) use ($search){
            $q->where('bank','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('banks.index')->with('banks',$banks);
    }

    public function getMaster(Request $request)
    {
        // dd($request->all());
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $contracts = Bank::where(function ($query) use ($search){
                $query->where('id','LIKE','%' . $search . '%')
                ->orWhere('branch','LIKE','%' . $search . '%');
            })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;
    }

    public function create()
    {
        return view('banks.create')->with('banks',Bank::where('status',1)->get());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'bank' => 'required|min:3|unique:banks',
            'nick' => 'required|min:3',
            'account_no' => 'required',
            'branch' => 'required',
            'address' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $bank = new Bank();
            $bank->bank = $request->bank;
            $bank->nick = $request->nick;
            $bank->account_no = $request->account_no;
            $bank->branch = $request->branch;
            $bank->address = $request->address;
            $bank->balance = $request->balance;
            $bank->save();
            DB::commit();
            Session::flash('success','Bank Details created');
            return redirect()->route('banks.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit($id)
    {
        return view('banks.edit')->with('bank',Bank::findOrFail($id));
    }

    public function update(Request $request, Bank $bank)
    {
        // dd($request->all());
        $this->validate($request,[
            'bank' => 'required|min:3|unique:banks,bank,'. $bank->id,
            'nick' => 'required|min:3',
            'account_no' => 'required',
            'branch' => 'required',
            'address' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $bank->bank = $request->bank;
            $bank->nick = $request->nick;
            $bank->account_no = $request->account_no;
            $bank->branch = $request->branch;
            $bank->address = $request->address;
            $bank->balance = $request->balance;
            $bank->save();
            DB::commit();
            Session::flash('info','Bank Details updated');
            return redirect()->route('banks.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function show($id)
    {
        $bank = Bank::findOrFail($id);
        if($bank->status === 1) {
            $bank->status = 2;
        }else {
            $bank->status = 1;
        }
        $bank->save();
        Session::flash('info',"Bank status set");
        return redirect()->route('banks.index');
    }
}
