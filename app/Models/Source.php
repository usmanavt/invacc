<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Care Of model
class Source extends Model
{
    use HasFactory;
    protected $table= "tblesource";
    protected $fillable = ['srcname'];

    // Relationships
    public function items(){ return $this->hasMany(Item::class); }
    public function customers(){ return $this->hasMany(Customer::class); }

}
