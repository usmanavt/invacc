<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Source;
use App\Models\Location;
use App\Models\Specification;

use \Mpdf\Mpdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class StockLedgerController extends Controller
{

    public function index(Request $request)
    {

         $fromdate = $request->fromdate;
         $todate = $request->todate;

        //  $fromdate = '2023/03/01';
        //  $todate = '2023/05/30';

        return view('stockledgers.index')
        ->with('heads',Category::where('status',1)->get())
        ->with('location',Location::where('status',1)->get())
        ->with('source',Source::where('status',1)->get())
        ->with('specification',Specification::where('status',1)->get())
        ->with('glheads',Category::where('status',1)->whereIn('id',[1,2,3,4,5,6,7,8,9,10])->get())
        ->with('vchrheads',Category::where('status',1)->whereIn('id',[6,7,8,9])->get())
        ->with('subheads',DB::table('vwmatcategory')->select('*')->get()->toArray())
        ->with('subheadsci',DB::table('vwcuststcategory')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadsciloc',DB::table('vwsupcategoryloccominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadspend',DB::table('vwpendcontinvs')->select('*')->get()->toArray())
        ;
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

    public function funcstkos(Request $request)
    {
        //  dd($request->all());
        // $fromdate = $request->fromdate;
        // $todate = $request->todate;
        // $head = $request->head;
        $head_id = $request->head_id;
        $source_id = $request->source_id;
        $brand_id = $request->brand_id;
        $srch = $request->srch;

        return  DB::select('call procmatcategory(?,?,?)',array($head_id,$source_id, $brand_id));

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

    public function getMPDFSettingsP($orientation = 'A4')
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



    public function fetch(Request $request)
    {
        //  https://stackoverflow.com/questions/42555512/how-to-create-temporary-table-in-laravel
        // dd($request->all());
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
        // $mpdf = $this->getMPDFSettingsP();
        // $mpdf = new PDF( [
        //     'mode' => 'utf-8',
        //     'format' => 'A4',
        //     'margin_header' => '2',
        //     'margin_top' => '5',
        //     'margin_bottom' => '5',
        //     'margin_footer' => '2',
        //     'default_font_size' => 9,
        //     'margin_left' => '5',
        //     'margin_right' => '5',
        // ]);
        // $mpdf->showImageErrors = true;
        // $mpdf->curlAllowUnsafeSslRequests = true;
        // $mpdf->debug = true;
        //  Get Report
        if($report_type === 'dlvrychln'){

            //   dd($request->all());
            $head_id = $request->head_id;
            $ltype ="Office Stock";
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  dd($request->subhead_id);
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'GLCODE' => $id ]);
                }
            }
            $data = DB::select('call procstockledgeros(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsP();
            $html =  view('stockledgers.slsummary')->with('data',$data)->with('fromdate',$fromdate)
            ->with('todate',$todate)->with('ltype',$ltype)->render();
            $filename = 'StockLedgerSummary-'.$fromdate.'-'.$todate.'.pdf';
        }


        if($report_type === 'dlvrychlngd'){

            //   dd($request->all());
            $head_id = $request->head_id;
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                $ltype ="Godown Stock";
                //  dd($request->subhead_id);
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'GLCODE' => $id ]);
                }
            }
            $data = DB::select('call procstockledgergs(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsP();
            $html =  view('stockledgers.slsummary')->with('data',$data)->with('fromdate',$fromdate)
            ->with('todate',$todate)->with('ltype',$ltype)->render();
            $filename = 'StockLedgerSummary-'.$fromdate.'-'.$todate.'.pdf';
        }


        if($report_type === 'sraluntos'){

            //   dd($request->all());
            $head_id = $request->head_id;
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                $ltype ="Office Stock";
                //  dd($request->subhead_id);
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'GLCODE' => $id ]);
                }
            }
            $data = DB::select('call procstockledgerallunitos(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsL();
            $html =  view('stockledgers.slsummaryalunit')->with('data',$data)->with('fromdate',$fromdate)
            ->with('todate',$todate)->with('ltype',$ltype)->render();
            $filename = 'StockLedgerSummary-'.$fromdate.'-'.$todate.'.pdf';
        }

        if($report_type === 'sraluntgs'){

            //   dd($request->all());
            $head_id = $request->head_id;
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                $ltype ="Godown Stock";
                //  dd($request->subhead_id);
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'GLCODE' => $id ]);
                }
            }
            $data = DB::select('call procstockledgerallunitgs(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsL();
            $html =  view('stockledgers.slsummaryalunit')->with('data',$data)->with('fromdate',$fromdate)
            ->with('todate',$todate)->with('ltype',$ltype)->render();
            $filename = 'StockLedgerSummary-'.$fromdate.'-'.$todate.'.pdf';
        }


        if($report_type === 'gwsmu'){

            //   dd($request->all());
             $head_id = $request->head_id;
            $gc = $request->gc;
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                $ltype ="Godown Stock";
                //  dd($request->subhead_id);
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'GLCODE' => $id ]);
                }
            }
            $data = DB::select('call procgwsstock(?,?,?)',array($fromdate,$todate,$gc));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            // $mpdf = $this->getMPDFSettingsP();
            // $html =  view('stockledgers.gwstkledger')->with('data',$data)->with('fromdate',$fromdate)
            // ->with('todate',$todate)->with('ltype',$ltype)->render();
            // $filename = 'StockLedgerSummary-'.$fromdate.'-'.$todate.'.pdf';
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('ldesc');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                $html =  view('stockledgers.gwstkledger')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                ->render();
                $filename = $g[0]->ldesc  .'-'.$fromdate.'-'.$todate.'.pdf';
                $mpdf = $this->getMPDFSettingsP();
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            //  $mpdf->Output($filename,'I');
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }


        if($report_type === 'gwsau'){

            //   dd($request->all());
            $head_id = $request->head_id;
            $gc = $request->gc;
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                $ltype ="Godown Stock";
                //  dd($request->subhead_id);
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'GLCODE' => $id ]);
                }
            }
            $data = DB::select('call procgwsstockau(?,?,?)',array($fromdate,$todate,$gc));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            // $mpdf = $this->getMPDFSettingsP();
            // $html =  view('stockledgers.gwstkledger')->with('data',$data)->with('fromdate',$fromdate)
            // ->with('todate',$todate)->with('ltype',$ltype)->render();
            // $filename = 'StockLedgerSummary-'.$fromdate.'-'.$todate.'.pdf';
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('ldesc');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                $html =  view('stockledgers.gwstkledgerau')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                ->render();
                $filename = $g[0]->ldesc  .'-'.$fromdate.'-'.$todate.'.pdf';
                $mpdf = $this->getMPDFSettingsL();
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            //  $mpdf->Output($filename,'I');
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }






        if($report_type === 'smsind'){
            $ltype ="Office Stock";
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'glcode' => $id ]);
                }
            }
            //  Call Procedure
            $mpdf = $this->getMPDFSettingsP();
            $data = DB::select('call procindvstockos(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection
            ///// THIS IS CHANGED FOR REPORT//////////
            // Filter non grpid
            // $nogrp = $collection->filter(function ($item){
            //     return $item->sortid != 1;
            // })->values();
            // $nogrp->values()->all();
            // // Now FIlter Collection for grpid == 1
            // $collection = $collection->filter(function ($item){
            //     return $item->sortid == 1;
            // })->values();
            ///// THIS IS CHANGED FOR REPORT//////////
            $grouped = $collection->groupBy('material_id');
            $grouped->values()->all();        //  values() removes indices of array
            foreach($grouped as $g){
                 $html =  view('stockledgers.indvstockgsmu')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                 ->with('headtype',$head->title)->with('ltype',$ltype)->render();
                //  ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('t1',$t1)->with('t2',$t2)->with('t3',$t3)->with('t4',$t4)->with('t5',$t5)
                // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->material_id  .'-'.$fromdate.'-'.$todate.'.pdf';
                // $mpdf->SetHTMLFooter('
                // <table width="100%" style="border-top:1px solid gray">
                //     <tr>
                //         <td width="33%">{DATE d-m-Y}</td>
                //         <td width="33%" align="center">{PAGENO}/{nbpg}</td>

                //     </tr>
                // </table>');
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

        }


        if($report_type === 'smsindgs'){
            $ltype ="Godown Stock";
            $head_id = $request->head_id;
            $gc = $request->gc;
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'glcode' => $id ]);
                }
            }
            //  Call Procedure
            $mpdf = $this->getMPDFSettingsP();
            $data = DB::select('call procindvstockgs(?,?,?)',array($fromdate,$todate,$gc));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection
            ///// THIS IS CHANGED FOR REPORT//////////
            // Filter non grpid
            // $nogrp = $collection->filter(function ($item){
            //     return $item->sortid != 1;
            // })->values();
            // $nogrp->values()->all();
            // // Now FIlter Collection for grpid == 1
            // $collection = $collection->filter(function ($item){
            //     return $item->sortid == 1;
            // })->values();
            ///// THIS IS CHANGED FOR REPORT//////////
            $grouped = $collection->groupBy('lid');
            $grouped->values()->all();        //  values() removes indices of array
            foreach($grouped as $g){
                 $html =  view('stockledgers.indvstockgsmugs')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                 ->with('headtype',$head->title)->with('ltype',$ltype)->render();
                //  ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('t1',$t1)->with('t2',$t2)->with('t3',$t3)->with('t4',$t4)->with('t5',$t5)
                // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->material_id  .'-'.$fromdate.'-'.$todate.'.pdf';
                // $mpdf->SetHTMLFooter('
                // <table width="100%" style="border-top:1px solid gray">
                //     <tr>
                //         <td width="33%">{DATE d-m-Y}</td>
                //         <td width="33%" align="center">{PAGENO}/{nbpg}</td>

                //     </tr>
                // </table>');
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

        }

        if($report_type === 'smsval'){

            //   dd($request->all());
            $head_id = $request->head_id;
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                 $ltype ="Office Stock";
                //  dd($request->subhead_id);
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'GLCODE' => $id ]);
                }
            }
            $data = DB::select('call procstockledgerosval(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsL();
            $html =  view('stockledgers.smsvaluation')->with('data',$data)->with('fromdate',$fromdate)
            ->with('todate',$todate)->with('ltype',$ltype)->render();
            $filename = 'StockLedgerSummary-'.$fromdate.'-'.$todate.'.pdf';
        }








        if($report_type === 'sraluntgs'){

            //   dd($request->all());
            $head_id = $request->head_id;
            $head = Category::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                $ltype ="Godown Stock";
                //  dd($request->subhead_id);
                //  Clear Data from Table
                DB::table('tmpstockrptpar')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpstockrptpar')->insert([ 'GLCODE' => $id ]);
                }
            }
            $data = DB::select('call procstockledgerallunitgs(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsL();
            $html =  view('stockledgers.slsummaryalunit')->with('data',$data)->with('fromdate',$fromdate)
            ->with('todate',$todate)->with('ltype',$ltype)->render();
            $filename = 'StockLedgerSummary-'.$fromdate.'-'.$todate.'.pdf';






        }


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
            $html =  view('stockledgers.pendcontractsrpt')->with('data',$data)->render();
            $filename = 'PendingContracts-'.$fromdate.'-'.$todate.'.pdf';
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
            // $data = DB::select('call ProcGLHW(?,?,?)',array($fromdate,$todate,$head_id));
            // $data = DB::select('call procpurinvc(?,?,?)',array($fromdate,$todate,$head_id));

            $mpdf = new PDF( [
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_header' => '2',
                'margin_top' => '5',
                'margin_bottom' => '5',
                'margin_footer' => '2',
                'default_font_size' => 9,
                'margin_left' => '15',
                'margin_right' => '15',
            ]);




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
                 $html =  view('stockledgers.saleinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('stockledgers.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
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
                $mpdf->AddPage();
            }
            // $mpdf->Output($filename,'I');
            // dd('wait');
            // return;
                    //  CORRECTION
        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }



        if($report_type === 'loccominvs'){
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
            $data = DB::select('call procpurinvcloc()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection

            $mpdf = new PDF( [
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_header' => '2',
                'margin_top' => '5',
                'margin_bottom' => '5',
                'margin_footer' => '2',
                'default_font_size' => 10,
                'margin_left' => '15',
                'margin_right' => '15',

            ]);


            // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                 $html =  view('stockledgers.loccominvsrpt')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('stockledgers.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();

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
                $mpdf->AddPage();
            }
            // $mpdf->Output($filename,'I');
            // dd('wait');
            // return;
                    //  CORRECTION
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
                 $html =  view('stockledgers.saltaxinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('stockledgers.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
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
                $mpdf->AddPage();
            }
            // $mpdf->Output($filename,'I');
            // dd('wait');
            // return;
                    //  CORRECTION
        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
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
        // $mpdf->Output($filename,'I');
        //  CORRECTION
        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
    }

}
