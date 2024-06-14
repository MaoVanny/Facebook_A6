<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Share;
use App\Http\Resources\ShareResource;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $share = Share::all();
        $share = ShareResource::collection($share);
        return response(['success' => true, 'data' => $share, 'message'=>'You can get information from share!'], 200);
    }

    /**
     * as a user can share.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validated();
        $share = Share::create($validatedData);
        $user_id = $share->user_id;
        $post_id = $share->post_id;
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
