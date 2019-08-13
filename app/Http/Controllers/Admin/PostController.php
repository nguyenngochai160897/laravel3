<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Services\CategoryService;
use App\Http\Requests\Admin\PostRequest;
use App\Http\Requests\Admin\PostUpdateRequest;

class PostController extends Controller
{
    private $postService, $categoryService;

    public function __construct(PostService $postService, CategoryService $categoryService) {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
    }
    public function index(){
        $option = config("postOption.option");
        if(isset(\Request::query()['category_id']))  $option['search']['category_id']=\Request::query()['category_id'];
        if(isset(\Request::query()['state']))  $option['search']['state']=\Request::query()['state'];
        $posts = $this->postService->getAllPost($option);
        $pagination = $posts;
        unset($pagination['data']);
        return view("admin.post.index")->with([
            "categories" => $this->categoryService->getAllCategory(),
            "posts" => $posts['data'],
            "pagination" => $pagination
        ]);
    }
    public function showFormAdd(){
        return view("admin.post.add")->with(
            "categories" , $this->categoryService->getAllcategory()
        );
    }
    public function store(PostRequest $request){
        $data = [
            'title' => $request->input("title"),
            'category_id' => $request->input("category_id"),
            'image' => $request->file('image'),
            'snapshort' => $request->input("snapshort"),
            'content' => $request->input("content"),
            'state' =>  $request->input("state"),
        ];
        $this->postService->createPost($data);
        return redirect()->route("admin.post.index");
    }
    public function showFormUpdate($id){
        return view("admin.post.update")->with([
            'post'=> $this->postService->getPost($id),
            "categories" => $this->categoryService->getAllCategory(),]);
    }
    public function update(PostUpdateRequest $request, $id){
        $data = [
            "id" => $id,
            'title' => $request->input("title"),
            'category_id' => $request->input("category_id"),
            'image' => $request->file('image'),
            'snapshort' => $request->input("snapshort"),
            'content' => $request->input("content"),
            'state' =>  $request->input("state"),
        ];
        $this->postService->updatePost($data);
        return redirect()->route("admin.post.index");
    }
    public function delete($id){
        $this->postService->deletePost($id);
        return redirect()->route("admin.post.index");
    }
}
