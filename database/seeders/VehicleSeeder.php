<?php

namespace Database\Seeders;

use App\Imports\VehicleImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new VehicleImport, public_path("data/vehicles.xlsx"));
    }
}
