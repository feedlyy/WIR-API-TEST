<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Airlock\PersonalAccessToken;

class UserController extends Controller
{
    //
    public function login (Request $request) {
//        validate input
        $request = $request->all();
        $rules = [ //validation input
            'email' => 'required|email',
            'password' => 'required'
        ];
        $validate = Validator::make($request, $rules);
        if ($validate->fails()) {
            return response()->json($validate->messages()->first(), 401);
        }

        $user = User::where('email', $request)->first();
//        check if the data is correct
        if (! $user || ! Hash::check($request['password'], $user->password)) {
            return response()->json(['Error' => 'Email or Password not correct '], 404);
        }

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $token = $user->createToken(Auth::id());
            return response()->json(['success' => $token->plainTextToken], 200);
        }
        else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function logout () {
        if (Auth::check()) {
            PersonalAccessToken::query()->where('tokenable_id', Auth::id())
                ->delete();
            return response()->json(['success' =>'logout success'],200);
        } else {
            return response()->json(['error' =>'api something went wrong'], 500);
        }
    }
}
