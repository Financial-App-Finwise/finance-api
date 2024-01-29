<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goals = [
            [
                'userID' => 1,
                'name' => 'New Room Decoration',
                'amount' => 150.00,
                'currentSave' => 50.00,
                'remainingSave' => 100.00,
                'setDates' => true,
                'startDate' => '2024-1-01',
                'endDate' => '2024-2-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'name' => 'Vietnam Trip',
                'amount' => 500.00,
                'currentSave' => 50.00,
                'remainingSave' => 450.00,
                'setDates' => true,
                'startDate' => '2024-5-01',
                'endDate' => '2024-8-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 1,
                'name' => 'Car',
                'amount' => 25000.00,
                'currentSave' => 500.00,
                'remainingSave' => 24500.00,
                'setDates' => true,
                'startDate' => '2024-1-01',
                'endDate' => '2030-5-01',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            
            // 'userID' => 1,
            // 'name' => 'Vacation',
            // 'amount' => 2000.00,
            // 'currentSave' => 500.00,
            // 'remainingSave' => 1500.00,
            // 'setDates' => true,
            // 'startDate' => '2023-01-01',
            // 'endDate' => '2023-12-31',
            // 'created_at' => now(),
            // 'updated_at' => now(),
        ];
        // Insert data into the goals table
        DB::table('goals')->insert($goals);
    }
}

