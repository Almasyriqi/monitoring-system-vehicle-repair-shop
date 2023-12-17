<?php

namespace Database\Seeders;

use App\Imports\MechanicImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MechanicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new MechanicImport, public_path("data/mechanics.xlsx"));
    }
}
