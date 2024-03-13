<?php

namespace App\Http\Controllers;

use App\Models\Head;
use \Mpdf\Mpdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{

    public function index()
    {
        return view('reports.index')
        ->with('heads',Head::where('status',1)->whereIn('id',[32,33,34,100,101,102,103,104,105,106,107,110,111,112,113,114])->get())
        ->with('glheads',Head::where('status',1)->whereIn('id',[1,2,30,36,37,38])->get())
        ->with('vchrheads',Head::where('status',1)->whereIn('id',[5,6,7,8,9,50])->get())
        ->with('subheads',DB::table('vwcategory')->select('*')->get()->toArray())
        // ->with('vchrcats',DB::table('vwvouchercategory')->select('*')->get()->toArray())
        ;
    }

    public function vouchers(Request $request)
    {
        //  dd($request->all());
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $head = $request->head;
        // return DB::table('vwvouchercategory')->select('*')->whereBetween('docdate',[$fromdate,$todate])->where('mheadid',$head)->get()->toArray();
        return  DB::select('call procvouchertrans(?,?,?)',array($fromdate,$todate,$head));



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
        // $temp = storage_path('temp');
        $mpdf = new PDF( [
            'mode' => 'utf-8',
            // 'format' => 'A4-L',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '10',
            'margin_bottom' => '10',
            'margin_footer' => '2',
            'default_font_size' => 9,
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->debug = true;
        //  Get Report
        if($report_type === 'tpl'){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $data = DB::select('call ProcTPL(?,?,1)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            $html =  view('reports.tpl')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$data)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = 'TransactionProveLista-'.$fromdate.'-'.$todate.'.pdf';

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
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
    }


        if($report_type === 'gl'){
            // dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $subhead_id = $request->subhead_id;
            //  Truncate Table Data
            DB::table('glparameterrpt')->truncate();
            foreach($request->subhead_id as $id)
            {
                DB::table('glparameterrpt')->insert([
                    'GLCODE' => $id
                ]);
            }
            // Add input for Muliple parameters in Procedure
            // if($request->p5 == 0)
            $data = DB::select('call ProcGL(?,?,?)',array($fromdate,$todate,1));
            // else
            // { $data = DB::select('call ProcGL(?,?,?)',array($fromdate,$todate,2));}
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            // $html =  view('reports.gl')->with('data',$data)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            // $filename = 'GeneralLedger-'.$fromdate.'-'.$todate.'.pdf';

            $collection = collect($data);                   //  Make array a collection

            $grouped = $collection->groupBy('Parid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){
                if($request->p5 == 0)
                { $html =  view('reports.gl')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render(); }
                else
                { $html =  view('reports.glf2')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render(); }
                $filename = $g[0]->Parid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                // $mpdf->AddPage();
            }
            //  $mpdf->Output($filename,'I');
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');




        }



        if($report_type === 'glhw'){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $head_id = $request->head_id;
            $vrtype = $request->p2;
            //  dd($vrtype);
            $head = Head::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('glparameterrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('glparameterrpt')->insert([ 'GLCODE' => $id ]);
                }
            }
            //  Call Procedure
            $data = DB::select('call ProcGLHW(?,?,?,?)',array($fromdate,$todate,$head_id,$vrtype));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('SubHead');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){

             if($vrtype == 0)
              {
                 if($request->p6 == 0)
                 {
                    $html =  view('reports.glhw')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                 }
                 else
                 {
                    $html =  view('reports.glhwrup')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                 }
                }
              else
              {
                if($request->p6 == 0)
                    {
                    $html =  view('reports.glhwsummary')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                    }
                else
                    {
                    $html =  view('reports.glhwsummaryrup')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                    }
              }



               $filename = $g[0]->SubHead  .'-'.$fromdate.'-'.$todate.'.pdf';

               $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            //  $mpdf->Output($filename,'I');
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

            // return;
        }






        if($report_type === 'chktran'){
            //  dd($request->all());
            // $head_id = $request->head_id;
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $vrtype4 = $request->p4;
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

            //  if($vrtype4 == 0)
            //   {
                $html =  view('reports.chequecoll')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            //    }
            //   else
            //   {
                // $html =  view('reports.glhwsummary')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
            //    }



               $filename = $g[0]->grp  .'-'.$fromdate.'-'.$todate.'.pdf';

               $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                // $mpdf->AddPage();
            }
            //  $mpdf->Output($filename,'I');
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

            // return;
        }



        if($report_type === 'invwspay'){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $head_id = $request->head_id;
            $par1=$request->p1;
            $head = Head::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('tmpvoucherrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpvoucherrpt')->insert([ 'supid' => $id ]);
                }
            }


            //  Call Procedure ,$head_id
            if($head_id == 32)
            {
            $data = DB::select('call procinvwspayment(?,?,?)',array($fromdate,$todate,$par1));
            }
            if($head_id == 33)
            {
            $data = DB::select('call proccollectiondetail(?,?,?)',array($fromdate,$todate,$par1));
            }
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('supplier_id');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){

                if($head_id == 32)
                {
                $html =  view('reports.invswspayment')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                }
                if($head_id == 33)
                {
                $html =  view('reports.invswscollection')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                }
                $filename = $g[0]->supplier_id  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            //  $mpdf->Output($filename,'I');
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

            // return;
        }



        if($report_type === 'agng'){
            //  dd($request->all());
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;
            $head_id = $request->head_id;
            $par3=$request->p3;
            $head = Head::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('tmpvoucherrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpvoucherrpt')->insert([ 'supid' => $id ]);
                }
            }
            //  Call Procedure ,$head_id
            if($head_id == 32)
            {
            $data = DB::select('call procagngdtl(?,?,?)',array($fromdate,$todate,$par3));
            }
            if($head_id == 33)
            {
            $data = DB::select('call procsalagngdtl(?,?,?)',array($fromdate,$todate,$par3));
            }
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('supplier_id');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){

                if($head_id == 32)
                {
                    if( $par3 == 0)
                    {

                            $html =  view('reports.agingdtl')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();

                    }
                    else
                    {

                            $html =  view('reports.agingsumary')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();

                    }

                }
                if($head_id == 33)
                {
                    if( $par3 == 0)
                    {
                        $html =  view('reports.agingdtlsale')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                    }

                    else
                    {
                        $html =  view('reports.agingsalesumary')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                    }
                }
                $filename = $g[0]->supplier_id  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                $mpdf->AddPage();
            }
            //  $mpdf->Output($filename,'I');
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

            // return;
        }





        if($report_type === 'vchr'){
            $hdng1 = $request->cname;
            $hdng2 = $request->csdrs;

            $head_id = $request->head_id;
            $head = Head::findOrFail($head_id);
            if($request->has('subhead_id')){
                $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('tmpvoucherrpt')->truncate();
                foreach($request->subhead_id as $id)
                {
                    DB::table('tmpvoucherrpt')->insert([ 'supid' => $id ]);
                }
            }
            //  Call Procedure
            // $data = DB::select('call ProcGLHW(?,?,?)',array($fromdate,$todate,$head_id));
            if($head_id == 5)
                {
                    $data = DB::select('call procvoucherrptjv()');
                }
            else
                {
                    $data = DB::select('call procvoucherrpt()');
                }


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

                if($head_id == 5)
                {
                    $html =  view('reports.vouchergv')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                }
                else
                {
                    $html =  view('reports.voucher')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                }
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
        // if($report_type === 'agng')

        // $mpdf->SetHTMLFooter('
        //     <table width="100%" style="border-top:1px solid gray">
        //         <tr>
        //             <td width="33%">{DATE j-m-Y}</td>
        //             <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        //             <td width="33%" style="text-align: right;">' . $filename . '</td>
        //         </tr>
        //     </table>');
        // $chunks = explode("chunk", $html);
        // foreach($chunks as $key => $val) {
        //     $mpdf->WriteHTML($val);
        // }
        // //$mpdf->Output($filename,'I');
        // return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
    }

}
