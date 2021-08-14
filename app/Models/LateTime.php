<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateTime extends Model
{
    protected $table = 'late_time';
    protected $fillable = ['employee_id', 'day', 'hours'];
    public $timestamps = false;
    use HasFactory;
    
}
