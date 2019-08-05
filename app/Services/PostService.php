<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostService {
    public $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    function getAllPost($option){
        if($option['search']['category_id']=="all" && $option['search']['state']=="all"){
            $post = Post::with("category")->paginate($option['limit']);
        }
        //...
        else if($option['search']['category_id'] != "all" && $option['search']['state']=="all"){
            $post =  Post::with("category")->where(["category_id"=> $option['search']['category_id']])->paginate($option['limit']);
        }
        else if($option['search']['category_id'] == "all" && $option['search']['state'] != "all"){
            $post = Post::with("category")->where(["state"=> $option['search']['state']])->paginate($option['limit']);
        }
        else{
            $post = Post::with("category")->where(["state"=> $option['search']['state'], "category_id"=> $option['search']['category_id']])->paginate($option['limit']);
        }
        $posts = array();
        foreach($post as $p){
            $p->image = 'storage/'.$p->image;
            array_push($posts, $p);
        }
        // dd($posts);
        return $posts;
    }
    function getPost(){
        return Post::find($this->post->id);
    }
    function createPost(){
        $this->post->save();
    }
    function updatePost(){
        Post::where("id", $this->post->id)->update([
            "title" => $this->post->title,
            "category_id" => $this->post->category_id,
            "image" => $this->post->image,
            "snapshort" => $this->post->snapshort,
            "content" => $this->post->content,
            "state" => $this->post->state
        ]);
    }
    function deletePost() {
        Post::destroy($this->post->id);
    }
}
