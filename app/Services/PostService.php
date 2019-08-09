<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostService {
    public $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    function getAllPost($option){
        $user = null;
        if(Auth::user()){
            $user = [
                'user_id' => Auth::user()->id,
                'account_type' => Auth::user()->account_type
            ];
        }
        $post = $this->post->getAllPost($option, $user)->toArray();
        $posts = array_map(function($p) {
            $p['image'] = asset('').Storage::url($p['image']);
            return $p;
        }, $post['data']);
        $post['data'] = $posts;

        return $post;
    }
    function getPost($id){
        $user = null;
        if(Auth::user()){
            $user = [
                'user_id' => Auth::user()->id,
                'account_type' => Auth::user()->account_type
            ];
        }
        $post = $this->post->getPost($id, $user);
        if($post){
            $post->image = asset('').Storage::url($post->image);
        }
        return $post;
    }
    function createPost($data){
        $file = $data['image'];
        // generate a new filename. getClientOriginalExtension() for the file extension
        $filename = time() .'-'. $file->getClientOriginalName();
        // save to storage/app/images as the new $filename
        $path = $file->storeAs('public/images', $filename);
        $data['image'] = $path;
        $data['user_id'] = Auth::user()->id;
        $this->post->createPost($data);
    }
    function updatePost($data){
        $file = $data['image'];
        $data['user_id'] = Auth::user()->id;
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
        $user = [
            'user_id' => Auth::user()->id,
            'account_type' => Auth::user()->account_type
        ];
        if($user['account_type'] == "super-admin"){
            unset($data['user_id']);
        }
        $this->post->updatePost($data, $data['id'], $user);
    }
    function deletePost($id) {
        $user = [
            'user_id' => Auth::user()->id,
            'account_type' => Auth::user()->account_type
        ];
        $this->post->deletePost($id, $user);
    }
}
