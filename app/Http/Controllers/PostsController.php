<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PostsSummaryResource;

class PostsController extends Controller
{


    /**
     * List latest posts as summary
     */
    public function index(Request $request)
    {

        //TODO: add post_format filter
        $posts = Post::type('post')->published()->orderBy('post_date', 'desc')->limit(5)->get();


        $resourced = PostsSummaryResource::collection($posts);


        return response()->json(
            $resourced,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
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

    public function videos()
    {
        $videos = Post::type('video')->get();
        $resourced = PostsSummaryResource::collection($videos);
        return response()->json(
            $resourced,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
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

    public function get(int $id)
    {
        $post = Post::type("post")->published()->where('id', $id)->first();
        if ($post != null) {
            return response()->json(new PostsResource($post), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        return response()->json(["message" => "Post not found"], 404, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
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

    public function suggestions($id)
    {
        try {
            $post = Post::type("post")->published()->findOrFail($id);

            $taxonomy = $post->taxonomies()->category()->firstOrFail();



            $posts = Post::type("post")->published()->where('ID', "<>", $post->id)->taxonomy("category", $taxonomy->name)->orderBy("post_date")->limit(4)->get();



            return response()->json(PostsResource::collection($posts), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "No post exists with this id"], 404, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }
}
