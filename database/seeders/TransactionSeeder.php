<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = [
            [
                'userID' => 1,
                'categoryID' => 10, 
                'isIncome' => 0,
                'amount' => 50.00,
                'hasContributed' => 0,
                'upcomingbillID' => 5,
                'budgetplanID' => null,
                'expenseType' => 'Upcoming Bill',
                'date' => '2024-02-01 12:00:00',
                'note' => 'Bought groceries',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 4, 
                'isIncome' => 0,
                'amount' => 200.00,
                'hasContributed' => 0,
                'upcomingbillID' => 2,
                'budgetplanID' => null,
                'expenseType' => 'Upcoming Bill',
                'date' => '2024-02-10 09:30:00',
                'note' => 'Received payment for freelance work',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 5, 
                'isIncome' => 0,
                'amount' => 30.00,
                'hasContributed' => 0,
                'upcomingbillID' => 1,
                'budgetplanID' => null,
                'expenseType' => 'Upcoming Bill',
                'date' => '2024-02-15 14:45:00',
                'note' => 'Dinner at a restaurant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 6, 
                'isIncome' => 1,
                'amount' => 100.00,
                'hasContributed' => 0,
                'upcomingbillID' => null,
                'budgetplanID' => null,
                'expenseType' => 'General',
                'date' => '2024-02-20 18:00:00',
                'note' => 'Shopping for clothes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 7, 
                'isIncome' => 0,
                'amount' => 500.00,
                'hasContributed' => 0,
                'upcomingbillID' => 1,
                'budgetplanID' => null,
                'expenseType' => 'Upcoming Bill',
                'date' => '2024-02-25 11:00:00',
                'note' => 'Electricity Bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 8, 
                'isIncome' => 0,
                'amount' => 80.00,
                'hasContributed' => 0,
                'upcomingbillID' => null,
                'budgetplanID' => null,
                'expenseType' => 'General',
                'date' => '2024-03-05 10:30:00',
                'note' => 'Gas refill for car',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 9, 
                'isIncome' => 0,
                'amount' => 25.00,
                'hasContributed' => 0,
                'upcomingbillID' => null,
                'budgetplanID' => null,
                'expenseType' => 'General',
                'date' => '2024-03-10 15:00:00',
                'note' => 'Movie tickets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 10, 
                'isIncome' => 1,
                'amount' => 300.00,
                'hasContributed' => 0,
                'upcomingbillID' => null,
                'budgetplanID' => null,
                'expenseType' => 'General',
                'date' => '2024-03-15 08:00:00',
                'note' => 'Received bonus from employer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 11, 
                'isIncome' => 0,
                'amount' => 40.00,
                'hasContributed' => 0,
                'upcomingbillID' => 2,
                'budgetplanID' => null,
                'expenseType' => 'Upcoming Bill',
                'date' => '2024-03-20 12:30:00',
                'note' => 'Internet Bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 12, 
                'isIncome' => 0,
                'amount' => 75.00,
                'hasContributed' => 0,
                'upcomingbillID' => null,
                'budgetplanID' => null,
                'expenseType' => 'General',
                'date' => '2024-03-25 17:00:00',
                'note' => 'Home utilities payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'categoryID' => 13, 
                'isIncome' => 0,
                'amount' => 150.00,
                'hasContributed' => 0,
                'upcomingbillID' => 4,
                'budgetplanID' => null,
                'expenseType' => 'Upcoming Bill',
                'date' => '2024-04-01 09:00:00',
                'note' => 'Spotify Bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data into the transactions table
        DB::table('transactions')->insert($transactions);
    }
}

