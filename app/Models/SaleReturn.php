<?php

namespace App\Models;

use DateTimeInterface;
// use App\Models\Contract;
use App\Models\Customers;
use App\Models\Sku;
use App\Models\SaleReturnDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{

    use HasFactory;
    protected $dates = ['dcdate','rdate'];
    protected $fillable = [
    //    'invoice_date','invoiceno','contract_id','supplier_id','machine_date','machineno','challanno','conversionrate','insurance','bankcharges','collofcustom','exataxoffie','lngnshipdochrgs','localcartage','miscexplunchetc','customsepoy','weighbridge','miscexpenses','agencychrgs','otherchrgs','goods_received','totallccostwexp'
        'customer_id','invoice_id','dcdate','rdate','dcno','billno','gpno','rcvblamount','saletaxper'
        ,'saletaxamt','totrcvbamount','Remarks'
    ];
    // public $appends = ['full_total'] ;

    protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}
    public function saleInvoicesdetails(){return $this->hasMany(SaleReturnDetails::class); }
    public function customer(){ return $this->belongsTo(Customer::class); }
    public function sku(){ return $this->belongsTo(Sku::class); }

}
