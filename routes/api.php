<?php

use App\Http\Controllers\Registration;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [Registration::class, 'register']);


Route::get('/users/{user}', function(User $user){
    return $user;
});

Route::post('/login', [Registration::class,'login']);