<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $departments = Department::get();
        $locations = Location::get()->count();
        $positions = array('Staff', 'Supervisor', 'Manager');

        $id = mt_rand(0, $departments->count()-1);

        // dd($departments);
        $department = $departments->slice($id, 1)->toArray();
        $position = $positions[array_rand($positions)];
        $salary = 0;
        $lvl = 0;

        if ($department[$id]['name'] == 'Board of Director' || $department[$id]['name'] == 'Shareholder' || $department[$id]['name'] == 'Board of Comissioner') {
            $position = $department[$id]['name'];
            $lvl = 5;
            $salary = mt_rand(30000000, 50000000);
        }
        else if ($department[$id]['name'] == "HRD") {
            $lvl = 2;
            $salary = mt_rand(4500000, 20000000);
        }
        else if ($department[$id]['name'] == 'Research & Development') {
            $lvl = 3;
            $salary = mt_rand(7500000, 20000000);
        }
        else if ($position == "Supervisor" || $position == "Manager") {
            $lvl = 4;
            $salary = mt_rand(10000000, 25000000);
        }
        else {
            $lvl = 1;
            $salary = mt_rand(4500000, 12500000);
        }

        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'department_id' => $department[$id]['id'],
            'position' => $position,
            'salary' => $salary,
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'birthdate' => fake()->date('Y-m-d', '2005-01-01'),
            'address' => fake()->address(),
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'location_id' => mt_rand(1, $locations),
            'access_lvl' => $lvl,
            'remember_token' => Str::random(10),
        ];
    }
}
