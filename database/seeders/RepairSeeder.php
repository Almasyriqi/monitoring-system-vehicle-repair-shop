<?php

namespace Database\Seeders;

use App\Imports\RepairImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class RepairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new RepairImport, public_path("data/repairs.xlsx"));
    }
}
