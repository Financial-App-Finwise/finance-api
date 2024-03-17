<?php
namespace App\Http\Controllers;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserOnboardingInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This file contains API routes for various functionalities, organized into
| several route groups for authentication, user management, financial
| operations, predictions, goals, transactions, categories, etc.
|
*/

// Authentication Routes (Does not require Bearer Token)
Route::group(['prefix' => 'auth'], function () {
    // User registration
    Route::post('/register', [AuthController::class, 'register']);

    // Email verification
    Route::post('/verify-email', [AuthController::class, 'verifyEmail']);

    // User login
    Route::post('/login', [AuthController::class, 'login']);

    // Request code for password reset
    Route::get('/forgot-password-code', [AuthController::class, 'forgotPasswordCode']);

    // Reset password
    Route::post('/forgot-password-reset', [AuthController::class, 'forgotPasswordReset']);
});

// User Routes
Route::group(['prefix' => 'users'], function () {
    // Get all users
    Route::get('/', [Api\V1\UserController::class, 'index']);

    // Get specific user
    Route::get('/{user}', [Api\V1\UserController::class, 'show']);
    // Create a new user

    Route::post('/', [Api\V1\UserController::class, 'store']);
    // Update user
    Route::put('/{user}', [Api\V1\UserController::class, 'update']);
    Route::patch('/{user}', [Api\V1\UserController::class, 'update']);

    // Delete user
    Route::delete('/{user}', [Api\V1\UserController::class, 'destroy']);
});

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    // Additional Authentication Routes
    Route::group(['prefix' => 'auth'], function () {
        // Logout user
        Route::post('/logout', [AuthController::class, 'logout']);

        // Reset user password
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    });

    // Budget Plan Routes
    Route::group(['prefix' => 'budgetplans'], function () {
        // Get summary of budget plans for a specific year
        Route::get('/summary/{year}', [Api\V1\BudgetPlanController::class, 'show_summary']);

        // Get budget plans for a specific year and month
        Route::get('/{year}/{month}', [Api\V1\BudgetPlanController::class, 'index']);

        // Get a specific budget plan
        Route::get('/{budgetplan}', [Api\V1\BudgetPlanController::class, 'show']);

        // Create a new budget plan
        Route::post('/', [Api\V1\BudgetPlanController::class, 'store']);

        // Delete a specific budget plan
        Route::delete('/{budgetplan}', [Api\V1\BudgetPlanController::class, 'destroy']);

        // Update a specific budget plan
        Route::put('/{budgetplan}', [Api\V1\BudgetPlanController::class, 'update']);
        Route::patch('/{budgetplan}', [Api\V1\BudgetPlanController::class, 'update']);
    });

    // My Finance Routes
    Route::group(['prefix' => 'myfinances'], function () {
        // Get user's finance details
        Route::get('/view-my-finance/', [Api\V1\MyFinanceController::class, 'show']);

        // Create new finance record
        Route::post('/', [Api\V1\MyFinanceController::class, 'create']);

        // View available currencies
        Route::get('/currency', [Api\V1\MyFinanceController::class, 'show_currency']);

        // Update user's net worth
        Route::put('/update-net-worth', [Api\V1\MyFinanceController::class, 'update']);
        Route::patch('/update-net-worth', [Api\V1\MyFinanceController::class, 'update']);
    });

    // User Onboarding Info Routes
    Route::group(['prefix' => 'onboardinginfo'], function () {
        // Get user onboarding info
        Route::get('/', [Api\V1\UserOnboardingInfoController::class, 'show']);

        // Create user onboarding info
        Route::post('/create', [Api\V1\UserOnboardingInfoController::class, 'create']);

        // Update user onboarding info
        Route::put('/', [Api\V1\UserOnboardingInfoController::class, 'update']);
        Route::patch('/', [Api\V1\UserOnboardingInfoController::class, 'update']);

        Route::delete('/{id}', [UserOnboardingInfoController::class, 'destroy']);
    });

    // Prediction Routes
    Route::group(['prefix' => 'predictions'], function () {
        // Get predictions
        Route::get('/', [Api\V1\PredictionController::class, 'show']);

        // Store a new prediction
        Route::post('/', [Api\V1\PredictionController::class, 'store']);

        // Update predictions
        Route::put('/', [Api\V1\PredictionController::class, 'update']);
        Route::patch('/', [Api\V1\PredictionController::class, 'update']);

        // Delete predictions
        Route::delete('/', [Api\V1\PredictionController::class, 'destroy']);
    });

    // Upcoming Bills Routes
    Route::group(['prefix' => 'upcomingbills'], function () {
        // Get all upcoming bills
        Route::get('/', [Api\V1\UpcomingbillController::class, 'index']);

        // Get a specific upcoming bill
        Route::get('/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'show']);

        // Store a new upcoming bill
        Route::post('/', [Api\V1\UpcomingbillController::class, 'store']);

        // Update a specific upcoming bill
        Route::put('/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'update']);
        Route::patch('/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'update']);

        // Delete a specific upcoming bill
        Route::delete('/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'destroy']);
    });

    // Goal Routes
    Route::group(['prefix' => 'goals'], function () {
        // Get all goals
        Route::get('/', [Api\V1\GoalController::class, 'index']);

        // Get a specific goal
        Route::get('/{goal}', [Api\V1\GoalController::class, 'show']);

        // Get transactions related to a specific goal
        Route::get('/{goal}/transactions', [Api\V1\GoalController::class, 'show']);

        // Create a new goal
        Route::post('/', [Api\V1\GoalController::class, 'store']);

        // Update a specific goal
        Route::put('/{goal}', [Api\V1\GoalController::class, 'update']);
        Route::patch('/{goal}', [Api\V1\GoalController::class, 'update']);

        // Delete a specific goal
        Route::delete('/{goal}', [Api\V1\GoalController::class, 'destroy']);
    });

    // Transaction Routes
    Route::group(['prefix' => 'transactions'], function () {
         // Get all transactions
        Route::get('/', [Api\V1\TransactionController::class, 'index']);

        // Get a specific transaction
        Route::get('/{transaction}', [Api\V1\TransactionController::class, 'show']);

        // Store a new transaction
        Route::post('/', [Api\V1\TransactionController::class, 'store']);

        // Update a specific transaction
        Route::put('/{transaction}', [Api\V1\TransactionController::class, 'update']);
        Route::patch('/{transaction}', [Api\V1\TransactionController::class, 'update']);

        // Delete a specific transaction
        Route::delete('/{transaction}', [Api\V1\TransactionController::class, 'destroy']);
    });

    // Transaction Goals Routes
    Route::group(['prefix' => 'transaction_goals'], function () {
        // Get all transactions goals
        Route::get('/', [Api\V1\TransactionGoalController::class, 'index']);

        // Get a specific transaction goals
        Route::get('/{transaction_goals}', [Api\V1\TransactionGoalController::class, 'show']);

        // Store a new transaction goals
        Route::post('/', [Api\V1\TransactionGoalController::class, 'store']);

        // Update a specific transaction goals
        Route::put('/{transaction_goals}', [Api\V1\TransactionGoalController::class, 'update']);
        Route::patch('/{transaction_goals}', [Api\V1\TransactionGoalController::class, 'update']);

        // Delete a specific transaction goals
        Route::delete('/{transaction_goals}', [Api\V1\TransactionGoalController::class, 'destroy']);
    });

    // Category Routes
    Route::group(['prefix' => 'categories'], function () {
        // Get all categories
        Route::get('/', [Api\V1\CategoryController::class, 'index']);

        // Get a specific category
        Route::get('/{category}', [Api\V1\CategoryController::class, 'show']);

        // Store a new category
        Route::post('/', [Api\V1\CategoryController::class, 'store']);

        // Update a specific category
        Route::put('/{category}', [Api\V1\CategoryController::class, 'update']);
        Route::patch('/{category}', [Api\V1\CategoryController::class, 'update']);

        // Delete a specific category
        Route::delete('/{category}', [Api\V1\CategoryController::class, 'destroy']);
    });
}); 

// Reject any random requests
Route::any('{any}', function () {
    return response()->json(
        [
            "errors" => [
                'status' => 404,
                'message' => 'Route not found'
            ]
        ],
        404
    );
})->where('any', '.*');