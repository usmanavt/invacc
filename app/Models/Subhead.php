<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// CHART OF ACCOUNTS
class Subhead extends Model
{
    use HasFactory;
    protected $table= "tblsubhead";
    protected $fillable = ['tblmanhead_id','subheadname','sstatus','ob'];

    //  Relationship
    public function manhead()
    {
        return $this->belongsTo(Manhead::class,'tblmanhead_id');
    }
}
