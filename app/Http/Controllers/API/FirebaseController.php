<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Message;
use DB;

class FirebaseController extends Controller
{
    /**
     * Notify users that a user has updated
     * his/her profile
     */
    public function notifyChanges(){
        $url = 'https://fcm.googleapis.com/fcm/send';
        $key = env('FIREBASEKEY');
        $user = User::where('username', '=', urldecode(request()->username))->first();
        
        $data =  array(
            'to' => '/topics/' . env('BROADCAST'),
            'data' => array(
                    'type' => 'update',
                    'username' => $user['username']
                    )
        );

        $headers = array(
            'Authorization: key=' . $key,
            'Content-Type: application/json'
        );

        $options = array(
            'http' => array(
                'header'  => $headers,
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            return response()->json([
                'code' => 400,
                'message' => 'Oops! Something is wrong!'
            ]);     
        }
        return response()->json([
                'code' => 200,
                'message' => 'Succesful!'
            ]);   
    }
    
   /*
   *sendUserMessage():
   *
   */
   public function sendUserMessage(Request $request){
        DB::reconnect();
        $key = env('FIREBASEKEY');
        $username = $request->input('username');
        $usernameTo = $request->input('usernameTo');
        $message = $request->input('message');
        $userTo = User::where('username', '=', $usernameTo)->first();
        $user = User::where('username', '=', $username)->first();
        $url = 'https://fcm.googleapis.com/fcm/send';

        if($userTo['clientID'] == 'server' || $userTo['status'] == 'offline'){
            //user not in an app
            return response()->json([
                'code' => 400,
                'message' => 'User is unable to receive messages.',
                'content' => $message
            ]); 
        }
      
        $data =  array(
            'to' => $userTo['clientID'],
            'data' => array(
                        'type' => 'user',
                        'id' => $user['id'],
                        'username' => $username,
                        'message' => $message,
                        'usernameTo' => $usernameTo
                    )
        );

        $headers = array(
            'Authorization: key=' . $key,
            'Content-Type: application/json'
        );

        $options = array(
            'http' => array(
                'header'  => $headers,
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            return response()->json([
                'code' => 400,
                'message' => 'Oops! Something is wrong!',
                'content' => $message
            ]);     
        }

        return response()->json([
            'code' => 200,
            'message' => 'Message sent',
            'content' => $message
        ]); 
   }

     /*
     *sendMessageChatroom():
     *
     */
    public function sendChatroomMessage(Request $request){
        $key = env('FIREBASEKEY');
        $username = $request->input('username');
        $message = '' . $request->input('message');
        $chatroom = $request->input('chatname');
        $location = $request->input('location');
        $url = 'https://fcm.googleapis.com/fcm/send';
        DB::reconnect();
                
        try{
			Message::create([
				'username'	=> $username,
				'message'	=> $message,
				'chatroom' => $chatroom,
                'location' => $location
			]);

		}catch(Exception $e){
			//Errors Log 
			return response()->json([
                'code' => 400,
                'message' => 'Oops! Something is wrong!' . $e->getMessage()
            ]); 
		}

        $data =  array(
            'to' => '/topics/' . $chatroom,
            'data' => array(
                        'type' => 'chatroom',
                        'location' => $location,
                        'username' => $username,
                        '$message' => $message
                    )
        );
 
        $headers = array(
            'Authorization: key=' . $key,
            'Content-Type: application/json'
        );

        $options = array(
            'http' => array(
                'header'  => $headers,
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        if ($result === FALSE) {
            return response()->json([
                'code' => 400,
                'message' => 'Oops! Something is wrong!'
            ]);     
        }
        
        return response()->json([
            'code' => 200,
            'message' => 'Message sent'
        ]);
    }
}
