<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'image' => 'default.png',
            'phone' => $this->faker->unique()->numberBetween(111111111,999999999),
            'country_code' => $this->faker->numberBetween(1,100),
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
            'description' => $this->faker->text(500),
            'bank_account' => $this->faker->numberBetween(1000,10000),
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'map_desc' => $this->faker->address,
            'level_experience' => $this->faker->name,
            'active' => random_int(0,1),
            'is_notify' => random_int(0,1),
            'is_approved' => random_int(0,1),
            'is_blocked' => random_int(0,1),
            'created_at' => now(),
        ];
    }
}
