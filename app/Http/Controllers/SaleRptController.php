<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\Customer;
use \Mpdf\Mpdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SaleRptController extends Controller
{

    public function index(Request $request)
    {

        $fromdate = $request->fromdate;
        $todate = $request->todate;


        //  $fromdate = '2023-07-01';
        //  $todate = '2023-07-31';

        return view('salerpt.index')
        ->with('heads',Customer::where('status',1)->get())
        ->with('glheads',Customer::where('status',1)->whereIn('id',[1,2,3,4,5,6,7,8,9,10])->get())
        ->with('vchrheads',Customer::where('status',1)->whereIn('id',[6,7,8,9])->get())
        ->with('subheads',DB::table('vwcustcategory')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        // ->with('subheadsqut',DB::table('vwqutcategory')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadsci',DB::table('vwcuststcategory')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadsciloc',DB::table('vwsupcategoryloccominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadspend',DB::table('vwpendcontinvs')->select('*')->get()->toArray())
        ;
    }

    // For Sale Quotation
    public function funcquotation(Request $request)
    {
        //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procqutcategory(?,?,?)',array($fromdate,$todate,$head));

    }

    public function funcdlvrychln(Request $request)
    {
        //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procsalecategory(?,?,?,?)',array($fromdate,$todate,$head,1));

    }

    public function funcsalinvs(Request $request)
    {
        //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procsalecategory(?,?,?,?)',array($fromdate,$todate,$head,2));

    }

    public function funcsaltxinvs(Request $request)
    {
        //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procsalecategory(?,?,?,?)',array($fromdate,$todate,$head,3));

    }

    public function funcsalhist(Request $request)
    {
        //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procsalhistcatory(?,?,?)',array($fromdate,$todate,$head));

    }




    // For Customer Order
    public function funccustorder(Request $request)
    {
        //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;

        return  DB::select('call proccopcategory(?,?,?)',array($fromdate,$todate,$head));
    }

// For Customer Order
public function funcpendcustorder(Request $request)
{
    $head = $request->head;

    return  DB::select('call proccopendcategory(?)',array($head));
}

public function funcsalretcat(Request $request)
{
    //  dd($request->all());
    $fromdate = $request->fromdate;
    $todate = $request->todate;
    $head = $request->head;

    return  DB::select('call procsalretcategory(?,?,?)',array($fromdate,$todate,$head));
}



    public function getMPDFSettings($orientation = 'A4')
    {

        $format;
        $orientation == 'L' ? $format = 'A4': 'A4';

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

    public function vouchers(Request $request)
    {
        // dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        // FIXME: correct this call and send back vouchers to function
        // return DB::table('vwvouchercategory')->select('*')->whereBetween('docdate',[$fromdate,$todate])->where('mheadid',$head)->get()->toArray();
        return DB::table('vwsupcategory')->select('*')->whereBetween('docdate',[$fromdate,$todate])->where('mheadid',$head)->get()->toArray();
    }

    public function fetch(Request $request)
    {
        //  https://stackoverflow.com/questions/42555512/how-to-create-temporary-table-in-laravel
        $report_type = $request->report_type;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $data = null;
        // MPDF Settings
        ini_set('max_execution_time', '2000');
        ini_set("pcre.backtrack_limit", "100000000");
        ini_set("memory_limit","4000M");
        ini_set('allow_url_fopen',1);
        ini_set('user_agent', 'Mozilla/5.0');
        $temp = storage_path('temp');
        $mpdf = $this->getMPDFSettings();


        //  Get Report
        // if($report_type === 'tpl'){
        //     $data = DB::select('call ProcTPL(?,?,1)',array($fromdate,$todate));
        //     if(!$data)
        //     {
        //         Session::flash('info','No data available');
        //         return redirect()->back();
        //     }
        //     $html =  view('reports.tpl')->with('data',$data)->with('fromdate',$fromdate)->with('todate',$todate)->render();
        //     $filename = 'TransactionProveLista-'.$fromdate.'-'.$todate.'.pdf';
        // }

        if($report_type === 'gl'){
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Customer::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('contparameterrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('contparameterrpt')->insert([ 'GLCODE' => $id ]);
                }

            // Add input for Muliple parameters in Procedure
            $data = DB::select('call procpendcontacts()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            }
            $html =  view('salerpt.pendcontractsrpt')->with('data',$data)->render();
            $filename = 'PendingContracts-'.$fromdate.'-'.$todate.'.pdf';
        }

        if($report_type === 'dlvrychln' or $report_type === 'salinvs' or $report_type === 'saltxinvs' ){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
        $head_id = $request->head_id;
        // $head = Head::findOrFail($head_id);
        $head = Customer::findOrFail($head_id);
        if($request->has('subhead_id')){
            $subhead_id = $request->subhead_id;
            //  Clear Data from Table
            DB::table('tmpqutparrpt')->truncate();
            foreach($request->subhead_id as $id)
            {
                DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
            }
        }
        //  Call Procedure
        $mpdf = $this->getMPDFSettings();
        $data = DB::select('call procsaletaxinvoice()');
        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $collection = collect($data);                   //  Make array a collection
        // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
        $grouped = $collection->groupBy('id');       //  Sort collection by SupName
        $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){


                if($report_type === 'dlvrychln')
                {
                $html =  view('salerpt.dlvrychalan')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                ->with('headtype',$head->title)
                ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                }
                if($report_type === 'salinvs')
                {
                $html =  view('salerpt.saleinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                ->with('headtype',$head->title)
                ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                }
                if($report_type === 'saltxinvs')
                {
                $html =  view('salerpt.saltaxinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                ->with('headtype',$head->title)
                ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                }

             // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = $g[0]->id  .'-'.$fromdate.'-'.$todate.'.pdf';
            $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top:1px solid gray">
                <tr>
                    <td width="33%">{DATE d-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>

                </tr>
            </table>');
            $chunks = explode("chunk", $html);
            foreach($chunks as $key => $val) {
                $mpdf->WriteHTML($val);
            }
            $mpdf->AddPage();
        }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

        }




        if($report_type === 'salret' ){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
        $head_id = $request->head_id;
        // $head = Head::findOrFail($head_id);
        $head = Customer::findOrFail($head_id);
        if($request->has('subhead_id')){
            $subhead_id = $request->subhead_id;
            //  Clear Data from Table
            DB::table('tmpqutparrpt')->truncate();
            foreach($request->subhead_id as $id)
            {
                DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
            }
        }
        //  Call Procedure
        $mpdf = $this->getMPDFSettings();
        $data = DB::select('call procsalretinvoice()');
        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $collection = collect($data);                   //  Make array a collection
        // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
        $grouped = $collection->groupBy('id');       //  Sort collection by SupName
        $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){


                // if($report_type === 'dlvrychln')
                // {
                $html =  view('salerpt.salereturn')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                ->with('headtype',$head->title)
                ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                // }
                // if($report_type === 'salinvs')
                // {
                // $html =  view('salerpt.saleinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                // ->with('headtype',$head->title)
                // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                // }
                // if($report_type === 'saltxinvs')
                // {
                // $html =  view('salerpt.saltaxinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                // ->with('headtype',$head->title)
                // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                // }

             // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = $g[0]->id  .'-'.$fromdate.'-'.$todate.'.pdf';
            $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top:1px solid gray">
                <tr>
                    <td width="33%">{DATE d-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>

                </tr>
            </table>');
            $chunks = explode("chunk", $html);
            foreach($chunks as $key => $val) {
                $mpdf->WriteHTML($val);
            }
            $mpdf->AddPage();
        }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

        }

























        if($report_type === 'salhist' ){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
        $head_id = $request->head_id;
        // $head = Head::findOrFail($head_id);
        $head = Customer::findOrFail($head_id);
        if($request->has('subhead_id')){
            $subhead_id = $request->subhead_id;
            //  Clear Data from Table
            DB::table('tmpqutparrpt')->truncate();
            foreach($request->subhead_id as $id)
            {
                DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
            }
        }
        //  Call Procedure
        $mpdf = $this->getMPDFSettings();
        $data = DB::select('call procsalhistory()');
        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $collection = collect($data);                   //  Make array a collection
        // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
        $grouped = $collection->groupBy('id');       //  Sort collection by SupName
        $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){


                // if($report_type === 'dlvrychln')
                // {
                $html =  view('salerpt.salhistory')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                ->with('headtype',$head->title)
                ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                // }
                // if($report_type === 'salinvs')
                // {
                // $html =  view('salerpt.saleinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                // ->with('headtype',$head->title)
                // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                // }
                // if($report_type === 'saltxinvs')
                // {
                // $html =  view('salerpt.saltaxinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                // ->with('headtype',$head->title)
                // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                // }

             // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = $g[0]->id  .'-'.$fromdate.'-'.$todate.'.pdf';
            $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top:1px solid gray">
                <tr>
                    <td width="33%">{DATE d-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>

                </tr>
            </table>');
            $chunks = explode("chunk", $html);
            foreach($chunks as $key => $val) {
                $mpdf->WriteHTML($val);
            }
            //$mpdf->AddPage();
        }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

        }







        if($report_type === 'salrethist' ){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
        $head_id = $request->head_id;
        // $head = Head::findOrFail($head_id);
        $head = Customer::findOrFail($head_id);
        if($request->has('subhead_id')){
            $subhead_id = $request->subhead_id;
            //  Clear Data from Table
            DB::table('tmpqutparrpt')->truncate();
            foreach($request->subhead_id as $id)
            {
                DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
            }
        }
        //  Call Procedure
        $mpdf = $this->getMPDFSettings();
        $data = DB::select('call procsalrethistory()');
        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $collection = collect($data);                   //  Make array a collection
        // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
        $grouped = $collection->groupBy('id');       //  Sort collection by SupName
        $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){


                // if($report_type === 'dlvrychln')
                // {
                $html =  view('salerpt.salereturnhist')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                ->with('headtype',$head->title)
                ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                // }
                // if($report_type === 'salinvs')
                // {
                // $html =  view('salerpt.saleinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                // ->with('headtype',$head->title)
                // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                // }
                // if($report_type === 'saltxinvs')
                // {
                // $html =  view('salerpt.saltaxinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                // ->with('headtype',$head->title)
                // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
                // }

             // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = $g[0]->id  .'-'.$fromdate.'-'.$todate.'.pdf';
            $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top:1px solid gray">
                <tr>
                    <td width="33%">{DATE d-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>

                </tr>
            </table>');
            $chunks = explode("chunk", $html);
            foreach($chunks as $key => $val) {
                $mpdf->WriteHTML($val);
            }
            //$mpdf->AddPage();
        }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

        }











        if($report_type === 'quotation' and $request->p1 == '1' ){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $t1 = $request->t1;
            $t2 = $request->t2;
            $t3 = $request->t3;
            $t4 = $request->t4;
            $t5 = $request->t5;
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Customer::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('tmpqutparrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
                }
            }
            //  Call Procedure
            $mpdf = $this->getMPDFSettings();
            $data = DB::select('call procquotation()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection
            ///// THIS IS CHANGED FOR REPORT//////////
            // Filter non grpid
            $nogrp = $collection->filter(function ($item){
                return $item->grpid != 1;
            })->values();
            $nogrp->values()->all();
            // Now FIlter Collection for grpid == 1
            $collection = $collection->filter(function ($item){
                return $item->grpid == 1;
            })->values();
            ///// THIS IS CHANGED FOR REPORT//////////
            $grouped = $collection->groupBy('id');
            $grouped->values()->all();        //  values() removes indices of array
            foreach($grouped as $g){
                 $html =  view('salerpt.quotationrptf1')->with('data',$g)->with('nogrp',$nogrp)->with('fromdate',$fromdate)->with('todate',$todate)
                 ->with('headtype',$head->title)
                 ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('t1',$t1)->with('t2',$t2)->with('t3',$t3)->with('t4',$t4)->with('t5',$t5)
                 ->render();
                // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->id  .'-'.$fromdate.'-'.$todate.'.pdf';
                // $mpdf = $this->getMPDFSettings();
                $mpdf->SetHTMLFooter('
                <table width="100%" style="border-top:1px solid gray">
                    <tr>
                        <td width="33%">{DATE d-m-Y}</td>
                        <td width="33%" align="center">{PAGENO}/{nbpg}</td>

                    </tr>
                </table>');
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }


        if($report_type === 'quotation' and $request->p1 == '0'){
            //  dd($request->all());

            $head_id = $request->head_id;
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $hdng3 = $request->toc;
            $t1 = $request->t1;
            $t2 = $request->t2;
            $t3 = $request->t3;
            $t4 = $request->t4;
            $t5 = $request->t5;


            // $head = Head::findOrFail($head_id);
            $head = Customer::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('tmpqutparrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
                }
            }
            //  Call Procedure
            $mpdf = $this->getMPDFSettings();
            $data = DB::select('call procquotation()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection
            // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
            $grouped = $collection->groupBy('id');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            // dd($grouped);

            foreach($grouped as $g){
                 $html =  view('salerpt.quotationrptf2')->with('data',$g)->with('fromdate',$fromdate)
                 ->with('todate',$todate)
                 ->with('headtype',$head->title)
                 ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('hdng3',$hdng3)
                 ->render();
                // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->id  .'-'.$fromdate.'-'.$todate.'.pdf';
                $mpdf->SetHTMLFooter('
                <table width="100%" style="border-top:1px solid gray">
                    <tr>
                        <td width="33%">{DATE d-m-Y}</td>
                        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    </tr>
                </table>');
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }







        if($report_type === 'custorder'){
            //  dd($request->all());
            $vrtype = $request->p2;
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $hdng3 = $request->toc;
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Customer::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('tmpqutparrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
                }
            }
            //  Call Procedure
            $mpdf = $this->getMPDFSettings();

            if($vrtype == 0)
            {
                $data = DB::select('call procsaleorders()');
            }
            if($vrtype == 1)
            {
                $data = DB::select('call proccompsaleorders()');
            }

            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection
            // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
            $grouped = $collection->groupBy('id');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            // dd($grouped);

            foreach($grouped as $g){
                 $html =  view('salerpt.custorder')->with('data',$g)->with('fromdate',$fromdate)
                 ->with('todate',$todate)
                 ->with('headtype',$head->title)
                 ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('hdng3',$hdng3)
                 ->render();
                // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->id  .'-'.$fromdate.'-'.$todate.'.pdf';
                $mpdf->SetHTMLFooter('
                <table width="100%" style="border-top:1px solid gray">
                    <tr>
                        <td width="33%">{DATE d-m-Y}</td>
                        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    </tr>
                </table>');
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }






        if($report_type === 'pendcustorder'){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $hdng3 = $request->toc;
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Customer::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('tmpqutparrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
                }
            }
            //  Call Procedure
            $mpdf = $this->getMPDFSettings();
            $data = DB::select('call procpendsaleorders()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection
            // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
            $grouped = $collection->groupBy('id');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            // dd($grouped);

            foreach($grouped as $g){
                 $html =  view('salerpt.pendcustorders')->with('data',$g)->with('fromdate',$fromdate)
                 ->with('todate',$todate)
                 ->with('headtype',$head->title)
                 ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('hdng3',$hdng3)
                 ->render();
                // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->id  .'-'.$fromdate.'-'.$todate.'.pdf';
                $mpdf->SetHTMLFooter('
                <table width="100%" style="border-top:1px solid gray">
                    <tr>
                        <td width="33%">{DATE d-m-Y}</td>
                        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    </tr>
                </table>');
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }








        if($report_type === 'salinvs'){
            //  dd($request->all());
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Customer::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('contparameterrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('contparameterrpt')->insert([ 'GLCODE' => $id ]);
                }
            }
            //  Call Procedure
            $mpdf = $this->getMPDFSettings();

            $data = DB::select('call procsalinv()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection
            // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
            $grouped = $collection->groupBy('salid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                 $html =  view('salerpt.saleinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->salid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $mpdf->SetHTMLFooter('
                <table width="100%" style="border-top:1px solid gray">
                    <tr>
                        <td width="33%">{DATE d-m-Y}</td>
                        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                        <td width="33%" style="text-align: right;">' . $filename . '</td>
                    </tr>
                </table>');
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                //$mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }

        if($report_type === 'salret'){
            //  dd($request->all());
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Customer::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('contparameterrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('contparameterrpt')->insert([ 'GLCODE' => $id ]);
                }
            }
            //  Call Procedure
            $data = DB::select('call procpurinvcloc()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection

            $mpdf = $this->getMPDFSettings();

            // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                 $html =  view('salerpt.loccominvsrpt')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();

                $filename = $g[0]->purid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $mpdf->SetHTMLFooter('
                <table width="100%" style="border-top:1px solid gray">
                    <tr>
                        <td width="33%">{DATE d-m-Y}</td>
                        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                        <td width="33%" style="text-align: right;">' . $filename . '</td>
                    </tr>
                </table>');
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                //$mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }















        if($report_type === 'saltxinvs'){
            //  dd($request->all());
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Customer::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('contparameterrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('contparameterrpt')->insert([ 'GLCODE' => $id ]);
                }
            }
            //  Call Procedure
            // $data = DB::select('call ProcGLHW(?,?,?)',array($fromdate,$todate,$head_id));
            // $data = DB::select('call procpurinvc(?,?,?)',array($fromdate,$todate,$head_id));
            $data = DB::select('call procstaxinvoice()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection
            // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                 $html =  view('salerpt.saltaxinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->salid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $mpdf->SetHTMLFooter('
                <table width="100%" style="border-top:1px solid gray">
                    <tr>
                        <td width="33%">{DATE d-m-Y}</td>
                        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                        <td width="33%" style="text-align: right;">' . $filename . '</td>
                    </tr>
                </table>');
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                //$mpdf->AddPage();
            }
            $mpdf->Output($filename,'I');
            dd('wait');
            return;
        }



        if($report_type === 'vchr'){
            // dd($request->all());
            $head_id = $request->head_id;
            $subhead_id = $request->subhead_id;
            //  TODO: How to fetch Data now? Shall we call vwvocherreport with mehadid , but where is subhead_id to get?
        }
        if($report_type === 'agng'){}

        $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top:1px solid gray">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">' . $filename . '</td>
                </tr>
            </table>');
        $chunks = explode("chunk", $html);
        foreach($chunks as $key => $val) {
            $mpdf->WriteHTML($val);
        }
        $mpdf->Output($filename,'I');
    }

}
