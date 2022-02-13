<?php

namespace App\Models;

use App\Models\Post;
use Corcel\Model\User as Corcel;
use Laravel\Sanctum\HasApiTokens; // Sanctum
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class User extends Corcel
{
    use HasFactory;
    use HasApiTokens; // Sanctum

    protected $table = 'users';
    protected $connection = 'wordpress';

    protected $expires_at;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @var array
     */
    protected static $aliases = [
        'login' => 'user_login',
        'email' => 'user_email',
        'slug' => 'user_nicename',
        'url' => 'user_url',
        'displayname' => 'display_name',
        'nickname' => ['meta' => 'nickname'],
        'first_name' => ['meta' => 'first_name'],
        'last_name' => ['meta' => 'last_name'],
        'description' => ['meta' => 'description'],
        'capabilities' => ['meta' => 'wpdt_capabilities'],
        'created_at' => 'user_registered',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'login',
        'email',
        'slug',
        'url',
        'nickname',
        'first_name',
        'last_name',
        'avatar',
        ['meta' => 'wpdt_capabilities'],
        'created_at',
    ];
    // public function realPosts() // Extend from 'realPost' (Post Model)
    // {
    //     return $this->posts()->where('post_type', 'post');
    // }


    public function tokenValid()
    {
        if (Carbon::parse($this->expires_at)) {
            return true;
        }
        return false;
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'post_author');
    }
}
