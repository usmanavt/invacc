<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GodownprDetails extends Model
{
    use HasFactory;
    protected $table= "godownpr_details";
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
