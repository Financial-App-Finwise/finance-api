<?php

namespace Database\Factories;
use App\Models\Category;
use App\Models\ParentCategory;
use Faker\Generator as Faker;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $type = $this->faker->randomElement(['Income', 'Expense']);
        // $parentID = $this->faker->boolean(50) ? Category::factory()->create()->id : null;
    
        // return [
        //     'userID' => User::factory(),
        //     'name' => $this->faker->$name,
        //     'type' => $type,
        //     'parentID' => $parentID,
        //     'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        //     'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        // ];

        $type = $this->faker->randomElement(['income', 'expense']);
        $parentCategory = ParentCategory::where('type', $type)->inRandomOrder()->first();

        if ($this->faker->boolean(50)) {
            // Generate a child category
            return [
                'userID' => User::factory(),
                'name' => $this->faker->unique()->word,
                'type' => $type,
                'parentID' => $parentCategory->id,
                'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            ];
        } else {
            // Generate a new parent category
            return [
                'userID' => User::factory(),
                'name' => $this->faker->unique()->word,
                'type' => $type,
                'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            ];
        }
    }
}