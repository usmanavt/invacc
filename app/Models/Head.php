<?php

namespace App\Models;

use App\Models\Subhead;
use App\Models\tempsubheads;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Chart of Acocunts
class Head extends Model
{
    use HasFactory;
    protected $fillable = ['title','nature','status'];

    // Relationship
    public function subheads()
    {
        return $this->hasMany(Subhead::class);
    }

    public function tempsubheads()
    {
         return $this->hasMany(tempsubheads::class);

    }

}
