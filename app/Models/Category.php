<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    function posts(){
        return $this->hasMany('App\Models\Post');
    }

    function getAllCategory(){
        return Category::with("posts")->get();
    }

    function getCategory($id){
        return Category::with("posts")->find($id);
    }

    function createCategory($data){
        Category::insert($data);
    }

    function updateCategory($id, $data){
        Category::where("id", $id)->update($data);
    }

    function deleteCategory($id){
        try {
            Category::destroy($id);
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
