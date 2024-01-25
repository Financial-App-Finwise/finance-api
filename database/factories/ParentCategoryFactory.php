<?php

namespace Database\Factories;
use App\Models\ParentCategory;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParentCategory>
 */
class ParentCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $type = $this->faker->randomElement(['income', 'expense']);

        // return [
        //     'userID' => User::factory(),
        //     'name' => $this->faker->unique()->word,
        //     'type' => $type,
        //     'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        //     'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        // ];
    }
}

