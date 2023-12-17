<?php

namespace App\Imports;

use App\Models\PaymentDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PaymentDetailImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PaymentDetail([
            'id' => $row['id'],
            'payment_id' => $row['payment_id'],
            'part_id' => $row['part_id'],
            'quantity' => $row['quantity'],
            'amount' => $row['amount'],
            'note' => $row['note']
        ]);
    }
}
