<?php

namespace App\Models;

use App\Models\Base;
use App\Models\Supplier;
use App\Models\RecivingPendingDetails;
use App\Models\RecivingCompletedDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reciving extends Base
{
    use HasFactory;
    protected $dates = ['machine_date','reciving_date'];
    protected $fillable = ['machine_date','machineno','supplier_id','commercial_invoice_id','invoiceno','reciving_date'];

    /************** Methods **************/

    /************** Relationships **************/
    public function commercialInvoice()
    {
        return $this->belongsTo(CommercialInvoice::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function pendingDetails()
    {
        return $this->hasMany(RecivingPendingDetails::class);
    }
    public function completedDetails()
    {
        return $this->hasMany(RecivingCompletedDetails::class);
    }
}
