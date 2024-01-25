<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Child Categories Expense
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Rentals',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 10, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Water Bill',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 10, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Phone Bill',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 10, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Electricity Bill',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 10, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Gas Bill',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Television Bill',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 10, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Internet Bill',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 10, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Other Utility Bill',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 10, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Personal Items',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 11,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Houseware',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 11, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Makeup',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 11, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Home Maintenance',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 12, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Home Services',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 12, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Pets',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 12, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Medical Check-up',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 13, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Fitness',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 13, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categories')->insert([
            'userID' => 1, 
            'name' => 'Streaming Service',
            'type' => 'expense', // or 'income' based on your needs
            'parentID' => 14, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // $entertainmentCategoryId = DB::table('categories')->where('name', 'Entertainment')->value('id');
        // DB::table('categories')->insert([
        //     'userID' => 1, 
        //     'name' => 'Fun Money',
        //     'type' => 'expense', // or 'income' based on your needs
        //     'user_defined_name' => null,
        //     'parent_id' => $entertainmentCategoryId, // ID of the Parent Category 1
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}

// class CategorySeeder extends Seeder
// {
//     public function run()
//     {
//         // Insert predefined parent categories
//         DB::table('categories')->insert([
//             'user_id' => 1, // Set the user ID as needed
//             'name' => 'Parent Category 1',
//             'type' => 'expense', // or 'income' based on your needs
//             'user_defined_name' => null,
//             'parent_id' => null,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);

//         // Insert predefined child categories under Parent Category 1
//         DB::table('categories')->insert([
//             'user_id' => 1, // Set the user ID as needed
//             'name' => 'Child Category 1',
//             'type' => 'expense', // or 'income' based on your needs
//             'user_defined_name' => null,
//             'parent_id' => 1, // ID of the Parent Category 1
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);

//         // Add more entries as needed for other categories

//         // You can also use the CategoryFactory to create additional random categories
//         \App\Models\Category::factory()->count(10)->create();
//     }
// }

