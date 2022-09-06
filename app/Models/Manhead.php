<?php

namespace App\Models;

use App\Models\Subhead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Chart of Acocunts
class Manhead extends Model
{
    use HasFactory;
    protected $table= "tblmanhead";
    protected $fillable = ['mheadname','sstatus','mdbnature'];

    // Relationship
    public function subheads()
    {
        return $this->hasMany(Subhead::class,'tblmanhead_id');
    }
}
