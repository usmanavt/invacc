<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;

use App\Models\SaleInvoices;
use App\Models\SaleReturnDetails;

use App\Models\SaleReturn;
use App\Models\SaleInvoicesDetails;

use App\Models\BankTransaction;




use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class SalesRetunrsController  extends Controller
{
    public function index(Request $request)
    {
         return view('salereturn.index');


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
        $cis = SaleReturn::where('status',$status)
        ->where(function ($query) use ($search){
                $query->where('dcno','LIKE','%' . $search . '%')
                // ->orWhere('gpno','LIKE','%' . $search . '%')
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
        $contractDetails = SaleReturnDetails::where('sale_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getMastersaler(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwmastersaleret')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('custname', 'like', "%$search%")
        ->orWhere('dcno', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;
    }

    public function getDetailssaler(Request $request)
    {
        $id = $request->id;
        // dd($id);
        //  $contractDetails = DB::table('vwdetailcustplan')->where('sale_invoice_id',$id)->get();
        $contractDetails = DB::select('call procdetailsales(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }





    public function create()
    {
         $locations = Location::select('id','title')->where('status',1)->get();

        // return view('salereturn.create')
        // $mycname='MUHAMMAD HABIB & Co.';
        $maxdcno = DB::table('sale_invoices')->select('dcno')->max('dcno')+1;
        $maxgpno = DB::table('sale_invoices')->select('gpno')->max('gpno')+1;
        $maxbillno = DB::table('sale_invoices')->select('billno')->max('billno')+1;
        $maxretno = DB::table('sale_returns')->select('returnno')->max('returnno')+1;

        return \view ('salereturn.create',compact('maxdcno','maxgpno','maxbillno','maxretno'))
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

            // 'dcno' => 'required|unique:sale_invoices',
            // 'gpno' => 'required|unique:sale_invoices',
            // 'poseqno' => 'required|min:1|unique:customer_orders',
            // 'pono' => 'required|min:1|unique:customer_orders'
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            // 'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $ci = new SaleReturn();

            $ci->invoice_id = $request->invoice_id;
            $ci->dcdate = $request->dcdate;
            $ci->rdate = $request->rdate;
            $ci->dcno = $request->dcno;
            $ci->gpno = $request->gpno;
            $ci->billno = $request->billno;
            $ci->customer_id = $request->customer_id;
            $ci->rcvblamount = $request->rcvblamount;
            $ci->saletaxper = $request->saletaxper;
            $ci->saletaxamt = $request->saletaxamt;
            $ci->totrcvbamount = $request->totrcvbamount;
            $ci->sretdescription = $request->sretdescription;

            $ci->save();


            if($request->customer_id==0)
            {
                $pv = new BankTransaction();
                $pv->cashretinvid = $ci->id;
                $pv->bank_id = 1;
                $pv->head_id = 33;
                $pv->subhead_id = 0;
                $pv->transaction_type = 'CPV';
                $pv->documentdate = $request->rdate;
                $pv->conversion_rate = 1;
                $pv->amount_fc = $request->totrcvbamount;
                $pv->amount_pkr = $request->totrcvbamount;
                $pv->cheque_date = $request->rdate;;
                $pv->cheque_no = '';
                $pv->description = 'Cash Sale Return';
                $pv->transno = 0;
                $pv->advance = 0;
                $pv->supname = 'CUST CASH CUSTOMER';
                $pv->save();
            }


            foreach ($request->sales as $cont) {
                // $material = Material::findOrFail($cont['id']);
                $lpd = new SaleReturnDetails();
                $lpd->sale_return_id = $ci->id;
                $lpd->material_id = $cont['material_id'];
                $lpd->sku_id = $cont['sku_id'];
                $lpd->repname = $cont['repname'];
                $lpd->brand = $cont['mybrand'];
                $lpd->qtykg = $cont['qtykg'];
                $lpd->qtypcs = $cont['qtypcs'];
                $lpd->qtyfeet = $cont['qtyfeet'];
                $lpd->price = $cont['price'];
                $lpd->saleamnt = $cont['saleamnt'];

                $lpd->prtbalwt = $cont['qtykg'];
                $lpd->prtbalpcs = $cont['qtypcs'];
                $lpd->prtbalfeet = $cont['qtyfeet'];
                $lpd->qtykgcrt = 0;
                $lpd->qtypcscrt = 0;
                $lpd->qtyfeetcrt = 0;
                $lpd->unitconversr = $cont['unitconversr'];
                $lpd->srfeedqty = $cont['feedqty'];




                // $location = Location::where("title", $cont['location'])->first();
                // $lpd->locid = $location->id;
                 $lpd->save();

            //  $dlvrdval = SaleInvoices::where('custplan_id',$ci->custplan_id)->sum('totrcvbamount');
            //  $custordr = CustomerOrder::where('id',$ci->custplan_id)->first();

            //  $custordr->delivered = $dlvrdval;
            //  $custordr->save();

            //   $sordrbal = SaleInvoices::where('id',$ci->id)->first();


            //   $sordrbal->ordrbal= $custordr->totrcvbamount - $dlvrdval;
            //   $sordrbal->save();


            //  $dlvrd = DB::table('sale_invoices_details')
            // ->join('sale_invoices', 'sale_invoices_details.sale_invoice_id', '=', 'sale_invoices.id')
            // ->where('sale_invoices.custplan_id', '=', $ci->custplan_id)->where('sale_invoices_details.material_id', '=', $lpd->material_id)
            // ->sum(DB::raw('( CASE sale_invoices_details.sku_id  WHEN  1 THEN sale_invoices_details.qtykg WHEN 2 THEN sale_invoices_details.qtypcs WHEN 3 THEN sale_invoices_details.qtyfeet  END)'));
            // $custplnbal = CustomerOrderDetails::where('sale_invoice_id',$ci->custplan_id)->where('material_id',$cont['material_id'])
            // ->first();
            // $custplnbal->balqty = $custplnbal->qtykg - $dlvrd;
            // $custplnbal->save();

            }





            DB::update(DB::raw("
            UPDATE sale_returns c
            INNER JOIN (
            SELECT sale_return_id,SUM(qtykg) AS wt,SUM(qtypcs) AS pcs,SUM(qtyfeet) AS feet FROM sale_return_details
				WHERE sale_return_id = $ci->id GROUP BY sale_return_id
            ) x ON c.id = x.sale_return_id
            SET c.tsrwt = x.wt,c.tsrpcs=x.pcs,c.tsrfeet=x.feet,
            c.psrwt = x.wt,c.psrpcs=x.pcs,c.psrfeet=x.feet  WHERE  c.id =$ci->id "));


            DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
            SELECT a.id AS transid,a.rdate,'SaleRet',6,b.material_id,b.sku_id,qtykg,qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
            ,( case c.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
            FROM sale_returns  a INNER JOIN  sale_return_details b
            ON a.id=b.sale_return_id inner join materials as c on b.material_id=c.id WHERE a.id=$ci->id"));





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
        // $planid = DB::table('sale_returns')->where('id',$id)->select('invoice_id')->max('invoice_id');
        $cd = DB::select('call procsalereturnedit(?)',array( $id ));

        // $cd = DB::table('sale_return_details')
        // ->join('materials', 'materials.id', '=', 'sale_return_details.material_id')
        // ->join('skus', 'skus.id', '=', 'sale_return_details.sku_id')
        // ->join('locations', 'locations.id', '=', 'sale_return_details.locid')
        // ->leftJoin('tmptblcustplan1', 'tmptblcustplan1.material_id', '=', 'sale_return_details.material_id')
        // ->select('sale_return_details.*','materials.title as material_title','materials.dimension','skus.title as sku',
        // 'locations.title as location','tmptblcustplan1.qtykg as sqtykg','tmptblcustplan1.qtypcs as sqtypcs','tmptblcustplan1.qtyfeet as sqtyfeet'
        // ,'tmptblcustplan1.balqty as balqty','tmptblcustplan1.totqty'
        // ,'tmptblcustplan1.wtper','tmptblcustplan1.pcper','tmptblcustplan1.feetper',
        // DB::raw('( CASE sale_return_details.sku_id  WHEN  1 THEN sale_return_details.qtykg WHEN 2 THEN sale_return_details.qtypcs WHEN 3 THEN sale_return_details.qtyfeet  END) AS feedqty')
        // )
        // ->where('sale_return_details.sale_return_id',$id)->get();
         $data=compact('cd');
        //  $locations = Location::select('id','title')->where('status',1)->get();

        return view('salereturn.edit')
        ->with('customer',Customer::select('id','title')->get())
        ->with('salereturn',SaleReturn::findOrFail($id))
        ->with($data)
        ->with('skus',Sku::select('id','title')->get());
        // ->with('locations',Location::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    public function update(Request $request, SaleReturn $salereturn)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());
        DB::beginTransaction();
        try {


            if($request->customer_id==0)
            {
                // $pv = new BankTransaction();
                // $pv = BankTransaction::findOrFail($request->sale_invoice_id);
                // dd($request->per());
                // and $request->customer_id==0
                // if($request->pcustno==0  )

                // {
                    $pv = BankTransaction::where('cashretinvid',$request->sale_return_id)->first();
                    $pv->bank_id = 1;
                    $pv->head_id = 33;
                    $pv->subhead_id = 0;
                    $pv->transaction_type = 'CPV';
                    $pv->documentdate = $request->rdate;
                    $pv->conversion_rate = 1;
                    $pv->amount_fc = $request->totrcvbamount;
                    $pv->amount_pkr = $request->totrcvbamount;
                    $pv->cheque_date = $request->rdate;
                    $pv->cheque_no = '';
                    $pv->description = 'Cash Sale Return';
                    $pv->transno = 0;
                    $pv->advance = 0;
                    $pv->supname = 'CUST CASH CUSTOMER';
                    $pv->save();

                // }
            // else
            // {
            //     DB::delete(DB::raw(" delete from bank_transactions where  cashinvid=$request->sale_return_id   "));

            // }

            }




            //  dd($request->sale_invoice_id);
            $salereturn = SaleReturn::findOrFail($request->sale_return_id);
            // $salereturn->invoice_id = $request->invoice_id;
            $salereturn->dcdate = $request->dcdate;
            $salereturn->rdate = $request->rdate;
            $salereturn->dcno = $request->dcno;
            $salereturn->gpno = $request->gpno;
            $salereturn->billno = $request->billno;
            $salereturn->customer_id = $request->customer_id;
            $salereturn->rcvblamount = $request->rcvblamount;
            $salereturn->saletaxper = $request->saletaxper;
            $salereturn->saletaxamt = $request->saletaxamt;
            $salereturn->totrcvbamount = $request->totrcvbamount;
            $salereturn->sretdescription = $request->sretdescription;

            $salereturn->save();

            // Get Data
            $cds = $request->salereturn; // This is array
            $cds = SaleReturnDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = SaleReturnDetails::where('sale_return_id',$salereturn->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                // dd($cd->id);
                if($cd->id)
                {
                    $cds = SaleReturnDetails::where('id',$cd->id)->first();
                    $cds->sale_return_id = $salereturn->id;
                    $cds->material_id = $cd['material_id'];
                    $cds->sku_id = $cd['sku_id'];
                    $cds->repname = $cd['repname'];
                    $cds->brand = $cd['mybrand'];
                    $cds->qtykg = $cd['qtykg'];
                    $cds->qtypcs = $cd['qtypcs'];
                    $cds->qtyfeet = $cd['qtyfeet'];
                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];

                    $cds->qtykgcrt = $cd['qtykgcrt'];
                    $cds->qtypcscrt = $cd['qtypcscrt'];
                    $cds->qtyfeetcrt = $cd['qtyfeetcrt'];

                    $cds->prtbalwt = $cd['qtykg'];
                    $cds->prtbalpcs = $cd['qtypcs'];
                    $cds->prtbalfeet = $cd['qtyfeet'];

                    $cds->unitconversr = $cd['unitconversr'];
                    $cds->srfeedqty = $cd['feedqty'];
                    $cds->save();


                    // $cds->sale_invoice_id = $sale_invoices->id;
                    // $cds->material_id = $cd->material_id;
                    // $cds->sku_id = $cd->sku_id;
                    // $cds->repname = $cd['repname'];
                    // $cds->brand = $cd['brand'];
                    // $cds->qtykg = $cd['qtykg'];
                    // $cds->qtypcs = $cd['qtypcs'];
                    // $cds->qtyfeet = $cd['qtyfeet'];
                    // $cds->price = $cd['price'];
                    // $cds->saleamnt = $cd['saleamnt'];
                    // $unit = Sku::where("title", $cd['sku'])->first();
                    // $cds->sku_id = $unit->id;

                    // $location = Location::where("title", $cd['location'])->first();
                    // $cds->locid = $location->id;
                    // dd($cds->locid);
                    // Last Sale Rate Update in Material Table
                    // $matsrate = Material::findOrFail($cds->material_id);
                    // if($cds->sku_id == 1)
                    // { $matsrate->salertkg = $cds->price;}
                    // elseif($cds->sku_id == 2)
                    // { $matsrate->salertpcs = $cds->price;}
                    // elseif($cds->sku_id == 3)
                    // { $matsrate->salertfeet = $cds->price;}
                    // $matsrate->save();

                    // $custplnbal = customer_order_details::findOrFail($cds->material_id);





                    // $dlvrd = DB::table('sale_invoices_details')
                    // ->join('sale_invoices', 'sale_invoices_details.sale_invoice_id', '=', 'sale_invoices.id')
                    // ->where('sale_invoices.custplan_id', '=', $sale_invoices->custplan_id)->where('sale_invoices_details.material_id', '=', $cd->material_id)
                    // ->sum(DB::raw('( CASE sale_invoices_details.sku_id  WHEN  1 THEN sale_invoices_details.qtykg WHEN 2 THEN sale_invoices_details.qtypcs WHEN 3 THEN sale_invoices_details.qtyfeet  END)'));
                    // // dd($dlvrd);
                    // $custplnbal = CustomerOrderDetails::where('sale_invoice_id',$sale_invoices->custplan_id)->where('material_id',$cd->material_id)
                    // ->first();
                    // $custplnbal->balqty = $custplnbal->qtykg - $dlvrd;
                    // $custplnbal->save();




                 }


                //  $cds->save();
                // }
                else
                 {
                //     //  The item is new, Add it
                //      $cds = new SaleInvoicesDetails();
                //      $cds->sale_invoice_id = $sale_invoices->id;
                //      $cds->material_id = $cd->material_id;
                //      $cds->sku_id = $cd->sku_id;
                //      $cds->repname = $cd['repname'];
                //      $cds->brand = $cd['brand'];
                //      $cds->qtykg = $cd['qtykg'];
                //      $cds->qtypcs = $cd['qtypcs'];
                //      $cds->qtyfeet = $cd['qtyfeet'];
                //      $cds->price = $cd['price'];
                //      $cds->saleamnt = $cd['saleamnt'];
                //      $unit = Sku::where("title", $cd['sku'])->first();
                //       $cds->sku_id = $unit->id;


                //     $cds->save();
                // }
            }
            // $dlvrd = SaleInvoices::where('custplan_id',$sale_invoices->custplan_id)->sum('totrcvbamount');
            // $custordr = CustomerOrder::where('id',$sale_invoices->custplan_id)->first();

            // $custordr->delivered = $dlvrd;
            // $custordr->save();

            // $sordrbal = SaleInvoices::where('id',$sale_invoices->id)->first();
            // $sordrbal->ordrbal= $custordr->totrcvbamount - $dlvrd;
            // $sordrbal->save();


        }
            DB::update(DB::raw("
            UPDATE sale_returns c
            INNER JOIN (
            SELECT sale_return_id,SUM(qtykg) AS wt,SUM(qtypcs) AS pcs,SUM(qtyfeet) AS feet FROM sale_return_details
				WHERE sale_return_id = $salereturn->id GROUP BY sale_return_id
            ) x ON c.id = x.sale_return_id
            SET c.tsrwt = x.wt,c.tsrpcs=x.pcs,c.tsrfeet=x.feet,
            c.psrwt = x.wt,c.psrpcs=x.pcs,c.psrfeet=x.feet  WHERE  c.id =$salereturn->id "));


            DB::delete(DB::raw(" delete from office_item_bal where ttypeid=6 and  transaction_id=$salereturn->id   "));

            // DB::insert(DB::raw("
            // INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
            // SELECT a.id AS transid,a.rdate,'SaleRet',6,b.material_id,sku_id,qtykg,qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt FROM sale_returns  a INNER JOIN  sale_return_details b
            // ON a.id=b.sale_return_id WHERE a.id=$salereturn->id"));

            DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
            SELECT a.id AS transid,a.rdate,'SaleRet',6,b.material_id,b.sku_id,qtykg,qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
            ,( case c.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
            FROM sale_returns  a INNER JOIN  sale_return_details b
            ON a.id=b.sale_return_id inner join materials as c on b.material_id=c.id WHERE a.id=$salereturn->id"));


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
