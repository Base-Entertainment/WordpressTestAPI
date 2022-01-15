<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json(PostsResource::collection(
        //     Post::limit(2)->get()
        // ), 200)->withHeaders([
        //     'Content-Type' => 'application/json;charset=UTF-8',
        //     'Charset' => 'UTF-8'
        // ]);
        return response()->json(PostsResource::collection(Post::type('post')->published()->orderBy('post_date', 'desc')->limit(5)->get()), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }


    public function count()
    {

        return Post::real()->count();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $post =  Post::real()->findOrFail($id);
            return response()->json(new PostsResource($post), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (ModelNotFoundException $e) {
            return response()->json('Model Not Found', 404, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
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

    public function suggestions($id){
        try{
            $post = Post::type("post")->published()->findOrFail($id);

            $taxonomy = $post->taxonomies()->category()->firstOrFail();



            $posts = Post::type("post")->published()->where('ID', "<>", $post->id )->taxonomy("category", $taxonomy->name)->orderBy("post_date")->limit(4)->get();



            return response()->json(PostsResource::collection($posts), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }catch(ModelNotFoundException $e){
            return response()->json(["message"=> "No post exists with this id"], 404, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }


    }
}
