<?php

namespace Database\Seeders;

use App\Imports\CustomerImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new CustomerImport, public_path("data/customers.xlsx"));
    }
}
