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
        // Parent Categories
        $parentCategory1 = Category::create([
            'userID' => 1,
            'name' => 'Food and Beverage',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);

        $parentCategory2 = Category::create([
            'userID' => 1,
            'name' => 'Transportation',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory3 = Category::create([
            'userID' => 1,
            'name' => 'Education',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory4 = Category::create([
            'userID' => 1,
            'name' => 'Gifts & Donations',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        // Child Categories
        $childCategory5 = Category::create([
            'userID' => 1,
            'name' => 'Insurance',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null,
        ]);
        $parentCategory6 = Category::create([
            'userID' => 1,
            'name' => 'Other Expense',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory7 = Category::create([
            'userID' => 1,
            'name' => 'Investment',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory8 = Category::create([
            'userID' => 1,
            'name' => 'Outgoing Transfer',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory9 = Category::create([
            'userID' => 1,
            'name' => 'Pay Interest',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory10 = Category::create([
            'userID' => 1,
            'name' => 'Bill & Utilities',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory11 = Category::create([
            'userID' => 1,
            'name' => 'Shopping',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory12 = Category::create([
            'userID' => 1,
            'name' => 'Family',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory13 = Category::create([
            'userID' => 1,
            'name' => 'Health & Fitness',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory14 = Category::create([
            'userID' => 1,
            'name' => 'Entertainment',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);

        //Child category for Bill & Utilities
        $childCategory1 = Category::create([
            'userID' => 1,
            'name' => 'Rentals',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory2 = Category::create([
            'userID' => 1,
            'name' => 'Water Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory3 = Category::create([
            'userID' => 1,
            'name' => 'Phone Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory4 = Category::create([
            'userID' => 1,
            'name' => 'Electricity Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory5 = Category::create([
            'userID' => 1,
            'name' => 'Gas Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory6 = Category::create([
            'userID' => 1,
            'name' => 'Television Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory7 = Category::create([
            'userID' => 1,
            'name' => 'Internet Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory8 = Category::create([
            'userID' => 1,
            'name' => 'Other Utility Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);

        //Child Categories for Shopping
        $childCategory9 = Category::create([
            'userID' => 1,
            'name' => 'Personal Items',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory11->id,
        ]);
        $childCategory10 = Category::create([
            'userID' => 1,
            'name' => 'Houseware',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory11->id,
        ]);
        $childCategory11 = Category::create([
            'userID' => 1,
            'name' => 'Makeup',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory11->id,
        ]);
        // Child Categories for Family
        $childCategory12 = Category::create([
            'userID' => 1,
            'name' => 'Home Maintenance',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory12->id,
        ]);
        $childCategory13 = Category::create([
            'userID' => 1,
            'name' => 'Home Services',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory12->id,
        ]);
        $childCategory14 = Category::create([
            'userID' => 1,
            'name' => 'Pets',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory12->id,
        ]);
        //Child Categories for Health & Fitness
        $childCategory15 = Category::create([
            'userID' => 1,
            'name' => 'Medical Check-up',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory13->id,
        ]);
        $childCategory16 = Category::create([
            'userID' => 1,
            'name' => 'Fitness',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory13->id,
        ]);
        //Child Categories for Entertainment
        $childCategory17 = Category::create([
            'userID' => 1,
            'name' => 'Streaming Service',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory14->id,
        ]);
        $childCategory18 = Category::create([
            'userID' => 1,
            'name' => 'Fun Money',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory14->id,
        ]);

        //Parent Categories for Income
        $parentCategory15 = Category::create([
            'userID' => 1,
            'name' => 'Salary',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory16 = Category::create([
            'userID' => 1,
            'name' => 'Interest',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory17 = Category::create([
            'userID' => 1,
            'name' => 'Investment',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory18 = Category::create([
            'userID' => 1,
            'name' => 'Capital Gains',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory19 = Category::create([
            'userID' => 1,
            'name' => 'Government Payments',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory20 = Category::create([
            'userID' => 1,
            'name' => 'Rental Income',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory21 = Category::create([
            'userID' => 1,
            'name' => 'Royalities',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory22 = Category::create([
            'userID' => 1,
            'name' => 'Active Income',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory23 = Category::create([
            'userID' => 1,
            'name' => 'Business Income',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory24 = Category::create([
            'userID' => 1,
            'name' => 'Comissions',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory25 = Category::create([
            'userID' => 1,
            'name' => 'Dividends',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);

        // Onboarding Category for Parent
        $onboardingparentCategory1 = Category::create([
            'userID' => 1,
            'name' => 'Housing',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]);  
        $onboardingparentCategory2 = Category::create([
            'userID' => 1,
            'name' => 'Transportation',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory3 = Category::create([
            'userID' => 1,
            'name' => 'Food',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory4 = Category::create([
            'userID' => 1,
            'name' => 'Utilities',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory5 = Category::create([
            'userID' => 1,
            'name' => 'Clothing',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory6 = Category::create([
            'userID' => 1,
            'name' => 'Medical/Healthcare',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory7 = Category::create([
            'userID' => 1,
            'name' => 'Insurance',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory8 = Category::create([
            'userID' => 1,
            'name' => 'Household Items',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory9 = Category::create([
            'userID' => 1,
            'name' => 'Personal',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory10 = Category::create([
            'userID' => 1,
            'name' => 'Debt',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory11 = Category::create([
            'userID' => 1,
            'name' => 'Retirement',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory12 = Category::create([
            'userID' => 1,
            'name' => 'Education',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory13 = Category::create([
            'userID' => 1,
            'name' => 'Gift/Donations',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory14 = Category::create([
            'userID' => 1,
            'name' => 'Entertainment',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory15 = Category::create([
            'userID' => 1,
            'name' => 'None of all above',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 

        //Child Categories for Onboarding Parent Housing
        $onboardingchildCategory1 = Category::create([
            'userID' => 1,
            'name' => 'Mortage or rent',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);
        $onboardingchildCategory2 = Category::create([
            'userID' => 1,
            'name' => 'Property taxes',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);
        $onboardingchildCategory3 = Category::create([
            'userID' => 1,
            'name' => 'Household repairs',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);
        $onboardingchildCategory4 = Category::create([
            'userID' => 1,
            'name' => 'HOA fees',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);
        $onboardingchildCategory5 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);

        //Child Categories for Onboarding Parent Transportation

        $onboardingchildCategory6 = Category::create([
            'userID' => 1,
            'name' => 'Car Payment',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory7 = Category::create([
            'userID' => 1,
            'name' => 'Car Warranty',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory8 = Category::create([
            'userID' => 1,
            'name' => 'Gas',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory9 = Category::create([
            'userID' => 1,
            'name' => 'Tires',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory10 = Category::create([
            'userID' => 1,
            'name' => 'Maintenances and oil changes',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory11 = Category::create([
            'userID' => 1,
            'name' => 'Parking fees',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory12 = Category::create([
            'userID' => 1,
            'name' => 'Repairs',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory13 = Category::create([
            'userID' => 1,
            'name' => 'Registration and DMV fees',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory14 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);

        //Child Categories for Onboarding Parent Food

        $onboardingchildCategory15 = Category::create([
            'userID' => 1,
            'name' => 'Groceries',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory3->id,
        ]);
        $onboardingchildCategory16 = Category::create([
            'userID' => 1,
            'name' => 'Restaurants',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory3->id,
        ]);
        $onboardingchildCategory17 = Category::create([
            'userID' => 1,
            'name' => 'Pet Food',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory3->id,
        ]);
        $onboardingchildCategory18 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory3->id,
        ]);

        //Child Categories for Onboarding Parent Utilities

        $onboardingchildCategory19 = Category::create([
            'userID' => 1,
            'name' => 'Electricity',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory20 = Category::create([
            'userID' => 1,
            'name' => 'Water',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory21 = Category::create([
            'userID' => 1,
            'name' => 'Garbage',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory22 = Category::create([
            'userID' => 1,
            'name' => 'Phones',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory23 = Category::create([
            'userID' => 1,
            'name' => 'Cable',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory24 = Category::create([
            'userID' => 1,
            'name' => 'Internet',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory25 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);

        //Child Categories for Onboarding Parent Clothing

        $onboardingchildCategory26 = Category::create([
            'userID' => 1,
            'name' => 'Adult Clothing',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);
        $onboardingchildCategory27 = Category::create([
            'userID' => 1,
            'name' => 'Adult Shoes',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);
        $onboardingchildCategory28 = Category::create([
            'userID' => 1,
            'name' => 'Children Clothing',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);
        $onboardingchildCategory29 = Category::create([
            'userID' => 1,
            'name' => 'Children Shoes',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);
        $onboardingchildCategory30 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);

         //Child Categories for Onboarding Parent Medical/Healthcare
         $onboardingchildCategory31 = Category::create([
            'userID' => 1,
            'name' => 'Primary Care',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory32 = Category::create([
            'userID' => 1,
            'name' => 'Dental Care',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory33 = Category::create([
            'userID' => 1,
            'name' => 'Specialty Care',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory34 = Category::create([
            'userID' => 1,
            'name' => 'Urgent Care',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory35 = Category::create([
            'userID' => 1,
            'name' => 'Medication',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory36 = Category::create([
            'userID' => 1,
            'name' => 'Medical devices',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory37 = Category::create([
            'userID' => 1,
            'name' => 'Adult Others',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);

        //Child Categories for Onboarding Parent Insurance

        $onboardingchildCategory38 = Category::create([
            'userID' => 1,
            'name' => 'Health Insurance',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory39 = Category::create([
            'userID' => 1,
            'name' => 'Home warranty',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory40 = Category::create([
            'userID' => 1,
            'name' => 'Auto insurance',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory41 = Category::create([
            'userID' => 1,
            'name' => 'Life insurnacne',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory42 = Category::create([
            'userID' => 1,
            'name' => 'Disablities insurance',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory43 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);

        //Child Onbarding Categories for Household Items
        $onboardingchildCategory44 = Category::create([
            'userID' => 1,
            'name' => 'Toiletries',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory45 = Category::create([
            'userID' => 1,
            'name' => 'Laundry detergent',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory46 = Category::create([
            'userID' => 1,
            'name' => 'Dishwasher detergent',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory47 = Category::create([
            'userID' => 1,
            'name' => 'Cleaning Supplies',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory48 = Category::create([
            'userID' => 1,
            'name' => 'Tools',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory49 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);

        //Child Onboarding Categories for Parent Personal
        $onboardingchildCategory50 = Category::create([
            'userID' => 1,
            'name' => 'Gym memberships',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory51 = Category::create([
            'userID' => 1,
            'name' => 'Haircuts',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory52 = Category::create([
            'userID' => 1,
            'name' => 'Salon Services',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory53 = Category::create([
            'userID' => 1,
            'name' => 'Cosmetics',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory54 = Category::create([
            'userID' => 1,
            'name' => 'Babysitter',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory55 = Category::create([
            'userID' => 1,
            'name' => 'Subscriptions',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory56 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);

        //Child Onbaording Categories for parent Debt
        $onboardingchildCategory57 = Category::create([
            'userID' => 1,
            'name' => 'Personal loans',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory10->id,
        ]);
        $onboardingchildCategory58 = Category::create([
            'userID' => 1,
            'name' => 'Student loans',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory10->id,
        ]);
        $onboardingchildCategory59 = Category::create([
            'userID' => 1,
            'name' => 'Credit cards',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory10->id,
        ]);
        $onboardingchildCategory60 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory10->id,
        ]);
        
        //Child Categories for Parent Retirement
        $onboardingchildCategory61 = Category::create([
            'userID' => 1,
            'name' => 'Financial Planning',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory11->id,
        ]);
        $onboardingchildCategory62 = Category::create([
            'userID' => 1,
            'name' => 'Investing',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory11->id,
        ]);
        $onboardingchildCategory63 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory11->id,
        ]);

        //Child Onboarding Categories for Parent Education
        $onboardingchildCategory64 = Category::create([
            'userID' => 1,
            'name' => 'My College',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory12->id,
        ]);
        $onboardingchildCategory65 = Category::create([
            'userID' => 1,
            'name' => 'Books',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory12->id,
        ]);
        $onboardingchildCategory66 = Category::create([
            'userID' => 1,
            'name' => 'School Supplies',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory12->id,
        ]);
        $onboardingchildCategory67 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory12->id,
        ]);

        //Child Onboarding Categories for Parent Gift & Donations
        $onboardingchildCategory68 = Category::create([
            'userID' => 1,
            'name' => 'Emergency fund',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory69 = Category::create([
            'userID' => 1,
            'name' => 'Anniversary',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory70 = Category::create([
            'userID' => 1,
            'name' => 'Wedding',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory71 = Category::create([
            'userID' => 1,
            'name' => 'Christmas',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory72 = Category::create([
            'userID' => 1,
            'name' => 'Special Occasion',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory73 = Category::create([
            'userID' => 1,
            'name' => 'Charities',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory74 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);

        //Child Onboarding categories for Parent Entertainment
        $onboardingchildCategory75 = Category::create([
            'userID' => 1,
            'name' => 'Alcohol',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory76 = Category::create([
            'userID' => 1,
            'name' => 'Games',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory77 = Category::create([
            'userID' => 1,
            'name' => 'Movies',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory77 = Category::create([
            'userID' => 1,
            'name' => 'Movies',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory78 = Category::create([
            'userID' => 1,
            'name' => 'Concerts',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory79 = Category::create([
            'userID' => 1,
            'name' => 'Vacation',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory80 = Category::create([
            'userID' => 1,
            'name' => 'Subscriptions',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory81 = Category::create([
            'userID' => 1,
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);

    }
}


