<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name',
    'nick','address','address2','contactaddress','phoneoff','phoneres','fax'
    ,'email','status','obalance','ntn','stax','care_id'];


    //  Relationship
    public function care()
    {
        return $this->belongsTo(Care::class);
    }
}

