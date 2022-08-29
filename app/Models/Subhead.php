<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subhead extends Model
{
    use HasFactory;
    protected $table= "tblsubhead";
    protected $fillable = ['mheadid','subheadid','subheadname','sstatus','ob'];
}
