<?php
namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Models\Post;
use Corcel\Model\Category;
use Corcel\Model\Taxonomy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function posts(String $slug){

        $category = Taxonomy::category()->slug($slug)->first();
        if($category != null){
            return response()->json(PostsResource::collection($category->posts()->type('post')->published()->limit(4)->get()), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }
}
