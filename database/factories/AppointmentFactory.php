<?php

namespace Database\Factories;

use Database\Enums\MeetingTypes;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'user_id' => User::factory(),
            'start' => fake()->datetime(),
            'end' => fake()->datetime(),
            'title' => fake()->catchPhrase(),
            'description' => fake()->text(),
            'type' => fake()->randomElement(array_column(MeetingTypes::cases(), 'value'))
        ];
    }
}
