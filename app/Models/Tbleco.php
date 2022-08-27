<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbleco extends Model
{
    use HasFactory;
    protected $table= "tbleco";
    protected $fillable = ['coid','coname','sstatus'];
}
