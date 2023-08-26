<?php

namespace Database\Factories;

use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RequestService>
 */
class RequestServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'details' => $this->faker->sentence,
            'min_price' => '10',
            'max_price' => '30',
            'duration' => '3 days',
            'images' => 'images',
            'price' => '100',
            'tax_value' => '10',
            'user_id' => User::get()->random()->id,
            'service_id' => Service::get()->random()->id,
            'provider_id' => Provider::get()->random()->id
        ];
    }
}
