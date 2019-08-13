<?php
namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentService {
    private $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getAllComment($post_id){
        $comments = $this->comment->getAllComment($post_id);
        return $comments;
    }

    public function createComment($data){
        $data['user_id'] = Auth::user()->id;
        $this->comment->createComment($data);
    }
}
