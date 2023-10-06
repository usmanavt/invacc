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



        //  dd($fromdate);
        return view('purrpt.index')
        ->with('heads',Supplier::where('status',1)->get())
        ->with('glheads',Supplier::where('status',1)->get())
        ->with('vchrheads',Supplier::where('status',1)->get())
        ->with('subheads',DB::table('vwsupcategory')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadsci',DB::table('vwsupcategorycominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadsciloc',DB::table('vwsupcategoryloccominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadspend',DB::table('vwpendcontinvs')->select('*')->get()->toArray())
        ->with('subheadscomp',DB::table('vwcompcontinvs')->select('*')->get()->toArray())
        ;
    }

    public function contlistfill(Request $request)
    {
    //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;

        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call proccontrcategory(?,?,?)',array($fromdate,$todate,$head));


        // return DB::table('vwsupcategory')->select('*');
        // ->whereBetween('invoice_date',[$fromdate,$todate])
        // ->where('MHEAD',$head)->get()->toArray();
    }

    public function funcpurcat(Request $request)
    {
    //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procpurcategory(?,?,?)',array($fromdate,$todate,$head));
    }


    public function cominvsloc(Request $request)
    {
        //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return DB::table('vwsupcategoryloccominv')
        ->select('*')->whereBetween('invoice_date',[$fromdate,$todate])
        ->where('MHEAD',$head)->get()->toArray();
    }


    public function cominvsimp(Request $request)
    {
    //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call proccominvcategory(?,?,?)',array($fromdate,$todate,$head));
        //   return DB::table('vwsupcategorycominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->where('MHEAD',$head)->get()->toArray();
    }

    public function dutycategory(Request $request)
    {
    //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procdtyclrnccategory(?,?,?)',array($fromdate,$todate,$head));
        //   return DB::table('vwsupcategorycominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->where('MHEAD',$head)->get()->toArray();
    }


    public function getMPDFSettingsLgl($orientation = 'Legal-L')
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

    public function getMPDFSettingsA3($orientation = 'A3-L')
    {

        $format;
        $orientation == 'L' ? $format = 'A3': 'A3';

        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => $orientation,
            'margin_header' => '2',
            'margin_top' => '5',
            'margin_bottom' => '5',
            'margin_footer' => '2',
            'default_font_size' => 9,
            'margin_left' => '5',
            'margin_right' => '2',
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->debug = true;
        return $mpdf;
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
            'margin_left' => '3',
            'margin_right' => '3',
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->debug = true;
        return $mpdf;
    }


    public function getMPDFSettingsA4L($orientation = 'A4-L')
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


    public function getMPDFSettingsLI($orientation = 'A4-L')
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
            'margin_left' => '3',
            'margin_right' => '3',
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->debug = true;
        return $mpdf;
    }

    public function fetch(Request $request)
    {
        //  https://stackoverflow.com/questions/42555512/how-to-create-temporary-table-in-laravel
        //  dd($request->all());
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

        if($report_type === 'cc'){
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
            $html =  view('purrpt.compcontractsrpt')->with('data',$data)->render();
            $filename = 'completedContracts-'.$fromdate.'-'.$todate.'.pdf';

        }

        if($report_type === 'glhw'){
            //  dd($request->all());
            $head_id = $request->head_id;
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
            $data = DB::select('call procpurinvc()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsA4L();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){
                 $html =  view('purrpt.contactsrpt')
                    ->with('data',$g)
                    ->with('fromdate',$fromdate)
                    ->with('todate',$todate)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->purid  .'-'.$fromdate.'-'.$todate.'.pdf';



                // $mpdf->SetHTMLFooter('
                // <table width="100%" style="border-top:1px solid gray">
                //     <tr>
                //         <td width="33%">{DATE d-m-Y}</td>
                //         <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                //         <td width="33%" style="text-align: right;">' . $filename . '</td>
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


        if($report_type === 'gdnrcvd'){
            //  dd($request->all());
            $head_id = $request->head_id;
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
            $data = DB::select('call procgdnpur()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsA3();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('id');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){
                 $html =  view('purrpt.gdnreceived')
                    ->with('data',$g)
                    ->with('fromdate',$fromdate)
                    ->with('todate',$todate)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->id  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }




        if($report_type === 'dtyclrnc'){
            //  dd($request->all());
            $head_id = $request->head_id;
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
            $data = DB::select('call procdutytrans()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsLgl();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('cominvid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){
                 $html =  view('purrpt.dtyclearance')
                    ->with('data',$g)
                    ->with('fromdate',$fromdate)
                    ->with('todate',$todate)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->cominvid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }



        if($report_type === 'loccominvs'){
            $head_id = $request->head_id;
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
            $data = DB::select('call procpurinvcloc()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection

            $mpdf = $this->getMPDFSettingsLI();
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                $html =  view('purrpt.loccominvsrpt')
                   ->with('data',$g)
                   ->with('fromdate',$fromdate)
                   ->with('todate',$todate)
                   ->with('headtype',$head->title)->render();

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
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }

        if($report_type === 'impcominvs'){
            //  dd($request->all());
            $head_id = $request->head_id;
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
            $data = DB::select('call procimpcominvs()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettingsA3();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                 $html =  view('purrpt.impcominvs')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('purrpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->purid  .'-'.$fromdate.'-'.$todate.'.pdf';
                // $mpdf->SetHTMLFooter('
                // <table width="100%" style="border-top:1px solid gray">
                //     <tr>
                //         <td width="33%">{DATE d-m-Y}</td>
                //         <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                //         <td width="33%" style="text-align: right;">' . $filename . '</td>
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
        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
    }

}
