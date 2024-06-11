<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;

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
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
