<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblpaketuser extends Model
{
    use HasFactory;
    protected $guarded = ['null'];
    protected $table = 'tblpaketuser';
    protected $primaryKey = 'idpaketuser';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    // protected $keyType = 'string';
}
