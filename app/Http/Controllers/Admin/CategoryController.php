<?php

namespace App\Http\Controllers\Admin;

use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategory();
        return view("admin.category.index")->with("categories", ($categories));
    }

    public function showFormAdd()
    {
        return view("admin.category.add");
    }

    public function store(CategoryRequest $request)
    {
        $data = [
            "name" => $request->input("name")
        ];
        $this->categoryService->createCategory($data);
        return redirect()->route("admin.category.index");
    }

    public function showFormUpdate($id)
    {
        $this->categoryService->category->id = $id;
        return view("admin.category.update")->with("category", $this->categoryService->getCategory($id));
    }

    public function update(CategoryRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'name' => $request->input("name")
        ];
        $this->categoryService->updateCategory($data);
        return redirect()->route("admin.category.index");
    }

    public function delete($id)
    {
        $data = $this->categoryService->deleteCategory($id);
        if(isset($data['error'])){
            return redirect()->route("admin.category.index")->withErrors(['errors'=> $data['error']]);
        }
        return redirect()->route("admin.category.index");
    }
}
