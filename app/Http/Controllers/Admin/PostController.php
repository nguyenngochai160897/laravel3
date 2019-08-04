<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Services\CategoryService;
use App\Http\Requests\Admin\PostRequest;

class PostController extends Controller
{
    private $postService, $categoryService;

    public function __construct(PostService $postService, CategoryService $categoryService) {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
    }
    function index(){
        $option = [
            "limit" => 10,
            "search" => [
                "category_id" => "all",
                "state" => "all"
            ]
        ];
        if(isset(\Request::query()['category_id']))  $option['search']['category_id']=\Request::query()['category_id'];
        if(isset(\Request::query()['state']))  $option['search']['state']=\Request::query()['state'];
        return view("admin.post.index")->with([
            "categories" => $this->categoryService->getAllCategory(),
            "posts" => $this->postService->getAllPost($option)
        ]);
    }
    function showFormAdd(){
        return view("admin.post.add")->with(
            "categories" , $this->categoryService->getAllcategory()
        );
    }
    function store(PostRequest $request){
        $file = $request->file('image');
        // generate a new filename. getClientOriginalExtension() for the file extension
        $filename = time() .'-'. $file->getClientOriginalName();
        // save to storage/app/images as the new $filename
        $path = $file->storeAs('images', $filename);
        $this->postService->post->title = $request->input("title");
        $this->postService->post->category_id = $request->input("category_id");
        $this->postService->post->image = $path;
        $this->postService->post->snapshort = $request->input("snapshort");
        $this->postService->post->content = $request->input("content");
        $this->postService->post->state = $request->input("state");
        $this->postService->createPost();
        return redirect()->route("admin.post.index");
    }
    function showFormUpdate($id){
        $this->postService->post->id = $id;
        return view("admin.post.update")->with([
            'post'=> $this->postService->getPost(),
            "categories" => $this->categoryService->getAllCategory(),]);
    }
    function update(PostRequest $request, $id){
        $target_dir = "uploads/images/".time()."-";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        if($target_file == $target_dir){
            //not update image file
            $post = new Post();
            $post->id = $id;
            $post = $post->getPost();
            $post->title = $request->input("title");
            $post->category_id = $request->input("category_id");
            $post->snapshort = $request->input("snapshort");
            $post->content = $request->input("content");
            $post->state = $request->input("state");
            $post->updatePost();
            return redirect()->route("post");
        }
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ){
            return redirect()->back()->withErrors(["errors"=>"Sorry, only JPG, JPEG, PNG & GIF files are allowed."]);
        }
        //...
        if (move_uploaded_file($_FILES["image"]["tmp_name"], time()."-".$target_file)) {
            $post = new Post();
            $post->id = $id;
            $post->title = $request->input("title");
            $post->category_id = $request->input("category_id");
            $post->image = $target_file;
            $post->snapshort = $request->input("snapshort");
            $post->content = $request->input("content");
            $post->state = $request->input("state");
            $post->updatePost();
            return redirect()->route("post");
        }
    }
    function delete($id){
        $this->postService->post->id = $id;
        $this->postService->deletePost();
        return redirect()->route("admin.post.index");
    }
}
