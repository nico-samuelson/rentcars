<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Location;
use App\Models\RentStatus;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Database\Seeders\RentSeeder;
use Database\Seeders\VehicleSeeder;
use Database\Seeders\VehicleModelSeeder;
use Illuminate\Support\Str;

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
        $paymethods = array('Bank Transfer', 'OVO', 'Gopay', 'DANA', 'LinkAja', 'ShopeePay', 'XL', 'Telkom', 'Indosat');

        foreach($cities as $city) {
            Location::create([
                'location_name' => $city,
            ]);
        }

        foreach($paymethods as $pmethods)
            PaymentMethod::create(['method' => $pmethods]);

        foreach($statuses as $status)
            RentStatus::create(['status' => $status]);

        Vendor::factory(10)->create();
        $vendors = Vendor::get();

        for($i=0; $i<100; $i++) {
            Admin::create([
                'name' => fake()->name(),
                'username' => fake()->unique()->userName(),
                'vendor_id' => mt_rand(1, $vendors->count()),
                'email' => fake()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'email_verified_at' => now(),
                'password' => bcrypt('123456789'),
                'remember_token' => Str::random(10),
            ]);
        }
        // Admin::factory(100)->create();

        $this->call([
            VehicleModelSeeder::class,
            // VehicleSeeder::class,
            RentSeeder::class,
        ]);
    }
}
