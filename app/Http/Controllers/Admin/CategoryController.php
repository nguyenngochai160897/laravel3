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
        $this->categoryService->category->name = $request->input("name");
        $this->categoryService->createCategory();
        return redirect()->route("admin.category.index");
    }

    public function showFormUpdate($id)
    {
        $this->categoryService->category->id = $id;
        return view("admin.category.update")->with("category", $this->categoryService->getCategory());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $this->categoryService->category->id = $id;
        $this->categoryService->category->name = $request->input("name");
        $this->categoryService->updateCategory();
        return redirect()->route("admin.category.index");
    }

    public function delete($id)
    {
        $this->categoryService->category->id = $id;
        $data = $this->categoryService->deleteCategory();
        if($data['status'] == "failed"){
            $message = "Co mot vai bai viet lien quan den danh muc nay?Khong the xoa";
            return redirect()->route("admin.category.index")->withErrors(['errors'=> $message]);
        }
        return redirect()->route("admin.category.index");
    }
}
