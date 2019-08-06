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
        $post = $this->post->getAllPost($option)->toArray();
        $posts = array_map(function($p) {
            $p['image'] = asset('').Storage::url($p['image']);
            return $p;
        }, $post['data']);
        $post['data'] = $posts;

        return $post;
    }
    function getPost($id){
        $post = $this->post->getPost($id);
        $post->image = asset('').Storage::url($post->image);
        return $post;
    }
    function createPost($data){
        $file = $data['image'];
        // generate a new filename. getClientOriginalExtension() for the file extension
        $filename = time() .'-'. $file->getClientOriginalName();
        // save to storage/app/images as the new $filename
        $path = $file->storeAs('public/images', $filename);
        $data['image'] = $path;
        $this->post->createPost($data);
    }
    function updatePost($data){
        $file = $data['image'];
        if(empty($file)){
            $post = $this->getPost($data['id']);
            $imageName = explode("/", $post->image);
            $imageName = ($imageName[count($imageName)-1]);
            $data['image'] = "public/images/".$imageName;
        }
        else{
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = time() .'-'. $file->getClientOriginalName();
            // save to storage/app/images as the new $filename
            $path = $file->storeAs('public/images', $filename);
            $data['image'] = $path;
        }
        $this->post->updatePost($data, $data['id']);
    }
    function deletePost($id) {
        $this->post->deletePost($id);
    }
}
