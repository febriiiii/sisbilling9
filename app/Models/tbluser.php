<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class tbluser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbluser';
    protected $guarded = ['userid'];
    protected $primaryKey = 'userid';
    const CREATED_AT = 'InsertDT';
    const UPDATED_AT = 'UpdateDT';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
