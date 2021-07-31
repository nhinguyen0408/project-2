<?php

namespace App\Imports;

use App\Models\TimeKeeping;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TimeKeepingImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        //$date = str_replace("/", "-", $row["datetime"]);
        $date = $row["datetime"];
        $check = date('Y-m-d H:i:m', strtotime($date));
        // dd($row['no'] . $date->toDateTimeString());
        var_dump($check);
        $data = [
            'employee_id' => number_format($row['no']),
            'checked' => $check
        ];
        return new TimeKeeping($data);
    }
}
