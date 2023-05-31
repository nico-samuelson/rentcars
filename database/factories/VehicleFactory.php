<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cars = array();
        $cars['Toyota'] = array('Avanza', 'Rush', 'Agya', 'Calya', 'Innova', 'Hiace Commuter', 'Alphard', 'Fortuner', 'Camry');
        $cars['Daihatsu'] = array('Ayla', 'Xenia', 'Sigra', 'Terios');
        $cars['Honda'] = array('Brio', 'Mobilio', 'HRV', 'CRV', 'Accord', 'Civic');
        $cars['Suzuki'] = array('Ertiga');
        $cars['Mitsubishi'] = array('Xpander', 'Pajero');
        $cars['Hyundai'] = array('Stargazer', 'Palisade');
        $cars['Mercedes'] = array("SLS AMG", "S Class", "E Class", "S Class Maybach");
        $cars['Porsche'] = array('911');
        $cars['Ford'] = array('Mustang');
        $cars['Nissan'] = array('Xtrail', 'R35 GTR');
        $cars['Mini'] = array('Cabriolet');
        $cars['BMW'] = array('Series 5', 'M4 Coupe');

        $brand = array_rand($cars);
        $model = $cars[$brand][array_rand($cars[$brand])];
        $year = fake()->numberBetween(2010, 2023);

        $locations = Location::get()->count();

        return [
            'license_plate' => fake()->randomLetter() . " " . fake()->randomNumber(4, true) . " " . fake()->randomLetter() . 
                                fake()->randomLetter(),
            'brand' => $brand,
            'model' => $model,
            'year' => $year,
            'color' => fake()->colorName(),
            'capacity' => fake()->numberBetween(5, 7),
            'transmission' => array_rand(array('manual' => 1, 'matic' => 2)),
            'daily_rate' => 0,
            'location_id' => mt_rand(1, $locations),
            'vehicle_image' => 'storage/vehicle-image/' . $model . '.jpg',
            'is_available' => true
        ];
    }
}
