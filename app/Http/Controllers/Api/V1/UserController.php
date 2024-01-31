<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Models\User;

use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\UserCollection;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    //      // Logic to get all users
    //      $users = User::all();
    //      return response()->json($users);
    // }
    public function index(){
        // Logic to get all users
        //return User::all(); 

        //Logic to store data in collection
        //return new UserCollection(User::all());

        //Logic to paginate the store data 
        return new UserCollection(User::paginate());

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logic to get a specific user by ID
         $user = User::find($id);
         return response()->json($user);
        //return $user = User::find($id);
    }

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
        // Logic to get a specific user by ID
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

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
        return response()->json(['message' => 'User deleted successfully']);
    }
}