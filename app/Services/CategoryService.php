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
            $category = $this->category->getAllCategory();
            // Redis::set("categories",  json_encode($category));
        }
        // Redis::del("categories");
        return $category;
    }

    function getCategory($id){
        return $this->category->getCategory($id);
    }

    function createCategory($data){
        $this->category->createCategory($data);
    }

    function updateCategory($data){
       $this->category->updateCategory($data['id'], [
           'name' => $data['name']
       ]);
    }

    function deleteCategory($id){
        $delete = $this->category->deleteCategory($id);
        if($delete['status'] == "fail"){
            return [
                "error" => "Cannot delete"
            ];
        }
        return;
    }
}
