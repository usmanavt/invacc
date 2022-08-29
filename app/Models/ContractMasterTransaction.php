<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractMasterTransaction extends Model
{
    use HasFactory;
    // protected $dates = false;
    // protected $primaryKey = 'invid';
    // public $incrementing = false; // If no autoincrement
    protected $table= "tblecontracttrans";
    protected $fillable = ['tinivd','transid','brandid','bundle1','pcspbundle1','bundle2','pcspbundle2','gdswt','gdsprice'];
}
