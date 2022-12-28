<?php

namespace App\Http\Controllers;

use App\Models\Head;
use \Mpdf\Mpdf as PDF;
use App\Models\Subhead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{

    public function index()
    {
        return view('reports.index')
        ->with('heads',Head::where('status',1)->get())
        ->with('glheads',Head::where('status',1)->whereIn('id',[1,2,30,36,38])->get())
        ->with('vchrheads',Head::where('status',1)->whereIn('id',[6,7,8,9])->get())
        ->with('subheads',Subhead::where('status',1)->get());
    }

    public function fetch(Request $request)
    {
        //  https://stackoverflow.com/questions/42555512/how-to-create-temporary-table-in-laravel
        // dd($request->all());
        $report_type = $request->report_type;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $data = null;

        if($report_type === 'tpl'){
            $data = DB::select('call ProcTPL(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $html =  view('reports.tpl')->with('data',$data)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = 'TransactionProveLista-'.$fromdate.'-'.$todate.'.pdf';
        }
        if($report_type === 'gl'){
            dd($request->all());
            $head_id = $request->head_id;
            // Loop over $subheads, As it can have multiple [HEADS ID]
            // Add input for Muliple parameters in Procedure
            $data = DB::select('call ProcGL(?,?,?)',array($fromdate,$todate,$head_id));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $html =  view('reports.gl')->with('data',$data)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = 'GeneralLedger-'.$fromdate.'-'.$todate.'.pdf';
        }
        if($report_type === 'glhw'){
            dd($request->all());
            $subheads = $request->subhead_id;
            $data = DB::select('call ProcGLHW(?,?)',array($fromdate,$todate));
            if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $html =  view('reports.glhw')->with('data',$data)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = 'GeneralLedgerWithHeaders-'.$fromdate.'-'.$todate.'.pdf';
        }
        if($report_type === 'vchr'){}
        if($report_type === 'agng'){}
        // MPDF Settings
        ini_set('max_execution_time', '2000');
        ini_set("pcre.backtrack_limit", "100000000");
        ini_set("memory_limit","4000M");
        ini_set('allow_url_fopen',1);
        ini_set('user_agent', 'Mozilla/5.0');

        // Log::info("MPDF init set");
        $temp = storage_path('temp');
        // Log::info("Temp is " . $temp);
        // return $html;
        // Create the mPDF document
        $mpdf = new PDF( [
            'mode' => 'utf-8',
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
        // Log::info('MPDF settings done');
        $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top:1px solid gray">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">' . $filename . '</td>
                </tr>
            </table>');
        // Log::info('MPDF SetHTMLFooter done');
        $chunks = explode("chunk", $html);
        foreach($chunks as $key => $val) {
            $mpdf->WriteHTML($val);
            Log::info('Chunks Writen ');
        }
        // $html = view('reports.tpl')->render();
        // $mpdf->WriteHTML($html);
        $mpdf->Output($filename,'D');
    }

}
