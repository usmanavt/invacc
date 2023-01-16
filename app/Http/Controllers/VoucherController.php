<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\Subhead;
use App\Models\Voucher;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VoucherController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }
    public function index()
    {
        $heads = Head::where('status',1)->get();
        $subheads = DB::select('SELECT * from VwCategory');
        $collection = collect($subheads);                   //  Make array a collection
        // $grouped = $collection->groupBy('MHEAD');       //  Sort collection by SupName
        $collection->values()->all();                       //  values() removes indices
        // dd($grouped);
        return view('journalvouchers.index')
        ->with('heads', $heads)
        ->with('subheads',$collection);
    }

    public function getMaster(Request $request)
    {
        // dd($request->all());
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $vouchers = Voucher::where(function ($query) use ($search){
            $query->where('transaction_type','LIKE','%' . $search . '%')
            ->orWhere('jvno','LIKE','%' . $search . '%')
            ->orWhereDate('document_date','LIKE','%' . $search . '%')
            ->orWhereHas('head',function($query) use($search){
                $query->where('title','LIKE',"%$search%");
            });
        })
        ->with('head:id,title')
        ->with('subhead')
        ->with('supplier:id,title')
        ->with('customer:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $vouchers;
    }

    public function create()
    {
        return view('journalvouchers.create')
        ->with('heads',Head::select(['id','title'])->where('status',1)->get())
        ->with('subheads',Subhead::where('status',1)->get())
        ->with('suppliers',Supplier::where('status',1)->get())
        ->with('customers',Customer::where('status',1)->get());
    }

    public function store(Request $request)
    {
        // return $request->all();
        $data = $request->validate([
            'document_date' => ['required'],
            // 'transaction_type' => ['required','string','max:6'],
            // 'head_id' => ['required','numeric'],
            // 'subhead_id' => ['required','numeric'],
            // 'jvno' => ['required','numeric'],
            // 'amount' => ['required','numeric'],
            // 'description' => ['required','string','max:100'],
        ]);
        DB::beginTransaction();
        $transaction_id = Voucher::generateUniqueTransaction();
        try {
            foreach($request->voucher as $vuch)
            {
                $v = new Voucher();
                $v->transaction = $transaction_id;
                $v->document_date = $request->document_date;
                $v->transaction_type = $vuch['transaction_type'];
                $v->head_id = $vuch['head_id'];
                if($vuch['head_id'] === 32){
                    // Supplier Process ID
                    $v->supplier_id = $vuch['subhead_id'];
                }
                if($vuch['head_id'] === 33){
                    // Customer Process ID
                    $v->customer_id = $vuch['subhead_id'];
                }
                if($vuch['head_id'] != 32 || $vuch['head_id'] != 33 )
                {
                    $v->subhead_id = $vuch['subhead_id'];
                }
                $v->jvno = $vuch['jvno'];
                $v->amount = $vuch['amount'];
                $v->description = $vuch['description'];
                $v->save();
            }
            DB::commit();
            Session::flash('success','Journal Voucer created');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function edit($id)
    {
        $heads = Head::where('status',1)->get();
        $subheads = DB::select('SELECT * from VwCategory');
        $collection = collect($subheads);                   //  Make array a collection
        $collection->values()->all();                       //  values() removes indices
        return view('journalvouchers.edit')
        ->with('jv',Voucher::findOrFail($id))
        ->with('heads', $heads)
        ->with('subheads',$collection);
    }

    public function update(Request $request, Voucher $voucher)
    {
        //
    }

}
