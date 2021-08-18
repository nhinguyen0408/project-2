<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulationDetails extends Model
{
    use HasFactory;
    protected $table = 'regulation_details';
    protected $fillable = ['employee_id', 'regulation_id'];
    public $timestamps = false;
}
