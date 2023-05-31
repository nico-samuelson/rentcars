<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rent>
 */
class RentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $vehicles = Vehicle::get()->count();

        $admins = Staff::where('position', 'Staff')->get();
        $adminId = mt_rand(0, $admins->count()-1);
        $admin = $admins->slice($adminId, 1)->toArray();

        $drivers = Staff::where('position', 'Driver')->get();
        $driverId = mt_rand(0, $drivers->count()-1);
        $driver = $drivers->slice($driverId, 1)->toArray();

        $start = fake()->dateTimeBetween('-1 weeks', 'now');
        $end = fake()->dateTimeInInterval($start, '+1 weeks');
        
        return [
            'rent_number' => "RR" . fake()->unique()->randomNumber(),
            'vehicle_id' => mt_rand(1, $vehicles),
            'admin_id' => $admin[$adminId]['id'],
            'driver_id' => $driver[$driverId]['id'],
            'start_date' => $start,
            'start_time' => fake()->time(),
            'end_date' => $end,
            'end_time' => fake()->time(),
            'total_price' => 0,
            'renter_name' => fake()->name(),
            'renter_email' => fake()->safeEmail(),
            'renter_phone' => fake()->phoneNumber(),
            'driver_name' => fake()->name(),
            'driver_email' => fake()->safeEmail(),
            'driver_phone' => fake()->phoneNumber(),
            'driver_identity' => 'storage/upload_KTP/KTP.jpg',
            'driver_license' => 'storage/upload_SIM/SIM.jpg',
            'status' => 0
        ];
    }
}
