<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manhead extends Model
{
    use HasFactory;
    protected $table= "tblmanhead";
    protected $fillable = ['mheadid','mheadname','sstatus','mdbnature'];
}
