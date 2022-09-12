<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Care Of model
class Source extends Model
{
    use HasFactory;
    protected $fillable = ['title','status'];

    // Relationships
    public function materials(){ return $this->hasMany(Material::class); }
    public function customers(){ return $this->hasMany(Customer::class); }

    public function suppliers(){ return $this->hasMany(Supplier::class); }

}
