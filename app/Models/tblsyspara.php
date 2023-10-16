<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblsyspara extends Model
{
    use HasFactory;
    protected $guarded = ['null'];
    protected $table = 'tblsyspara';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
