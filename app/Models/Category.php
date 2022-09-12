<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title','nick','status'];

    //  Relationships
    public function materials(){ return $this->hasMany(Material::class); }
    
}
