<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::value('id'),
            'apartment_type_id' => fake()->boolean(50)? rand(1,3) : null,
            'name' => fake()->text(20),
            'capacity_adults' => rand(1, 5),
            'capacity_children' => rand(1, 5),
            'size' =>fake()->boolean(50) ? fake()->numberBetween(20, 300) : null,
            'bathrooms' => rand(0, 5),
        ];
    }
}
