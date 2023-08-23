<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateSaleRate extends Model
{
    use HasFactory;

    protected $table= "last_sale_rate";
    protected $fillable = ['customer_id','salrate','material_id'];
}
