<?php

namespace App\Models;

use Corcel\Model\User as Corcel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; // Sanctum


class User extends Corcel
{
    use HasFactory;
    use HasApiTokens; // Sanctum

    protected $table = 'users';
    protected $connection = 'wordpress';



    public function __construct()
    {
        $this->appends = array_push($this->appends, ['meta' => 'wpdt_capabilities']);
    }

    /**
     * @var array
     */
    protected static $aliases = [
        'capabilities' => ['meta' => 'wpdt_capabilities'] // allias for user roles
    ];
}
