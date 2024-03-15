<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;
use App\Models\UpcomingBill;


class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // public function toArray(Request $request): array
    // {
    //     $this->load('upcomingBill.category', 'budgetPlan.category');
    //     return[
    //         'id' => $this->id,
    //         'userID' => $this->userID,
    //         'category' => [
    //             'id' => $this->category->id,
    //             'name' => $this->category->name,
    //             'isIncome' => $this->category->isIncome,
    //             'parentCategory' => $this->category->parentCategory ? [
    //                 'id' => $this->category->parentCategory->id,
    //                 'name' => $this->category->parentCategory->name,
    //                 'isIncome' => $this->category->parentCategory->isIncome,
    //                 'parentID' => $this->category->parentCategory->parentID,
    //             ] : null,
    //         ],
    //         'isIncome' => $this->isIncome,
    //         'amount' => (float)$this->amount,
    //         'hasContributed' => $this->hasContributed,
    //         'upcomingBill' => $this->upcomingBill ? [
    //             'id' => $this->upcomingBill->id,
    //             'categoryID' => $this->upcomingBill->categoryID,
    //             'category' => [
    //                 'id' => $this->upcomingBill->category->id,
    //                 'name' => $this->upcomingBill->category->name,
    //                 'isIncome' => $this->upcomingBill->category->isIncome,
    //                 'parentCategory' => $this->upcomingBill->category->parentCategory ? [
    //                     'id' => $this->upcomingBill->category->parentCategory->id,
    //                     'name' => $this->upcomingBill->category->parentCategory->name,
    //                 ] : null,
    //                 ],
    //             'amount' => (float) $this->upcomingBill->amount,
    //             'date' => $this->upcomingBill->date,
    //             'name' => $this->upcomingBill->name,
    //             'note' => $this->upcomingBill->note,
    //             'status' => $this->upcomingBill->status,
    //         ] : null,
    //         'budgetPlan' => $this->budgetplan ? [
    //             'id' => $this->budgetplan->id,
    //             'category' => [
    //                 'id' => $this->budgetplan->category->id,
    //                 'name' => $this->budgetplan->category->name,
    //                 'isIncome' => $this->budgetplan->category->isIncome,
    //                 'parentCategory' => $this->budgetplan->category->parentCategory ? [
    //                     'id' => $this->budgetplan->category->parentCategory->id,
    //                     'name' => $this->budgetplan->category->parentCategory->name,
    //                 ] : null,
    //             ],
    //             'isMonthly' => $this->budgetPlan->isMonthly,
    //             'name' => $this->budgetPlan->name,
    //             'amount' => (float) $this->budgetPlan->amount,
    //             'date' => $this->budgetPlan->date,
    //             'isRecurring' => $this->budgetPlan->isRecurring,
    //         ] : null,
    //         'expenseType' => $this->expenseType,
    //         'date' => $this->date,
    //         'note' => $this->note,
    //         ];
    // }
    public function toArray($request)
    {
        $this->load('upcomingBill.category', 'budgetPlan.category');

        $category = $this->category ? [
            'id' => $this->category->id,
            'name' => $this->category->name,
            'isIncome' => $this->category->isIncome,
            'parentCategory' => $this->category->parentCategory ? [
                'id' => $this->category->parentCategory->id,
                'name' => $this->category->parentCategory->name,
                'isIncome' => $this->category->parentCategory->isIncome,
                'parentID' => $this->category->parentCategory->parentID,
            ] : null,
        ] : null;

        $upcomingBill = $this->upcomingBill ? [
            'id' => $this->upcomingBill->id,
            'categoryID' => $this->upcomingBill->categoryID,
            'category' => $this->upcomingBill->category ? [
                'id' => $this->upcomingBill->category->id,
                'name' => $this->upcomingBill->category->name,
                'isIncome' => $this->upcomingBill->category->isIncome,
                'parentCategory' => $this->upcomingBill->category->parentCategory ? [
                    'id' => $this->upcomingBill->category->parentCategory->id,
                    'name' => $this->upcomingBill->category->parentCategory->name,
                ] : null,
            ] : null,
            'amount' => (float) $this->upcomingBill->amount,
            'date' => $this->upcomingBill->date,
            'name' => $this->upcomingBill->name,
            'note' => $this->upcomingBill->note,
            'status' => $this->upcomingBill->status,
        ] : null;

        $budgetPlan = $this->budgetPlan ? [
            'id' => $this->budgetPlan->id,
            'category' => $this->budgetPlan->category ? [
                'id' => $this->budgetPlan->category->id,
                'name' => $this->budgetPlan->category->name,
                'isIncome' => $this->budgetPlan->category->isIncome,
                'parentCategory' => $this->budgetPlan->category->parentCategory ? [
                    'id' => $this->budgetPlan->category->parentCategory->id,
                    'name' => $this->budgetPlan->category->parentCategory->name,
                ] : null,
            ] : null,
            'isMonthly' => $this->budgetPlan->isMonthly,
            'name' => $this->budgetPlan->name,
            'amount' => (float) $this->budgetPlan->amount,
            'date' => $this->budgetPlan->date,
            'isRecurring' => $this->budgetPlan->isRecurring,
        ] : null;

        return [
            'id' => $this->id,
            'userID' => $this->userID,
            'category' => $category,
            'isIncome' => $this->isIncome,
            'amount' => (float) $this->amount,
            'hasContributed' => $this->hasContributed,
            'upcomingBill' => $upcomingBill,
            'budgetPlan' => $budgetPlan,
            'expenseType' => $this->expenseType,
            'date' => $this->date,
            'note' => $this->note,
        ];
    }
}

            