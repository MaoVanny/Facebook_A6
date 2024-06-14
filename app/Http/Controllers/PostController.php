<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UserRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *     path="/api/post",
     *     summary="Get all Posts",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="List of posts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PostResource")
     *         )
     *     )
     * )
     */

    public function index()
    {
        //
        return PostResource::collection(Post::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/post/create",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     @OA\RequestBody(    
     *         required=true,
     *         description="Post data",
     *         @OA\JsonContent(ref="#/components/schemas/PostRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PostResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"title": {"The title field is required."}})
     *         )
     *     )
     * )
     */
    public function store(PostRequest $request)
    {
        $post = Post::create($request->all());
        return new PostResource($post);
    }


    /**
     * @OA\Get(
     *     path="/api/post/{id}",
     *     summary="Display the specified post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the post to retrieve",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post details found",
     *         @OA\JsonContent(ref="#/components/schemas/PostResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Post not found")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return new PostResource($post);
    }


    /**
     * Update the specified resource in storage.
     */


    /**
     * @OA\Put(
     *     path="/api/post/update/{id}",
     *     summary="Update a post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the post to update",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Post data to update",
     *         @OA\JsonContent(ref="#/components/schemas/PostRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PostResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Post not found")
     *         )
     *     )
     * )
     */
    public function update(PostRequest $request, string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $post->update($request->all());
        return new PostResource($post);
    }


    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/post/delete/{id}",
     *     summary="Delete a post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the post to delete",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Post not found")
     *         )
     *     )
     * )
     */


    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json(null, 204);
    }
}
