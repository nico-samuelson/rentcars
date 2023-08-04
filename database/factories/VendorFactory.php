<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'vendor_name' => fake()->company(),
            'vendor_email' => fake()->unique()->companyEmail(),
            'vendor_phone' => fake()->unique()->phoneNumber(),
            'vendor_logo' => fake()->imageUrl(640, 480, 'cats'),
        ];
    }
}
