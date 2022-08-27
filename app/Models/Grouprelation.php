<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grouprelation extends Model
{
    use HasFactory;
    protected $table= "tbleobszws";
    protected $fillable = ['itmid0','itmid','itmsizeid','obqty','purrate','costrate',
    'srcid','purunitid','trid','locid','brandid','sstatus'];





}
