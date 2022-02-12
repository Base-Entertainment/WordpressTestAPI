<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use MikeMcLin\WpPassword\Facades\WpPassword as WpPassword;


class AuthController extends Controller
{



    // public function register(Request $request)
    // {
    //     $fields = $request->validate([
    //         'username' => 'required|string',
    //         'firstname' => 'string',
    //         'lastname' => 'string',
    //         'email' => 'required|string|unique',
    //         'password' => 'required|string|confirmed'
    //     ]);

    //     $user = User::create([
    //         'login' => $fields['username'],
    //         'email' => $fields['email'],
    //         'user_pass' => bcrypt($fields['password']),
    //         'first_name' => $fields['firstname'],
    //         'last_name' => $fields['lastname'],
    //         'capabilities' => serialize(["subscriber", "bbp_participant"]) // As a default, It's registered as a 'subscriber'
    //     ]);
    // }

    public function login(Request $request)
    {
        //      VALIDATION RULES

        //$data = $request->all();
        $data = $request->json()->all();

        $rules = [
            'email' => 'required|string',
            'password' => 'required|string'
        ];



        $validator = Validator::make($data, $rules);
        if (!$validator->fails()) {




            //        CHECK EMAIL
            $user = User::where('user_email', $data['email'])->first();



            //      CHECK PASSWORD
            if (!$user || !WpPassword::check($data['password'], $user->user_pass)) {
                return response(null, 401);
            }
            //       CREATE AND SEND TOKEN 
            $token = $user->createToken('myapptoken')->plainTextToken;
            return  $response = [
                'token' => $token
            ];
        }

        return response()->json($validator->errors()->all(), 400);
    }



    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        if (Auth::check($request->user)) {
            return response()->json("Token couldn't delete");
        } else {
            return response()->json(null, 200);
        }
    }
}
