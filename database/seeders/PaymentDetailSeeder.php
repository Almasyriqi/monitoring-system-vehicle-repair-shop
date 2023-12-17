<?php

namespace Database\Seeders;

use App\Imports\PaymentDetailImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class PaymentDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new PaymentDetailImport, public_path("data/payment_details.xlsx"));
    }
}
