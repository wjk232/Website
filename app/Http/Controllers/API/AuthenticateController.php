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
        $username = base64_decode($request->input('username'));
        $password = base64_decode($request->input('password'));
		if (Auth::attempt(['username' => $username, 'password' => $password], true)){
            //Update clientID
            User::where('username','=',$username)
                ->update(array(
                    'clientID' => $request->input('clientID'),
                    'status' => 'online'
                ));

            $user = User::where('username', '=', $username)->first();
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
    
    /**
    * User logout method
    */
	public function logout(){
        //Update status
        User::where('username',request()->input('username'))
            ->update(array('status' => 'offline'));

        return response()->json([
            'code' => 200,
            'message' => 'You have logout successfully.'
        ]); 
	}
}
