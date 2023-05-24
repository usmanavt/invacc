<?php

namespace App\Models;
use App\Models\Material;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoicesDetails extends Model
{
    use HasFactory;
    public $appends = ['material_title','totval'];

    public function getMaterialTitleAttribute()
    {
        return $this->material->title;
    }
    public function getTotvalAttribute()
    {


        $calc = $this->qtykg * $this->price ;
        return $calc;

    }




    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }


    /************** Relationships **************/
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }



}
