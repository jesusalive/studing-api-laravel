<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(["store"]);
    }

    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data["password"] = Hash::make($data["password"]);
        return User::create($data);
    }

    public function show($id)
    {
        if(auth()->user()->getAuthIdentifier() != $id)
            return response()->json(["error" => "Unauthorized"], 401);

        $user = User::findOrFail($id);

        return response()->json($user);
    }

}
