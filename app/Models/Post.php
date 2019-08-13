<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category(){
        return $this->belongsTo("App\Models\Category");
    }

    public function queryAuthorization($user){
        $query = Post::query();
        if($user){
            if($user['account_type'] == "admin"){
                $query = $query->where("user_id", $user['user_id']);
            }
        }
        return $query;
    }
    public function getAllPost($option, $user){
        $query = $this->queryAuthorization($user);
        $query = $query->with("category");

        if(!empty($option['search']['category_id'])){
            $query = $query->where("category_id", $option['search']['category_id']);
        }
        if( $option['search']['state'] != null){
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

    public function getPost($id, $user){
        $query = $this->queryAuthorization($user);
        if(!$user) $query = $query->where("state", 1);
        $query = $query->find($id);
        return $query;
    }

    public function createPost($data) {
        Post::insert($data);
    }

    public function updatePost($data, $id, $user){
        $query = $this->queryAuthorization($user);
        $query = $query->where("id", $id)->update($data);
    }

    public function deletePost($id, $user){
       $query = $this->queryAuthorization($user);
       $query->where("id", $id)->delete();
    }
}
