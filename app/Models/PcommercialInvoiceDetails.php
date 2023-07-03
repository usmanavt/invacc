<?php

namespace App\Models;

use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PcommercialInvoiceDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'commercial_invoice_id','material_id','pcs','gdswt','gdsprice','dutyval','status','closed'
     ];




    // public function getMaterialTitleAttribute()
    // {
    //     return $this->material->title;
    // }

    /************** Relationships **************/
    // public function material()
    // {
    //     return $this->belongsTo(Material::class);
    // }
    // public function supplier()
    // {
    //     return $this->belongsTo(Supplier::class);
    // }
}
