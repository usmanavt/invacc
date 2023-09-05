<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasing extends Model
{
    use HasFactory;

    // protected $dates = ['contract_date','purdate'];
    protected $fillable = [
       'contract_id','contract_date','supplier_id','purseqid','purtotpcs','purtotwt','purtotfeet',
       'balpurtotpcs','balpurtotwt','balpurtotfeet' ];
    // public $appends = ['full_total'] ;

    /************** Methods **************/
    // protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}

    // public function getFullTotalAttribute()
    // {
    //     return $this->commericalInvoiceDetails()->sum('totallccostwexp');
    // }


    // public function getFullTotallAttributeLocal()
    // {
    //     return $this->commericalInvoiceDetails()->sum('totallccostwexp');
    // }


    // public static function hasCompletedReciving($id)
    // {
    //     $rpd = RecivingCompletedDetails::where('commercial_invoice_id',$id)->first();
    //     if($rpd) return true;
    //     return false;
    // }
    //  This function is called from RecivingController.php after closing the related Reciving
    // public static function closeCommercialInvoice($id)
    // {
    //     $ci = CommercialInvoice::findOrFail($id);
    //     $ci->status= 2;
    //     $ci->save();
    //     //  Update Relationships
    //     $ci->commericalInvoiceDetails()->update(['status' => 2]);
    // }
    /************** Relationships **************/
    public function PurchasingDetails(){return $this->hasMany(PurchasingDetails::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function contract(){ return $this->belongsTo(Contract::class); }
}
