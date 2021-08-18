<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    use HasFactory;
    protected $table = 'salary_details';
    protected $fillable = [
        'employee_id','month','salary_earning','total_time','bonus_earning','penalize'
    ];
    public $timestamps = false;
}
