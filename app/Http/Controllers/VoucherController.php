<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\Subhead;
use App\Models\Voucher;
use App\Models\Customer;
use App\Models\Supplier;
use \Mpdf\Mpdf as PDF;
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
            ->orWhere('subhead_title','LIKE','%' . $search . '%')
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

        // dd($request->dbtamt);

        if($request->cheque_no != ' ' )
        {
         // $dupchqno = BankTransaction::where('cheque_no',$request->cheque_no)->first();
         $chqamount = DB::table('cheque_transactions')->where('cheque_no',$request->cheque_no)->first();
         if(!$chqamount)
           {
            Session::flash('info','Invalid Cheque_no ');
            return response()->json(['success'],200);
           }

         if($chqamount) {
            if($request->dbtamt <> $chqamount->received )
            {
             Session::flash('info','Invalid Cheque Amount ');
             return response()->json(['success'],200);
            }
                       }
         }





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
                // $v->description = $request->description;

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

        $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
        $vouchers = Voucher::where('transaction',$id)->get();
        $dd = Voucher::select('document_date')->where('transaction',$id)->first();
        $dd1 = Voucher::select('jvno')->where('transaction',$id)->first();
        $dd2 = Voucher::select('cheque_no')->where('transaction',$id)->first();
        $delgdno = Voucher::select('vgdno')->where('transaction',$id)->first();
        return view('journalvouchers.edit',compact('passwrd'))
        ->with('jvs',$vouchers)
        ->with('transaction',$id)
        ->with('document_date',$dd->document_date)
        ->with('cheque_no',$dd2->cheque_no)
        ->with('vgdno',$delgdno->vgdno)
        ->with('jvno',$dd1->jvno)
        ->with('heads',Head::select(['id','title'])->where('status',1)->get()) //
        ->with('subheads',DB::table('VwCategory')->select('*')->get()->toArray());
    }


    public function deleterec($id)
    {

        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
        $vouchers = Voucher::where('transaction',$id)->get();
        $dd = Voucher::select('document_date')->where('transaction',$id)->first();
        $dd1 = Voucher::select('jvno')->where('transaction',$id)->first();
        $dd2 = Voucher::select('cheque_no')->where('transaction',$id)->first();
        $delgdno = Voucher::select('vgdno')->where('transaction',$id)->first();
        return view('journalvouchers.deleterec',compact('passwrd'))
        ->with('jvs',$vouchers)
        ->with('transaction',$id)
        ->with('document_date',$dd->document_date)
        ->with('cheque_no',$dd2->cheque_no)
        ->with('vgdno',$delgdno->vgdno)
        ->with('jvno',$dd1->jvno)
        ->with('heads',Head::select(['id','title'])->where('status',1)->get()) //
        ->with('subheads',DB::table('VwCategory')->select('*')->get()->toArray());

    }


    public function update(Request $request)
    {
        //  dd($request->cheque_nofd);

        // $mydate = $request->document_date;
        // $myjvno = $request->jvno;

        if($request->cheque_no != ' ' )
        {
         // $dupchqno = BankTransaction::where('cheque_no',$request->cheque_no)->first();
         $chqamount = DB::table('cheque_transactions')->where('cheque_no',$request->cheque_no)->first();
         if(!$chqamount)
           {
            Session::flash('info','Invalid Cheque_no ');
            return response()->json(['success'],200);
           }

         if($chqamount) {
            if($request->dbtamt <> $chqamount->received )
            {
             Session::flash('info','Invalid Cheque Amount ');
             return response()->json(['success'],200);
            }
                       }
         }






        DB::beginTransaction();
        try {

    // if($request->p2==0 )
    // {


        $vouchers = $request->vouchers;
        $transactions = Voucher::where('transaction',$vouchers[0]['transaction'])->delete();
        foreach($vouchers as $vuch)
            {
                $v = new Voucher();
                $v->jvno = $request->document_no;
                // $v->description = $request->description;
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
        // }


        // if(  $request->p2==1  )
        // {

            // dd($request->document_no);
            // $vouchers = $request->vouchers;
            // $transactions = Voucher::where('transaction',$vouchers[0]['transaction'])->delete();

            // DB::delete(DB::raw(" delete FROM vouchers WHERE cheque_no IS NULL AND vgdno IS NULL AND vcominvno=0 and  jvno=$request->document_no"));
                // $transactions = Voucher::where('transaction',$vouchers[0]['transaction'])->delete();
                // && $request->cheque_nofd==' '  && $request->gdno==' '
        // }



        DB::commit();


            Session::flash('success','Journal Voucer Updated');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }



    public function deleteBankRequest(Request $request)
    {


//  dd($request->invsid);
        DB::beginTransaction();
            try {

                // DB::delete(DB::raw(" delete FROM vouchers WHERE cheque_no IS NULL AND vgdno IS NULL AND vcominvno=0 and  jvno=$request->document_no"));


                DB::update(DB::raw("
                update cheque_transactions SET clrstatus=0,clrid=0,ref='' WHERE cheque_no='$request->cheque_no'

                "));




                $vouchers = $request->vouchers;
                $transactions = Voucher::where('transaction',$vouchers[0]['transaction'])->delete();

                DB::commit();
                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }





    public function getMPDFSettings($orientation = 'A4')
    {

        $format;
        $orientation == 'P' ? $format = 'A4': 'A4';

        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => $orientation,
            'margin_header' => '2',
            'margin_top' => '5',
            'margin_bottom' => '5',
            'margin_footer' => '2',
            'default_font_size' => 9,
            'margin_left' => '6',
            'margin_right' => '6',
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->debug = true;
        return $mpdf;
    }





    public function printContract($id)
    {

        $hdng1 = 'usman';
        $hdng2 = 'abc';

        // $head_id = $request->head_id;
        $head = 'shakoor';
        // if($request->has('subhead_id')){
        //     $subhead_id = $request->subhead_id;
        //     //  Clear Data from Table
            // DB::table('tmpvoucherrpt')->truncate();
        //     foreach($request->subhead_id as $id)
        //     {
                // DB::table('tmpvoucherrpt')->insert([ 'supid' => $jvno ]);
        //     }
        // }
        //  Call Procedure
        // $data = DB::select('call ProcGLHW(?,?,?)',array($fromdate,$todate,$head_id));
        // if($head_id == 5)
        //     {
                // $data = DB::select('call procvoucherrptjv()');
                $data = DB::select('call procvoucherrptjvfrm(?)',array($id));
        //     }
        // else
        //     {
        //         $data = DB::select('call procvoucherrpt()');
        //     }


        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $mpdf = $this->getMPDFSettings();
        $collection = collect($data);                   //  Make array a collection


        // $grouped1 = $collection->groupBy('transno');       //  Sort collection by SupName
        // $grouped1->values()->all();

        // foreach($grouped1 as $g)
        // {
            $grouped = $collection->groupBy('jvno');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g)
            {

            // if($head_id == 5)
            // {
                $html =  view('journalvouchers.print')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('headtype','kdfasfds')->render();
            // }
            // else
            // {
            //     $html =  view('reports.voucher')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
            // }

            $fromdate="";
            $todate="";

                $filename = $g[0]->transno  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                // $mpdf->AddPage();
            // }
        // $mpdf->AddPage();
        }
        //  $mpdf->Output($filename,'I');
        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');


    }



}
