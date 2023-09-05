<?php

namespace App\Models;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasingDetails extends Model
{
    use HasFactory;
    protected $table= "purchasing_details";
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


}
