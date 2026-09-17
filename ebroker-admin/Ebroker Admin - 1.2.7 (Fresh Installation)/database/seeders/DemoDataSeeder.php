<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Demo\PackageDataSeeder;
use Database\Seeders\Demo\CustomerDataSeeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Customer Data Seeder
        $customerDataSeeder = new CustomerDataSeeder();
        $customerDataSeeder->run();

        // Package Data Seeder
        $packageDataSeeder = new PackageDataSeeder();
        $packageDataSeeder->run();
    }
}