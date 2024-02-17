<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['code' => 'KHR', 'name' => 'Cambodian Riel'],
            ['code' => 'USD', 'name' => 'United States Dollar'],
            ['code' => 'CNY', 'name' => 'Chinese Yuan'],
            ['code' => 'EUR', 'name' => 'Euro'],
            ['code' => 'GBP', 'name' => 'British Pound Sterling'],
            ['code' => 'JPY', 'name' => 'Japanese Yen'],
            ['code' => 'AUD', 'name' => 'Australian Dollar'],
            ['code' => 'CAD', 'name' => 'Canadian Dollar'],
            ['code' => 'CHF', 'name' => 'Swiss Franc'],
            ['code' => 'INR', 'name' => 'Indian Rupee'],
            // Add more entries as needed
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
