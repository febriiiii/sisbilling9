<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblbilling extends Model
{
    use HasFactory;
    
    protected $guarded = ['null'];
    protected $table = 'tblbilling';
    protected $primaryKey = 'billingid';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
}
