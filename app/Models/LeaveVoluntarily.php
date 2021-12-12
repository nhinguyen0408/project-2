<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveVoluntarily extends Model
{
    use HasFactory;
    protected $table = 'leave_voluntarily';
    public $fillable = ['employee_id', 'day', 'month'];
}
