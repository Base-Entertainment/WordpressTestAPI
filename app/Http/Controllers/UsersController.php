<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Http\Resources\UsersResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return  response(UsersResource::collection(User::all()), 200)->withHeaders([
            'Content-Type' => 'application/json;charset=UTF-8'
        ]);
    }
    public function userposts(User $user)
    {

        return response()->json(PostsResource::collection($user->posts()->real()->published()->orderBy('post_date', 'desc')->limit(5)->get()), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response(new UsersResource($user), 200)->withHeaders([
            'Content-Type' => 'application/json;charset=UTF-8'
        ]);
    }


    public function getPostsByID($id)
    {
        $user =  User::findOrFail($id)->posts()->get();
        return response(PostsResource::collection($user), 200)->withHeaders([
            'Content-Type' => 'application/json;charset=UTF-8'
        ]);
    }

    public function me(Request $request){
        $user = $request->user();
        if($user != null){
            return response()->json(new UsersResource($user), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);

        }else{
            return response([
                'message' => 'Unauthorized.'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
