<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tblecontractmaster extends Model
{
    use HasFactory;
    protected $table= "tblecontractmaster";
    protected $fillable = ['invid','invdate','invno','supcode','convrate','insurance'];
}
