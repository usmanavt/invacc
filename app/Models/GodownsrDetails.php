<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GodownsrDetails extends Model
{
    use HasFactory;
    protected $table= "godownsr_details";
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
