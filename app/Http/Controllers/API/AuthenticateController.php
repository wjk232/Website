<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class AuthenticateController extends Controller
{
    /**
    * User login method
    * This method returns a token for user to request info
    */
	public function login(Request $request){
		if (Auth::attempt($request->only('username', 'password'), true)){
            //Update clientID
            User::where('username',$request->input('username') )
                  ->update(array('clientID' => $request->input('clientID')));

            $user = User::where('username', '=', $request->input('username'))->first();
            return response()->json([
                'code' => 200,
                'message' => 'You have login successfully.',
                'user' => $user,
                'token' => $user['api_token']
            ]); 
		}else{
			return response()->json([
            'code' => 400,
            'message' => 'Signin failed'
            ]);
		}
	}
}
