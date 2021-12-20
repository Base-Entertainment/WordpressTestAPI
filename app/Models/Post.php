<?php

namespace App\Models;

use Corcel\Model\Post as Corcel;
use Laravel\Sanctum\HasApiTokens; // Sanctum
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Corcel
{
    use HasFactory, HasApiTokens;

    protected $table = "posts";
    protected $connection = "wordpress";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var array
     */
    protected static $aliases = [
        'id' => 'ID',
        'title' => 'post_title',
        'content' => 'post_content',
        'excerpt' => 'post_excerpt',
        'slug' => 'post_name',
        'created_at' => 'post_date',
        'type' => 'post_type',
        'author_id' => 'post_author',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'title', // required
        'content', // required
        'mime_type',
        'author_id', // required (Author first and last name, )
        'created_at', // required
    ];

    public function scopeReal($query)
    {
        return $query->where('post_type', 'post');
    }
}
