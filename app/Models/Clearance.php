<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Supplier;
use App\Models\Clearance;
use App\Models\Bank;
use App\Models\CommercialInvoice;
use App\Models\ClearancePendingDetails;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClearanceCompletedDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clearance extends Model
{
    use HasFactory;
    protected $dates = ['invoice_date','machine_date','gd_date','cheque_date'];
    protected $fillable = [
        'commercial_invoice_id','gdno','gd_date','invoice_date','invoiceno','supplier_id','machine_date','machineno',
        'conversionrate','insurance','bankcharges','collofcustom','exataxoffie','lngnshipdochrgs','localcartage',
        'miscexplunchetc','customsepoy','weighbridge','miscexpenses','agencychrgs','otherchrgs','cleared','status',
        'totallccostwexp','clearmade','bank_id','cheque_date','cheque_no'
    ];

    /************** Methods **************/
    protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}

    public static function hasCompletedClearance($id)
    {
        $ccd = ClearanceCompletedDetails::where('clearance_id',$id)->first();
        if($ccd) return true;
        return false;
    }

    /************** Relationships **************/
    public function clearance(){ return $this->belongsTo(Clearance::class); }
    public function supplier(){return $this->belongsTo(Supplier::class);}
    public function clearancePendingDetails(){ return $this->hasMany(ClearancePendingDetails::class); }
    public function clearanceCompletedDetails(){ return $this->hasMany(ClearanceCompletedDetails::class); }
    public function bank(){ return $this->belongsTo(Bank::class); }
}
