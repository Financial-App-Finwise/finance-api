<?php

namespace Database\Factories;
use App\Models\Goal;
use App\Models\User;
use Faker\Generator as Faker;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goal>
 */
class GoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $setDates = $this->faker->randomElement([true, false]);
        return [
            'userID' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'name' => $this->faker->word,
            'amount' => $amount = $this->faker->numberBetween(100, 10000),
            'currentSave' => $currentSave = $this->faker->numberBetween(5, $amount),
            'remainingSave' => $this->faker->numberBetween(5, $currentSave),       
            'start_date' => $setDates ? $this->faker->dateTimeThisDecade() : null,
            'end_date' => $setDates ? $this->faker->dateTimeThisDecade() : null,
            'setDates' => $setDates,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
