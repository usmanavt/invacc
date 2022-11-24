<?php

namespace App\Models;

use App\Models\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecivingCompletedDetails extends Base
{
    use HasFactory;
    public $dates = ['reciving_date'];
    protected $fillable = ['reciving_id','location','machine_date','machineno','supplier_id','commercial_invoice_id','invoiceno','material_id','material_title','reciving_date','status','received','rejected'];

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
