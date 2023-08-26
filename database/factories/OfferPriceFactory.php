<?php

namespace Database\Factories;

use App\Models\Provider;
use App\Models\RequestService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OfferPrice>
 */
class OfferPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'process_type' => $this->faker->sentence,
            'duration' => '1 day',
            'price' => '200',
            'status' => 'pending',
            'provider_id' => Provider::get()->random()->id,
            'request_service_id' => RequestService::get()->random()->id
        ];
    }
}
