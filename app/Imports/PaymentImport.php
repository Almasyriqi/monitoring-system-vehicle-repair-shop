<?php

namespace App\Imports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PaymentImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Payment([
            'id' => $row['id'],
            'repair_id' => $row['repair_id'],
            'total' => $row['total'],
            'payment_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['payment_date']),
        ]);
    }
}
