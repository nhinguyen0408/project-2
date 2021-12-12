<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{
    use HasFactory;
    protected $table = 'regulation';
    protected $fillable = ['amount_of_money', 'description', 'status'];
    public $timestamps = false;
}
