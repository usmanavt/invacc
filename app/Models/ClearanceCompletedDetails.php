<?php

namespace App\Models;

use App\Models\Material;
use App\Models\Supplier;
use App\Models\Clearance;
use App\Models\CommercialInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClearanceCompletedDetails extends Model
{
    use HasFactory;
    public $dates = ['gd_date','machine_date'];
    protected $fillable = ['clearance_id','gdno','gd_date','machine_date','machineno','commercial_invoice_id','invoiceno','contract_id','material_id','supplier_id','user_id','category_id','sku_id','dimension_id','source_id','brand_id','pcs','gdswt','inkg','gdsprice','amtindollar','amtinpkr','hscode','cd','st','rd','acd','ast','it','wse','length','itmratio','insuranceperitem','amountwithoutinsurance','onepercentdutypkr','pricevaluecostsheet','cda','sta','rda','acda','asta','ita','wsca','total','perpc','perkg','perft','status','totallccostwexp'];

    // public $appends = ['material_title'];




    // public function getMaterialTitleAttribute()
    // {
    //     return $this->material->title;
    // }





    /************** Relationships **************/
    public function supplier(){ ;return $this->belongsTo(Supplier::class) ;}
    public function clearance(){ ;return $this->belongsTo(Clearance::class,'commercial_invoice_id') ;}
    public function material(){ ;return $this->belongsTo(Material::class) ;}
    public function cis(){ return $this->belongsTo(CommercialInvoice::class,'commercial_invoice_id'); }





}
