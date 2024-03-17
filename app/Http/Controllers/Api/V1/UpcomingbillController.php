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
use Carbon\Carbon;


class UpcomingbillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $user = auth()->user();
    //     $upcomingbill = UpcomingBill::where('userID', $user->id);
    //     $filter = new UpcomingBillFilter();
    //     $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

    //     if (count($queryItems) == 0){
    //         return new UpcomingbillCollection(UpcomingBill::paginate());
    //     } else{ 

    //         $upcomingbill = UpcomingBill::where($queryItems)->paginate();

    //         return new UpcomingbillCollection($upcomingbill->appends($request->query()));
    //     }
    // }
    //$upcomingbill = UpcomingBill::where($queryItems)->paginate();


    // public function index(Request $request)
    // {
    //     $user = auth()->user();

    //     $filter = new UpcomingBillFilter();
    //     $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

    //     $query = UpcomingBill::where('userID', $user->id);

    //     // Apply filters from the query parameters
    //     foreach ($queryItems as $item) {
    //         $query->where($item[0], $item[1], $item[2]);
    //     }
    //     // Filter by specific month and year if provided
    //     $month = $request->input('month');
    //     $year = $request->input('year');
    //     if ($month && $year) {
    //         $query->whereMonth('date', '=', date('m', strtotime($month)))
    //             ->whereYear('date', '=', $year);
    //     }
    //     // Filter by status (paid and unpaid)
    //     $status = $request->input('status');
    //     if ($status) {
    //         $query->where('status', $status);
    //     }
    //     // Sort by date
    //     $dateSort = $request->input('date');
    //     if ($dateSort === 'desc') {
    //         $query->orderBy('date', 'desc');
    //     } else {
    //         $query->orderBy('date', 'asc');
    //     }

    //     //Filter group by Year->Month
    //     $year = $request->get('year');
    //     $month = $request->get('month');
    //     if ($year) {
    //         $startDate = Carbon::createFromFormat('Y', $year)->startOfYear();
    //         $endDate = Carbon::createFromFormat('Y', $year)->endOfYear();
    //         $query->whereBetween('date', [$startDate, $endDate]);

    //         $upcomingbillsByMonth = $query->get()->groupBy(function ($upcomingbill) {
    //             return Carbon::parse($upcomingbill->date)->format('F');
    //         });

    //         if ($month) {
    //             $upcomingbillsForMonth = $upcomingbillsByMonth->get($month, collect());
    //             return [
    //                 'Total Upcomingbill' => $upcomingbillsForMonth->count(),
    //                 'upcomingbills' => $upcomingbillsForMonth,
    //             ];
    //         }

    //         $months = collect();
    //         for ($i = 1; $i <= 12; $i++) {
    //             $monthName = Carbon::createFromFormat('m', $i)->format('F');
    //             $upcomingbillsForMonth = $upcomingbillsByMonth->get($monthName, collect());
    //             $months->put($monthName, ['Number of upcomingbills' => $upcomingbillsForMonth->count()]);
    //         }

    //         return $months;
    //     }

    //     // Fetch total count of upcoming bills
    //     $totalCount = $query->count();

    //     // Fetch paginated upcoming bills
    //     $upcomingbills = $query->orderBy('date', 'asc')->paginate();

    //     return response()->json([
    //         'totalUpcomingBills' => $totalCount,
    //         'upcomingBills' => new UpcomingBillCollection($upcomingbills->appends($request->query())),
    //         'links' => [
    //             'first' => $upcomingbills->url(1),
    //             'last' => $upcomingbills->url($upcomingbills->lastPage()),
    //             'prev' => $upcomingbills->previousPageUrl(),
    //             'next' => $upcomingbills->nextPageUrl(),
    //         ]
    //     ]);
    // }
    //return new UpcomingbillCollection($upcomingbills->appends($request->query()));


    public function index(Request $request)
    {
        $user = auth()->user();

        $filter = new UpcomingBillFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

        $query = UpcomingBill::where('userID', $user->id);

        // Apply filters from the query parameters
        foreach ($queryItems as $item) {
            $query->where($item[0], $item[1], $item[2]);
        }

        // Filter by specific month and year if provided
        $month = $request->input('month');
        $year = $request->input('year');
        if ($month && $year) {
            $query->whereMonth('date', '=', date('m', strtotime($month)))
                ->whereYear('date', '=', $year);
        }

        // Filter by status (paid and unpaid)
        $status = $request->input('status');
        if ($status) {
            $query->where('status', $status);
        }

        // Sort by date
        $dateSort = $request->input('date');
        if ($dateSort === 'desc') {
            $query->orderBy('date', 'desc');
        } else {
            $query->orderBy('date', 'asc');
        }

        // Filter by this month, next month, next 6 months, this year, and next year
        $filter = $request->input('filter');
        if ($filter) {
            $now = Carbon::now();
            switch ($filter) {
                case 'this month':
                    $query->whereYear('date', $now->year)
                        ->whereMonth('date', $now->month);
                    break;
                case 'next month':
                    $query->whereYear('date', $now->copy()->addMonth()->year)
                        ->whereMonth('date', $now->copy()->addMonth()->month);
                    break;
                case 'next 6 months':
                    $query->whereBetween('date', [$now->copy(), $now->copy()->addMonths(6)]);
                    break;
                case 'this year':
                    $query->whereYear('date', $now->year);
                    break;
                case 'next year':
                    $query->whereYear('date', $now->copy()->addYear()->year);
                    break;
            }
        }
        // Fetch total count of upcoming bills
        $totalCount = $query->count();

        // Fetch paginated upcoming bills
        $upcomingbills = $query->paginate();

        // Calculate totals for different time frames
        $thisMonthTotal = $this->getTotalForMonth(now()->month, now()->year);
        $nextMonthTotal = $this->getTotalForMonth(now()->addMonth()->month, now()->addMonth()->year);
        $next6MonthsTotal = $this->getTotalForNextMonths(6);
        $thisYearTotal = $this->getTotalForYear(now()->year);
        $nextYearTotal = $this->getTotalForYear(now()->addYear()->year);

        return response()->json([
            'totalUpcomingBills' => $totalCount,
            'upcomingBills' => new UpcomingBillCollection($upcomingbills->appends($request->query())),
            'totals' => [
                'thisMonth' => $thisMonthTotal,
                'nextMonth' => $nextMonthTotal,
                'next6Months' => $next6MonthsTotal,
                'thisYear' => $thisYearTotal,
                'nextYear' => $nextYearTotal,
            ],
            'links' => [
                'first' => $upcomingbills->url(1),
                'last' => $upcomingbills->url($upcomingbills->lastPage()),
                'prev' => $upcomingbills->previousPageUrl(),
                'next' => $upcomingbills->nextPageUrl(),
            ]
        ]);
    }

    // Helper functions to calculate total upcoming bills for different time frames
    protected function getTotalForMonth($month, $year)
    {
        return UpcomingBill::whereMonth('date', $month)->whereYear('date', $year)->count();
    }

    protected function getTotalForNextMonths($months)
    {
        return UpcomingBill::whereBetween('date', [now()->startOfMonth(), now()->addMonths($months)->endOfMonth()])->count();
    }

    protected function getTotalForYear($year)
    {
        return UpcomingBill::whereYear('date', $year)->count();
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
