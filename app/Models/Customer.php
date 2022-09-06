<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table= "tblecustomer";
    protected $fillable = ['cname',
    'cnname','cpaddress','cdivraddress','contpaddress','cphoneoff','cphoneres','cfax'
    ,'cemail','cstatus','obalance','ntnno','staxno','cop'];


    //  Relationship
    public function care()
    {
        return $this->belongsTo(Care::class,'tbleco_id');
    }
}

