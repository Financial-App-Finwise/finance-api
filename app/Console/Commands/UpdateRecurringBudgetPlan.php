<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateRecurringBudgetPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'budgetplans:update-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the date attribute for recurring budget plans.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = Carbon::now();
        $budgetPlans = BudgetPlan::where('isRecurring', true)->get();

        foreach ($budgetPlans as $budgetPlan) {
            // Check if the current date is after the budget plan's date
            if (Carbon::now()->greaterThanOrEqualTo($budgetPlan->date)) {
                // Increment the date to next month while preserving the day
                $budgetPlan->date = $budgetPlan->date->addMonthNoOverflow();
                $budgetPlan->save();
            }
        }
        $this->info('Recurring budget plan dates updated successfully.');
    }
}
