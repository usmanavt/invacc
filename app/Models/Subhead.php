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
    public $appends = ['head_title'];


    public function getHeadTitleAttribute()
    {
        // return $this->head->title;
    }

    //  Relationship
    public function head()
    {
        return $this->belongsTo(Head::class);
    }
}
