<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialInvoiceDetails extends Model
{
    use HasFactory;



    /************** Relationships **************/
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
