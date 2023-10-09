<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblproducttype extends Model
{
    use HasFactory;
    protected $guarded = ['null'];
    protected $table = 'tblproducttype';
    protected $primaryKey = 'producttypeid';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
}
