<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblpengumuman extends Model
{
    use HasFactory;
    protected $guarded = ['null'];
    protected $table = 'tblpengumuman';
    protected $primaryKey = 'pengumumanid';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
}
