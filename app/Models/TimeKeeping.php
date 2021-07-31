<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeKeeping extends Model
{
    protected $table = 'time_keeping';
    protected $fillable = [
        "id",
        "employee_id",
        "checked",
    ];
    use HasFactory;
}
