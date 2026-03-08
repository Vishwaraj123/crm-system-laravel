<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'job_title' => fake()->jobTitle(),
            'address' => fake()->address(),
            'country' => fake()->country(),
            'status' => fake()->randomElement(['new', 'reached', 'interested', 'not interested']),
            'notes' => fake()->paragraph(),
            'source' => fake()->randomElement(['Website', 'Referral', 'Social Media', 'Ads']),
        ];
    }
}
