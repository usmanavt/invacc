<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommercialInvoiceDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialInvoice extends Model
{
    use HasFactory;
    protected $dates = ['invoice_date','machine_date'];
    protected $fillable = [
       'invoice_date','invoiceno','supplier_id','machine_date','machineno','challanno','conversionrate','insurance','bankcharges','collofcustom','exataxoffie','lngnshipdochrgs','localcartage','miscexplunchetc','customsepoy','weighbridge','miscexpenses','agencychrgs','otherchrgs','goods_received'
    ];


    protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}

    /************** Relationships **************/
    public function commericalInvoiceDetails()
    {
        return $this->hasMany(CommercialInvoiceDetails::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
