<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment = Comment::list();
        $comment = CommentResource::collection($comment);
        return response(['success' => true, 'data' => $comment], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'description' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update(['description' => $validatedData['description'],]);
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['status' => 'success', 'message' => 'Comment is deleted', 'data' => $comment,], 200);
    }
    // public function getAllCommentInPost($postId)
    // {
    //     // Find all the comments for the given post
    //     $comments = Comment::where('post_id', $postId)->get();

    //     // Return the comments as a resource collection
    //     return CommentResource::collection($comments);
    // }
}
