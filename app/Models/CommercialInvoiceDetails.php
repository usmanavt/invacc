<?php

namespace App\Models;

use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialInvoiceDetails extends Model
{
    use HasFactory;
    public $appends = ['material_title'];




    public function getMaterialTitleAttribute()
    {
        return $this->material->title;
    }

    /************** Relationships **************/
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
