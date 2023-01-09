<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories  = Category::all();

        return response()->json([
            'status' => 'success',
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'alias' => 'required:unique:categories,alias'
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->alias = $request->input('alias');
        $category->category_id = $request->input('category') ?? null;
        $category->save();

        return response()->json([
            'status' => 'success',
            'category_id' => $category->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'category' => Category::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'alias' => 'required:unique:categories,alias'
        ]);

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->alias = $request->input('alias');
        $category->category_id = $request->input('category') ?? null;
        $category->save();

        return response()->json([
            'status' => 'success',
            'category_id' => $category->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
