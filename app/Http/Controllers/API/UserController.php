<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return response()->json(
               User::orderBy('id','DESC')->limit(20)->get()
        );
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        
        return response()->json(
            User::where('id','=',$id)
                ->first()
        );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //Update user profile
        try{
            User::where('id','=',$id)
                ->update(array('profile_pic' => $request->input('profile_pic')));
                
        }catch(Exception $e){
         //Errors Log 
         return response()->json([
                'code' => 400,
                'message' => 'Oops! Something is wrong!'
            ]); 
        }

        $user = User::where('id', '=', $id)->first();
        return response()->json([
            'code' => 200,
            'message' => 'Profile update successfully.',
            'user' => $user
        ]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
    //
    }
}
