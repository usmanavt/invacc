<?php

namespace App\Models;

use App\Models\Head;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// CHART OF ACCOUNTS
class Subhead extends Model
{
    use HasFactory;
    protected $fillable = ['head_id','title','status','ob'];

    //  Relationship
    public function head()
    {
        return $this->belongsTo(Head::class);
    }
}
