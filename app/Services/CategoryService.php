<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Redis;

class CategoryService {
    public $category;

    public function __construct(Category $category) {
        $this->category = $category;
    }

    public function getAllCategory($post_active = false) {
        // $categories = array();
        if(!empty(Redis::get("categories"))){
            $category = json_decode(Redis::get("categories"), true);
        }
        else {
            $category = $this->category->getAllCategory();
            if($post_active){
                // $postActives = array();
                // foreach($category as $cat){
                //     $postActive = array_map(function($post){
                //         if($post['state'] == 1){
                //             return $post;
                //         }
                //     }, $cat['posts']);
                //     $postActive = array_filter($postActive, function($value){
                //         return !is_null($value);
                //     });
                //     array_push($postActives, $postActive);
                // }
                // for($i = 0; $i < count($category); $i++){
                //     $category[$i]['posts'] = $postActives[$i];
                // }

                $category = $category->map(function($cat){
                    $posts = $cat['posts']->reject(function($post){
                        return $post['state'] == 0;
                    });
                    $cat['posts'] = $posts;
                    return $cat;
                });
            }
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
