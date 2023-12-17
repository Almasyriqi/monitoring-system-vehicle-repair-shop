<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CustomerSeeder::class);
        $this->call(MechanicSeeder::class);
        $this->call(PartSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(RepairSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(PaymentDetailSeeder::class);
    }
}
