<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frmrptparamtr extends Model
{
    use HasFactory;
    protected $tabel = 'frmrptparamtr';
    protected $fillable = ['mytitle','rptname'];
}
