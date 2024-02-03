<?php

namespace Database\Factories;
use App\Models\Goal;
use App\Models\User;
use Faker\Generator as Faker;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BudgetPlan>
 */
class BudgetPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'userID' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'categoryID' => $this->faker->numberBetween(1, 5),
            'isMonthly' => $this->faker->boolean,
            'name' => $this->faker->word,
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
