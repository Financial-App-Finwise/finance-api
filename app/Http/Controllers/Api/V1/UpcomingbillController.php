<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUpcomingbillRequest;
use App\Http\Requests\V1\UpdateUpcomingbillRequest;

use App\Models\Upcomingbill;
use App\Http\Resources\V1\UpcomingbillResource;
use App\Http\Resources\V1\UpcomingbillCollection;

class UpcomingbillController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(){

        //Logic to paginate the store data 
        return new UpcomingbillCollection(Upcomingbill::paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logic to get a specific upcomingbill by ID
         $upcomingbill = Upcomingbill::find($id);
         return response()->json($upcomingbill);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpcomingbillRequest $request)
    {
        // Logic to create a new upcomingbill
        return new UpcomingbillResource(Upcomingbill::create($request->all()));
        //return response()->json(['message' => 'Upcomingbill created successfully']);
    }
    /**
     * Display the specified resource.
     */
    public function show(Upcomingbill $upcomingbill)
    {
        // Logic to get a specific upcomingbill by ID
        return response()->json($upcomingbill);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Upcomingbill $upcomingbill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUpcomingbillRequest $request, Upcomingbill $upcomingbill)
    {
        // Logic to update a upcomingbill by ID
        $upcomingbill->update($request->all());
        return response()->json(['message' => 'Upcomingbill updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Upcomingbill $upcomingbill)
    {
        // Check if the authenticated user is the owner of the upcomingbill
        if ($user->id !== $upcomingbill->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
            }
            // Logic to delete a upcomingbill by ID
            $upcomingbill->delete();
        // Logic to delete a upcomingbill by ID
        return response()->json(['message' => 'Upcomingbill deleted successfully']);
    }
}