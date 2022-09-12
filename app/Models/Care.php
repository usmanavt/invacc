<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Care Of model
class Care extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','status'
    ];

    // Relationships
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
