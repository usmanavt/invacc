<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Sku;
use App\Models\Brand;
use App\Models\Hscode;
use App\Models\Source;
use App\Models\Category;
use App\Models\Material;
use App\Models\Dimension;
use App\Models\Specification;
use App\Models\Frmrptparamtr;
use App\Models\Location;



use Carbon\Carbon;
use \Mpdf\Mpdf as PDF;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $materials = Material::where(function($q) use ($search){
            $q->where('title','LIKE',"%$search%")
            ->orWhere('nick','LIKE',"%$search%")
            ->orWhereHas('hscodes', function($qu) use ($search){
                $qu->where('hscode','LIKE',"$search");
            });
        })
        ->orderBy('id','desc')
        ->paginate(5);
        // return $materials;
        return view('materials.index')
        ->with('materials',$materials)
        ->with('skus',Sku::all())
        ->with('categories',Category::all())
        ->with('dimensions',Dimension::all())
        ->with('sources',Source::all())
        // ->with('brands',Brand::all())
        ->with('specifications',Specification::all())
        ->with('locations',Location::all())
        ->with('frmrptparamtrs',Frmrptparamtr::where('rptid',1)->get())
        ->with('hscodes',Hscode::select('id','hscode')->get());
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $materials = Material::where(function ($query) use ($search){
            $query->where('srchb','LIKE','%' . $search . '%');
            // ->orWhere('title','LIKE','%' . $search . '%');
            // ->orWhere('category','LIKE','%' . $search . '%')
            // ->orWhere('brand','LIKE','%' . $search . '%')
            // ->orWhere('sku','LIKE','%' . $search . '%')
            // ->orWhere('srchi','LIKE','%' . $search . '%')
            // ->orWhere('srchb','LIKE','%' . $search . '%')
            // ->orWhere('nick','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $materials;
    }

    public function create()
    {
        // return view('materials.create')
        //     ->with('skus',Sku::all())
        //     ->with('categories',Category::all())
        //     ->with('dimensions',Dimension::all())
        //     ->with('sources',Source::all())
        //     ->with('brands',Brand::all())
        //     ->with('hscodes',Hscode::select('id','hscode')->get())
        //     ->with('materials',Material::all())
        //     ;
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
            'margin_left' => '10',
            'margin_right' => '10',
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





    public function printContractSelected(Request $request)

    {

//  if($request->rptid == 1)
//   {

    // dd($request->all());
    $rptid= $request->rptid;
    // $rptid= 1;
    $gc=$request->gdwn;;

    // $fromdate = Carbon::now()->startOfMonth();
    // $todate = Carbon::now();

    $fromdate = $request->from;
    $todate = $request->to;


    $ids = $request->ids;

    // dd($rptid);

    $ltype ="Office Stock";
    DB::table('tmpstockrptpar')->truncate();
    foreach ($ids as $id) {
        DB::table('tmpstockrptpar')->insert([ 'GLCODE' => (int)$id ]);
    }
    $mpdf = $this->getMPDFSettingsP();


    if($rptid==1)
                {
                    $data = DB::select('call procstockledgeros(?,?,?)',array($fromdate,$todate,1));
                    if(!$data)
                    {
                        Session::flash('info','No data available');
                        return redirect()->back();
                    }
                    $collection = collect($data);                   //  Make array a collection
                    $grouped = $collection->groupBy('grpid');
                    $grouped->values()->all();        //  values() removes indices of array
                    foreach($grouped as $g){
                        $html =  view('stockledgers.slsummary')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                        ->with('ltype',$ltype)->render();
                        $filename = $g[0]->grpid  .'-'.$fromdate.'-'.$todate.'.pdf';
                        $chunks = explode("chunk", $html);
                        foreach($chunks as $key => $val) {
                            $mpdf->WriteHTML($val);
                        }
                        // $mpdf->AddPage();
                    }
                    return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                }

    if($rptid==2)
                {
                    $data = DB::select('call procstockledgerallunitos(?,?)',array($fromdate,$todate));
                    if(!$data)
                    {
                        Session::flash('info','No data available');
                        return redirect()->back();
                    }
                    $mpdf = $this->getMPDFSettingsL();
                    $collection = collect($data);                   //  Make array a collection
                    $grouped = $collection->groupBy('grpid');
                    $grouped->values()->all();        //  values() removes indices of array
                    foreach($grouped as $g){
                        $html =  view('stockledgers.slsummaryalunit')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                        ->with('ltype',$ltype)->render();
                        $filename = $g[0]->grpid  .'-'.$fromdate.'-'.$todate.'.pdf';
                        $chunks = explode("chunk", $html);
                        foreach($chunks as $key => $val) {
                            $mpdf->WriteHTML($val);
                        }
                        // $mpdf->AddPage();
                    }
                    return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                }

    if($rptid==3)
                {

                    $data = DB::select('call procindvstockos(?,?)',array($fromdate,$todate));
                    if(!$data)
                    {
                        Session::flash('info','No data available');
                        return redirect()->back();
                    }
                    $collection = collect($data);                   //  Make array a collection
                    $grouped = $collection->groupBy('material_id');
                    $grouped->values()->all();        //  values() removes indices of array
                    foreach($grouped as $g){
                         $html =  view('stockledgers.indvstockgsmu')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                         ->with('ltype',$ltype)->render();
                        $filename = $g[0]->material_id  .'-'.$fromdate.'-'.$todate.'.pdf';
                        $chunks = explode("chunk", $html);
                        foreach($chunks as $key => $val) {
                            $mpdf->WriteHTML($val);
                        }
                        $mpdf->AddPage();
                    }
                    return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
    }

    if($rptid==4)
                    {

                        $data = DB::select('call procstockledgerosval(?,?,?)',array($fromdate,$todate,1));
                        if(!$data)
                        {
                            Session::flash('info','No data available');
                            return redirect()->back();
                        }
                        $mpdf = $this->getMPDFSettingsL();
                        $collection = collect($data);                   //  Make array a collection
                        $grouped = $collection->groupBy('grpid');
                        $grouped->values()->all();        //  values() removes indices of array
                        foreach($grouped as $g){
                                $html =  view('stockledgers.smsvaluation')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                                ->with('ltype',$ltype)->render();
                            $filename = $g[0]->grpid  .'-'.$fromdate.'-'.$todate.'.pdf';
                            $chunks = explode("chunk", $html);
                            foreach($chunks as $key => $val) {
                                $mpdf->WriteHTML($val);
                            }
                            // $mpdf->AddPage();
                        }
                        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                    }


    if($rptid==5)
                    {

                        $data = DB::select('call procstorpt(?,?,?)',array($fromdate,$todate,0));
                        if(!$data)
                        {
                            Session::flash('info','No data available');
                            return redirect()->back();
                        }
                        $collection = collect($data);                   //  Make array a collection
                        $grouped = $collection->groupBy('stono');
                        $grouped->values()->all();        //  values() removes indices of array
                        foreach($grouped as $g){
                                $html =  view('stockledgers.sto')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                                ->with('ltype',$ltype)->render();
                            $filename = $g[0]->stono  .'-'.$fromdate.'-'.$todate.'.pdf';
                            $chunks = explode("chunk", $html);
                            foreach($chunks as $key => $val) {
                                $mpdf->WriteHTML($val);
                            }
                            $mpdf->AddPage();
                        }
                        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                    }

    if($rptid==6)
                    {

                        $data = DB::select('call procstorpt(?,?,?)',array($fromdate,$todate,1));
                        if(!$data)
                        {
                            Session::flash('info','No data available');
                            return redirect()->back();
                        }
                        $collection = collect($data);                   //  Make array a collection
                        $grouped = $collection->groupBy('stono');
                        $grouped->values()->all();        //  values() removes indices of array
                        foreach($grouped as $g){
                                $html =  view('stockledgers.sto')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                                ->with('ltype',$ltype)->render();
                            $filename = $g[0]->stono  .'-'.$fromdate.'-'.$todate.'.pdf';
                            $chunks = explode("chunk", $html);
                            foreach($chunks as $key => $val) {
                                $mpdf->WriteHTML($val);
                            }
                            $mpdf->AddPage();
                        }
                        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                    }

    if($rptid==7)
                    {

                        $ltype ="Godown Stock";
                        $data = DB::select('call procstockledgergs(?,?)',array($fromdate,$todate));
                        if(!$data)
                        {
                            Session::flash('info','No data available');
                            return redirect()->back();
                        }
                        $collection = collect($data);                   //  Make array a collection
                        $grouped = $collection->groupBy('grpid');
                        $grouped->values()->all();        //  values() removes indices of array
                        foreach($grouped as $g){
                                $html =  view('stockledgers.slsummary')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                                ->with('ltype',$ltype)->render();
                            $filename = $g[0]->grpid  .'-'.$fromdate.'-'.$todate.'.pdf';
                            $chunks = explode("chunk", $html);
                            foreach($chunks as $key => $val) {
                                $mpdf->WriteHTML($val);
                            }
                            // $mpdf->AddPage();
                        }
                        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                    }

    if($rptid==8)
                    {

                        $ltype ="Godown Stock";
                        $data = DB::select('call procstockledgerallunitgs(?,?)',array($fromdate,$todate));
                        if(!$data)
                        {
                            Session::flash('info','No data available');
                            return redirect()->back();
                        }
                        $mpdf = $this->getMPDFSettingsL();
                        $collection = collect($data);                   //  Make array a collection
                        $grouped = $collection->groupBy('grpid');
                        $grouped->values()->all();        //  values() removes indices of array
                        foreach($grouped as $g){
                                $html =  view('stockledgers.slsummaryalunit')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                                ->with('ltype',$ltype)->render();
                            $filename = $g[0]->grpid  .'-'.$fromdate.'-'.$todate.'.pdf';
                            $chunks = explode("chunk", $html);
                            foreach($chunks as $key => $val) {
                                $mpdf->WriteHTML($val);
                            }
                            // $mpdf->AddPage();
                        }
                        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                    }


    if($rptid==10)
                    {

                        $ltype ="Godown Stock";
                        $data = DB::select('call procgwsstock(?,?,?)',array($fromdate,$todate,$gc));
                        if(!$data)
                        {
                            Session::flash('info','No data available');
                            return redirect()->back();
                        }

                        $collection = collect($data);                   //  Make array a collection
                        $grouped = $collection->groupBy('ldesc');
                        $grouped->values()->all();        //  values() removes indices of array
                        foreach($grouped as $g){
                                $html =  view('stockledgers.gwstkledger')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                                ->with('ltype',$ltype)->render();
                            $filename = $g[0]->ldesc  .'-'.$fromdate.'-'.$todate.'.pdf';
                            $chunks = explode("chunk", $html);
                            foreach($chunks as $key => $val) {
                                $mpdf->WriteHTML($val);
                            }
                            // $mpdf->AddPage();
                        }
                        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                    }

    if($rptid==11)
                    {

                        $ltype ="Godown Stock";
                        $data = DB::select('call procgwsstockau(?,?,?)',array($fromdate,$todate,$gc));
                        if(!$data)
                        {
                            Session::flash('info','No data available');
                            return redirect()->back();
                        }
                        $mpdf = $this->getMPDFSettingsA3();
                        $collection = collect($data);                   //  Make array a collection
                        $grouped = $collection->groupBy('ldesc');
                        $grouped->values()->all();        //  values() removes indices of array
                        foreach($grouped as $g){
                                $html =  view('stockledgers.gwstkledgerau')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                                ->with('ltype',$ltype)->render();
                            $filename = $g[0]->ldesc  .'-'.$fromdate.'-'.$todate.'.pdf';
                            $chunks = explode("chunk", $html);
                            foreach($chunks as $key => $val) {
                                $mpdf->WriteHTML($val);
                            }
                            // $mpdf->AddPage();
                        }
                        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                    }

    if($rptid==12)
                    {

                        $ltype ="Godown Stock";
                        $data = DB::select('call procindvstockgs(?,?,?)',array($fromdate,$todate,$gc));
                        if(!$data)
                        {
                            Session::flash('info','No data available');
                            return redirect()->back();
                        }
                        $mpdf = $this->getMPDFSettingsA4L();
                        $collection = collect($data);                   //  Make array a collection
                        $grouped = $collection->groupBy('material_id');
                        $grouped->values()->all();        //  values() removes indices of array
                        foreach($grouped as $g){
                                $html =  view('stockledgers.indvstockgsmugs')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                                ->with('ltype',$ltype)->render();
                            $filename = $g[0]->material_id  .'-'.$fromdate.'-'.$todate.'.pdf';
                            $chunks = explode("chunk", $html);
                            foreach($chunks as $key => $val) {
                                $mpdf->WriteHTML($val);
                            }
                            $mpdf->AddPage();
                        }
                        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                    }


    if($rptid==13)
                    {

                        $ltype ="Godown Stock";
                        $data = DB::select('call procstockledgergsval(?,?,?)',array($fromdate,$todate,$gc));
                        if(!$data)
                        {
                            Session::flash('info','No data available');
                            return redirect()->back();
                        }
                        $mpdf = $this->getMPDFSettingsL();
                        $collection = collect($data);                   //  Make array a collection
                        $grouped = $collection->groupBy('lid');
                        $grouped->values()->all();        //  values() removes indices of array
                        foreach($grouped as $g){
                                $html =  view('stockledgers.smsvaluationgs')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
                                ->with('ltype',$ltype)->render();
                            $filename = $g[0]->lid  .'-'.$fromdate.'-'.$todate.'.pdf';
                            $chunks = explode("chunk", $html);
                            foreach($chunks as $key => $val) {
                                $mpdf->WriteHTML($val);
                            }
                            $mpdf->AddPage();
                        }
                        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
                    }



}






    public function printContract($id)
    {

        $ltype ="Office Stock";
        // $head_id = $request->head_id;
        // $head = Head::findOrFail($head_id);
        // $head = Category::findOrFail($head_id);
        // if($request->has('subhead_id')){
        //     $subhead_id = $request->subhead_id;
            //  Clear Data from Table
            DB::table('tmpstockrptpar')->truncate();
            // foreach($request->subhead_id as $id)
            // {
                DB::table('tmpstockrptpar')->insert([ 'glcode' => $id ]);
        //     }
        // }
        //  Call Procedure
        $mpdf = $this->getMPDFSettingsP();


        $fromdate = Carbon::now()->startOfMonth();
        $todate = Carbon::now();
        // $data = DB::select('call procindvstockos(?,?)',array($fromdate,$todate));
        $data = DB::select('call procstockledgeros(?,?,?)',array($fromdate,$todate,1));
        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $collection = collect($data);                   //  Make array a collection
        $grouped = $collection->groupBy('grpid');
        $grouped->values()->all();        //  values() removes indices of array
        foreach($grouped as $g){
             $html =  view('materials.print')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
             ->with('ltype',$ltype)->render();
            $filename = $g[0]->grpid  .'-'.$fromdate.'-'.$todate.'.pdf';
            $chunks = explode("chunk", $html);
            foreach($chunks as $key => $val) {
                $mpdf->WriteHTML($val);
            }
            $mpdf->AddPage();
        }
        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

    }








    public function store(Request $request)
    {
        //   dd($request->all());
        $request->validate([
            //  'title'=>'required|min:3|unique:materials'
            // 'srchi'=>'required|unique:materials',
            // 'srchb'=>'required|unique:materials'
        ]);


        // dd($request->p1);
        $title = $request->title;
        $category_id=$request->category_id;
        $dimension_id = $request->dimension_id;
        $source_id = $request->source_id;


        $mat = Material::where('dimension_id',$dimension_id)->where('title',$title)->where('category_id',$category_id)->where('source_id',$source_id)->first();
        if($mat)
        {
            // dd($mat);
            Session::flash('info','Same dimension for same title exists');
            return  redirect()->back();
        }

        DB::beginTransaction();
        try {
            {
                $material = new Material();
                //  dd($request->brand);
                $material->title = $request->title;
                $material->nick = $request->nick;
                $material->category_id = $request->category_id;
                $material->dimension_id = $request->dimension_id;
                $material->source_id = $request->source_id;
                $material->source = $request->source;
                $material->sku_id = $request->sku_id;
                $material->sku = $request->sku;
                $material->brand_id = $request->brand_id;
                $material->category = $request->category;
                $material->dimension = $request->dimension;
                $material->srchi = $request->srchi;
                $material->srchb = $request->srchb;
                $material->brand = $request->brand;
                $material->save();


                // $material->qtykg = $request->qtykg;
                // $material->qtykgrt = $request->qtykgrt;
                // $material->qtypcs = $request->qtypcs;
                // $material->qtypcsrt = $request->qtypcsrt;
                // $material->qtyfeet = $request->qtyfeet;
                // $material->qtyfeetrt = $request->qtyfeetrt;
                // $material->balkg = $request->qtykg;
                // $material->balpcs = $request->qtypcs;
                // $material->balfeet = $request->qtyfeet;


            }

            // DB::update(DB::raw("
            // update materials set hscode_id=1 where id=$material->id and title='MS SEAMLESS PIPE'
            // "));

            // DB::update(DB::raw("
            // update materials set hscode_id=2 where id=$material->id and title='MS ELBOW 90Â°'
            // "));

            // DB::update(DB::raw("
            // update materials set hscode_id=3 where id=$material->id and title not in('MS ELBOW 90Â°','MS SEAMLESS PIPE')
            // "));




            DB::commit();
            Session::flash('success','Material created');
               return redirect()->back();

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function show(Material $material)
    {
        //
    }

    public function copyMaterial($id)
    {
        // dd($material);
        return view('materials.copy')
        // ->with('skus',Sku::all())
        // ->with('categories',Category::all())
        ->with('dimensions',Dimension::all())
        // ->with('sources',Source::all())
        // ->with('brands',Brand::all())
        // ->with('hscodes',Hscode::all())
        ->with('specifications',Specification::all())
        ->with('material',Material::findOrFail($id))
        ->with('materials',Material::select('id','title','dimension','brand')->get()) ;
    }

    public function edit(Material $material)
    {
        return view('materials.edit')
        ->with('skus',Sku::all())
        ->with('categories',Category::all())
        ->with('dimensions',Dimension::all())
        ->with('sources',Source::all())
        // ->with('brands',Brand::all())
        ->with('specifications',Specification::all())

        // ->with('hscodes',Hscode::select('id','hscode')->get())
        ->with('material',$material)
        ;
    }

    public function update(Material $material,Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'title'=>'required|unique:materials,title,'.$material->id
            // 'srchb' => 'required|size:10|string'
        ]);
        DB::beginTransaction();
        try {
            $material->title = $request->title;
            $material->nick = $request->nick;
            $material->category_id = $request->category_id;
            $material->dimension_id = $request->dimension_id;
            $material->source_id = $request->source_id;
            $material->sku_id = $request->sku_id;
            $material->brand_id = $request->brand_id;
            $material->brand = $request->brand;
            // $material->hscode_id = $request->hscode_id;
            $material->category = $request->category;
            $material->dimension = $request->dimension;
            $material->source = $request->source;
            $material->sku = $request->sku;
            $material->srchi = $request->srchi;
            $material->srchb = $request->srchb;

            // $material->brand = $request->brand;
            // $material->qtykg = $request->qtykg;
            // $material->qtykgrt = $request->qtykgrt;
            // $material->qtypcs = $request->qtypcs;
            // $material->qtypcsrt = $request->qtypcsrt;
            // $material->qtyfeet = $request->qtyfeet;
            // $material->qtyfeetrt = $request->qtyfeetrt;
            // $material->balkg = $request->qtykg;
            // $material->balpcs = $request->qtypcs;
            // $material->balfeet = $request->qtyfeet;


            if($request->has('status'))
            {
                $material->status = 1;
            }else {
                $material->status = 0;
            }
            $material->save();
            DB::commit();
            Session::flash('info','Material updated');
            return redirect()->route('materials.index');

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function destroy($id)
    {

    }
}
