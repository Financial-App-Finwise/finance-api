<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\V1\StoreCategoryRequest;
use App\Http\Requests\V1\UpdateCategoryRequest;
use App\Models\Category;

use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\CategoryCollection;

use App\Filters\V1\CategoryFilter;


class CategoryController extends Controller
{
    //     public function index(Request $request)
//     {
//         $user = auth()->user();
// Í   
//         $filter = new CategoryFilter();
//         $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]
//         $query = Category::where('userID', $user->id);


    //         if (count($queryItems) == 0){
//             return new CategoryCollection(Category::all());
//         } else{ 

    //             $category = Category::where($queryItems)->all();

    //             return new CategoryCollection($category->appends($request->query()));

    //         }
//     }
    public function index(Request $request)
    {
        $user = auth()->user();

        $filter = new CategoryFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

        //$query = Category::where('userID', $user->id);
        $query = Category::where('userID', $user->id)
            ->orWhereNull('userID')
            ->where('isOnboarding', 0);

        // Apply filters from the query parameters
        foreach ($queryItems as $item) {
            $query->where($item[0], $item[1], $item[2]);
        }

        $category = $query->get();

        //return new CategoryCollection($category->appends($request->query()));
        return new CategoryCollection($category);
    }
    //return new CategoryCollection(Category::where($queryItems)->paginate());

    //Normal index function but we don't need it
    // public function index(){
    //     //Logic to get all categories
    //     //return Category::all(); 

    //     //Logic to store data in collection
    //     //return new CategoryCollection(Category::all());

    //     //Logic to paginate the store data 
    //     return new CategoryCollection(Category::paginate());
    // }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     // Logic to get a specific category by ID
    //      $category = Category::find($id);
    //      return response()->json($category);
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreCategoryRequest $request)
    // {
    //     try {
    //         // Get user id from jwt token
    //         $user = auth()->user();

    //         // Add user id to the request
    //         $request->merge(['userID' => $user->id]);

    //         // Validate the incoming request
    //         $validatedData = $request->validated();

    //         $validatedData['userID'] = $user->id;

    //         $category = new Category();

    //         $category->fill($validatedData);

    //         $category->save();

    //         return new CategoryResource($category);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }
    public function store(StoreCategoryRequest $request)
    {
        try {
            // Get user id from jwt token
            $user = auth()->user();

            // Add user id to the request
            $request->merge(['userID' => $user->id]);

            // Validate the incoming request
            $validatedData = $request->validated();
            $validatedData['userID'] = $user->id;

            // Automatically set level based on parentID presence
            $validatedData['level'] = isset($validatedData['parentID']) ? 1 : 2;

            $category = new Category();

            $category->fill($validatedData);

            $category->save();

            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Logic to get a specific category by ID
        //return response()->json($category);

        //Another to write it
        return new CategoryResource($category);
    }


    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateCategoryRequest $request, Category $category)
    // {
    //     // Logic to update a category by ID
    //     $category->update($request->all());
    //     return response()->json(['message' => 'Category updated successfully']);
    // }
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $user = auth()->user();
        if ($category->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to update this Category'], 403);
        }

        try {
            $validatedData = $request->validated();
            $validatedData['userID'] = $user->id;

            // If parentID is not provided, set it to null and update the level to 2
            if (!$request->has('parentID')) {
                $validatedData['parentID'] = null;
                $validatedData['level'] = 2;
            }

            $category->update($validatedData);
        } catch (Exception $e) {
            return response()->json(['success' => 'false', 'message' => 'Failed to update Category'], 500);
        }
        return response()->json(['success' => 'true', 'message' => 'Category updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $user = auth()->user();
        if ($category->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this category'], 403);
        }

        $category->delete();

        return response()->json(['success' => 'true', 'message' => 'Category deleted successfully']);
    }
}
