<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeItemBal extends Model
{
    use HasFactory;
    protected $table= "office_item_bal";
    protected $fillable = ['transaction_id','tdate','ttypedesc','ttypeid','material_id','tqtykg','tqtypcs','tqtyfeet',
                           'tcostkg','tcostpcs','tcostfeet'];
}
