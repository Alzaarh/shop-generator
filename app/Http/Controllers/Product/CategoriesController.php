<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return (new CategoryResource($category));
    }

    public function create(Request $request)
    {
        $input = $this->validateCreateAndUpdateCategory($request);

        $categoryData = $this->transformToDatabaseInput($input);

        $category = Category::create($categoryData);

        return (new CategoryResource($category))->response(201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $input = $this->validateCreateAndUpdateCategory($request);

        $categoryData = $this->transformToDatabaseInput($input);

        $category->update($categoryData);

        return (new CategoryResource($category));
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return $this->okResponse();
    }

    private function validateCreateAndUpdateCategory(Request $request)
    {
        $rules = [
            'title' => 'bail|required|string|max:255',

            'picture' => 'bail|string|nullable|max:255',

            'details' => 'bail|json|nullable',

            'parent' => 'bail|numeric|nullable|exists:categories,id',
        ];

        return $this->validate($request, $rules);
    }

    private function transformToDatabaseInput($data)
    {
        return [
            'title' => $data['title'],

            'picture' => isset($data['picture']) ? $data['picture'] : null,

            'details' => isset($data['details']) ? $data['details'] : null,

            'parent_id' => isset($data['parent']) ? $data['parent'] : null,
        ];
    }
}
