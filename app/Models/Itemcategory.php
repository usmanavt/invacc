<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemcategory extends Model
{
    use HasFactory;
    protected $table= "TbleItem0";
    protected $fillable = ['icode0','iname0','inname0'];
}
