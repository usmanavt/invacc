<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetail extends Model
{
    use HasFactory;
    protected $table= "purchase_return_details";

    public function sku()
    {
        return $this->belongsTo(Sku::class);
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
