<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todos;

class TodoController extends Controller
{
   public function create(Request $request){
    $data = $request->validate([
        "title" => "required|string",
        "description" => "required|string"

    ]);

    $todo = Todos::create([
        "title" => $data["title"],
        "description" => $data["description"]
    ]);

   

    return response()->json([
        "id" => $todo->id,
        "title" => $todo->title,
        "description" => $todo->description
    ]);


   }
}
