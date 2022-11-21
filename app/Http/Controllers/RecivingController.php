<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Reciving;
use Illuminate\Http\Request;
use App\Models\RecivingDetails;
use App\Models\CommercialInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\CommercialInvoiceDetails;

class RecivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $recivings = Reciving::where(function($q) use ($search){
            $q->where('machineno','LIKE',"%$search%")
            ->orWhere('invoiceno','LIKE',"%$search%")
            ->orWhereHas('supplier', function($qu) use ($search){
                $qu->where('title','LIKE',"$search");
            });
        })
        ->with('supplier')
        ->orderBy('id','desc')
        ->paginate(5);
        // return $recivings;
        return view('recivings.index')->with('recivings',$recivings);
    }

    public function getCISMaster(Request $request)
    {
        // dd($request->all());
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $cis = CommercialInvoice::where('status',1)->where('goods_received',0)
            // ->where(function ($query) use ($search){
            // $query->where('invoiceno','LIKE','%' . $search . '%')
            //     ->orWhere('challanno','LIKE','%' . $search . '%')
            //     ->orWhere('machineno','LIKE','%' . $search . '%');
            // })
            // ->orWhereHas('supplier', function($query) use($search){
            //     $query->where('title','LIKE',"%$search%");
            // })
        ->with('supplier:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;
    }
    public function getCISDetails(Request $request)
    {
        $contractDetails = CommercialInvoiceDetails::with('supplier')->where('commercial_invoice_id',$request->id)->where('status',1)->get();
        $locations = Location::select('id','title')->where('status',1)->get();
        return compact('contractDetails','locations');
    }

    public function create()
    {
        return view('recivings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $recivings = $request->recivings;

            $reciving = new Reciving();
            $reciving->reciving_date = $request->reciving_date;
            $reciving->invoiceno = $request->invoiceno;
            $reciving->machine_date = $request->machine_date;
            $reciving->machineno = $request->machineno;
            $reciving->supplier_id = $request->supplier_id;
            $reciving->commercial_invoice_id = $request->commercial_invoice_id;
            $reciving->status = 1;
            $reciving->save();

            foreach ($recivings as $receive) {
                // dd($receive['location']);
                $loc = Location::findOrFail($receive['location']);
                $rd = new RecivingDetails();
                $rd->reciving_id = $reciving->id;
                $rd->location_id = $loc->id;
                $rd->location = $loc->title;
                $rd->machine_date = $reciving->machine_date;
                $rd->machineno = $reciving->machineno;
                $rd->supplier_id = $reciving->supplier_id;
                $rd->commercial_invoice_id = $reciving->commercial_invoice_id;
                $rd->invoiceno = $reciving->invoiceno;
                $rd->reciving_date = $reciving->reciving_date;
                $rd->status = 1;
                $rd->qtyinpcs = $receive['pcs'];
                $rd->qtyinkg = $receive['inkg'];
                $rd->qtyinfeet = $receive['length'];
                $rd->rateperpc = $receive['perpc'];
                $rd->rateperkg = $receive['perkg'];
                $rd->rateperft = $receive['perft'];
                $rd->save();
            }
            $cis = CommercialInvoice::findOrFail($reciving->commercial_invoice_id);
            $cis->goods_received = 1;
            $cis->save();
            foreach($cis->commericalInvoiceDetails as $c)
            {
                $c->goods_received = 1;
                $c->save();
            }

        DB::commit();
        Session::flash('success','Good Received');
        return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function show(Receiving $receiving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function edit(Receiving $receiving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receiving $receiving)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receiving $receiving)
    {
        //
    }
}
