<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUpcomingbillRequest;
use App\Http\Requests\V1\UpdateUpcomingbillRequest;

use App\Models\User;
use App\Models\UpcomingBill;
use App\Http\Resources\V1\UpcomingbillResource;
use App\Http\Resources\V1\UpcomingbillCollection;

use App\Filters\V1\UpcomingBillFilter;

class UpcomingbillController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $user = auth()->user();

        $filter = new UpcomingBillFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

        if (count($queryItems) == 0) {
            return new UpcomingbillCollection(UpcomingBill::where('userID', $user->id)->orderBy('date', 'desc')->paginate());
        } else {
            $query = UpcomingBill::where('userID', $user->id);

            foreach ($queryItems as $item) {
                $query->where($item[0], $item[1], $item[2]);
            }

            $upcomingbill = $query->orderBy('date', 'desc')->paginate();

            //$upcomingbill = UpcomingBill::where($queryItems)->paginate();

            return new UpcomingbillCollection($upcomingbill->appends($request->query()));
        }
    }


    // public function index(){

    //     //Logic to paginate the store data 
    //     return new UpcomingbillCollection(UpcomingBill::paginate());
    // }

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
        // Logic to create a new upcomingbill 1st draft
        //return new UpcomingbillResource(Upcomingbill::create($request->all()));
        //return response()->json(['message' => 'Upcomingbill created successfully']);
        try {
            // Get user id from jwt token
            $user = auth()->user();

            // Add user id to the request
            $request->merge(['userID' => $user->id]);

            // Validate the incoming request
            $validatedData = $request->validated();

            $validatedData['userID'] = $user->id;

            // Create a new upcomingbill instance
            $upcomingbill = new UpcomingBill();

            // Populate the upcomingbill attributes with validated data
            $upcomingbill->fill($validatedData);

            // Save the upcomingbill to the database
            $upcomingbill->save();

            return new UpcomingbillResource($upcomingbill);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
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
        // $upcomingbill->update($request->all());
        // return response()->json(['message' => 'Upcomingbill updated successfully']);
        // Check if the model is retrieved successfully
        if (!$upcomingbill) {
            return response()->json(['error' => 'Upcomingbill not found'], 404);
        }

        # add user id to the request
        $user = auth()->user();
        # check if the budget plan belongs to the user
        if ($upcomingbill->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this Upcomingbill'], 403);
        }

        // Logic to update a upcomingbill by ID
        try {
            $validatedData = $request->validated();
            $upcomingbill->update($validatedData);
        } catch (Exception $e) {
            return response()->json(['success' => 'false', 'message' => 'Failed to update Upcomingbill'], 500);
        }

        return response()->json(['success' => 'true', 'message' => 'Upcomingbill updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Upcomingbill $upcomingbill)
    {
        $user = auth()->user();
        // Check if the authenticated user is the owner of the upcomingbill
        if ($upcomingbill->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this upcomingbill'], 403);
        }
        // Logic to delete a upcomingbill by ID
        $upcomingbill->delete();
        // Logic to delete a upcomingbill by ID
        return response()->json(['success' => 'true', 'message' => 'Upcomingbill deleted successfully']);
    }
}
