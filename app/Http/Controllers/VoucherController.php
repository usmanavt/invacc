<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }
    public function index(){   return view('journalvouchers.index'); }

    public function getMaster(Request $request)
    {
        // dd($request->all());
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $vouchers = Voucher::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('description','LIKE','%' . $search . '%')
            ->orWhereDate('document_date','LIKE','%' . $search . '%');
            // ->orWhereHas('supplier',function($query) use($search){
            //     $query->where('title','LIKE',"%$search%");
            // })
            // ->orWhereHas('customer',function($query) use($search){
            //     $query->where('title','LIKE',"%$search%");
            // })
            // ->orWhereHas('head',function($query) use($search){
            //     $query->where('title','LIKE',"%$search%");
            // })
            // ->orWhereHas('subhead',function($query) use($search){
            //     $query->where('title','LIKE',"%$search%");
            // });
        })
        // ->with('bank:id,title')
        // ->with('head:id,title')
        // ->with('subhead:id,title')
        // ->with('supplier:id,title')
        // ->with('customer:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $vouchers;
    }

    public function store(Request $request)
    {
        //
    }


    public function edit(Voucher $voucher)
    {
        //
    }

    public function update(Request $request, Voucher $voucher)
    {
        //
    }

}
