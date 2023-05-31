<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Staff;
use App\Models\Location;
use App\Models\Department;
use App\Models\RentStatus;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Database\Seeders\RentSeeder;
use Database\Seeders\VehicleSeeder;
use Database\Seeders\VehicleModelSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(100)->create();

        $statuses = array('Unpaid', 'Paid', 'Approved', 'On Progress', 'Rejected', 'Cancelled', 'Refunded', 'Completed');
        $cities = array('Surabaya', 'Jakarta', 'Malang', 'Semarang', 'Yogyakarta', 'Bandung', 'Medan', 'Pekanbaru', 'Palembang', 'Padang', 'Lombok', 'Bali');
        $departments = array("Board of Director", "Board of Comissioner", "Shareholder", "Operations", "Finance", "IT", "HRD", "Research & Development");
        $paymethods = array('Bank Transfer', 'OVO', 'Gopay', 'DANA', 'LinkAja', 'ShopeePay', 'XL', 'Telkom', 'Indosat');

        foreach($departments as $department)
            Department::create(['name' => $department]);

        foreach($cities as $city) {
            Location::create([
                'location_name' => $city,
                'address' => 'Jl. Imam Bonjol 123',
                'phone_number' => '0812345678',
            ]);
        }

        foreach($paymethods as $pmethods)
            PaymentMethod::create(['method' => $pmethods]);

        foreach($statuses as $status)
            RentStatus::create(['status' => $status]);

        Staff::factory(300)->create();

        $this->call([
            VehicleModelSeeder::class,
            VehicleSeeder::class,
            RentSeeder::class,
        ]);
    }
}
