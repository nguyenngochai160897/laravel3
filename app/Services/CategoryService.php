<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Redis;

class CategoryService {
    public $category;

    public function __construct(Category $category) {
        $this->category = $category;
    }

    public function getAllCategory() {
        if(!empty(Redis::get("categories"))){
            $category = json_decode(Redis::get("categories"), true);
        }
        else {
            $category = Category::with("posts")->get()->toArray();
            Redis::set("categories",  json_encode($category));
        }
        // dd($category);
        return $category;
    }

    function getCategory(){
        return Category::with("posts")->find($this->category->id);
    }

    function createCategory(){
        $this->category->save();
    }

    function updateCategory(){
       Category::where("id", $this->category->id)->update(["name" => $this->category->name]);
    }

    function deleteCategory(){
        try {
            Category::destroy($this->category->id);
            return [
                'status' => "success",
            ];
        } catch (\Exception $e) {
            return [
               "status" => "failed",
            ];
        }
    }
}
