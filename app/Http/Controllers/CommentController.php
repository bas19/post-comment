<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Comment as CommentRequest;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        return Comment::create([
            'name' => $request->name,
            'message' => $request->message,
            'post_id' => $request->post_id,
            'parent_comment_id' => $request->parent_comment_id,
            'nested_level' => $request->nested_level
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Show all comments by post id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCommentsByPostId($id)
    {
        return Comment::where('post_id', $id)   
            ->where('nested_level', 0)
            ->with('grandchildren')
            ->get();
    }
}
