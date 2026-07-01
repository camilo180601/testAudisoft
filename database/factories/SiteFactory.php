<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Site>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'url' => fake()->url(),
            'category_id' => Category::factory(),
        ];
    }
}
