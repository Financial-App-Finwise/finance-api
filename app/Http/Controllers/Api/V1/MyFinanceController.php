<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\V1\StoreMyFinanceRequest;
use App\Http\Requests\V1\UpdateMyFinanceRequest;

use App\Models\MyFinance;
use App\Models\Currency;
use App\Http\Resources\V1\MyFinanceResource;
use App\Http\Resources\V1\MyFinanceCollection;
use App\Http\Resources\V1\CurrencyResource;
use App\Http\Resources\V1\CurrencyCollection;
use Carbon\Carbon;

class MyFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    { 
        // get user id
        $user = auth()->user();

        $myfinance = MyFinance::where('userID', $user->id)
            // ->where('your_column_name', $filter)
            ->with('currency')
            ->get();

        return response()->json(['success'=> 'true', 'data' => MyFinanceResource::collection($myfinance)]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show_currency()
    {
        // Retrieve all currencies
        $currencies = Currency::all();

        return response()->json(['success'=> 'true', 'data' => CurrencyResource::collection($currencies)]);
    }

        /**
     * Show the form for creating a new resource.
     */
    public function create(StoreMyFinanceRequest $request)
    {
        # get user id from jwt token
        $user = auth()->user();

        // # add user id to the request
        $request->merge(['userID' => $user->id]);

        return response()->json(['success' => 'true', 'data' => new MyFinanceResource(MyFinance::create($request->all()))]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMyFinanceRequest $request, MyFinance $myfinance)
    {
        // Validate the request data
        $user = auth()->user();
        $data = $request->validated();

        try {
            $myfinance->where('userID', $user->id)->update(['totalbalance' => $data['totalbalance']]);

            $updatedMyFinance = MyFinance::where('userID', $user->id)
            // ->where('your_column_name', $filter)
            ->with('currency')
            ->get();

        } catch (Exception $e) {
            return response()->json(['success'=> 'false', 'message' => 'Failed to update Net Worth'], 500);
        }

        return response()->json(['success'=> 'true', 'message' => 'Net Worth updated successfully', 'data' => MyFinanceResource::collection($updatedMyFinance)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
