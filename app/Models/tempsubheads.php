<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempsubheads extends Model
{
    use HasFactory;
    protected $fillable = ['head_id','title','status'];

    //  Relationship
    public function head()
    {
        return $this->belongsTo(Head::class);
    }
}
