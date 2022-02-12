<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategorySummaryResource;
use App\Http\Resources\PostsSummaryResource;
use App\Models\Post as ModelsPost;
use Corcel\Model\Post as ModelPost;
use Corcel\Model\Taxonomy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Post\Model\Post;




class CategoryController extends Controller
{
    public function posts(int $id)
    {

        $category = Taxonomy::category()->where('term_id', $id)->first();
        if ($category != null) {
            return response()->json(PostsSummaryResource::collection($category->posts()->type('post')->published()->limit(4)->get()), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function index()
    {
        // $cat = Taxonomy::where('taxonomy', 'category')->with('posts')->get();

        // $resourced = CategorySummaryResource::collection($cat);

        // return response()->json($cat, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
