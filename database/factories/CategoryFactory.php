<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category2>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => [
                'en' => $this->faker->name,
                'ar' => $this->faker->name
            ],
            'slug' => Str::slug($this->faker->name),
            'image' => 'default.png',
            'parent_id' => rand(1,2)
        ];
    }
}
