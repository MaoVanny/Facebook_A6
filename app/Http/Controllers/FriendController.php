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
    public function showAllRequests($id)
    {
        $user = User::find($id);
        $friendRequests = Friend::where('friend_id', $user->id)->where('accepted', 0)->get();
        return response()->json($friendRequests, 200);
    }

    /**
     * Display the the user who is your fb friend
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
