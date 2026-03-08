<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'birthday' => fake()->date('Y-m-d', '-20 years'),
            'birthplace' => fake()->city(),
            'gender' => fake()->randomElement(['men', 'women']),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'department' => fake()->jobTitle(),
            'position' => fake()->jobTitle(),
            'address' => fake()->streetAddress(),
            'state' => fake()->state(),
        ];
    }
}
