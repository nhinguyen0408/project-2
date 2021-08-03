<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverTime extends Model
{
    protected $table = 'overtime';
    protected $fillable = ['employee_id', 'day', 'hours'];
    public $timestamps = false;
    use HasFactory;
}
