<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'en' => $this->faker->name,
                'ar' => Str::slug($this->faker->name)
            ],
            'slug' => Str::slug($this->faker->name),
            'status' => rand(0,1),
            'category_id' => Category::whereNotNull('parent_id')->get()->random()->id
        ];
    }
}
