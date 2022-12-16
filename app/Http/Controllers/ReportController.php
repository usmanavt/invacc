<?php

namespace App\Http\Controllers;

use App\Models\Head;
use \Mpdf\Mpdf as PDF;
use App\Models\Subhead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        // dd($request->all());
        $report_type = $request->report_type;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $data = null;

        if($report_type === 'tpl'){
            $data = DB::select('call ProcGL(?,?)',array($fromdate,$todate));
            $html =  view('reports.tpl')->with('data',$data)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = 'GeneralLedger-'.$fromdate.'-'.$todate.'.pdf';
        }
        if($report_type === 'gl'){}
        if($report_type === 'glwh'){}
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

    // function printPDF($filename,$html)
    // {
    //     ini_set('max_execution_time', '2000');
    //     ini_set("pcre.backtrack_limit", "100000000");
    //     ini_set("memory_limit","8000M");
    //     ini_set('allow_url_fopen',1);
    //     $temp = storage_path('temp');
    //     // Create the mPDF document
    //     $mpdf = new PDF( [
    //         'mode' => 'utf-8',
    //         'format' => 'A4',
    //         'margin_header' => '3',
    //         'margin_top' => '20',
    //         'margin_bottom' => '20',
    //         'margin_footer' => '2',
    //         'default_font_size' => 9,
    //     ]);
    //     $mpdf->SetHTMLFooter('
    //         <table width="100%" style="border-top:1px solid gray">
    //             <tr>
    //                 <td width="33%">{DATE j-m-Y}</td>
    //                 <td width="33%" align="center">{PAGENO}/{nbpg}</td>
    //                 <td width="33%" style="text-align: right;">' . $filename . '</td>
    //             </tr>
    //         </table>');
    //     $chunks = explode("chunk", $html);
    //     foreach($chunks as $key => $val) {
    //         $mpdf->WriteHTML($val);
    //     }
    //     $mpdf->Output($filename,'I');
    //     // 'D': download the PDF file
    //     // 'I': serves in-line to the browser
    //     // 'S': returns the PDF document as a string
    //     // 'F': save as file $file_out
    // }
}
