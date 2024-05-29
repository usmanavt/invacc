<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Head;
use App\Models\Subhead;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ChequeTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use \Mpdf\Mpdf as PDF;
use Carbon\Carbon;

class BankRecivingsController extends Controller
{

    public function index()
    {
        return view('bankrecivings.index')
        ->with('bts',ChequeTransaction::where('status',1)->orderBy('id','desc')->limit(10)->get())
        ->with('banks',Bank::where('status',1)->get())
        ->with('suppliers',Supplier::where('status',1)->get())
        ->with('heads',Head::where('status',1)->get())
        ->with('subheads',Subhead::where('status',1)->get())
        ->with('customers',Customer::where('status',1)->get())
        ;
    }
    public function getMaster(Request $request)
    {
        // dd($request->all());
        // $search = $request->search;
        // $size = $request->size;
        // $field = $request->sort[0]["field"];     //  Nested Array
        // $dir = $request->sort[0]["dir"];         //  Nested Array
        // //  With Tables
        // $transactions = ChequeTransaction::where('transaction_type','BRV')->where(function ($query) use ($search){
        //     $query->where('id','LIKE','%' . $search . '%')
        //     ->orWhere('description','LIKE','%' . $search . '%')
        //     ->orWhereDate('cheque_date','LIKE','%' . $search . '%')
        //     ->orWhereHas('supplier',function($query) use($search){
        //         $query->where('title','LIKE',"%$search%");
        //     })
        //     ->orWhereHas('customer',function($query) use($search){
        //         $query->where('title','LIKE',"%$search%");
        //     })
        //     ->orWhereHas('head',function($query) use($search){
        //         $query->where('title','LIKE',"%$search%");
        //     })
        //     ->orWhereHas('subhead',function($query) use($search){
        //         $query->where('title','LIKE',"%$search%");
        //     });
        // })
        // ->with('bank:id,title')
        // ->with('head:id,title')
        // ->with('subhead:id,title')
        // ->with('supplier:id,title')
        // ->with('customer:id,title')
        // ->orderBy($field,$dir)
        // ->paginate((int) $size);
        // return $transactions;

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        // $transactions = DB::select('call procchequeindex')
        $transactions = DB::table('vwchequeindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->with('customer:id,title')
        ->where('cheque_no', 'like', "%$search%")
        ->orWhere('supname', 'like', "%$search%")
        //  ->orWhere('ref', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $transactions;


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
            // 'bank_id' => 'required',
            'head_id' => 'required',
            // 'conversion_rate' => 'required|numeric',
            // 'received' => 'required|numeric',
            // 'payment' => 'required|numeric',
            'cheque_no' => 'required|min:3',
            'cheque_date' => 'required'
            // 'description' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $bt = new ChequeTransaction();
            // $bt->bank_id = $request->bank_id;
            $bt->head_id = $request->head_id;
            $bt->received = $request->received;
            // $bt->chqinvbal = $request->received * -1;

            $bt->payment = $request->received * $request->conversion_rate;
            $bt->cheque_no = $request->cheque_no;
            $bt->cheque_date = $request->cheque_date;
            $bt->description = $request->description;
            $bt->documentdate = $request->documentdate;
            $bt->banknaration = $request->banknaration;

            if($request->has('subhead_id'))     $bt->subhead_id = $request->subhead_id;
            if($request->has('supplier_id'))    $bt->supplier_id = $request->supplier_id;
            if($request->has('customer_id'))    $bt->customer_id = $request->customer_id;
            $bt->save();
            DB::commit();
            Session::flash('success','Bank Reciving created');
            return redirect()->route('bankrecivings.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit($id)
    {
        $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
        // $passwrddel = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');


        return view('bankrecivings.edit',compact('passwrd'))
        ->with('bt',ChequeTransaction::whereId($id)->first())
        ->with('banks',Bank::where('status',1)->get())
        ->with('suppliers',Supplier::where('status',1)->get())
        ->with('heads',Head::where('status',1)->get())
        ->with('subheads',Subhead::where('status',1)->get())
        ->with('customers',Customer::where('status',1)->get())
        ;
    }


    public function deleterec($id)
    {
        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
        // $passwrddel = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');


        return view('bankrecivings.deleterec',compact('passwrd'))
        ->with('bt',ChequeTransaction::whereId($id)->first())
        ->with('banks',Bank::where('status',1)->get())
        ->with('suppliers',Supplier::where('status',1)->get())
        ->with('heads',Head::where('status',1)->get())
        ->with('subheads',Subhead::where('status',1)->get())
        ->with('customers',Customer::where('status',1)->get())
        ;
    }


    public function update(Request $request, ChequeTransaction $bt)

    {
        // dd($request->all(),$bt);
        $this->validate($request,[
            // 'bank_id' => 'required',
            'head_id' => 'required',
            // 'conversion_rate' => 'required|numeric',
            // 'received' => 'required|numeric',
            // 'payment' => 'required|numeric',
            'cheque_no' => 'required|min:3',
            'cheque_date' => 'required',
            // 'description' => 'required'
        ]);
        DB::beginTransaction();
        try {

        if($request->p2==0 )
        {
            $bt = ChequeTransaction::findOrFail($request->id);
            // $bt->bank_id = $request->bank_id;
            $bt->head_id = $request->head_id;
            // $bt->conversion_rate = $request->conversion_rate;
            $bt->received = $request->received;
            $bt->payment = $request->payment ;
            $bt->cheque_no = $request->cheque_no;
            $bt->cheque_date = $request->cheque_date;
            $bt->description = $request->description;
            $bt->banknaration = $request->banknaration;
            $bt->documentdate = $request->documentdate;
            if($request->has('subhead_id')){$bt->subhead_id = $request->subhead_id;}else { $bt->subhead_id= 0;}
            if($request->has('supplier_id')){ $bt->supplier_id = $request->supplier_id;} else { $bt->supplier_id = 0;}
            if($request->has('customer_id')) { $bt->customer_id = $request->customer_id;} else { $bt->customer_id = 0;}

            if($request->p1==1 && $request->sts==0 )
            {
                $bt->clrstatus = 1;
                $bt->ref = 'CHEQUE_RETURN';

            }
            if($request->p1==1 && $request->sts==1 )
            {
                // $bt->clrstatus = 1;
                $bt->ref = 'CHEQUE_RETURN - '.$request->chqref;
                // $xyz1='CHEQUE_RETURN';
                // $xyz2=$request->chqref;
                // $xyz=$xyz1 . $xyz2;
                // dd($xyz);

            }






            if($request->p1==0 && $request->sts==1 && $request->chqref=='CHEQUE_RETURN'  )
            {
                $bt->clrstatus = 0;
                $bt->ref = '';

            }




            $bt->save();
        }

        if( ( $request->p2==1  && $request->sts==0 ) || $request->chqref=='CHEQUE_RETURN' )
        {

                DB::delete(DB::raw(" delete FROM cheque_transactions WHERE id=$request->id"));

        }
            DB::commit();
            Session::flash('info','Bank Payment/Transaction updated');
            return redirect()->route('bankrecivings.index');
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


    public function deleteBankRequest(Request $request)
    {


//   dd($request->sts);


if($request->sts == 1)
{
    Session::flash('info','Record Already Used In Other Transaction');
    // return response()->json(['success'],200);
    // return redirect()->route('bankrecivings.index');
    return redirect()->route('bankrecivings.index');
}


DB::beginTransaction();
            try {

                 DB::delete(DB::raw(" delete FROM cheque_transactions WHERE id=$request->id; "));


                // DB::update(DB::raw("
                // deletefrom cheque_transactions SET clrstatus=0,clrid=0,ref='' WHERE cheque_no=$request->id;

                // "));


                DB::commit();
                Session::flash('success','Record Deleted Successfully');
                // return response()->json(['success'],200);
                return redirect()->route('bankrecivings.index');

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }


    public function getMPDFSettingsL($orientation = 'Legal-L')
    {

        $format;
        $orientation == 'L' ? $format = 'Legal': 'Legal';

        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => $orientation,
            'margin_header' => '2',
            'margin_top' => '5',
            'margin_bottom' => '5',
            'margin_footer' => '2',
            'default_font_size' => 9,
            'margin_left' => '10',
            'margin_right' => '10',
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->debug = true;
        return $mpdf;
    }




    public function printContract(Request $request)
    {
            //  dd($request->all());
            // // $head_id = $request->head_id;
            // $hdng1 = $request->cname;
            // $hdng2 = $request->csdrs;
                // $vrtype4 = $request->p4;
                //  dd($vrtype);
                // $head = Head::findOrFail($head_id);
                // if($request->has('subhead_id')){
                //     $subhead_id = $request->subhead_id;
                //     DB::table('glparameterrpt')->truncate();
                //     foreach($request->subhead_id as $id)
                //     {
                //         DB::table('glparameterrpt')->insert([ 'GLCODE' => $id ]);
                //     }
                // }
                //  Call Procedure
            // $fromdate='2024-01-01';
            // $todate='2024-03-30';

            $fromdate = Carbon::now()->startOfMonth();
            $todate = Carbon::now();


        // dd($fromdate);
            $data = DB::select('call procchequetrans(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsL();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('grp');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){

                $html =  view('bankrecivings.print')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();

                // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();



               $filename = $g[0]->grp  .'-'.$fromdate.'-'.$todate.'.pdf';

               $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                // $mpdf->AddPage();
            }
            //  $mpdf->Output($filename,'I');
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');


    }









}
