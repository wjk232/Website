<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Message;

class MessageController extends Controller
{
       /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
     return response()->json(
         Message::All()
      );
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
     //
   }

   /**
   * Display the specified resource.
   *
   * @param  string  $chatroom 
   * @return \Illuminate\Http\Response
   */
   public function show($_chatroom)
   {
        $chatroom = urldecode($_chatroom);
        $user = User::where('username', '=', request()->input('username'))->first();
        $location = explode( ',', $user['location']);
        $city = $location[0];  
        $state = $location[1];
      
        //Check if user is on same client if not dont proceed 
        if($user['clientID'] != request()->input('clientID')){
            return response()->json([
                'code' => 400,
                'message' => 'Need to signin again.',
                'messages' => []
            ]);
        }
    
        if($chatroom == 'nearme'){
            $chatroom = Message::where('chatroom', '=', 'nearme')->
                       where('location', 'like', '%' . $city . '%')->orderBy('id','DESC')->limit(100)->get();
        }else{
            $chatroom = Message::where('chatroom', '=', 'region')->
                       where('location', 'like', '%' . $state . '%')->orderBy('id','DESC')->limit(100)->get();
        }
       
        return response()->json([
            'code' => 200,
            'message' => 'Success',
            'messages' => $chatroom
        ]);
   }
}
