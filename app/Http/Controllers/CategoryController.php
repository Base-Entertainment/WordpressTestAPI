<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Http\Resources\PostsSummaryResource;
use App\Models\Post;
use Corcel\Model\Category;
use Corcel\Model\Taxonomy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
}
