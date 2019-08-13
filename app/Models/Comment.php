<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

    public function getAllComment($post_id){
        return Comment::with("user")->where("post_id", $post_id)->get();
    }

    public function createComment($comment){
        Comment::insert($comment);
    }
}
