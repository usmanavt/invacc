<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hscode extends Model
{
    use HasFactory;
    protected $fillable = ['hscode','cd','st','rd','acd','ast','it','wse'];

    //  Relationships
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
