<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Models\Post;

class IndexController extends Controller
{
    private $categoryService, $postService;
    public function __construct(CategoryService $categoryService, PostService $postService)
    {
        $this->categoryService = $categoryService;
        $this->postService = $postService;
    }
    function defaultSideBar(){
        $option = [
            "limit" => 5,
            "search" => [
                "category_id" => null,
                "state" => 1
            ],
            "orderBy" => [
                "id" => 'desc',
            ]
        ];
        $categories = $this->categoryService->getAllCategory();
        $postRecent = $this->postService->getAllPost($option);
        $data = [
            "categories" => $categories,
            "postRecent" => $postRecent['data']
        ];
        return $data;
    }
    function index(){
        return view("public.index")->with($this->defaultSideBar());
    }
    function showPost($id){
        $data = $this->defaultSideBar();
        $post = $this->postService->getPost($id);
        $data = array_merge($data, ['post' => $post]);
        return view("public.post")->with($data);
    }
    function showCategory($id){
        $data = $this->defaultSideBar();
        $category = $this->categoryService->getCategory($id);
        $data = array_merge($data, [
            'posts' => $this->postService->getAllPost([
                "limit" => 5,
                "search" => [
                    "category_id" => $id,
                    "state" => "1"
                ],
                "orderBy" => [
                    "id" => 'desc',
                ]
            ])['data'],
            'category_name' => $category->name,
        ]);
        return view("public.category")->with($data);
    }
}
