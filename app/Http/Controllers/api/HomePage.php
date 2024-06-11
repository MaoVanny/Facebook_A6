<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/post/create",
 *     summary="Authenticate user and generate JWT token",
 *     @OA\Parameter(
 *         name="title",
 *         in="query",
 *         description="User's name",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="description",
 *         in="query",
 *         description="User's name",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="Login successful"),
 *     @OA\Response(response="401", description="Invalid credentials")
 * )
 */


class HomePage extends Controller
{
    //
}
