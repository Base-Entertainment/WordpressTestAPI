<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as Sanctum;

class PersonalAccessToken extends Sanctum
{
    use HasFactory;
    protected $table = "personal_access_tokens";
}
