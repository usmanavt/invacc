<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\Supplier;
use \Mpdf\Mpdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PurchaseRptController extends Controller
{

    public function index(Request $request)
    {

         $fromdate = $request->fromdate;
         $todate = $request->todate;

         $fromdate = '2023/03/01';
         $todate = '2023/05/20';

        return view('purrpt.index')
        ->with('heads',Supplier::where('status',1)->get())
        ->with('glheads',Supplier::where('status',1)->whereIn('id',[1,2,3,4,5,6,7,8,9,10])->get())
        ->with('vchrheads',Supplier::where('status',1)->whereIn('id',[6,7,8,9])->get())
        ->with('subheads',DB::table('vwsupcategory')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadsci',DB::table('vwsupcategorycominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
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
        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '2',
            'margin_top' => '5',
            'margin_bottom' => '5',
            'margin_footer' => '2',
            'default_font_size' => 9,
            'margin_left' => '3',
            'margin_right' => '3',
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->debug = true;
        //  Get Report
        if($report_type === 'tpl'){
            $data = DB::select('call ProcTPL(?,?,1)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $html =  view('reports.tpl')->with('data',$data)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = 'TransactionProveLista-'.$fromdate.'-'.$todate.'.pdf';
        }

        if($report_type === 'gl'){
            // dd($request->all());
            // $subhead_id = $request->subhead_id;
            // //  Truncate Table Data
            // DB::table('glparameterrpt')->truncate();
            // foreach($request->subhead_id as $id)
            // {
            //     DB::table('glparameterrpt')->insert([
            //         'GLCODE' => $id
            //     ]);
            // }
            // // Add input for Muliple parameters in Procedure
            // $data = DB::select('call ProcGL(?,?)',array($fromdate,$todate));
            // if(!$data)
            // {
            //     Session::flash('info','No data available');
            //     return redirect()->back();
            // }
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Supplier::findOrFail($head_id);
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
            $html =  view('purrpt.pendcontractsrpt')->with('data',$data)->render();
            $filename = 'PendingContracts-'.$fromdate.'-'.$todate.'.pdf';
        }

        if($report_type === 'glhw'){
            //  dd($request->all());
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Supplier::findOrFail($head_id);
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
            $data = DB::select('call procpurinvc()');
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
                 $html =  view('purrpt.contactsrpt')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('purrpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
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
            $mpdf->Output($filename,'I');
            dd('wait');
            return;
        }




        if($report_type === 'loccominvs'){
            //  dd($request->all());
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Supplier::findOrFail($head_id);
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
                 $html =  view('purrpt.loccominvsrpt')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('purrpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();

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
            $mpdf->Output($filename,'I');
            dd('wait');
            return;
        }















        if($report_type === 'impcominvs'){
            //  dd($request->all());
            $head_id = $request->head_id;
            // $head = Head::findOrFail($head_id);
            $head = Supplier::findOrFail($head_id);
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
            $data = DB::select('call procimpcominvs()');
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
                 $html =  view('purrpt.impcominvs')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('purrpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
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
