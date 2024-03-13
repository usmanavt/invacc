<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\Supplier;
use App\Models\Source;

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
        $xyz = $request->source_id;



        return view('purrpt.index')
        ->with('heads',Supplier::where('status',1)->get())
        ->with('glheads',Supplier::where('status',1)->get())
        ->with('vchrheads',Supplier::where('status',1)->get())
        ->with('subheads',DB::table('vwsupcategory')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadsci',DB::table('vwsupcategorycominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadsciloc',DB::table('vwsupcategoryloccominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->get()->toArray())
        ->with('subheadspend',DB::table('vwpendcontinvs')->select('*')->get()->toArray())
        ->with('subheadscomp',DB::table('vwcompcontinvs')->select('*')->get()->toArray())
        ->with('sources',Source::whereIn('id',[2,13])->get())
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


    public function funcgetsuplr(Request $request)
    {
    //  dd($request->all());

        $src = $request->source_id;
        return  DB::select('call procgetsupplier(?)',array($src));
    }



    public function cominvsloc(Request $request)
    {
        //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        // return DB::table('vwsupcategoryloccominv')
        return  DB::select('call procsupcategoryloc(?,?,?)',array($fromdate,$todate,$head));
        // ->select('*')->whereBetween('invoice_date',[$fromdate,$todate])
        // ->where('MHEAD',$head)->get()->toArray();
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


    public function pnddutycategory(Request $request)
    {
    //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procpnddtyclrnccategory(?,?,?)',array($fromdate,$todate,$head));
        //   return DB::table('vwsupcategorycominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->where('MHEAD',$head)->get()->toArray();
    }

    public function pndcontractcategory(Request $request)
    {
    //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procpendcontrcategory(?,?,?)',array($fromdate,$todate,$head));
        //   return DB::table('vwsupcategorycominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->where('MHEAD',$head)->get()->toArray();
    }

    public function compcontractcategory(Request $request)
    {
    //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call proccompcontrcategory(?,?,?)',array($fromdate,$todate,$head));
        //   return DB::table('vwsupcategorycominv')->select('*')->whereBetween('invoice_date',[$fromdate,$todate])->where('MHEAD',$head)->get()->toArray();
    }

    public function funcpurretcategory(Request $request)
    {
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        return  DB::select('call procpurretcategory(?,?,?)',array($fromdate,$todate,$head));
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
        $orientation == 'P' ? $format = 'A4': 'A4';

        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => $orientation,
            'margin_header' => '2',
            'margin_top' => '2',
            'margin_bottom' => '2',
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

        if($report_type === 'pndcontr'){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;

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
            $data = DB::select('call procpendcontacts()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){
                 $html =  view('purrpt.pendcontractsrpt')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                    ->with('data',$g)
                    ->with('fromdate',$fromdate)
                    ->with('todate',$todate)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->purid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

        }

        if($report_type === 'cc'){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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
            $data = DB::select('call proccompcontacts()');
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
                 $html =  view('purrpt.compcontractsrpt')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                    ->with('data',$g)
                    ->with('fromdate',$fromdate)
                    ->with('todate',$todate)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->purid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');


        }

        if($report_type === 'glhw'){
            //  dd($request->all());
            $head_id = $request->head_id;
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            //  dd($request->all());
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
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){
                 $html =  view('purrpt.contactsrpt')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->purid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }

        if($report_type === 'tpl'){
            //  dd($request->all());
            $head_id = $request->head_id;
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('grp');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){
                 $html =  view('purrpt.conthistory')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->grp  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                // $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }


        if($report_type === 'impcominvspc'){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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
            //  Call Procedure procinvspmntstatus ( For Detail)
            $data = DB::select('CALL procpaycriteria ()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('grpid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){
                 $html =  view('purrpt.imppaycriteriasum')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                    ->with('data',$g)
                    ->with('fromdate',$fromdate)
                    ->with('todate',$todate)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->grpid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                // $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }


        if($report_type === 'dtysmry'){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;

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
            $data = DB::select('call  procdutysmry()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('grpid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){
                 $html =  view('purrpt.dutysmry')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                    ->with('data',$g)
                    ->with('fromdate',$fromdate)
                    ->with('todate',$todate)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->grpid  .'-'.$fromdate.'-'.$todate.'.pdf';
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
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;

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
                 $html =  view('purrpt.gdnreceived')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
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




        if($report_type === 'dtyclrnc'   ){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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
            $mpdf = $this->getMPDFSettingsA4L();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('cominvid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){


                $html =  view('purrpt.dtyclearance')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
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


        if($report_type === 'dtypnding' && $request->p7==0  ){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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
            $mpdf = $this->getMPDFSettingsA4L();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('cominvid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){


                $html =  view('purrpt.dtyclearance')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
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

        if($report_type === 'dtypnding' && $request->p7==1  ){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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
            $mpdf = $this->getMPDFSettingsA4L();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('grpid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array

            foreach($grouped as $g){


                $html =  view('purrpt.dtyclearancesmry')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                    ->with('data',$g)
                    ->with('fromdate',$fromdate)
                    ->with('todate',$todate)
                    ->with('headtype',$head->title)->render();
                $filename = $g[0]->grpid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                // $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }








        if($report_type === 'loccominvs'){

            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;

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

            $mpdf = $this->getMPDFSettings();
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                $html =  view('purrpt.loccominvsrpt')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                   ->with('data',$g)
                   ->with('fromdate',$fromdate)
                   ->with('todate',$todate)
                   ->with('headtype',$head->title)->render();

                $filename = $g[0]->purid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }

        if($report_type === 'locpurhist'){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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

            $mpdf = $this->getMPDFSettings();
            $grouped = $collection->groupBy('grp');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                $html =  view('purrpt.locpurhistory')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                   ->with('data',$g)
                   ->with('fromdate',$fromdate)
                   ->with('todate',$todate)
                   ->with('headtype',$head->title)->render();

                $filename = $g[0]->grp  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }




        if($report_type === 'purret'){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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
            $data = DB::select('call procpurretrpt()');
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $collection = collect($data);                   //  Make array a collection

            $mpdf = $this->getMPDFSettings();
            $grouped = $collection->groupBy('id');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                $html =  view('purrpt.purchaseret')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
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

        if($report_type === 'locpurhist'){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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

            $mpdf = $this->getMPDFSettings();
            $grouped = $collection->groupBy('grp');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                $html =  view('purrpt.locpurhistory')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
                   ->with('data',$g)
                   ->with('fromdate',$fromdate)
                   ->with('todate',$todate)
                   ->with('headtype',$head->title)->render();

                $filename = $g[0]->grp  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }









        if($report_type === 'impcominvs' || $report_type === 'impcominvs1' ){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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
            // imppurdtl.blade
            if($request->p5==0)
            { $data = DB::select('call procimpcominvs()'); }
            else
            { $data = DB::select('call procipdetail()'); }
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){

                if($report_type === 'impcominvs')
                {
                    if($request->p5==0)
                        { $html =  view('purrpt.impcominvs')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render(); }
                    else
                    { $html =  view('purrpt.imppurdtl')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render(); }

                }
                if($report_type === 'impcominvs1')
                {
                $html =  view('purrpt.impcominvs1')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                }

                // $html =  view('purrpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->purid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }


        if($report_type === 'imppurhist'){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
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
            $mpdf = $this->getMPDFSettingsLI();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('grp');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                 $html =  view('purrpt.imppurhistory')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // $html =  view('purrpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $filename = $g[0]->grp  .'-'.$fromdate.'-'.$todate.'.pdf';
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
