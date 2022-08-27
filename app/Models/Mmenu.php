<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mmenu extends Model
{
    use HasFactory;
    protected $table= "tblemmenu";
    protected $fillable = ['mmenuname'];
}
