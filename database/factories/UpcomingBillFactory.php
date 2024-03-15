<?php

namespace Database\Factories;
use App\Models\UpcomingBill;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UpcomingBill>
 */
class UpcomingBillFactory extends Factory
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
            'categoryID' => function () {
                return \App\Models\Category::factory()->create()->id;
            },
            'amount' => $this->faker->randomFloat(2, 10, 1000), 
            'date' => $this->faker->date(),
            'name' => $this->faker->word, 
            'note' => $this->faker->text,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
