<?php

namespace Database\Factories;

use App\Models\Company;
use Database\Enums\States;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $states = States::cases();
        $state = $states[array_rand($states)];
        return [
            'company_id' => Company::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'street_1' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => $state->value,
            'first_level_division' => $state->firstLevelDivision()->value
        ];
    }
}
