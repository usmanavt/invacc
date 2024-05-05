<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;
use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use App\Models\CustomerOrder;


use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class QuotationController  extends Controller
{
    public function index(Request $request)
    {
         return view('quotations.index');


    }


    public function qutseqno(Request $request)
    {
        //  dd($request->all());
        // $head_id = $request->head_id;
        $newqutno = DB::table('quotations')->select('qutno')->max('qutno')+1;
        return  $newqutno;

    }



    public function itemlistwrate(Request $request)
    {
        //  dd($request->all());
        $customerid = $request->customer_id;
        // procpaymentmaster(32)
        return  DB::select('call procqutmatfrmlist(?)',array($customerid));

    }





    public function getMaster(Request $request)
    {
        // dd($request->all());
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = Quotation::where('status',$status)
        ->where(function ($query) use ($search){
                $query->where('qutno','LIKE','%' . $search . '%')
                // ->orWhere('gpno','LIKE','%' . $search . '%')
                ->orWhere('prno','LIKE','%' . $search . '%');
            })
            // ->whereHas('customer', function ($query) {
            //      $query->where('source_id','=','1');
            // })
        ->with('customer:id,title')
         ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;
    }


    public function qutIndex(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = DB::table('quotationindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->with('customer:id,title')
        ->where('custname', 'like', "%$search%")
        ->orWhere('qutno', 'like', "%$search%")
        // ->orWhere('impgdno', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;

    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = QuotationDetails::where('sale_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }



    public function getmmfrqut(Request $request)
    {

        $search = $request->search;
        $customerid = $request->customerid;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        // $vrtype = $request->p1;
        //  $abc = DB::select(' call procmmfrquotation(?)',array( $customerid ));
        // $contracts = DB::table('tmpmmmaterial')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        //  ->where('customer_id',$custid)
        // ->orWhere('customer_id','=','0')
        // ->where('category_id','=',(int)(substr($search,0,2)))
        // ->where('dimension','LIKE','%' . substr($search,3,10) . '%')

        //  ->where('custname', 'like', "%$search%")
        //  ->where('srchb', 'like', "%$search%")
        //  ->orWhere('dimension', 'like', "%$search%")

        $contracts=DB::table('materials as a')
        ->leftJoin('last_sale_rate AS b', function($join) use ($customerid){
            $join->on('a.id', '=', 'b.material_id')
                 ->where('b.customer_id', '=', $customerid);
        // dd($customerid);

        })

        // ->leftJoin('last_sale_rate', 'materials.id', '=', 'last_sale_rate.material_id')
        // ->where('customer_id','=',$customerid)
       ->select('a.id','a.title','a.srchb','a.category','a.category_id','a.dimension','a.dimension_id','b.salrate  as pcspbundle1'
       ,DB::raw('case when b.sunitid<>0 then b.sunitname else a.sku end as sku'))

        ->where(function ($query) use ($search){
            $query->where('srchb','LIKE','%' . $search. '%');
        //    ->where('brand_id','=',$supplierId)
            // ->where('srchb','LIKE','%' . $search. '%');
        })

        ->orderBy($field,$dir)
        ->paginate((int) $size);

        return $contracts;

    }



    public function create()
    {
        // $locations = Location::select('id','title')->where('status',1)->get();

        $result = DB::table('vwcusfrmlist')->get();
        $resultArray = $result->toArray();
        $data=compact('resultArray');


        $result1 = DB::table('vwcontfrmmatlist')->get();
        $resultArray1 = $result1->toArray();
        $data1=compact('resultArray1');

        // $result1=DB::table('materials as a')
        // ->leftJoin('last_sale_rate AS b', function($join) {
        //     $join->on('a.id', '=', 'b.material_id')
        //          ->where('b.customer_id', '=', 65);
        // // dd($customerid);

        // });
        // $resultArray1 = $result1->toArray();
        // $data1=compact('resultArray1');

// dd($contracts);


        // return view('sales.create')
        $mycname='MUHAMMAD HABIB & Co.';
        $maxdcno = DB::table('quotations')->select('*')->max('qutno')+1;
        // $maxblno = DB::table('sale_invoices')->select('*')->max('prno')+1;
        // $maxgpno = DB::table('sale_invoices')->select('*')->max('gpno')+1;
        return \view ('quotations.create',compact('maxdcno','mycname'))
        ->with($data)->with($data1)
        ->with('customers',Customer::select('id','title')->where('id','<>','1')->get())
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get());

        // ->with('maxdcno',lastsalinvno::select('id','qutno')->get());

        // ->with('lastsno',DB::table('lastsalinvno')->select('*')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[
            'saldate' => 'required|min:3|date',
        //    'title'=>'required|min:3|unique:materials'
            'qutno' => 'required|min:1|unique:quotations',
            // 'prno' => 'required|min:1|unique:quotations',
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {

            $ci = new Quotation();
            $ci->saldate = $request->saldate;
            $ci->valdate = $request->valdate;
            $ci->qutno = $request->qutno;
            $ci->prno = $request->prno;
            $ci->customer_id = $request->customer_id;
            $ci->t1 = $request->t1;
            $ci->t2 = $request->t2;
            $ci->t3 = $request->t3;
            $ci->t4 = $request->t4;
            $ci->t5 = $request->t5;





            $ci->fstatus = 0;

            $ci->cashcustomer = $request->cashcustomer;
            $ci->cashcustadrs = $request->cashcustadrs;


            $ci->discntper = $request->discntper;
            $ci->discntamt = $request->discntamt;
            $ci->cartage = $request->cartage;
            $ci->rcvblamount = $request->rcvblamount;

            $ci->saletaxper = $request->saletaxper;
            $ci->saletaxamt = $request->saletaxamt;
            $ci->totrcvbamount = $request->totrcvbamount;
            $ci->save();
            foreach ($request->contracts as $cont) {
                $material = Material::findOrFail($cont['id']);
                $lpd = new QuotationDetails();
                $lpd->sale_invoice_id = $ci->id;
                $lpd->material_id = $material->id;
                $lpd->repname = $cont['repname'];
                $lpd->mybrand = $cont['mybrand'];
                $lpd->qtykg = $cont['bundle1'];
                $lpd->price = $cont['price'];
                $lpd->lstslprice = $cont['pcspbundle1'];
                $lpd->mrktprice1 = $cont['mrktprice1'];
                $lpd->mrktprice2 = $cont['mrktprice2'];
                $lpd->mrktprice3 = $cont['mrktprice3'];
                $lpd->saleamnt = $cont['ttpcs'];
                $lpd->supp1 = $cont['supp1'];
                $lpd->supp2 = $cont['supp2'];
                $lpd->supp3 = $cont['supp3'];
                $lpd->tqtpendqty = $cont['bundle1'];

                // $location = Location::where("title", $cont['location'])->first();
                // $lpd->locid = $location->id;
                // $lpd->location = $cont['location'];

                $unit = Sku::where("title", $cont['sku'])->first();
                $lpd->sku_id = $unit->id;
                // $lpd->sku = $cont['sku'];
                $lpd->save();
            }

            DB::update(DB::raw("
            update quotations c
            INNER JOIN (
                SELECT sale_invoice_id, SUM(qtykg) as qty,sum(saleamnt) as amount  FROM quotation_details where  sale_invoice_id = $ci->id  GROUP BY sale_invoice_id
                        ) x ON c.id = x.sale_invoice_id
            SET c.tqqty = x.qty,c.tqpendqty=x.qty,c.tqpendval=amount where  id = $ci->id
            "));



                // DB::update(DB::raw("
                // UPDATE quotations c
                // INNER JOIN (
                // SELECT quotation_id,SUM(qtykg) AS qty,SUM(saleamnt) AS amount FROM customer_order_details WHERE quotation_id=$ci->id GROUP BY quotation_id
                // ) x ON c.id = x.quotation_id
                // SET c.tqpendqty = c.tqqty - coalesce(x.qty,0), c.tqpendval = c.rcvblamount - coalesce(x.amount,0) WHERE  c.id = $ci->id"));






            // }
            DB::commit();
            Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

    // public function edit(Contract $contract)
    public function edit($id)
    {

        $result = DB::table('vwcusfrmlist')->get();
        $resultArray = $result->toArray();
        $data0=compact('resultArray');


        $result1 = DB::table('vwcontfrmmatlist')->get();
        $resultArray1 = $result1->toArray();
        $data1=compact('resultArray1');


        $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');

        $cd = DB::table('quotation_details')
        ->join('materials', 'materials.id', '=', 'quotation_details.material_id')
        ->join('skus', 'skus.id', '=', 'quotation_details.sku_id')
        ->select('quotation_details.*','materials.title as material_title','materials.dimension','skus.title as sku')
        ->where('sale_invoice_id',$id)->get();
         $data=compact('cd');



        return view('quotations.edit',compact('passwrd'))
        ->with('customer',Customer::select('id','title')->get())
        // ->with('materials',Material::select('id','category')->get())
        ->with('quotation',Quotation::findOrFail($id))
        // ->with('cd',QuotationDetails::where('sale_invoice_id',$id)->get())
        ->with($data)->with($data0)->with($data1)
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }




    public function deleterec($id)
    {

        $rsrvpo = CustomerOrder::where('quotation_id',$id)->max('quotation_id');
        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');

        $cd = DB::table('quotation_details')
        ->join('materials', 'materials.id', '=', 'quotation_details.material_id')
        ->join('skus', 'skus.id', '=', 'quotation_details.sku_id')
        ->select('quotation_details.*','materials.title as material_title','materials.dimension','skus.title as sku')
        ->where('sale_invoice_id',$id)->get();
         $data=compact('cd');

        // DB::table('skus')->select('id AS dunitid','title AS dunit')
        // ->whereIn('id',[1,2])->get();



        return view('quotations.deleterec',compact('passwrd','rsrvpo'))
        ->with('customer',Customer::select('id','title')->get())
        // ->with('materials',Material::select('id','category')->get())
        ->with('quotation',Quotation::findOrFail($id))
        // ->with('cd',QuotationDetails::where('sale_invoice_id',$id)->get())
        ->with($data)
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }












    public function update(Request $request, Quotation $quotation)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());




        DB::beginTransaction();
        try {

            //  dd($request->customer_id);
            $quotation = Quotation::findOrFail($request->sale_invoice_id);
            $quotation->saldate = $request->saldate;
            $quotation->valdate = $request->valdate;
            $quotation->qutno = $request->qutno;
            $quotation->prno = $request->prno;
            $quotation->customer_id = $request->customer_id;
            $quotation->cashcustomer = $request->cashcustomer;
            $quotation->cashcustadrs = $request->cashcustadrs;
            $quotation->t1 = $request->t1;
            $quotation->t2 = $request->t2;
            $quotation->t3 = $request->t3;
            $quotation->t4 = $request->t4;
            $quotation->t5 = $request->t5;


            $quotation->discntper = $request->discntper;
            $quotation->discntamt = $request->discntamt;
            $quotation->cartage = $request->cartage;
            $quotation->rcvblamount = $request->rcvblamount;
            $quotation->saletaxper = $request->saletaxper;
            $quotation->saletaxamt = $request->saletaxamt;
            $quotation->totrcvbamount = $request->totrcvbamount;
            $quotation->closed = $request->p5;

            $quotation->save();
            // Get Data
            $cds = $request->quotations; // This is array
            $cds = QuotationDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = QuotationDetails::where('sale_invoice_id',$quotation->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                if($cd->id)
                {
                    $cds = QuotationDetails::where('id',$cd->id)->first();

                    $cds->sale_invoice_id = $quotation->id;
                    $cds->material_id = $cd->material_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->repname = $cd['repname'];
                    $cds->mybrand = $cd['mybrand'];
                    $cds->qtykg = $cd['qtykg'];
                    $cds->price = $cd['price'];
                    $cds->lstslprice = $cd['lstslprice'];
                    $cds->mrktprice1 = $cd['mrktprice1'];
                    $cds->mrktprice2 = $cd['mrktprice2'];
                    $cds->saleamnt = $cd['saleamnt'];
                    $cds->supp1 = $cd['supp1'];
                    $cds->supp2 = $cd['supp2'];


                    //  $location = Location::where("title", $cd['location'])->first();
                    //  $cds->locid = $location->id;
                    //   $cds->location = $cd['location'];

                     $unit = Sku::where("title", $cd['sku'])->first();
                     $cds->sku_id = $unit->id;
                    //  $cds->sku = $cd['sku'];

                 $cds->save();
                }else
                {
                    //  The item is new, Add it
                     $cds = new QuotationDetails();
                    // $cds->sale_invoice_id = $saleinvoices->id;
                    // $cds->material_id = $cd->material_id;
                    // $cds->sku_id = $cd->sku_id;

                    // $cds->qtykg = $cd['bundle1'];
                    // $cds->qtypcs = $cd['bundle2'];
                    // $cds->qtyfeet = $cd['pcspbundle2'];
                    // $cds->price = $cd['pcspbundle1'];
                    // $cds->saleamnt = $cd['ttpcs'];
                    // $cds->locid = $cd['location'];
                    // $cds->salunitid = $cd['sku'];

                    $cds->sale_invoice_id = $quotation->id;
                    $cds->material_id = $cd->material_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->repname = $cd['repname'];
                    $cds->qtykg = $cd['qtykg'];
                    // $cds->qtypcs = $cd['qtypcs'];
                    // $cds->qtyfeet = $cd['qtyfeet'];
                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];

                    //  $location = Location::where("title", $cd['location'])->first();
                    //  $cds->locid = $location->id;
                    //  $cds->location = $cd['location'];

                     $unit = Sku::where("title", $cd['sku'])->first();
                     $cds->sku_id = $unit->id;
                    //  $cds->sku = $cd['sku'];


                    $cds->save();
                }
            }

            DB::update(DB::raw("
            update quotations c
            INNER JOIN (
                SELECT sale_invoice_id, SUM(qtykg) as qty  FROM quotation_details where  sale_invoice_id = $quotation->id  GROUP BY sale_invoice_id
                        ) x ON c.id = x.sale_invoice_id
            SET c.tqqty = x.qty where  c.id = $quotation->id
            "));


            $lstrt = CustomerOrder::where('quotation_id',$quotation->id)->first();
            if($lstrt) {


            DB::update(DB::raw("
            UPDATE quotations c
            INNER JOIN (
            SELECT quotation_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
            WHERE quotation_id=$quotation->id GROUP BY quotation_id
            ) x ON c.id = x.quotation_id
            SET c.tqpendqty = c.tqqty - coalesce(x.qty,0), c.tqpendval = c.rcvblamount - coalesce(x.amount,0) WHERE  c.id = $quotation->id"));

            DB::update(DB::raw("
            UPDATE quotation_details c
            INNER JOIN (
            SELECT quotation_id,material_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b
            on a.id=b.sale_invoice_id   WHERE quotation_id=$quotation->id GROUP BY quotation_id,material_id
            ) x ON c.sale_invoice_id = x.quotation_id and c.material_id=x.material_id
            SET c.tqtpendqty = c.qtykg - coalesce(x.qty,0) WHERE  c.sale_invoice_id = $quotation->id"));
            }












            DB::commit();
            Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
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


    public function printContract($id)
    {

        // $hdng1 = $request->cname;
        // $hdng2 = $request->csdrs;
        // $t1 = $request->t1;
        // $t2 = $request->t2;
        // $t3 = $request->t3;
        // $t4 = $request->t4;
        // $t5 = $request->t5;
        // $head_id = $request->head_id;
        // $head = Head::findOrFail($head_id);
        // $head = Customer::findOrFail($head_id);
        // if($request->has('subhead_id')){
        //     $subhead_id = $request->subhead_id;
            //  Clear Data from Table
            DB::table('tmpqutparrpt')->truncate();
            // foreach($request->subhead_id as $id)
            // {
                DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
        //     }
        // }
        //  Call Procedure
        // $mpdf = $this->getMPDFSettingslndscap();
        $data = DB::select('call procquotation()');
        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $mpdf = $this->getMPDFSettings();
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
            // $mpdf = $this->getMPDFSettingslndscap();
             $html =  view('quotations.print')->with('data',$g)->with('nogrp',$nogrp)->render();
            //  ->with('fromdate',$fromdate)->with('todate',$todate)
            //  ->with('headtype',$head->title)
            //  ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('t1',$t1)->with('t2',$t2)->with('t3',$t3)->with('t4',$t4)->with('t5',$t5)
            //  ->render();
            // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
            $filename = $g[0]->id  .'.pdf';

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



    public function deleteBankRequest(Request $request)
    {


//  dd($request->invsid);
        DB::beginTransaction();
            try {





                // DB::update(DB::raw("
                // UPDATE quotations c
                // INNER JOIN (
                // SELECT quotation_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
                // WHERE quotation_id=$request->quotation_id GROUP BY quotation_id
                // ) x ON c.id = x.quotation_id
                // SET c.tqpendqty = c.tqpendqty + coalesce(x.qty,0), c.tqpendval = c.tqpendval + coalesce(x.amount,0) WHERE  c.id = $request->quotation_id"));

                // DB::update(DB::raw("
                // UPDATE quotation_details c
                // INNER JOIN (
                // SELECT quotation_id,material_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
                // WHERE quotation_id=$request->quotation_id GROUP BY quotation_id,material_id
                // ) x ON c.sale_invoice_id = x.quotation_id and c.material_id=x.material_id
                // SET c.tqtpendqty = c.tqtpendqty + coalesce(x.qty,0) WHERE  c.sale_invoice_id = $request->quotation_id"));



                DB::delete(DB::raw(" delete from quotations where id=$request->sale_invoice_id   "));
                DB::delete(DB::raw(" delete from quotation_details where sale_invoice_id=$request->sale_invoice_id   "));
                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }



}
