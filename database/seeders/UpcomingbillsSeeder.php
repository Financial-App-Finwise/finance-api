<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Upcomingbill;
use Illuminate\Support\Facades\DB;

class UpcomingbillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Normal manual insert seed
        $upcomingBills = [
            [
                'userID' => 1,
                'categoryID' => 15, // Replace with a valid category ID from your categories table
                'amount' => 100.00,
                'date' => '2024-02-01 12:00:00', // Replace with the desired date and time
                'name' => 'Electricity Bill',
                'note' => 'Monthly electricity bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 20, // Replace with another valid category ID
                'amount' => 50.00,
                'date' => '2024-04-20 10:00:00', // Replace with the desired date and time
                'name' => 'Internet Bill',
                'note' => 'Monthly internet bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 10, // Replace with another valid category ID
                'amount' => 50.00,
                'date' => '2024-01-20 10:00:00', // Replace with the desired date and time
                'name' => 'Internet Bill',
                'note' => 'Monthly internet bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 22, // Replace with another valid category ID
                'amount' => 15.00,
                'date' => '2024-02-25 10:00:00', // Replace with the desired date and time
                'name' => 'Spotify Bill',
                'note' => 'Yearly  Spotify bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 8, // Replace with another valid category ID
                'amount' => 5.00,
                'date' => '2024-12-13 10:00:00', // Replace with the desired date and time
                'name' => ' Youtube Bill',
                'note' => 'Monthly Youtube bill',
                'created_at' => '2024-01-22',
                'updated_at' => '2024-01-22',
            ],
            [
                'userID' => 1,
                'categoryID' => 5, // Replace with another valid category ID
                'amount' => 10.00,
                'date' => '2024-12-13 10:00:00', // Replace with the desired date and time
                'name' => null,
                'note' => null,
                'created_at' => '2024-02-12',
                'updated_at' => '2024-02-12',
            ],
            [
                'userID' => 1,
                'categoryID' => 5, // Replace with another valid category ID
                'amount' => 10.00,
                'date' => '2024-12-13 10:00:00', // Replace with the desired date and time
                'name' => null,
                'note' => "Borrow Money from friend",
                'created_at' => '2023-02-12',
                'updated_at' => '2023-02-12',
            ],
            [
                'userID' => 1,
                'categoryID' => 6, // Replace with another valid category ID
                'amount' => 15.00,
                'date' => '2024-2-25 10:00:00', // Replace with the desired date and time
                'name' => "Borrow Mom's Money",
                'note' => null,
                'created_at' => '2023-12-12',
                'updated_at' => '2023-12-12',
            ],
        ];
    
        // Insert data into the upcoming_bills table
        DB::table('upcoming_bills')->insert($upcomingBills);
    }
    
}

//Insert many random for faster seed
        // $upcomingBills = [];

        // for ($i = 1; $i <= 15; $i++) {
        //     $upcomingBills[] = [
        //         'userID' => 1,
        //         'categoryID' => $i, // Replace with valid category IDs from categories table
        //         'amount' => rand(50, 200), // Generate a random amount
        //         'date' => now()->addDays($i), // Set the date to be i days from now
        //         'name' => "Bill $i",
        //         'note' => "Monthly bill number $i",
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }