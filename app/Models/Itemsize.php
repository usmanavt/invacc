<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemsize extends Model
{
    use HasFactory;
    protected $table= "tblesize";
    protected $fillable = ['sizeid','sizename','sizenname'];
}
