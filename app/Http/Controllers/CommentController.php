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

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/comment",
     *     summary="Create a new comment",
     *     tags={"Comments"},
     *     @OA\RequestBody(    
     *         required=true,
     *         description="Create new comment in a specific post",
     *         @OA\JsonContent(ref="#/components/schemas/CommentRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comment created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CommentResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"description": {"The description field is required."}})
     *         )
     *     )
     * )
     */
  
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
    /**
     * @OA\Put(
     *     path="/api/comment/{id}",
     *     summary="Update a comment",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the comment to update",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Input new datas to update",
     *         @OA\JsonContent(ref="#/components/schemas/CommentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CommentResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Comment not found")
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $commnet = Comment::find($id);
        $commnet->update($request->all());
        return new CommentResource($commnet);
    }

     /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/comment/delete/{id}",
     *     summary="Delete a comment",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Insert ID of comment to delete the comment",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Comment deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Comment not found")
     *         )
     *     )
     * )
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
