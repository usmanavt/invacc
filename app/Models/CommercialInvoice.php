<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialInvoice extends Model
{
    use HasFactory;
    protected $dates = ['invoice_date'];
    protected $fillable = [
       'invoice_date','invoiceno','challanno','conversionrate','insurance','bankcharges','collofcustom','exataxoffie','lngnshipdochrgs','localcartage','miscexplunchetc','customsepoy','weighbridge','miscexpenses','agencychrgs','otherchrgs'
    ];

    
    protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}
}
