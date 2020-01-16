<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class userController extends Controller
{
    function list(){

    $user = User::all();
        return response()->json($user);
    }
}
