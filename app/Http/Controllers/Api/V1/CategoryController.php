<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index() { return $this->success(Category::withCount('courses')->get()); }

    public function show(Category $category) { return $this->success($category->load('courses')); }

    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string','description'=>'nullable|string','color'=>'nullable|string','icon'=>'nullable|string']);
        $data['slug'] = Str::slug($data['name']);
        $category = Category::create($data);
        return $this->success($category, 'Category created', 201);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate(['name'=>'sometimes|string','description'=>'nullable|string','color'=>'nullable|string','icon'=>'nullable|string']);
        if (isset($data['name'])) $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return $this->success($category, 'Category updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->success(null, 'Category deleted');
    }
}
