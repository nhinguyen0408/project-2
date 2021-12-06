<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnLeave extends Model
{
    protected $table = 'on_leave';
    public $fillable = ['employee_id', 'day', 'month'];
    use HasFactory;
}
