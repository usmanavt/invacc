<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smenu extends Model
{
    use HasFactory;
    protected $table= "tblesmenu";
    protected $fillable = ['mmenuid','smenuname'];

}
