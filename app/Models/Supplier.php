<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table= "tblesupplier";
    protected $fillable = ['scode','sname',
    'snname','spaddress','sphoneoff',
    'sphoneres','sfax','semail','sstatus',
    'obalance','ntnno','staxNo','srcId'];
}
