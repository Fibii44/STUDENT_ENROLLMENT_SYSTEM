<?php

namespace Database\Factories;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
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
            'email' => $this->faker->unique()->safeEmail,
            'age' => $this->faker->numberBetween(18, 25),
            'year' => $this->faker->randomElement(['1', '2', '3', '4']),
            'course' => $this->faker->randomElement(['BSCS', 'BSIT', 'BSIS', 'BSECE', 'BSCE']),
            'address' => $this->faker->address,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
