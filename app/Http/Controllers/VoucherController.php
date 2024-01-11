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
        // $subheads = DB::select('SELECT * from VwCategory');
        // $collection = collect($subheads);                   //  Make array a collection
        // $grouped = $collection->groupBy('MHEAD');       //  Sort collection by SupName
        // $collection->values()->all();                       //  values() removes indices
        return view('journalvouchers.index');
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
        $maxjvno = DB::table('vouchers')->select('jvno')->max('jvno')+1;
        return view('journalvouchers.create',compact('maxjvno'))
        ->with('heads',Head::select(['id','title'])->where('forjv',1)->get()) //
        ->with('subheads',DB::table('VwCategory')->select('*')->get()->toArray());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'document_date' => ['required'],
        ]);
        DB::beginTransaction();
        $transaction_id = Voucher::generateUniqueTransaction();
        try {
            foreach($request->voucher as $vuch)
            {
                $head_title = $vuch['head_title'];
                $subhead_title = $vuch['subhead_title'];
                $sub = DB::select('select * from VwCategory where mtitle = ? AND title = ? LIMIT 1', [$head_title,$subhead_title]);
                // return $sub;
                // return compact('head_title','subhead_title','sub');
                $v = new Voucher();
                $v->transaction = $transaction_id;
                $v->document_date = $request->document_date;
                $v->jvno = $request->document_no;
                $v->cheque_no = $request->cheque_no;
                $v->transaction_type = $vuch['transaction_type'];
                // $v->jvno = $vuch['jvno'];
                $v->amount = $vuch['amount'];
                $v->description = $vuch['description'];
                foreach($sub as $s)
                {
                    $v->head_id = $s->MHEAD;
                    $v->head_title = $s->mtitle;
                    $v->subhead_id = $s->Subhead;
                    $v->subhead_title = $s->title;
                }
                $v->save();
            }

            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (SELECT distinct jvno,document_date,cheque_no,'JV' as transaction_type,subhead_id as bank_id FROM vouchers WHERE  jvno=$v->jvno) x
            ON c.cheque_no=x.cheque_no
            SET c.bank_id=x.bank_id, c.clrstatus=1,c.clrdate=x.document_date,clrid=x.jvno,c.ref=CONCAT(x.transaction_type,'-',LPAD(x.jvno,4,'0')) "));

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
        $vouchers = Voucher::where('transaction',$id)->get();
        $dd = Voucher::select('document_date')->where('transaction',$id)->first();
        $dd1 = Voucher::select('jvno')->where('transaction',$id)->first();
        $dd2 = Voucher::select('cheque_no')->where('transaction',$id)->first();
        return view('journalvouchers.edit')
        ->with('jvs',$vouchers)
        ->with('transaction',$id)
        ->with('document_date',$dd->document_date)
        ->with('cheque_no',$dd2->cheque_no)
        ->with('jvno',$dd1->jvno)
        ->with('heads',Head::select(['id','title'])->where('status',1)->get()) //
        ->with('subheads',DB::table('VwCategory')->select('*')->get()->toArray());
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $vouchers = $request->vouchers;
        // $mydate = $request->document_date;
        // $myjvno = $request->jvno;
        $transactions = Voucher::where('transaction',$vouchers[0]['transaction'])->delete();
        DB::beginTransaction();
        try {
            foreach($vouchers as $vuch)
            {
                $v = new Voucher();
                $v->jvno = $request->document_no;
                //    dd($request->all());

                $v->document_date = $request->jvdate;
                $v->cheque_no = $request->cheque_no;
                $v->head_title = $vuch['head_title'];
                $v->subhead_title = $vuch['subhead_title'];
                $sub = DB::select('select * from VwCategory where mtitle = ? AND title = ? LIMIT 1', [ $vuch['head_title'], $vuch['subhead_title']]);
                $v->transaction = $vuch['transaction'];
                // $v->document_date = $vuch['document_date'];
                $v->transaction_type = $vuch['transaction_type'];
                // $v->jvno = $vuch['jvno'];
                $v->amount = $vuch['amount'];
                $v->description = $vuch['description'];
                foreach($sub as $s)
                {
                    $v->head_id = $s->MHEAD;
                    $v->subhead_id = $s->Subhead;
                }
                $v->save();
            }

            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (SELECT distinct jvno,document_date,cheque_no,'JV' as transaction_type,subhead_id as bank_id FROM vouchers WHERE  jvno=$v->jvno) x
            ON c.cheque_no=x.cheque_no
            SET c.bank_id=x.bank_id, c.clrstatus=1,c.clrdate=x.document_date,clrid=x.jvno,c.ref=CONCAT(x.transaction_type,'-',LPAD(x.jvno,4,'0')) "));





            DB::commit();
            Session::flash('success','Journal Voucer Updated');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

}
