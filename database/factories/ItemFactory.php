<?php

namespace Database\Factories;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory()->create()->id,
            'name' => fake()->sentence(rand(1, 3)),
            'description' =>  fake()->sentence(),
            'price' => rand(1, 100)
        ];
    }
}
