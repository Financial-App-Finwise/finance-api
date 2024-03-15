<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Category;
use App\Models\Goal;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'userID' => User::factory(),
            'parentID' => Category::factory(), // Assuming you have a parentID column in your transactions table
            'categoryID' => Category::factory(),
            'goalID' => function () {
                return Goal::factory()->create()->id;
            },
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'date' => $this->faker->date(),
            'note' => $this->faker->text,
            'type' => $this->faker->randomElement(['Income', 'Expense']),
            'contributionAmount' => function (array $attributes) {
                return $attributes['type'] === 'Income' ? $this->faker->randomFloat(2, 0, 500) : null;
            },
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
