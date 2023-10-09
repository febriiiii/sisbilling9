<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblagenda extends Model
{
    use HasFactory;
    protected $guarded = ['null'];
    protected $table = 'tblagenda';
    protected $primaryKey = 'AppointmentId';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
}
