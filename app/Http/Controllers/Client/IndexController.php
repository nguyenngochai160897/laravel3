<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateCommentRequest;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    private $categoryService, $postService, $commentService;
    public function __construct(CategoryService $categoryService, PostService $postService,
        CommentService $comment)
    {
        $this->categoryService = $categoryService;
        $this->postService = $postService;
        $this->commentService = $comment;
    }
    private function defaultSideBar(){
        $option = config("postOption.option");
        $option['orderBy'] = ["id" => "desc"];
        $option['search']['state'] = 1;
        $categories = $this->categoryService->getAllCategory();
        $postRecent = $this->postService->getAllPost($option);
        $data = [
            "categories" => $categories,
            "postRecent" => $postRecent['data']
        ];
        return $data;
    }
    public function index(){
        return view("public.index")->with($this->defaultSideBar());
    }
    public function showPost($id){
        $data = $this->defaultSideBar();
        $post = $this->postService->getPost($id);
        $comments = $this->commentService->getAllComment($id)->toArray();
        $data = array_merge($data, ['post' => $post, 'comments' => $comments]);
        return view("public.post")->with($data);
    }
    public function showCategory($id){
        $data = $this->defaultSideBar();
        $category = $this->categoryService->getCategory($id);
        $option = config("postOption.option");
        $option['orderBy'] = ["id" => "desc"];
        $option['search']['state'] = 1;
        $option['category_id'] = $id;
        $data = array_merge($data, [
            'posts' => $this->postService->getAllPost($option)['data'],
            'category_name' => $category->name,
        ]);
        return view("public.category")->with($data);
    }

    public function createComment(CreateCommentRequest $request){
        //check user logon ?
        if(!Auth::check()){
            return redirect()->route("admin.auth.showFormLogin");
        }
        $this->commentService->createComment($request->only(["comment", "post_id"]));
        return redirect()->back();
    }

}
