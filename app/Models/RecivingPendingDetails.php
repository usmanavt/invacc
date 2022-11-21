<?php

namespace App\Models;

use App\Models\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecivingPendingDetails extends Base
{
    use HasFactory;

    protected $fillable = ['reciving_id','machine_date','machineno','supplier_id','commercial_invoice_id','invoiceno','material_id','material_title','reciving_date','status','rateperpc','rateperkg','rateperft','qtyinpcs','qtyinkg','qtyinfeet','qtyinpcspending'];

    /************** Relationships **************/
    public function reciving()
    {
        return $this->belongsTo(Reciving::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function cis()
    {
        return $this->belongsTo(CommercialInvoice::class,'commercial_invoice_id');
    }
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
