<?php

namespace App\Imports;

use App\Models\Mechanic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MechanicImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Mechanic([
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'expertise' => $row['expertise']
        ]);
    }
}
