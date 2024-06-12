<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    // get users
    public function index(Request $request)
    {
        try {
            $users = User::all();
            return response()->json([
                'status' => true,
                'message' => 'Getting users successfully',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function register(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'username' => 'required',
                    'phone_number' => 'required',
                    'password' => 'required|min:8'
                ]
            );
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $user = User::create([
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username'     => 'required',
            'phone_number'     => 'required|string|max:255',
            'password'  => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only('phone_number', 'username', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user   = User::where('phone_number', $request->phone_number)->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    // public function index(Request $request)
    // {
    //     $user = $request->user();
    //     $permissions = $user->getAllPermissions();
    //     $roles = $user->getRoleNames();
    //     return response()->json([
    //         'message' => 'Login success',
    //         'data' => $user,
    //     ]);
    // }


    public function logout(Request $request)
    {
        // return $request;
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    // view users profile
    public function show(string $id)
    {
        return User::find($id);
    }

    // update users profile
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'phone_number' => 'required|unique:users,phone_number,' . $user->id,
                'password' => 'nullable|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $user->update([
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User profile updated successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }

    // update image profile

    public function uploadProfile(Request $request, $id)
    {
        $validateUser = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validateUser->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 422);
        }
        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move(public_path() . '/uploads/', $imageName);

        try {
            $user = User::find($id);
            $user->update([
                'image' => $imageName
            ]);
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Profile updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
