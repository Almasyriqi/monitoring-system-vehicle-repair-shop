<?php

namespace App\Imports;

use App\Models\Repair;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RepairImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Repair([
            'id' => $row['id'],
            'vehicle_id' => $row['vehicle_id'],
            'mechanic_id' => $row['mechanic_id'],
            'issue' => $row['issue'],
            'repair_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['repair_date']),
            'start_time' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['start_time']),
            'end_time' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['end_time']),
            'status' => $row['status']
        ]);
    }
}
