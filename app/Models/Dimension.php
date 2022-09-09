<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dimension extends Model
{
    use HasFactory;
    protected $tabel = 'dimensions';
    protected $fillable = ['title','status'];

     //  Relationships
     public function materials(){ return $this->hasMany(Material::class); }

}
