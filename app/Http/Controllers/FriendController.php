<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\FriendRequest;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $friends = Friend::all();
        return response()->json($friends, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/friend/request",
     *     summary="Create a new friend request",
     *     tags={"Friend"},
     *     @OA\RequestBody(    
     *         required=true,
     *         description="Create new friend request to the specific person",
     *         @OA\JsonContent(ref="#/components/schemas/FriendRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Friend request created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/FriendResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"friend_id": {"The friend_id field is required."}})
     *         )
     *     )
     * )
     */

    public function store(FriendRequest $request)
    {
        $validatedData = $request->validated();

        // Check if the request is being made by the current user
        if ($validatedData['user_id'] == $validatedData['friend_id']) {
            // You can't send a friend request to yourself
            return response()->json(['error' => 'You can\'t send a friend request to yourself.'], 400);
        }

        // Create a new friend request
        $friendRequest = Friend::create([
            'user_id' => $validatedData['user_id'],
            'friend_id' => $validatedData['friend_id'],
            'status' => 'pending',
        ]);

        return response()->json($friendRequest, 201);
    }

    /**
     * Accept a friend request.
     */
    /**
     * @OA\Post(
     *     path="/api/friend/accept",
     *     summary="Accept a friend request",
     *     tags={"Friend"},
     *     @OA\RequestBody(    
     *         required=true,
     *         description="Accept a friend request to the specific requested",
     *         @OA\JsonContent(ref="#/components/schemas/FriendRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Friend accept is successfully",
     *         @OA\JsonContent(ref="#/components/schemas/FriendResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"friend_id": {"The friend_id field is required."}})
     *         )
     *     )
     * )
     */
    public function accept(FriendRequest $request)
    {
        $validatedData = $request->validated();

        // Find the friend request
        $friendRequest = Friend::where('user_id', $validatedData['user_id'])
            ->where('friend_id', $validatedData['friend_id'])
            ->first();

        if (!$friendRequest) {
            return response()->json(['error' => 'Friend request not found.'], 404);
        }

        // Update the friend request status
        $friendRequest->accepted = true;
        $friendRequest->save();

        return response()->json($friendRequest, 200);
    }

    /**
     * Display the the user who request to be your friend
     */
    /**
     * @OA\Get(
     *     path="/api/friend/requested/{id}",
     *     summary="Get all who requested to be your facebook friends",
     *     tags={"Friend"},
     *     @OA\Response(
     *         response=200,
     *         description="List all of people who requested to be your facebook friends",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/FriendResource")
     *         )
     *     )
     * )
     */
    public function showAllRequests($id)
    {
        $user = User::find($id);
        $friendRequests = Friend::where('friend_id', $user->id)->where('accepted', 0)->get();
        return response()->json($friendRequests, 200);
    }

    /**
     * Display the the user who is your fb friend
     */
    /**
     * @OA\Get(
     *     path="/api/friend/list/{id}",
     *     summary="Get all your facebook friends",
     *     tags={"Friend"},
     *     @OA\Response(
     *         response=200,
     *         description="List all of your facebook friends",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/FriendResource")
     *         )
     *     )
     * )
     */

public function showAllFriends($id)
{
    $user = User::find($id);
    $friends = Friend::where('user_id', $user->id)->where('accepted', 1)->get();
    return response()->json($friends, 200);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Friend $friend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/friend/unfriend/{friendId}",
     *     summary="Delete a friend or Unfriend",
     *     tags={"Friend"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Insert ID your facebook friend ID to for unfriend",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Unfriend successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $friend = Friend::find($id);
        $friend = Friend::where('friend_id', $id)->first() ?: Friend::where('user_id', $id)->first();
        if ($friend) {
            $friend->delete();
            return response()->json(['message' => 'Friend deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Friend not found'], 404);
        }
    }
}
