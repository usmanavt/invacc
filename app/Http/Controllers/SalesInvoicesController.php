<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;

use App\Models\SaleInvoices;
use App\Models\SaleInvoicesDetails;
use App\Models\CreateSaleRate;
use App\Models\ItemBal;


use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class SalesInvoicesController  extends Controller
{
    public function index(Request $request)
    {
         return view('sales.index');


    }

    // public function getMaster(Request $request)
    // {
    //     $status =$request->status ;
    //     $search = $request->search;
    //     $size = $request->size;
    //     $field = $request->sort[0]["field"];     //  Nested Array
    //     $dir = $request->sort[0]["dir"];         //  Nested Array
    //     $localpurchase = CommercialInvoice::where('status',$status)
    //     ->where(function ($query) use ($search){
    //             $query->where('invoiceno','LIKE','%' . $search . '%');

    //         })
    //         ->whereHas('supplier', function ($query) {
    //             $query->where('source_id','=','1');
    //             // ->orWhere('source_id',1);
    //         })

    //     ->with('supplier:id,title')
    //     ->orderBy($field,$dir)
    //     ->paginate((int) $size);
    //     return $localpurchase;
    // }

    public function getMaster(Request $request)
    {
        // dd($request->all());
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = SaleInvoices::where('custplan_id','<>','0')
        ->where(function ($query) use ($search){
                $query->where('dcno','LIKE','%' . $search . '%')
                ->orWhere('pono','LIKE','%' . $search . '%')
                ->orWhere('billno','LIKE','%' . $search . '%');
            })
            // ->whereHas('customer', function ($query) {
            //      $query->where('source_id','=','1');
            // })
        ->with('customer:id,title')
         ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;
    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = SaleInvoicesDetails::where('sale_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getMastercustplan(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwmastercustplan')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('custname', 'like', "%$search%")
        ->orWhere('pono', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;
    }

    public function getDetailscustplan(Request $request)
    {
        $id = $request->id;
        // dd($id);
        //  $contractDetails = DB::table('vwdetailcustplan')->where('sale_invoice_id',$id)->get();
        $contractDetails = DB::select('call procdetailcustplan(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }





    public function create()
    {
         $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        // $mycname='MUHAMMAD HABIB & Co.';
        $maxdcno = DB::table('sale_invoices')->select('dcno')->max('dcno')+1;
        $maxgpno = DB::table('sale_invoices')->select('gpno')->max('gpno')+1;
        $maxbillno = DB::table('sale_invoices')->select('billno')->max('billno')+1;

        return \view ('sales.create',compact('maxdcno','maxgpno','maxbillno'))
        ->with('customers',Customer::select('id','title')->get())
         ->with('locations',Location::select('id','title')->get());
        // ->with('skus',Sku::select('id','title')->get());

        // ->with('maxdcno',lastsalinvno::select('id','poseqno')->get());

        // ->with('lastsno',DB::table('lastsalinvno')->select('*')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[

            'dcno' => 'required|unique:sale_invoices',
            'gpno' => 'required|unique:sale_invoices',
            // 'poseqno' => 'required|min:1|unique:customer_orders',
            // 'pono' => 'required|min:1|unique:customer_orders'
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            // 'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $ci = new SaleInvoices();

            $ci->custplan_id = $request->custplan_id;
            $ci->pono = $request->pono;
            $ci->podate = $request->podate;
            $ci->saldate = $request->deliverydt;
            $ci->dcno = $request->dcno;
            $ci->gpno = $request->gpno;
            $ci->billno = $request->billno;
            $ci->customer_id = $request->customer_id;
            $ci->discntper = $request->discntper;
            $ci->discntamt = $request->discntamt;
            $ci->cartage = $request->cartage;
            $ci->rcvblamount = $request->rcvblamount;
            $ci->saletaxper = $request->saletaxper;
            $ci->saletaxamt = $request->saletaxamt;
            $ci->totrcvbamount = $request->totrcvbamount;
            $ci->paymentbal = $request->totrcvbamount;
            $ci->saldescription = $request->saldescription;

            $ci->save();

            foreach ($request->sales as $cont) {
                // $material = Material::findOrFail($cont['id']);
                $lpd = new SaleInvoicesDetails();
                $lpd->sale_invoice_id = $ci->id;
                $lpd->material_id = $cont['material_id'];
                $lpd->sku_id = $cont['sku_id'];
                $lpd->repname = $cont['repname'];
                $lpd->brand = $cont['mybrand'];
                $lpd->qtykg = $cont['qtykg'];
                $lpd->qtypcs = $cont['qtypcs'];
                $lpd->qtyfeet = $cont['qtyfeet'];
                $lpd->unitconver = $cont['unitconver'];
                $lpd->price = $cont['price'];
                $lpd->saleamnt = $cont['saleamnt'];
                $lpd->feedqty = $cont['feedqty'];

                $lpd->qtykgcrt = $cont['salcostkg'];
                $lpd->qtypcscrt = $cont['salcostpcs'];
                $lpd->qtyfeetcrt = $cont['salcostfeet'];

                $lpd->sqtykg = $cont['sqtykg'];
                $lpd->sqtypcs = $cont['sqtypcs'];
                $lpd->sqtyfeet = $cont['sqtyfeet'];

                $lpd->wtper = $cont['wtper'];
                $lpd->pcper = $cont['pcper'];
                $lpd->feetper = $cont['feetper'];

                $lpd->salewt = $cont['qtykg'];
                $lpd->salepcs = $cont['qtypcs'];
                $lpd->salefeet = $cont['qtyfeet'];




                $lstrt = CreateSaleRate::where('customer_id',$request->customer_id)->where('material_id',$cont['material_id'])->first();
                if(!$lstrt) {
                    $abc = new CreateSaleRate();
                    $abc->customer_id=$request->customer_id;
                    $abc->material_id=$cont['material_id'];
                    $abc->salrate=$cont['price'];
                    $abc->sunitid=$cont['sku_id'];
                    $abc->sunitname=$cont['sku'];
                    $abc->tranid=$ci->id;
                    $abc->save();
                }
                else
                    {
                        $lstrt->material_id=$cont['material_id'];
                        $lstrt->salrate=$cont['price'];
                        $lstrt->sunitid=$cont['sku_id'];
                        $lstrt->sunitname=$cont['sku'];
                        $lstrt->tranid=$ci->id;
                        $lstrt->save();
                    }


                $lpd->save();


            }

            //// Details update

            /// **** update summary data to master table
            DB::update(DB::raw("
            UPDATE sale_invoices c
            INNER JOIN (
            SELECT sale_invoice_id,SUM(qtykg) AS twt,SUM(qtypcs) AS tpcs,SUM(qtyfeet) AS tfeet FROM sale_invoices_details WHERE sale_invoice_id=$ci->id GROUP BY sale_invoice_id
            ) x ON c.id = x.sale_invoice_id
            SET c.sltwt = x.twt,c.sltpcs=x.tpcs,c.slfeet=x.tfeet ,
            c.balsltwt=x.twt,c.balsltpcs=x.tpcs,c.balslfeet=x.tfeet  WHERE  c.id = $ci->id "));


            DB::update(DB::raw("
            UPDATE customer_order_details c
            INNER JOIN (
            SELECT b.custplan_id,a.material_id,SUM(feedqty) AS feedqty  FROM sale_invoices_details a
				INNER JOIN sale_invoices AS b ON b.id=a.sale_invoice_id WHERE b.custplan_id=$ci->custplan_id GROUP BY b.custplan_id,a.material_id
            ) x ON c.sale_invoice_id = x.custplan_id AND c.material_id=x.material_id
            SET c.balqty = c.qtykg - x.feedqty WHERE  c.sale_invoice_id = $ci->custplan_id"));


            ///**** Master Update
            DB::update(DB::raw("
            UPDATE customer_orders c
            INNER JOIN (
            SELECT custplan_id,SUM(totrcvbamount)-SUM(cartage) AS Dlvred FROM sale_invoices WHERE custplan_id=$ci->custplan_id
				GROUP BY custplan_id
            ) x ON c.id = x.custplan_id
            SET c.delivered = x.Dlvred,c.salordbal=( coalesce(totrcvbamount,0)-coalesce(cartage,0) )-x.Dlvred WHERE  c.id = $ci->custplan_id"));


            DB::update(DB::raw("
            UPDATE customer_orders c
            INNER JOIN (
                SELECT custplan_id,sum(feedqty) as feedqty
                FROM sale_invoices a INNER JOIN sale_invoices_details AS b ON a.id=b.sale_invoice_id WHERE custplan_id=$ci->custplan_id GROUP BY custplan_id
            ) x ON c.id = x.custplan_id    SET c.tslwt = x.feedqty WHERE  c.id = $ci->custplan_id"));






            DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
            SELECT a.id AS transid,a.saldate,'sales',4,b.material_id,b.sku_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
            ,( case c.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
            FROM sale_invoices a INNER JOIN  sale_invoices_details b inner join materials as c on b.material_id=c.id
            ON a.id=b.sale_invoice_id WHERE a.id=$ci->id"));






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

        // $planid = SaleInvoices::select('custplan_id')->where('id',$id)->first();
        // $planid = DB::table('sale_invoices')->where('id',$id)->select('custplan_id')->max('custplan_id');
         $cd = DB::select('call procdetailcustplanedit (?)',array( $id ));
        // $cd = DB::table('sale_invoices_details')
        // ->join('materials', 'materials.id', '=', 'sale_invoices_details.material_id')
        // ->join('skus', 'skus.id', '=', 'sale_invoices_details.sku_id')
        // ->join('sale_invoices', 'sale_invoices.id', '=', 'sale_invoices_details.sale_invoice_id')
        // ->join('customer_orders', 'customer_orders.id', '=', 'sale_invoices_details.sale_invoice_id')
        // ->join('customer_order_details', 'customer_orders.id', '=', 'customer_order_details.sale_invoice_id')
        // ->and('customer_order_details.material_id', '=', 'sale_invoices_details.material_id'     )


        // ->select('sale_invoices_details.*','customer_order_details.balqty','materials.title as material_title','materials.dimension','skus.title as sku'
        // , '0 as balqty'
        // 'tmptblcustplan1.totqty' ,'tmptblcustplan1.wtper','tmptblcustplan1.pcper','tmptblcustplan1.feetper'
        // ,'tmptblcustplan1.qtykg as sqtykg','tmptblcustplan1.qtypcs as sqtypcs','tmptblcustplan1.qtyfeet as sqtyfeet'

        // DB::raw('( CASE sale_invoices_details.sku_id  WHEN  1 THEN sale_invoices_details.qtykg WHEN 2 THEN sale_invoices_details.qtypcs WHEN 3 THEN sale_invoices_details.qtyfeet  END) AS feedqty')
        // ,DB::raw('( CASE sale_invoices_details.sku_id  WHEN  1 THEN sale_invoices_details.qtykg WHEN 2 THEN sale_invoices_details.qtypcs WHEN 3 THEN sale_invoices_details.qtyfeet  END) + tmptblcustplan1.balqty AS balqty')
        // ,DB::raw(' tmptblcustplan1.balqty + sale_invoices_details.feedqty   AS balqty')

        // )
        // ->where('sale_invoices_details.sale_invoice_id',$id)->get();
         $data=compact('cd');
         $locations = Location::select('id','title')->where('status',1)->get();

        return view('sales.edit')
        ->with('customer',Customer::select('id','title')->get())
        ->with('saleinvoices',SaleInvoices::findOrFail($id))
        ->with($data)
        ->with('skus',Sku::select('id','title')->get())
        ->with('locations',Location::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    public function update(Request $request, SaleInvoices $saleinvoices)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());
        DB::beginTransaction();
        try {

            //  dd($request->sale_invoice_id);
            $sale_invoices = SaleInvoices::findOrFail($request->sale_invoice_id);
            $sale_invoices->custplan_id = $request->custplan_id;
            $sale_invoices->pono = $request->pono;
            $sale_invoices->podate = $request->podate;
            $sale_invoices->saldate = $request->deliverydt;
            $sale_invoices->dcno = $request->dcno;
            $sale_invoices->gpno = $request->gpno;
            $sale_invoices->billno = $request->billno;
            $sale_invoices->customer_id = $request->customer_id;
            $sale_invoices->discntper = $request->discntper;
            $sale_invoices->discntamt = $request->discntamt;
            $sale_invoices->cartage = $request->cartage;
            $sale_invoices->rcvblamount = $request->rcvblamount;
            $sale_invoices->saletaxper = $request->saletaxper;
            $sale_invoices->saletaxamt = $request->saletaxamt;
            $sale_invoices->totrcvbamount = $request->totrcvbamount;
            $sale_invoices->paymentbal = $request->totrcvbamount;
            $sale_invoices->saldescription = $request->saldescription;
            $sale_invoices->save();

            // Get Data
            $cds = $request->saleinvoices; // This is array
            $cds = SaleInvoicesDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = SaleInvoicesDetails::where('sale_invoice_id',$sale_invoices->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                if($cd->id)
                {
                    $cds = SaleInvoicesDetails::where('id',$cd->id)->first();
                    $cds->sale_invoice_id = $sale_invoices->id;
                    $cds->material_id = $cd->material_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->repname = $cd['repname'];
                    $cds->brand = $cd['brand'];
                    $cds->qtykg = $cd['qtykg'];
                    $cds->qtypcs = $cd['qtypcs'];
                    $cds->qtyfeet = $cd['qtyfeet'];
                    $cds->unitconver = $cd['unitconver'];

                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];
                    $cds->feedqty = $cd['feedqty'];
                    $unit = Sku::where("title", $cd['sku'])->first();
                    $cds->sku_id = $unit->id;
                    $cds->salewt = $cd['qtykg'];
                    $cds->salepcs = $cd['qtypcs'];
                    $cds->salefeet = $cd['qtyfeet'];



                    $cds->qtykgcrt = $cd['qtykgcrt'];
                    $cds->qtypcscrt = $cd['qtypcscrt'];
                    $cds->qtyfeetcrt = $cd['qtyfeetcrt'];


                    $cds->wtper = $cd['wtper'];
                    $cds->pcper = $cd['pcper'];
                    $cds->feetper = $cd['feetper'];





                    // $lstrt = CreateSaleRate::where('customer_id',$request->customer_id)->where('material_id',$cd['material_id'])->first();
                    $lstrt = CreateSaleRate::where('tranid',$sale_invoices->id)->where('material_id',$cd['material_id'])->first();
                    if(!$lstrt) {
                        $abc = new CreateSaleRate();
                        $abc->customer_id=$request->customer_id;
                        $abc->material_id=$cd['material_id'];
                        $abc->salrate=$cd['price'];
                        $abc->sunitid=$cd['sku_id'];
                        $abc->sunitname=$cd['sku'];
                        $abc->tranid=$sale_invoices->id;
                        $abc->save();
                    }
                    else
                        {
                            $lstrt->material_id=$cd['material_id'];
                            $lstrt->salrate=$cd['price'];
                            $lstrt->sunitid=$cd['sku_id'];
                            $lstrt->sunitname=$cd['sku'];
                            $lstrt->tranid=$sale_invoices->id;
                            $lstrt->save();
                        }


                        // $lstrt->save();


                    $cds->save();


            }

        }

            /// **** update summary data to master table
            DB::update(DB::raw("
            UPDATE sale_invoices c
            INNER JOIN (
            SELECT sale_invoice_id,SUM(qtykg) AS twt,SUM(qtypcs) AS tpcs,SUM(qtyfeet) AS tfeet FROM sale_invoices_details WHERE sale_invoice_id=$sale_invoices->id GROUP BY sale_invoice_id
            ) x ON c.id = x.sale_invoice_id
            SET c.sltwt = x.twt,c.sltpcs=x.tpcs,c.slfeet=x.tfeet ,
            c.balsltwt=x.twt,c.balsltpcs=x.tpcs,c.balslfeet=x.tfeet  WHERE  c.id = $sale_invoices->id "));



        //// Details update
        DB::update(DB::raw("
        UPDATE customer_order_details c
        INNER JOIN (
        SELECT b.custplan_id,a.material_id,SUM(feedqty) AS feedqty  FROM sale_invoices_details a
            INNER JOIN sale_invoices AS b ON b.id=a.sale_invoice_id WHERE b.custplan_id=$sale_invoices->custplan_id GROUP BY b.custplan_id,a.material_id
        ) x ON c.sale_invoice_id = x.custplan_id AND c.material_id=x.material_id
        SET c.balqty = c.qtykg - x.feedqty WHERE  c.sale_invoice_id = $sale_invoices->custplan_id"));





        DB::update(DB::raw("
        UPDATE customer_orders c
        INNER JOIN (
        SELECT custplan_id,SUM(totrcvbamount)-SUM(cartage) AS Dlvred,sum(sltwt) as sltwt,sum(sltpcs) as sltpcs,sum(slfeet) as slfeet
        FROM sale_invoices WHERE custplan_id=$sale_invoices->custplan_id GROUP BY custplan_id
        ) x ON c.id = x.custplan_id
        SET c.delivered = x.Dlvred,c.salordbal=( coalesce(totrcvbamount,0)-coalesce(cartage,0) )-x.Dlvred
        WHERE  c.id = $sale_invoices->custplan_id"));


        DB::update(DB::raw("
        UPDATE customer_orders c
        INNER JOIN (
            SELECT custplan_id,sum(feedqty) as feedqty
            FROM sale_invoices a INNER JOIN sale_invoices_details AS b ON a.id=b.sale_invoice_id WHERE custplan_id=$sale_invoices->custplan_id GROUP BY custplan_id
        ) x ON c.id = x.custplan_id    SET c.tslwt = x.feedqty WHERE  c.id = $sale_invoices->custplan_id"));








        DB::delete(DB::raw(" delete from office_item_bal where ttypeid=4 and  transaction_id=$sale_invoices->id   "));

        // DB::insert(DB::raw("
        // INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
        // SELECT a.id AS transid,a.saldate,'sales',4,b.material_id,sku_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt FROM sale_invoices a INNER JOIN  sale_invoices_details b
        // ON a.id=b.sale_invoice_id WHERE a.id=$sale_invoices->id"));


        DB::insert(DB::raw("
        INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
        SELECT a.id AS transid,a.saldate,'sales',4,b.material_id,b.sku_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
        ,( case c.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
        FROM sale_invoices a INNER JOIN  sale_invoices_details b inner join materials as c on b.material_id=c.id
        ON a.id=b.sale_invoice_id WHERE a.id=$sale_invoices->id"));






            DB::commit();
            Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function destroy(Contract $contract)
    {
        //
    }

    public function printContract($id)
    {
        // dd($id);
        $contract = Contract::findOrFail($id);
        $cd = ContractDetails::where('contract_id',$contract->id)->get();
        $html = view('contracts.print')->with('cd',$cd)->with('contract',$contract)->render();
        $filename = $contract->id . '.pdf';
        ini_set('max_execution_time', '2000');
        ini_set("pcre.backtrack_limit", "100000000");
        ini_set("memory_limit","8000M");
        ini_set('allow_url_fopen',1);
        $temp = storage_path('temp');
        // Create the mPDF document
        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
            'default_font_size' => 9,
            'orientation' => 'L'
        ]);
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
        // 'D': download the PDF file
        // 'I': serves in-line to the browser
        // 'S': returns the PDF document as a string
        // 'F': save as file $file_out
    }
}
