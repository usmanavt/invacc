<?php

namespace App\Models;
use App\Models\Material;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatepasseDetails extends Model
{
    use HasFactory;
    public $appends = ['totval'];

    public function getTotvalAttribute()
    {
        $calc = $this->qtykg * $this->price ;
        return $calc;

    }

}
