<?php

namespace Database\Factories;

use App\Models\BodyPart;
use App\Models\Category;
use App\Models\City;
use App\Models\Location;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceProduct>
 */
class ServiceProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agent_id' => User::where('role', 'agent')->inRandomOrder()->first()->id,
            'category_id' => Category::all()->random()->id,
            'subcategory_id' => Subcategory::all()->random()->id,
            'bodypart_id' => BodyPart::all()->random()->id,
            'city_id' => City::all()->random()->id,
            'name' => fake()->sentence(rand(2, 4)),
            'description' => fake()->sentences(rand(10, 15), true),
            'image' => fake()->imageUrl,
            'product_price' => rand(100, 1000),
            'service_price' => rand(100, 1000),
            'location_ids' => json_encode([Location::all()->random()->id, Location::all()->random()->id,]),
            'gender' => fake()->randomElement(['male', 'female', 'both']),
        ];
    }
}