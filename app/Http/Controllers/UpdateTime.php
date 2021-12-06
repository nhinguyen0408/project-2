<?php

namespace App\Http\Controllers;
use App\Models\TimeKeeping;
use Illuminate\Http\Request;

class UpdateTime extends Controller
{
    public static function updateTime(){
        $time = TimeKeeping::orderby('updated_at', 'DESC')->first();
        if(isset($time)){
            $updated_time = $time->updated_at;
        } else {
            $updated_time = null;
        }

        return $updated_time;
    }
}
