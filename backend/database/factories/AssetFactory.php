<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'code' => 'AST-' . $this->faker->unique()->numberBetween(1000, 9999),
            'category_id' => \App\Models\AssetCategory::factory(),
            'location_id' => \App\Models\Location::factory(),
            'status' => 'active',
        ];
    }
}
