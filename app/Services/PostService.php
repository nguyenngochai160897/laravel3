<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostService {
    private $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    public function getAllPost($option){
        $user = null;
        $userCurrent = Auth::user();
        if($userCurrent){
            $user = [
                'user_id' =>$userCurrent->id,
                'account_type' => $userCurrent->account_type
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
    public function getPost($id){
        $user = null;
        $userCurrent = Auth::user();
        if($userCurrent){
            $user = [
                'user_id' =>$userCurrent->id,
                'account_type' => $userCurrent->account_type
            ];
        }
        $post = $this->post->getPost($id, $user);
        if($post){
            $post->image = asset('').Storage::url($post->image);
        }
        return $post;
    }
    public function createPost($data){
        $file = $data['image'];
        // generate a new filename. getClientOriginalExtension() for the file extension
        $filename = time() .'-'. $file->getClientOriginalName();
        // save to storage/app/images as the new $filename
        $path = $file->storeAs('public/images', $filename);
        $data['image'] = $path;
        $data['user_id'] = Auth::user()->id;
        $this->post->createPost($data);
    }
    public function updatePost($data){
        $file = $data['image'];
        $data['user_id'] = Auth::user()->id;
        if(!empty($file)){
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = time() .'-'. $file->getClientOriginalName();
            // save to storage/app/images as the new $filename
            $path = $file->storeAs('public/images', $filename);
            $data['image'] = $path;
        }
        else {
            unset($data['image']);
        }
        $userCurrent = Auth::user();
        if($userCurrent){
            $user = [
                'user_id' =>$userCurrent->id,
                'account_type' => $userCurrent->account_type
            ];
        }
        if($user['account_type'] == "super-admin"){
            unset($data['user_id']);
        }
        $this->post->updatePost($data, $data['id'], $user);
    }
    public function deletePost($id) {
        $userCurrent = Auth::user();
        $user = [
            'user_id' => $userCurrent->id,
            'account_type' => $userCurrent->account_type
        ];
        $this->post->deletePost($id, $user);
    }
}
