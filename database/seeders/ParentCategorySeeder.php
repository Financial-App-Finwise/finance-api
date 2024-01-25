<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParentCategory;
use Illuminate\Support\Facades\DB;

class ParentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('parent_categories')->insert([
        //     ['name' => 'Entertainment'],
        //     ['name' => 'Business'],
        //     // Add more parent categories as needed
        // ]);
         // Insert predefined parent categories
         DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Food and Beverage',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Transportation',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Education',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Gifts & Donations',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Insurance',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Other Expense',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Investment',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Outgoing Transfer',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Pay Interest',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Bill and Utilities',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Shopping',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Family',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Health & Fitness',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Entertainment',
            'type' => 'expense', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //Parent Income Categories
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Salary',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Interest',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Investment',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Capital Gains',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Government Payments',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Rental Income',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Royalities',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Active Income',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Business Income',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Comissions',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Dividends',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parent_categories')->insert([
            'userID' => 1, 
            'name' => 'Food and Beverage',
            'type' => 'income', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
