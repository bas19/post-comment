<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Comment as CommentRequest;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $data = Comment::create([
            'name' => $request->name,
            'message' => $request->message,
            'post_id' => $request->post_id,
            'parent_comment_id' => $request->parent_comment_id,
            'nested_level' => $request->nested_level
        ]);

        return response()->json($data);

    }

    /**
     * Show all comments by post id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCommentsByPostId($id)
    {
        $data = Comment::where('post_id', $id)   
            ->where('nested_level', 0)
            ->with('grandchildren')
            ->get();

        return response()->json($data);
    }
}
