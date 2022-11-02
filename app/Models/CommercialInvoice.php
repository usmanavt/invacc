<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommercialInvoiceDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialInvoice extends Model
{
    use HasFactory;
    protected $dates = ['invoice_date','machine_date'];
    protected $fillable = [
       'invoice_date','invoiceno','machine_date','machineno','challanno','conversionrate','insurance','bankcharges','collofcustom','exataxoffie','lngnshipdochrgs','localcartage','miscexplunchetc','customsepoy','weighbridge','miscexpenses','agencychrgs','otherchrgs'
    ];


    protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}

    /**
     * Get all of the commericalInvoiceDetails for the CommercialInvoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commericalInvoiceDetails()
    {
        return $this->hasMany(CommercialInvoiceDetails::class);
    }
}
