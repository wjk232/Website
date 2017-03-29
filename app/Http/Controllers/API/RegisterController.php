<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Validator;
use Hash;


class RegisterController extends Controller
{
    /* 
     * register(): Register form on the sign up view POSTS
     * to this function. 
     * This function creates a new user and redirects them to login. 
     */
    public function register(Request $request){
        //Validate input
        $validation = Validator::make($request->all(),[
            'username' =>' required|unique:users', 
            'password' => 'required',
        ]);
        //Return error if input needed
        if($validation->fails()){
            return response()->json([
                'code' => 400,
                'message' => 'Failed: Username already exist.']
            );
        }
        //Create new user
        try{
            $user = User::create([
                'status' => 'offline',
                'password'	=> bcrypt($request->input('password')),
                'username' => $request->input('username'),
                'profile_pic' => $request->input('profile_pic'),
                'api_token' => str_random(120),
                'location' => $request->input('location'),
                'clientID' => $request->input('clientID')
            ]);

        }catch(Exception $e){
            //Errors Log 
            return response()->json([
                'code' => 500,
                'message' => 'Oops! Something is wrong!'
            ]); 
        }

        return response()->json([
            'code' => 201,
            'message' => 'You have registered successfully.',
            'user' => $user
        ]);    

    }   
}
