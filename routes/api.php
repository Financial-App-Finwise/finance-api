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
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Authentication routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('/login', [AuthController::class, 'login']);

    // These routes do not require authentication middleware
    Route::get('/forgot-password-code', [AuthController::class, 'forgotPasswordCode']);
    Route::post('/forgot-password-reset', [AuthController::class, 'forgotPasswordReset']);
});

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    });

    Route::group(['prefix' => 'budgetplans'], function () {
        Route::get('/summary/{year}', [Api\V1\BudgetPlanController::class, 'show_summary']);
        Route::get('/{year}/{month}', [Api\V1\BudgetPlanController::class, 'index']);
        Route::get('/{budgetplan}', [Api\V1\BudgetPlanController::class, 'show']);
        Route::post('/', [Api\V1\BudgetPlanController::class, 'store']);
        Route::delete('/{budgetplan}', [Api\V1\BudgetPlanController::class, 'destroy']);
        Route::put('/{budgetplan}', [Api\V1\BudgetPlanController::class, 'update']);
        Route::patch('/{budgetplan}', [Api\V1\BudgetPlanController::class, 'update']);
    });
    Route::group(['prefix' => 'myfinances'], function () {
        Route::get('/view-my-finance/', [Api\V1\MyFinanceController::class, 'show']);
        Route::post('/', [Api\V1\MyFinanceController::class, 'create']);
        Route::get('/currency', [Api\V1\MyFinanceController::class, 'show_currency']);
        Route::put('/update-net-worth', [Api\V1\MyFinanceController::class, 'update']);
        Route::patch('/update-net-worth', [Api\V1\MyFinanceController::class, 'update']);
    });

    Route::group(['prefix' => 'onboardinginfo'], function () {
        Route::get('/', [Api\V1\UserOnboardingInfoController::class, 'index']);
        Route::post('/', [Api\V1\UserOnboardingInfoController::class, 'store']);
        Route::put('/', [Api\V1\UserOnboardingInfoController::class, 'update']);
        Route::patch('/', [Api\V1\UserOnboardingInfoController::class, 'update']);
    });
}); 



Route::group(['prefix' => 'users'], function () {
    Route::get('/', [Api\V1\UserController::class, 'index']);
    Route::get('/{user}', [Api\V1\UserController::class, 'show']);
    Route::post('/', [Api\V1\UserController::class, 'store']);
    Route::put('/{user}', [Api\V1\UserController::class, 'update']);
    Route::patch('/{user}', [Api\V1\UserController::class, 'update']);
    Route::delete('/{user}', [Api\V1\UserController::class, 'destroy']);
});

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::group(['prefix' => 'upcomingbills'], function () {
        Route::get('/', [Api\V1\UpcomingbillController::class, 'index']);
        Route::get('/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'show']);
        Route::post('/', [Api\V1\UpcomingbillController::class, 'store']);
        Route::put('/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'update']);
        Route::patch('/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'update']);
        Route::delete('/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'destroy']);
    });

    Route::group(['prefix' => 'goals'], function () {
        Route::get('/', [Api\V1\GoalController::class, 'index']);
        Route::get('/{goal}', [Api\V1\GoalController::class, 'show']);
        Route::post('/', [Api\V1\GoalController::class, 'store']);
        Route::put('/{goal}', [Api\V1\GoalController::class, 'update']);
        Route::patch('/{goal}', [Api\V1\GoalController::class, 'update']);
        Route::delete('/{goal}', [Api\V1\GoalController::class, 'destroy']);
    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', [Api\V1\TransactionController::class, 'index']);
        Route::get('/{transaction}', [Api\V1\TransactionController::class, 'show']);
        Route::post('/', [Api\V1\TransactionController::class, 'store']);
        Route::put('/{transaction}', [Api\V1\TransactionController::class, 'update']);
        Route::patch('/{transaction}', [Api\V1\TransactionController::class, 'update']);
        Route::delete('/{transaction}', [Api\V1\TransactionController::class, 'destroy']);
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [Api\V1\CategoryController::class, 'index']);
        Route::get('/{category}', [Api\V1\CategoryController::class, 'show']);
        Route::post('/', [Api\V1\CategoryController::class, 'store']);
        Route::put('/{category}', [Api\V1\CategoryController::class, 'update']);
        Route::patch('/{category}', [Api\V1\CategoryController::class, 'update']);
        Route::delete('/{category}', [Api\V1\CategoryController::class, 'destroy']);
    });
}); 

// Reject any random requests
// Route::any('{any}', function () {
//     return response()->json(
//         [
//             "errors" => [
//                 'status' => 404,
//                 'message' => 'Route not found'
//             ]
//         ],
//         404
//     );
// })->where('any', '.*');


// // Route to get all users
 //Route::get('/users', [UserController::class, 'index']);

// // Route to update a user by ID
// Route::put('/users/{id}', [UserController::class, 'update']);

// // Route to delete a user by ID
// Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Route::group(['prefix'=>'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function(){
//     Route::apiResource('users', UserController::class);
// });