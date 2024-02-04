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
    public function index(Request $request)
    {
        $filter = new CategoryFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]
        
        if (count($queryItems) == 0){
            return new CategoryCollection(Category::paginate());
        } else{ 

            $category = Category::where($queryItems)->paginate();

            return new CategoryCollection($category->appends($request->query()));

            //return new CategoryCollection(Category::where($queryItems)->paginate());
        }
    }

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
    public function create()
    {
        // Logic to get a specific category by ID
         $category = Category::find($id);
         return response()->json($category);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        return new CategoryResource(Category::create($request->all()));
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
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // Logic to update a category by ID
        $category->update($request->all());
        return response()->json(['message' => 'Category updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if the authenticated user is the owner of the category
        if ($user->id !== $category->userID) {
        return response()->json(['error' => 'Unauthorized'], 403);
        }
        // Logic to delete a category by ID
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
