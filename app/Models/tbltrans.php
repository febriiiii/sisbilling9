<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbltrans extends Model
{
    use HasFactory;
    protected $guarded = ['null'];
    protected $table = 'tbltrans';
    protected $primaryKey = 'notrans';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
}
