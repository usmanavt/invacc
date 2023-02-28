<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Contract;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommercialInvoiceDetails;
use App\Models\RecivingCompletedDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialInvoice extends Model
{
    use HasFactory;
    protected $dates = ['invoice_date','machine_date'];
    protected $fillable = [
       'invoice_date','invoiceno','contract_id','supplier_id','machine_date','machineno','challanno','conversionrate','insurance','bankcharges','collofcustom','exataxoffie','lngnshipdochrgs','localcartage','miscexplunchetc','customsepoy','weighbridge','miscexpenses','agencychrgs','otherchrgs','goods_received','totallccostwexp'
    ];
    public $appends = ['full_total'] ;


    /************** Methods **************/
    protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}

    public function getFullTotalAttribute()
    {
        return $this->commericalInvoiceDetails()->sum('totallccostwexp');
    }


    public function getFullTotallAttributeLocal()
    {
        return $this->commericalInvoiceDetails()->sum('totallccostwexp');
    }


    public static function hasCompletedReciving($id)
    {
        $rpd = RecivingCompletedDetails::where('commercial_invoice_id',$id)->first();
        if($rpd) return true;
        return false;
    }
    //  This function is called from RecivingController.php after closing the related Reciving
    public static function closeCommercialInvoice($id)
    {
        $ci = CommercialInvoice::findOrFail($id);
        $ci->status= 2;
        $ci->save();
        //  Update Relationships
        $ci->commericalInvoiceDetails()->update(['status' => 2]);
    }
    /************** Relationships **************/
    public function commericalInvoiceDetails(){return $this->hasMany(CommercialInvoiceDetails::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function contract(){ return $this->belongsTo(Contract::class); }
}
