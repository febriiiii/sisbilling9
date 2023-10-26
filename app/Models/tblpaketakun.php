<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblpaketakun extends Model
{
    use HasFactory;
    protected $guarded = ['null'];
    protected $table = 'tblpaketakun';
    protected $primaryKey = 'idpaketakun';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    // protected $keyType = 'string';
}
