<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Head;
use App\Models\Subhead;
use App\Models\tempsubheads;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\CashTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CashPaymentController extends Controller
{
    public function index()
    {
        return view('cashpayments.index')
        ->with('bts',CashTransaction::where('status',1)->orderBy('id','desc')->limit(10)->get())
          ->with('banks',Bank::where('status',1)->get())
          ->with('suppliers',Supplier::where('status',1)->get())
        ->with('heads',Head::where('status',1)->where('forcp',1)->get())
        ->with('subheads',Subhead::where('status',1)->get()) //Subhead
          ->with('customers',Customer::where('status',1)->get())
        ;
    }

    public function getMaster(Request $request)
    {
        // dd($request->all());
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $contracts = CashTransaction::where('transaction_type','=','CPV')->where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('description','LIKE','%' . $search . '%')
            ->orWhereDate('docdate','LIKE','%' . $search . '%')
            ->orWhereHas('supplier',function($query) use($search){
                $query->where('title','LIKE',"%$search%");
            })
            ->orWhereHas('customer',function($query) use($search){
                $query->where('title','LIKE',"%$search%");
            })
            ->orWhereHas('head',function($query) use($search){
                $query->where('title','LIKE',"%$search%");
            })
            ->orWhereHas('subhead',function($query) use($search){
                $query->where('title','LIKE',"%$search%");
            });
        })

        // ->with('bank:id,title')
        ->with('head:id,title')
        ->with('subhead:id,title')
        ->with('supplier:id,title')
        ->with('customer:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;
    }

    public function create()
    {
        // return view('bankpayments.create')
        // ->with('bts',bankpayments::where('status',1)->orderBy('id','desc')->limit(10)->get())
        // ->with('banks',Bank::where('status',1)->get())
        // ->with('suppliers',Supplier::where('status',1)->get())
        // ->with('heads',Head::where('status',1)->get())
        // ->with('customers',Customer::where('status',1)->get())
        // ;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'head_id' => 'required',
            'conversion_rate' => 'required|numeric',
            'amount_fc' => 'required|numeric',
            'receiver' => 'required|min:3',
            'docdate' => 'required',
            'description' => 'required'
        ]);

        DB::beginTransaction();

        try {

            $bt = new CashTransaction();
            // $bt->bank_id = $request->bank_id;
            $bt->transaction_type = 'CPV';
            $bt->head_id = $request->head_id;
            $bt->conversion_rate = $request->conversion_rate;
            $bt->amount_fc = $request->amount_fc;
            $bt->amount_pkr = $request->amount_fc * $request->conversion_rate;
            $bt->receiver = $request->receiver;
            $bt->docdate = $request->docdate;
            $bt->description = $request->description;
            if($request->has('subhead_id'))     $bt->subhead_id = $request->subhead_id;
             if($request->has('supplier_id'))    $bt->supplier_id = $request->supplier_id;
             if($request->has('customer_id'))    $bt->customer_id = $request->customer_id;
            $bt->save();
            DB::commit();
            // dd('committed');
            Session::flash('success','Cash Transaction created');
            return redirect()->route('cashpayments.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit($id)
    {
        // dd($request->all());
        return view('cashpayments.edit')
        ->with('bt',CashTransaction::whereId($id)->first())
        // ->with('banks',Bank::where('status',1)->get())
         ->with('suppliers',Supplier::where('status',1)->get())
        ->with('heads',Head::where('status',1)->get())
        ->with('subheads',Subhead::where('status',1)->get())
         ->with('customers',Customer::where('status',1)->get())
        ;
    }

    public function update(Request $request, CashTransaction $bt)
    {
        // dd($request->all(),$bt);
        $this->validate($request,[
            'head_id' => 'required',
            'conversion_rate' => 'required|numeric',
            'amount_fc' => 'required|numeric',
            'receiver' => 'required|min:3',
            'docdate' => 'required',
            'description' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $bt = CashTransaction::findOrFail($request->id);
            // $bt->bank_id = $request->bank_id;
            $bt->head_id = $request->head_id;
            $bt->conversion_rate = $request->conversion_rate;
            $bt->amount_fc = $request->amount_fc;
            $bt->amount_pkr = $request->amount_fc * $request->conversion_rate;
            $bt->receiver = $request->receiver;
            $bt->docdate = $request->docdate;
            $bt->description = $request->description;
            $bt->docdate = $request->docdate;
            if($request->has('subhead_id')){$bt->subhead_id = $request->subhead_id;}else { $bt->subhead_id= 0;}
            if($request->has('supplier_id')){ $bt->supplier_id = $request->supplier_id;} else { $bt->supplier_id = 0;}
            if($request->has('customer_id')) { $bt->customer_id = $request->customer_id;} else { $bt->customer_id = 0;}
            $bt->save();
            DB::commit();
            Session::flash('info','Cash Payment/Transaction updated');
            return redirect()->route('cashpayments.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    // public function show($id)
    // {
    //     $bank = Bank::findOrFail($id);
    //     if($bank->status === 1) {
    //         $bank->status = 2;
    //     }else {
    //         $bank->status = 1;
    //     }
    //     $bank->save();
    //     Session::flash('info',"Bank status set");
    //     return redirect()->route('banks.index');
    // }
}
