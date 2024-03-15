<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TransactionGoal;
use Illuminate\Support\Facades\DB;

class TransactionGoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'userID' => 1,
                'transactionID' => 1,
                'goalID' => 1,
                'ContributionAmount' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'transactionID' => 2,
                'goalID' => 2,
                'ContributionAmount' => 200.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        // Insert data into the transaction_goals table
        DB::table('transaction_goals')->insert($data);
    }
}
