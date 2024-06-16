<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareRequest;
use App\Models\Share;
use Illuminate\Http\Request;
use App\Http\Resources\ShareResources;
use Illuminate\Support\Facades\Validator;


class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *     path="/api/share",
     *     tags={"shares"},
     *     summary="Display a listing of the shares.",
     *     @OA\Response(
     *         response=200,
     *         description="A list of shares.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ShareResources")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $shares = Share::all();
        return ShareResources::collection($shares);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/share/create",
     *     tags={"shares"},
     *     summary="Store a newly created shares.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ShareRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The created shares.",
     *         @OA\JsonContent(ref="#/components/schemas/ShareResources")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found."
     *     )
     * )
     */
    public function store(ShareRequest $request)
    {
        $share = Share::create($request->all());
        return new ShareResources($share);
    }


    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *     path="/api/share/show/{id}",
     *     tags={"shares"},
     *     summary="Display the specified shares.",
     *     description="Display the specified resource.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the share",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The specified share.",
     *         @OA\JsonContent(ref="#/components/schemas/ShareResources")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Share not found."
     *     )
     * )
     */
    public function show(string $id)
    {
        $share = Share::find($id);
        if (!$share) {
            return response()->json(['error' => 'Share not found.'], 404);
        }
        return new ShareResources($share);
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *     path="/api/share/update/{id}",
     *     tags={"shares"},
     *     summary="Update the specified share.",
     *     description="Update the specified resource identified by ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the share to update",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ShareRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated share.",
     *         @OA\JsonContent(ref="#/components/schemas/ShareResources")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Share not found."
     *     )
     * )
     */
    public function update(ShareRequest $request, string $id)
    {
        $share = Share::find($id);
        if (!$share) {
            return response()->json(['error' => 'Share not found.'], 404);
        }
        $share->update($request->all());
        return new ShareResources($share);
    }


    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/share/delete/{id}",
     *     tags={"shares"},
     *     summary="Delete the specified share.",
     *     description="Delete the specified share identified by ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the share to delete",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Share deleted successfully.",
     *         @OA\JsonContent(ref="#/components/schemas/ShareResources")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Share not found."
     *     )
     * )
     */
    public function destroy(string $shareId)
    {
        $share = Share::find($shareId);
        if (!$share) {
            return response()->json(['message' => 'Share not found'], 404);
        }
        $share->delete();
        return new ShareResources($share);
    }
}
