<?php
namespace App\Http\Controllers;
use App\Http\Requests\V1\UpdateUserRequest;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Authentication routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
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

// // Route to get all users
Route::get('/users', [Api\V1\UserController::class, 'index']);
// // Route to get a specific user by ID
Route::get('/users/{user}', [Api\V1\UserController::class, 'show']);
// Route to create a new user
Route::post('/users', [Api\V1\UserController::class, 'store']);
// Route to update a user by ID
Route::put('/users/{user}', [Api\V1\UserController::class, 'update']);
Route::patch('/users/{user}', [Api\V1\UserController::class, 'update']);

// Route to get all categories
Route::get('/categories', [Api\V1\CategoryController::class, 'index']);
// Route to get a specific categories by ID
Route::get('/categories/{category}', [Api\V1\CategoryController::class, 'show']);
// Route to create a new category
Route::post('/categories', [Api\V1\CategoryController::class, 'store']);
// Route to update a category by ID
Route::put('/categories/{category}', [Api\V1\CategoryController::class, 'update']);
Route::patch('/categories/{category}', [Api\V1\CategoryController::class, 'update']);

// Route to get all upcomingbills
Route::get('/upcomingbills', [Api\V1\UpcomingbillController::class, 'index']);
// Route to get a specific upcomingbill by ID
Route::get('/upcomingbills/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'show']);
// Route to create a new upcomingbill
Route::post('/upcomingbills', [Api\V1\UpcomingbillController::class, 'store']);
// Route to update a upcomingbill by ID
Route::put('/upcomingbills/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'update']);
Route::patch('/upcomingbills/{upcomingbill}', [Api\V1\UpcomingbillController::class, 'update']);

// Route to get all goals
Route::get('/goals', [Api\V1\GoalController::class, 'index']);
// Route to get a specific goal by ID
Route::get('/goals/{goal}', [Api\V1\GoalController::class, 'show']);
// Route to create a new goal
Route::post('/goals', [Api\V1\GoalController::class, 'store']);
// Route to update a goal by ID
Route::put('/goals/{goal}', [Api\V1\GoalController::class, 'update']);
Route::patch('/goals/{goal}', [Api\V1\GoalController::class, 'update']);

