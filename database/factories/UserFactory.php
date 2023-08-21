<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'               => $this->faker->name,
            'country_code' => '966',
            'email'              => $this->faker->unique()->safeEmail,
            'phone'              => $this->faker->unique()->numberBetween(12356,9999999),
            'image' => $this->faker->image('public/storage/images/users',640,480, null, false),
            'is_blocked'              => rand(0,1),
            'active'             => rand(0,1),
        ];
    }
}
