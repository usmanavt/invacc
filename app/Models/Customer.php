<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table= "tblecustomer";
    protected $fillable = ['ccode','cname',
    'cnname','cpaddress','cdivraddress','contpaddress','cphoneoff','cphoneres','cfax'
    ,'cemail','cstatus','obalance','ntnno','staxno','cop'];

}

