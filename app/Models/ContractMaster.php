<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractMaster extends Model
{
    use HasFactory;
    // protected $dates = false;
    // protected $primaryKey = 'invid';
    // public $incrementing = false; // If no autoincrement
    protected $table= "tblecontractmaster";
    protected $fillable = ['invid','invdate','invno','supcode'];
}
