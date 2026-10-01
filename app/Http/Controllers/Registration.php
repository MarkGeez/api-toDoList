<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Registration extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "password" => "required|min:8",

        ]);

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password"=> Hash::make($data["password"]),
        ]);

        return response()->json([
            "message" => "registered sucess",
            "user" => $user,
        ]);
    }

    public function login(Request $request){
         $data = $request->validate([
            "email" => "required|email",
            "password" => "required"
         ]);

        $user = User::where("email", $data["email"])->first();

        if(!$user || !Hash::check($data["password"], $user->password)){
            return response()->json([
                "message"=> "invalid"
            ], 401);
        }

        return response()->json([
            "message"=> "user exist",
           "user" =>$user
        ]);
    }
}
