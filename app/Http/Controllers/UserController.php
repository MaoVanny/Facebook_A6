<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\Validated;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="Endpoints for managing users"
 * )
 */

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get all users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="List of users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UserResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return UserResource::collection(user::all());
    }


    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Get(
     *      path="/api/user/profile/{id}",
     *      operationId="getUserById",
     *      tags={"Users"},
     *      summary="Get user details",
     *      description="Returns user details by user ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the user to fetch",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      )
     * )
     */

    public function showProfile(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return new UserResource($user);
    }

    /**
     * @OA\Put(
     *     path="/api/update/updateProfile/{id}",
     *     summary="Update a user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to update",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="User data to update",
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     )
     * )
     */

    public function updateProile(Request $request, $id)
    {
        $profile = Validator::make($request->all(), [
            'username' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        if ($profile->fails()) {
            return response()->json(['error' => $profile->errors()], 422);
        }

        $user = User::find($id);
        $user->username = $request->username;
        $user->phone_number = $request->phone_number;
        $user->save();
        return new UserResource($user);
    }

    /**
     * @OA\Delete(
     *     path="/api/user/delete/{id}",
     *     tags={"Users"},
     *     summary="Delete user profile by ID.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User profile deleted.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User profile deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User not authenticated."
     *     )
     * )
     */
    public function deleteProfile(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User profile deleted successfully.']);
    }
}
