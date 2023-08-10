<?php

namespace App\Models;

use DateTimeInterface;
// use App\Models\Contract;
use App\Models\Customers;
use App\Models\Sku;
use App\Models\SaleInvoicesDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoices extends Model
{
    use HasFactory;
    protected $dates = ['saldate','podate'];
    protected $fillable = [
    //    'invoice_date','invoiceno','contract_id','supplier_id','machine_date','machineno','challanno','conversionrate','insurance','bankcharges','collofcustom','exataxoffie','lngnshipdochrgs','localcartage','miscexplunchetc','customsepoy','weighbridge','miscexpenses','agencychrgs','otherchrgs','goods_received','totallccostwexp'
        'customer_id','saldate','dcno','billno','gpno','discntper','discntamt','cartage','rcvblamount','saletaxper'
        ,'saletaxamt','totrcvbamount','Remarks'
    ];
    // public $appends = ['full_total'] ;

    protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}
    public function saleInvoicesdetails(){return $this->hasMany(SaleInvoicesDetails::class); }
    public function customer(){ return $this->belongsTo(Customer::class); }
    public function sku(){ return $this->belongsTo(Sku::class); }

}
