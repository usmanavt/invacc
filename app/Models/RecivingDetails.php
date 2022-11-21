<?php

namespace App\Models;

use App\Models\Location;
use App\Models\Reciving;
use App\Models\Supplier;
use App\Models\CommercialInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecivingDetails extends Model
{
    use HasFactory;

    /************** Relationships **************/
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function reciving()
    {
        return $this->belongsTo(Reciving::class);
    }
    public function cis()
    {
        return $this->belongsTo(CommercialInvoice::class,'commercial_invoice_id');
    }

}
