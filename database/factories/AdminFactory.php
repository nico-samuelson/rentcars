<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $vendors = Vendor::get();

        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'vendor_id' => mt_rand(1, $vendors->count()),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ];
    }
}
