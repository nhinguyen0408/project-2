<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    public $timestamps = false;

    public function GetSexNameAttribute()
    {
        if ($this->gender == 1) {
            return 'Nam';
        } else {
            return 'Nữ';
        }
    }
}
