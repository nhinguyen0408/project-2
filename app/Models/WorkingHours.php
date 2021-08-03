<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    protected $table = 'working_hours';
    protected $fillable = ['employee_id', 'day', 'hours', 'status'];
    public $timestamps = false;
    use HasFactory;
}
