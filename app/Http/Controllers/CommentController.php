<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use OpenApi\Annotations as OA;

class CommentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/comments",
     *     summary="Get all comments",
     *     tags={"Comments"},
     *     @OA\Response(
     *         response=200,
     *         description="List of comments",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CommentResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $comment = Comment::list();
        $comment = CommentResource::collection($comment);
        return response(['success' => true, 'data' => $comment], 200);
    }

    public function store(CommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $comment)
    {
        //
        $comment = Comment::findOrFail($comment);
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, string $id)
    {
        $commnet = Comment::find($id);
        $commnet->update($request->all());
        return new CommentResource($commnet);
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
