<?php

use App\Http\Controllers\Registration;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;


Route::post('/register', [Registration::class, 'register']);


Route::get('/users/{user}', function(User $user){
    return $user;
});

Route::post('/login', [Registration::class,'login']);

Route::prefix('/user')->middleware('auth:sanctum')->group(function(){
Route::post('/add', [TodoController::class, 'create'])->name('task.add');
Route::patch('/todos/{id}', [TodoController::class,'update'])->name('task.update');
Route::delete('/todos/{id}', [TodoController::class,'delete'])->name('task.delete');

});