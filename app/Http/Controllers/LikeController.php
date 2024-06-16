<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Http\Requests\LikeRequest;
use App\Http\Resources\LikeResource;

class LikeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/like",
     *     tags={"likes"},
     *     summary="Display a listing of the likes.",
     *     @OA\Response(
     *         response=200,
     *         description="A list of likes.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/LikeResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $like = Like::all();
        return LikeResource::collection($like);
    }

    /**
     * @OA\Post(
     *     path="/api/posts/like",
     *     tags={"likes"},
     *     summary="Store a newly created like.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LikeRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The created like.",
     *         @OA\JsonContent(ref="#/components/schemas/LikeResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found."
     *     )
     * )
     */
    public function likePost(LikeRequest $request)
    {

        $like = Like::create($request->all());
        return new LikeResource($like);
    }


    /**
     * @OA\Put(
     *     path="/api/like/update/{id}",
     *     tags={"likes"},
     *     summary="Update the specified like.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the like.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LikeRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The updated like.",
     *         @OA\JsonContent(ref="#/components/schemas/LikeResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Like not found."
     *     )
     * )
     */
    public function update(LikeRequest $request, string $id)
    {

        $like = Like::findOrFail($id);
        $like->update($request->validated());
        return new LikeResource($like);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}/unlike",
     *     tags={"likes"},
     *     summary="Remove the specified like from storage.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the like.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post unliked successfully."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Like not found."
     *     )
     * )
     */
    public function unlikePost($id)
    {
        $like = Like::findOrFail($id);
        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Post unliked successfully']);
        } else {
            return response()->json(['error' => 'Like not found'], 404);
        }
    }
}
