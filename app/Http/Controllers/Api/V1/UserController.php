<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Models\User;

use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\UserCollection;

use App\Filters\V1\UserFilter;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //test query
    public function index(Request $request)
    {
        $filter = new UserFilter();
        $filterItems = $filter->transform($request); //[['column', 'operator', 'value']]

        //include related data 
        $includeCategory = $request->query('includeCategory');
        $includeUpcomingbill = $request->query('includeUpcomingbill');
        $includeGoal = $request->query('includeGoal');

        $user = User::where($filterItems);

        if ($includeCategory) {
            $user = $user->with('categories');
        }
        if ($includeUpcomingbill) {
            $user = $user->with('upcoming_bills');
        }
        if ($includeGoal) {
            $user = $user->with('goals');
        }
        return new UserCollection($user->paginate()->appends($request->query()));

    }
    //return new UserCollection(User::where($queryItems)->paginate());

    // public function index(){
    //     // Logic to get all users
    //     //return User::all(); 

    //     //Logic to store data in collection
    //     //return new UserCollection(User::all());

    //     //Logic to paginate the store data 
    //     return new UserCollection(User::paginate());

    // }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     // Logic to get a specific user by ID
    //      $user = User::find($id);
    //      return response()->json($user);
    //     //return $user = User::find($id);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Logic to create a new user
        return new UserResource(User::create($request->all()));
        //return response()->json(['message' => 'User created successfully']);
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $includeCategory = request()->query('includeCategory');
        $includeUpcomingbill = request()->query('includeUpcomingbill');
        $includeGoal = request()->query('includeGoal');
        $loadData = [];

        if ($includeCategory) {
            $loadData[] = 'categories';
        }
        if ($includeUpcomingbill) {
            $loadData[] = 'upcoming_bills';
        }
        if ($includeGoal) {
            $loadData[] = 'goals';
        }

        $user->loadMissing($loadData);

        // Filter goals based on startDate[gte] parameter

        // if ($includeGoal && request()->has('startDate.gte')) {
        //     $startDateGte = request()->input('startDate.gte');
        //     $goals = $user->goals()->where('startDate', '>=', $startDateGte)->get();
        //     $user->setRelation('goals', $goals);
        // }

        // Filter goals based on startDate[gte] parameter
        if ($includeGoal && request()->has('startDate.gte')) {
            $startDateGte = request()->input('startDate.gte');
            //\Log::info('Goals Query: ' . $user->goals()->where('startDate', '>=', $startDateGte)->toSql());
            $goals = $user->goals()->where('startDate', '>=', $startDateGte)->get();
            $user->setRelation('goals', $goals);
        }

        // Initialize meta array
        $meta = [];

        // Count the number of categories if requested
        if ($includeCategory) {
            $meta['categoryCount'] = $user->categories->count();
        }

        // Count the number of goals if requested
        if ($includeGoal) {
            $meta['totalSmartGoal'] = $user->goals->count();
        }
        if ($includeUpcomingbill) {
            $meta['totalUpcomingbill'] = $user->upcoming_bills->count();
        }
        // Return JSON response with user data and optionally category and goal counts
        return (new UserResource($user))->additional([
            'meta' => $meta,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(User $user)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Logic to update a user by ID
        $user->update($request->all());
        return response()->json(['message' => 'User updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Logic to delete a user by ID
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}