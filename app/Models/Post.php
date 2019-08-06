<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    function category(){
        return $this->belongsTo("App\Models\Category");
    }

    function getAllPost($option){
        $query = Post::query()->with("category");

        if(!empty($option['search']['category_id'])){
            $query = $query->where("category_id", $option['search']['category_id']);
        }
        if(!($option['search']['state'])){
            $query = $query->where("state", $option['search']['state']);
        }

        if(!empty($option['orderBy'])){
            $fieldOrder = array_keys($option['orderBy']);
            $typeOrder = array_values($option['orderBy']);
            for($i = 0; $i < count($fieldOrder); $i++){
                $query = $query->orderBy($fieldOrder[$i], $typeOrder[$i]);
            }
        }
        if(!empty($option['limit'])){
            $query = $query->paginate($option['limit']);
        }
        $post = $query;
        return $post;
    }

    function getPost($id){
        return Post::find($id);
    }

    function createPost($data) {
        Post::insert($data);
    }

    function updatePost($data, $id){
        Post::where("id", $id)->update($data);
    }

    function deletePost($id){
        Post::destroy($id);
    }
}
