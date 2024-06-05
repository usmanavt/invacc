<?php

namespace App\Http\Controllers;

use App\Models\Hscode;
use App\Models\Pcontract;
use App\Models\Subhead;
use App\Models\Location;
use App\Models\Reciving;
use App\Models\Clearance;
use Illuminate\Http\Request;
use App\Models\ContractDetails;
use App\Models\Contract;
use App\Models\CommercialInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\RecivingPendingDetails;
use App\Models\ClearancePendingDetails;
use Illuminate\Support\Facades\Session;
use App\Models\CommercialInvoiceDetails;
use App\Models\PcommercialInvoiceDetails;
use App\Models\RecivingCompletedDetails;
use App\Models\PcommercialInvoice;
use App\Models\Material;
use App\Models\Sku;
use App\Models\Purchasing;
use App\Models\PurchasingDetails;
use App\Models\Supplier;
use \Mpdf\Mpdf as PDF;


class PurchasingController extends Controller
{

    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        return view('purchasing.index');
    }

    public function getMaster(Request $request)
    {
        // $status =$request->status ;
        // $search = $request->search;
        // $size = $request->size;
        // $field = $request->sort[0]["field"];     //  Nested Array
        // $dir = $request->sort[0]["dir"];         //  Nested Array
        // $cis = Purchasing::where('status',$status)
        // ->where(function ($query) use ($search){
        //         $query->where('purinvsno','LIKE','%' . $search . '%');
        //         // ->orWhere('invoiceno','LIKE','%' . $search . '%');
        //     })
        //     ->whereHas('supplier', function ($query) {
        //         $query->where('source_id','=','2');
        //     })
        // ->with('supplier:id,title')
        // ->orderBy($field,$dir)
        // ->paginate((int) $size);
        // return $cis;

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = DB::table('vwgdrcvdimpindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('supname', 'like', "%$search%")
        ->orWhere('purinvsno', 'like', "%$search%")
        // ->orWhere('machineno', 'like', "%$search%")

        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;




    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = PurchasingDetails::where('purid',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getContractDetails(Request $request)
    {
        $id = $request->id;
        // $contractDetails = ContractDetails::with('material.hscodes')->where('contract_id',$id)->get();

        // $contractDetails = DB::table('vwfrmpendcontractsdtl')->where('contract_id',$id)->get();
        $contractDetails = DB::select('call procfrmpendcontractsdtl(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }

    public function getMasterdc(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwfrmpenddutyclear')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('supname', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;


    }


    public function create()
    {

        // $locations = Location::select('id','title')->where('status',1)->get();

        $maxpurseqid = DB::table('purchasings')->select('*')->max('purseqid')+1;
        return \view ('purchasing.create',compact('maxpurseqid'));
        // ->with('suppliers',Supplier::select('id','title')->get());




        // $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
        //  ->whereIn('id',[1,2])->get();
        // $data=compact('cd');
        // return view('purchasing.create')
        // ->with('hscodes',Hscode::all())
        // ->with('locations',Location::select('id','title')->get())
        // ->with($data);

    }

    public function store(Request $request)
    {
        //    dd($request->all());
        // $comminvoice = $request->comminvoice;
         $purchasing = $request->purchasing;

        DB::beginTransaction();
        try {
            //  Commercial Invoice Master
            $ci = new Purchasing();
            $ci->contract_id = $request->contract_id;
            $ci->contract_date = $request->contract_date;
            $ci->supplier_id = $request->supplier_id;
            $ci->purseqid = $request->purseqid;
            $ci->purdate = $request->purdate;
            $ci->purinvsno = $request->purinvsno;
            $ci->save();


            //  Commercial Invoice Details
            foreach ($purchasing as $cid) {
                $c = new PurchasingDetails();
                $c->purid = $ci->id;
                $c->contract_id = $request->contract_id;
                $c->material_id = $cid['material_id'];
                $c->sku_id = $cid['sku_id'];
                $c->purwte13 = $cid['purwte13'];
                $c->purpcse13 = $cid['purpcse13'];
                $c->purfeete13 = $cid['purfeete13'];

                $c->purwtgn2 = $cid['purwtgn2'];
                $c->purpcsgn2 = $cid['purpcsgn2'];
                $c->purfeetgn2 = $cid['purfeetgn2'];

                $c->purwtams = $cid['purwtams'];
                $c->purpcsams = $cid['purpcsams'];
                $c->purfeetams = $cid['purfeetams'];

                $c->purwte24 = $cid['purwte24'];
                $c->purpcse24 = $cid['purpcse24'];
                $c->purfeete24 = $cid['purfeete24'];

                $c->purwtbs = $cid['purwtbs'];
                $c->purpcsbs = $cid['purpcsbs'];
                $c->purfeetbs = $cid['purfeetbs'];

                $c->purwtoth = $cid['purwtoth'];
                $c->purpcsoth = $cid['purpcsoth'];
                $c->purfeetoth = $cid['purfeetoth'];

                $c->purwttot = $cid['purwttot'];
                $c->purpcstot = $cid['purpcstot'];
                $c->purfeettot = $cid['purfeettot'];

                $c->length = $cid['length'];
                $c->brand = $cid['brand'];
                $c->repname = $cid['repname'];

                $c->dtyrate = $cid['dtyrate'];
                $c->gdsprice = $cid['gdsprice'];
                $c->invsrate = $cid['invsrate'];
                $c->bundle1 = $cid['bundle1'];
                $c->bundle2 = $cid['bundle2'];


                $c->save();

            }


            DB::update(DB::raw("
            update purchasings c
            INNER JOIN (
				SELECT purid, SUM(purpcstot) as pcs,SUM(purwttot) AS wt,sum(purfeettot) as ft
            FROM purchasing_details where  purid = $ci->id
            GROUP BY purid
            ) x ON c.id = x.purid
            SET c.purtotpcs = x.pcs,c.purtotwt=x.wt,c.purtotfeet=x.ft where  purid = $ci->id
            "));

            // //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
                    UPDATE contracts c
                    INNER JOIN (
                    SELECT contract_id, SUM(purtotpcs) as pcs,SUM(purtotwt) AS wt
                    FROM purchasings as a inner join suppliers as b on a.supplier_id=b.id and b.source_id=2
                    where  contract_id=$ci->contract_id  GROUP BY contract_id
                    ) x ON c.id = x.contract_id
                    SET c.balpcs = c.totalpcs - x.pcs,c.balwt= c.conversion_rate-x.wt
                    where  contract_id = $ci->contract_id  "));

            // //****################# Transfert item wise Contract Balance from detail to detail
            DB::update(DB::raw("
            UPDATE contract_details c
            INNER JOIN (
            SELECT a.contract_id,material_id,SUM(purpcstot) as pcs,SUM(purwttot) AS wt
            FROM purchasing_details AS a INNER JOIN purchasings AS b ON a.purid=b.id
			INNER JOIN suppliers AS c ON b.supplier_id=c.id AND c.source_id=2
			WHERE  a.contract_id = $ci->contract_id   GROUP BY a.contract_id,material_id
            ) x ON c.contract_id = x.contract_id and c.material_id=x.material_id
            SET c.tbalpcs = c.totpcs - x.pcs,c.tbalwt= c.gdswt-x.wt WHERE  c.contract_id = $ci->contract_id
            "));

             DB::insert(DB::raw("
             INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
             stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
             stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot )
             SELECT a.id,a.purdate,2,'purchasing',material_id,purwte13,purpcse13,purfeete13,purwtgn2,purpcsgn2,purfeetgn2,purwtams,purpcsams,purfeetams,purwte24,purpcse24,purfeete24,
             purwtbs,purpcsbs,purfeetbs,purwtoth,purpcsoth,purfeetoth,purwttot,purpcstot,purfeettot FROM purchasings a inner join purchasing_details b ON a.id=b.purid AND a.id=$ci->id
            "));






            DB::commit();
            Session::flash('success',"Commerical Invoice#[$ci->id] Created with Reciving# & Duty Clearance#[$ci->id]");
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function show($id)
    {
        return view('commercialinvoices.show')->with('i',CommercialInvoice::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first());
    }

    public function edit($id)
    {

    $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
    $cd = DB::select('call procpuredit(?)',array( $id ));
    $data=compact('cd');
        return view('purchasing.edit',compact('passwrd'))
        ->with('purchasing',Purchasing::findOrFail($id))
        ->with('supplier',Supplier::select('id','title')->get())
        ->with($data);

    }


    public function deleterec($id)
    {

    $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');

    $srchcid= Purchasing::where('id',$id)->max('contract_id');
    $prgp = CommercialInvoice::where('contract_id',$srchcid)->max('contract_id');

    $cd = DB::select('call procpuredit(?)',array( $id ));
    $data=compact('cd');
        return view('purchasing.deleterec',compact('passwrd','prgp'))
        ->with('purchasing',Purchasing::findOrFail($id))
        ->with('supplier',Supplier::select('id','title')->get())
        ->with($data);

    }



    public function update(Request $request, Purchasing $purchasing)
    {

        $ci = Purchasing::findOrFail($request->purid);

        $purchasing = $request->purchasing;
        DB::beginTransaction();
        try {

            //  dd($request->all($request->purid));
            // $ci = Purchasing::findOrFail($request->purid);
            $ci->contract_id = $request->contract_id;
            $ci->contract_date = $request->contract_date;
            $ci->supplier_id = $request->supplier_id;
            $ci->purseqid = $request->purseqid;
            $ci->purdate = $request->purdate;
            $ci->purinvsno = $request->purinvsno;
            $ci->save();


            // foreach ($comminvoice as $cid) {
            //     $c = CommercialInvoiceDetails::findOrFail($cid['id']);

            foreach ($purchasing as $cid) {
                $c = PurchasingDetails::findOrFail($cid['id']);

                $c->purid = $ci->id;
                $c->contract_id = $request->contract_id;
                $c->material_id = $cid['material_id'];
                $c->sku_id = $cid['sku_id'];
                $c->purwte13 = $cid['purwte13'];
                $c->purpcse13 = $cid['purpcse13'];
                $c->purfeete13 = $cid['purfeete13'];

                $c->purwtgn2 = $cid['purwtgn2'];
                $c->purpcsgn2 = $cid['purpcsgn2'];
                $c->purfeetgn2 = $cid['purfeetgn2'];

                $c->purwtams = $cid['purwtams'];
                $c->purpcsams = $cid['purpcsams'];
                $c->purfeetams = $cid['purfeetams'];

                $c->purwte24 = $cid['purwte24'];
                $c->purpcse24 = $cid['purpcse24'];
                $c->purfeete24 = $cid['purfeete24'];

                $c->purwtbs = $cid['purwtbs'];
                $c->purpcsbs = $cid['purpcsbs'];
                $c->purfeetbs = $cid['purfeetbs'];

                $c->purwtoth = $cid['purwtoth'];
                $c->purpcsoth = $cid['purpcsoth'];
                $c->purfeetoth = $cid['purfeetoth'];

                $c->purwttot = $cid['purwttot'];
                $c->purpcstot = $cid['purpcstot'];
                $c->purfeettot = $cid['purfeettot'];

                $c->length = $cid['length'];
                $c->brand = $cid['brand'];
                $c->repname = $cid['repname'];

                $c->save();

            }

            DB::update(DB::raw("
            update purchasings c
            INNER JOIN (
				SELECT purid, SUM(purpcstot) as pcs,SUM(purwttot) AS wt,sum(purfeettot) as ft
            FROM purchasing_details where  purid = $ci->id
            GROUP BY purid
            ) x ON c.id = x.purid
            SET c.purtotpcs = x.pcs,c.purtotwt=x.wt,c.purtotfeet=x.ft where  purid = $ci->id
            "));

            //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
                    UPDATE contracts c
                    INNER JOIN (
                    SELECT contract_id, SUM(purtotpcs) as pcs,SUM(purtotwt) AS wt
                    FROM purchasings as a inner join suppliers as b on a.supplier_id=b.id and b.source_id=2
                    where  contract_id=$ci->contract_id  GROUP BY contract_id
                    ) x ON c.id = x.contract_id
                    SET c.balpcs = c.totalpcs - x.pcs,c.balwt= c.conversion_rate-x.wt
                    where  contract_id = $ci->contract_id  "));

            // //****################# Transfert item wise Contract Balance from detail to detail
            DB::update(DB::raw("
            UPDATE contract_details c
            INNER JOIN (
            SELECT a.contract_id,material_id,SUM(purpcstot) as pcs,SUM(purwttot) AS wt
            FROM purchasing_details AS a INNER JOIN purchasings AS b ON a.purid=b.id
			INNER JOIN suppliers AS c ON b.supplier_id=c.id AND c.source_id=2
			WHERE  a.contract_id = $ci->contract_id   GROUP BY a.contract_id,material_id
            ) x ON c.contract_id = x.contract_id and c.material_id=x.material_id
            SET c.tbalpcs = c.totpcs - x.pcs,c.tbalwt= c.gdswt-x.wt WHERE  c.contract_id = $ci->contract_id
            "));


            DB::delete(DB::raw(" delete from godown_stock where ttypeid=2 and  transaction_id=$ci->id  "));



            DB::insert(DB::raw("
            INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
            stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
            stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot )
            SELECT a.id,a.purdate,2,'purchasing',material_id,purwte13,purpcse13,purfeete13,purwtgn2,purpcsgn2,purfeetgn2,purwtams,purpcsams,purfeetams,purwte24,purpcse24,purfeete24,
            purwtbs,purpcsbs,purfeetbs,purwtoth,purpcsoth,purfeetoth,purwttot,purpcstot,purfeettot FROM purchasings a inner join purchasing_details b ON a.id=b.purid AND a.id=$ci->id
           "));






            DB::commit();
            Session::flash('info',"Commerical Invoice#[$ci->id] Updated with Reciving# & Duty Clearance#[$ci->id]");
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function deleteBankRequest(Request $request)
    {


//  dd($request->invsid);
        DB::beginTransaction();
            try {



                DB::update(DB::raw(" update purchasing_details SET purpcstot=0,purwttot=0,purfeettot=0 where contract_id=$request->purid "));
                DB::update(DB::raw(" update purchasings SET purtotpcs=0,purtotwt=0 where id=$request->purid "));


                DB::update(DB::raw("
                UPDATE contracts c
                INNER JOIN (
                SELECT contract_id, SUM(purtotpcs) as pcs,SUM(purtotwt) AS wt
                FROM purchasings as a inner join suppliers as b on a.supplier_id=b.id and b.source_id=2
                where  contract_id=$request->contract_id  GROUP BY contract_id
                ) x ON c.id = x.contract_id
                SET c.balpcs = c.totalpcs - x.pcs,c.balwt= c.conversion_rate-x.wt
                where  contract_id = $request->contract_id  "));

                //****################# Transfert item wise Contract Balance from detail to detail
                DB::update(DB::raw("
                UPDATE contract_details c
                INNER JOIN (
                SELECT a.contract_id,material_id,SUM(purpcstot) as pcs,SUM(purwttot) AS wt
                FROM purchasing_details AS a INNER JOIN purchasings AS b ON a.purid=b.id
                INNER JOIN suppliers AS c ON b.supplier_id=c.id AND c.source_id=2
                WHERE  a.contract_id = $request->contract_id   GROUP BY a.contract_id,material_id
                ) x ON c.contract_id = x.contract_id and c.material_id=x.material_id
                SET c.tbalpcs = c.totpcs - x.pcs,c.tbalwt= c.gdswt-x.wt WHERE  c.contract_id = $request->contract_id
                "));


                DB::delete(DB::raw(" delete from purchasings where id=$request->purid"  ));
                DB::delete(DB::raw(" delete from purchasing_details where purid=$request->purid   "));

                DB::delete(DB::raw(" delete from godown_stock where ttypeid=2 and  transaction_id=$request->purid   "));

                DB::update(DB::raw(" update contracts set closed=0 where id=$request->contract_id "));






                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
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



    public function printContract($id)
    {

      //  dd($request->all());
    //   $hdng1 = $request->cname;
    //   $hdng2 = $request->csdrs;

    //   $head_id = $request->head_id;
    //   $head = Supplier::findOrFail($head_id);
    //   if($request->has('subhead_id')){
    //       $subhead_id = $request->subhead_id;
          //  Clear Data from Table
          DB::table('contparameterrpt')->truncate();
        //   foreach($request->subhead_id as $id)
        //   {
              DB::table('contparameterrpt')->insert([ 'GLCODE' => $id ]);
    //       }
    //   }
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
           $html =  view('purchasing.print')->with('data',$g)->render();
            //   ->with('hdng1',$hdng1)->with('hdng2',$hdng2)
            //   ->with('data',$g)
            //   ->with('fromdate',$fromdate)
            //   ->with('todate',$todate)
            //   ->with('headtype',$head->title)->render();
          $filename = $g[0]->id  .'.pdf';
          $chunks = explode("chunk", $html);
          $mpdf->AddPage();
          foreach($chunks as $key => $val) {
              $mpdf->WriteHTML($val);
          }

      }
      return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
  }



}
