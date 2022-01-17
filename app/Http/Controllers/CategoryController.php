<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategorySummaryResource;
use App\Http\Resources\PostsSummaryResource;
use Corcel\Model\Taxonomy;

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

    public function index(){
        $categories = Taxonomy::category()->where('count','>', 0)->with('posts')->get();

        return CategorySummaryResource::collection($categories);

    }
}
