<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Currency;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition()
    {
        $code = $this->faker->currencyCode;

        return [
            'code' => $code,
            'name' => $this->getCurrencyName($code),
        ];
    }

    private function getCurrencyName($code)
    {
        switch ($code) {
            case 'USD':
                return 'United States Dollar';
            case 'EUR':
                return 'Euro';
            case 'GBP':
                return 'British Pound Sterling';
            case 'JPY':
                return 'Japanese Yen';
            case 'AUD':
                return 'Australian Dollar';
            case 'CAD':
                return 'Canadian Dollar';
            case 'CHF':
                return 'Swiss Franc';
            case 'CNY':
                return 'Chinese Yuan';
            case 'INR':
                return 'Indian Rupee';
            case 'MXN':
                return 'Mexican Peso';
            default:
                return $this->faker->word;
        }
    }
}
