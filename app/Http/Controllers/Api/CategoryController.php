<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // Filter by profile
        if ($request->has('profile')) {
            $query->where('profile', $request->profile);
        }

        $categories = $query->get();

        return CategoryResource::collection($categories);
    }

    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);

        return new CategoryResource($category);
    }
}
