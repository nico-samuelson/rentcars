<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\Location;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
        $locations = Location::get()->count();
        $models = VehicleModel::get();

        foreach($models as $model) {
            for ($i = 0; $i < 20; $i++) {
                $vehicle = array();
                $vehicle['model_id'] = $model->id;
                $vehicle['license_plate'] = strtoupper(fake()->randomLetter()) . " " . fake()->randomNumber(4, true) . " " . strtoupper(fake()->randomLetter()) . strtoupper(fake()->randomLetter());
                $vehicle['year'] = fake()->numberBetween(2010, 2023);
                $vehicle['color'] = fake()->colorName();
                $vehicle['transmission'] = array_rand(array('Manual' => 1, 'Matic' => 2));
                $vehicle['location_id'] = mt_rand(1, $locations);
                $vehicle['is_available'] = true;
                Vehicle::create($vehicle);
            }
        }
    }
}
