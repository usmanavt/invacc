<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reciving extends Model
{
    use HasFactory;
    protected $dates = ['machine_date','reciving_date'];
    protected $fillable = ['machine_date','machineno','supplier_id','commercial_invoice_id','invoiceno','reciving_date'];


    /************** Relationships **************/
    public function commercialInvoice()
    {
        return $this->belongsTo(CommercialInvoice::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
