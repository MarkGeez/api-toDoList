<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todos;

class TodoController extends Controller
{

     private function findTodos($id){
    $todo = Todos::findOrFail($id);


    return $todo;
}
   public function create(Request $request){
    $data = $request->validate([
        "title" => "required|string",
        "description" => "required|string"

    ]);

    $todo = Todos::create([
        "title" => $data["title"],
        "description" => $data["description"],
        "user_id" => auth()->user()->id
    ]);

   

    return response()->json([
        "id" => $todo->id,
        "title" => $todo->title,
        "description" => $todo->description
    ]);


   }

   public function update(Request $request, $id){
        $data = $request->validate([

        "title"=> "string",
        "description"=> "string"]);

        $todo = $this->findTodos($id);
        $todo->update([
            "title" => $data["title"],
            "description"=> $data["description"],
        ]);

        return response()->json([
            "id"=> $todo->id,
            "title" => $todo->title,
            "description"=> $todo->description
        ]);
   }

   public function delete($id){
    
    $todo = $this->findTodos($id);


    if (auth()->id() != $todo->user_id) {
        return response()->json([
            "message" => "unauthorized"
        ], 403);
    }
    $todo->delete();

    return response()->json([
        "message" => "deleted"
    ], 204);


   
   }
    public function view(Request $request){
    $limit = $request->input("limit", 10);

    $todo = Todos::where('user_id', auth()->user()->id)->paginate($limit, [
        "id", "title", "description"
    ]);

    return response()->json([
        "data" => $todo->items(),
        "page" =>$todo->currentPage(),
        "limit" => $todo->perPage(),
        "total" => $todo->total()
    ]);
    }
}
 