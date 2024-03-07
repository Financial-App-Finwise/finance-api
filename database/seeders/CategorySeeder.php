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
            'name' => 'Food and Beverage',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);

        $parentCategory2 = Category::create([
            'name' => 'Transportation',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory3 = Category::create([
            'name' => 'Education',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory4 = Category::create([
            'name' => 'Gifts & Donations',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        // Child Categories
        $childCategory5 = Category::create([
            'name' => 'Insurance',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null,
        ]);
        $parentCategory6 = Category::create([
            'name' => 'Other Expense',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory7 = Category::create([
            'name' => 'Investment',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory8 = Category::create([
            'name' => 'Outgoing Transfer',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory9 = Category::create([
            'name' => 'Pay Interest',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory10 = Category::create([
            'name' => 'Bill & Utilities',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory11 = Category::create([
            'name' => 'Shopping',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory12 = Category::create([
            'name' => 'Family',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory13 = Category::create([
            'name' => 'Health & Fitness',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory14 = Category::create([
            'name' => 'Entertainment',
            'level' => 2,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Parent categories have null parentID
        ]);

        //Child category for Bill & Utilities
        $childCategory1 = Category::create([
            'name' => 'Rentals',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory2 = Category::create([
            'name' => 'Water Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory3 = Category::create([
            'name' => 'Phone Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory4 = Category::create([
            'name' => 'Electricity Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory5 = Category::create([
            'name' => 'Gas Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory6 = Category::create([
            'name' => 'Television Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory7 = Category::create([
            'name' => 'Internet Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);
        $childCategory8 = Category::create([
            'name' => 'Other Utility Bill',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory10->id,
        ]);

        //Child Categories for Shopping
        $childCategory9 = Category::create([
            'name' => 'Personal Items',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory11->id,
        ]);
        $childCategory10 = Category::create([
            'name' => 'Houseware',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory11->id,
        ]);
        $childCategory11 = Category::create([
            'name' => 'Makeup',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory11->id,
        ]);
        // Child Categories for Family
        $childCategory12 = Category::create([
            'name' => 'Home Maintenance',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory12->id,
        ]);
        $childCategory13 = Category::create([
            'name' => 'Home Services',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory12->id,
        ]);
        $childCategory14 = Category::create([
            'name' => 'Pets',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory12->id,
        ]);
        //Child Categories for Health & Fitness
        $childCategory15 = Category::create([
            'name' => 'Medical Check-up',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory13->id,
        ]);
        $childCategory16 = Category::create([
            'name' => 'Fitness',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory13->id,
        ]);
        //Child Categories for Entertainment
        $childCategory17 = Category::create([
            'name' => 'Streaming Service',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory14->id,
        ]);
        $childCategory18 = Category::create([
            'name' => 'Fun Money',
            'level' => 1,
            'isOnboarding' => 0, // Not an onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $parentCategory14->id,
        ]);

        //Parent Categories for Income
        $parentCategory15 = Category::create([
            'name' => 'Salary',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory16 = Category::create([
            'name' => 'Interest',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory17 = Category::create([
            'name' => 'Investment',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory18 = Category::create([
            'name' => 'Capital Gains',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory19 = Category::create([
            'name' => 'Government Payments',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory20 = Category::create([
            'name' => 'Rental Income',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory21 = Category::create([
            'name' => 'Royalities',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory22 = Category::create([
            'name' => 'Active Income',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory23 = Category::create([
            'name' => 'Business Income',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory24 = Category::create([
            'name' => 'Comissions',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);
        $parentCategory25 = Category::create([
            'name' => 'Dividends',
            'level' => 2,
            'isOnboarding' => 0, // Is an onboarding category
            'isIncome' => 1, // Income category
            'parentID' => null, // Parent categories have null parentID
        ]);

        // Onboarding Category for Parent
        $onboardingparentCategory1 = Category::create([
            'name' => 'Housing',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]);  
        $onboardingparentCategory2 = Category::create([
            'name' => 'Transportation',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory3 = Category::create([
            'name' => 'Food',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory4 = Category::create([
            'name' => 'Utilities',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory5 = Category::create([
            'name' => 'Clothing',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory6 = Category::create([
            'name' => 'Medical/Healthcare',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory7 = Category::create([
            'name' => 'Insurance',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory8 = Category::create([
            'name' => 'Household Items',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory9 = Category::create([
            'name' => 'Personal',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory10 = Category::create([
            'name' => 'Debt',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory11 = Category::create([
            'name' => 'Retirement',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory12 = Category::create([
            'name' => 'Education',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory13 = Category::create([
            'name' => 'Gift/Donations',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory14 = Category::create([
            'name' => 'Entertainment',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 
        $onboardingparentCategory15 = Category::create([
            'name' => 'None of all above',
            'level' => 2,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => null, // Onboarding categories have null parentID
        ]); 

        //Child Categories for Onboarding Parent Housing
        $onboardingchildCategory1 = Category::create([
            'name' => 'Mortage or rent',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);
        $onboardingchildCategory2 = Category::create([
            'name' => 'Property taxes',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);
        $onboardingchildCategory3 = Category::create([
            'name' => 'Household repairs',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);
        $onboardingchildCategory4 = Category::create([
            'name' => 'HOA fees',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);
        $onboardingchildCategory5 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory1->id,
        ]);

        //Child Categories for Onboarding Parent Transportation

        $onboardingchildCategory6 = Category::create([
            'name' => 'Car Payment',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory7 = Category::create([
            'name' => 'Car Warranty',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory8 = Category::create([
            'name' => 'Gas',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory9 = Category::create([
            'name' => 'Tires',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory10 = Category::create([
            'name' => 'Maintenances and oil changes',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory11 = Category::create([
            'name' => 'Parking fees',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory12 = Category::create([
            'name' => 'Repairs',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory13 = Category::create([
            'name' => 'Registration and DMV fees',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);
        $onboardingchildCategory14 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory2->id,
        ]);

        //Child Categories for Onboarding Parent Food

        $onboardingchildCategory15 = Category::create([
            'name' => 'Groceries',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory3->id,
        ]);
        $onboardingchildCategory16 = Category::create([
            'name' => 'Restaurants',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory3->id,
        ]);
        $onboardingchildCategory17 = Category::create([
            'name' => 'Pet Food',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory3->id,
        ]);
        $onboardingchildCategory18 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory3->id,
        ]);

        //Child Categories for Onboarding Parent Utilities

        $onboardingchildCategory19 = Category::create([
            'name' => 'Electricity',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory20 = Category::create([
            'name' => 'Water',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory21 = Category::create([
            'name' => 'Garbage',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory22 = Category::create([
            'name' => 'Phones',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory23 = Category::create([
            'name' => 'Cable',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory24 = Category::create([
            'name' => 'Internet',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);
        $onboardingchildCategory25 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory4->id,
        ]);

        //Child Categories for Onboarding Parent Clothing

        $onboardingchildCategory26 = Category::create([
            'name' => 'Adult Clothing',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);
        $onboardingchildCategory27 = Category::create([
            'name' => 'Adult Shoes',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);
        $onboardingchildCategory28 = Category::create([
            'name' => 'Children Clothing',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);
        $onboardingchildCategory29 = Category::create([
            'name' => 'Children Shoes',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);
        $onboardingchildCategory30 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory5->id,
        ]);

         //Child Categories for Onboarding Parent Medical/Healthcare
         $onboardingchildCategory31 = Category::create([
            'name' => 'Primary Care',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory32 = Category::create([
            'name' => 'Dental Care',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory33 = Category::create([
            'name' => 'Specialty Care',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory34 = Category::create([
            'name' => 'Urgent Care',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory35 = Category::create([
            'name' => 'Medication',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory36 = Category::create([
            'name' => 'Medical devices',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);
        $onboardingchildCategory37 = Category::create([
            'name' => 'Adult Others',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory6->id,
        ]);

        //Child Categories for Onboarding Parent Insurance

        $onboardingchildCategory38 = Category::create([
            'name' => 'Health Insurance',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory39 = Category::create([
            'name' => 'Home warranty',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory40 = Category::create([
            'name' => 'Auto insurance',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory41 = Category::create([
            'name' => 'Life insurnacne',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory42 = Category::create([
            'name' => 'Disablities insurance',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);
        $onboardingchildCategory43 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory7->id,
        ]);

        //Child Onbarding Categories for Household Items
        $onboardingchildCategory44 = Category::create([
            'name' => 'Toiletries',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory45 = Category::create([
            'name' => 'Laundry detergent',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory46 = Category::create([
            'name' => 'Dishwasher detergent',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory47 = Category::create([
            'name' => 'Cleaning Supplies',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory48 = Category::create([
            'name' => 'Tools',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);
        $onboardingchildCategory49 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory8->id,
        ]);

        //Child Onboarding Categories for Parent Personal
        $onboardingchildCategory50 = Category::create([
            'name' => 'Gym memberships',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory51 = Category::create([
            'name' => 'Haircuts',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory52 = Category::create([
            'name' => 'Salon Services',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory53 = Category::create([
            'name' => 'Cosmetics',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory54 = Category::create([
            'name' => 'Babysitter',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory55 = Category::create([
            'name' => 'Subscriptions',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);
        $onboardingchildCategory56 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory9->id,
        ]);

        //Child Onbaording Categories for parent Debt
        $onboardingchildCategory57 = Category::create([
            'name' => 'Personal loans',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory10->id,
        ]);
        $onboardingchildCategory58 = Category::create([
            'name' => 'Student loans',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory10->id,
        ]);
        $onboardingchildCategory59 = Category::create([
            'name' => 'Credit cards',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory10->id,
        ]);
        $onboardingchildCategory60 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory10->id,
        ]);
        
        //Child Categories for Parent Retirement
        $onboardingchildCategory61 = Category::create([
            'name' => 'Financial Planning',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory11->id,
        ]);
        $onboardingchildCategory62 = Category::create([
            'name' => 'Investing',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory11->id,
        ]);
        $onboardingchildCategory63 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory11->id,
        ]);

        //Child Onboarding Categories for Parent Education
        $onboardingchildCategory64 = Category::create([
            'name' => 'My College',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory12->id,
        ]);
        $onboardingchildCategory65 = Category::create([
            'name' => 'Books',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory12->id,
        ]);
        $onboardingchildCategory66 = Category::create([
            'name' => 'School Supplies',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory12->id,
        ]);
        $onboardingchildCategory67 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory12->id,
        ]);

        //Child Onboarding Categories for Parent Gift & Donations
        $onboardingchildCategory68 = Category::create([
            'name' => 'Emergency fund',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory69 = Category::create([
            'name' => 'Anniversary',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory70 = Category::create([
            'name' => 'Wedding',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory71 = Category::create([
            'name' => 'Christmas',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory72 = Category::create([
            'name' => 'Special Occasion',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory73 = Category::create([
            'name' => 'Charities',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);
        $onboardingchildCategory74 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory13->id,
        ]);

        //Child Onboarding categories for Parent Entertainment
        $onboardingchildCategory75 = Category::create([
            'name' => 'Alcohol',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory76 = Category::create([
            'name' => 'Games',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory77 = Category::create([
            'name' => 'Movies',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory77 = Category::create([
            'name' => 'Movies',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory78 = Category::create([
            'name' => 'Concerts',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory79 = Category::create([
            'name' => 'Vacation',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory80 = Category::create([
            'name' => 'Subscriptions',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);
        $onboardingchildCategory81 = Category::create([
            'name' => 'Other',
            'level' => 1,
            'isOnboarding' => 1, // Onboarding category
            'isIncome' => 0, // Expense category
            'parentID' => $onboardingparentCategory14->id,
        ]);

    }
}


