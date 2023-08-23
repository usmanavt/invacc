<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBal extends Model
{
    use HasFactory;
    protected $table= "item_bal";
    protected $fillable = ['locid','material_id','obqtykg','obqtypcs','obqtyfeet','cbqtykg','cbqtypcs','cbqtyfeet'];
}
