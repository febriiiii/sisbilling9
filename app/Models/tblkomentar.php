<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblkomentar extends Model
{
    use HasFactory;
    protected $guarded = ['null'];
    protected $table = 'tblkomentar';
    protected $primaryKey = 'komentarid';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
}
