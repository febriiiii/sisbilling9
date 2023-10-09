<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblpaymenttrans extends Model
{
    use HasFactory;
    protected $table = 'tblpaymenttrans';
    protected $guarded = ['null'];
    protected $primaryKey = 'notrans';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
}
