<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;
use Redirect;
use View;
use DB;
use App\Message;
use App\User;

class HomeController extends Controller
{
    /**
    * Make profile view
    */
	public function showProfile()
	{
		return View::make('profile');
	}
    
    /**
    * Make chat view if logged in
    * got to login otherwise
    */
    public function showChat($chatname){
            //Return messages
            return View::make('chat', [
                'chatname' => $chatname,
                'username' => ''
            ]);
    }
   
    /**
    * Login user in website chatroom
    * return session message
    */
    public function loginRegister(Request $request){
        $validation = Validator::make($request->all(),[
            'username' =>' required|unique:users', 
            'password' => 'required',
            'location' => 'required'
        ]);
        //Initilizing var
        $password = $request->input('password');
        $username = ucfirst($request->input('username'));
        $message = '';
        $_locations = explode( ' ', $request->input('location'));
        $address = '';

        //Parse location input for json call
        foreach($_locations as $_location){
            $address .= $_location . '+';
        }
        //For getting the address from location input
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address;
        $json = file_get_contents($url);
        $response = json_decode($json);
        $address_component = $response->results[0]->address_components;
        $location = '';

        //Geting address from json response
        foreach($address_component as $component){
        $types = $component->types;
        foreach($types as $type){
            if($type == 'locality'){
                $location .= $component->long_name . ',';
            }
            if($type == 'administrative_area_level_1'){
                $location .= $component->long_name . ' ';   
            }
            if($type == 'country'){
                $location .= $component->short_name; 
            }
        }
        }

        //Check if user is registered and try to login
        if (Auth::attempt($request->only('username', 'password'), true)){
            //Update location
            User::where('username',$username )
                ->update(array('location' => $location));
            User::where('username',$username )
                ->update(array('clientID' => 'server'));
               
            Session::flash('message', 'You have signin successfully.');
            return redirect('/chat/nearme/');
        }else{         
            //Check if user is available to register
            if($validation->fails()){
                $messages = $validation->messages();
                Session::flash('validation_messages', $messages);
                return Redirect::back()->withInput();
            }
           
            //Create new user
            try{
                User::create([
                    'password'	=> bcrypt($password),
                    'username' => ucfirst($username),
                    'api_token' => str_random(120),
                    'profile_pic' => 'none',
                    'location' => $location,
                    'clientID' => 'server'
                ]);

            }catch(Exception $e){
                //Errors Log 
                Session::flash('message', $e->getMessage());
                return Redirect::back()->withInput(); 
            }
            Session::flash('message', 'Registered successfully');
            return Redirect::back();
        }
        
        Session::flash('message', 'Login/Register failed.');
        return Redirect::back();
    }

   
    /*
    * Returns messages from chatroom 
    * nearme or region   
    */
    public function messagesForChat($chatname){
        $id = request()->id;
        $user = Auth::user();
        $location = explode( ',', $user['location']);
        $city = $location[0];  
        $state = $location[1];

        if($chatname == "nearme"){
            $_chatroom = Message::where('chatroom', '=', $chatname)->
                            where('location', 'like', '%' . $city . '%')->where('id', '>', $id)->orderBy('id','DESC')->limit(100)->get();
        }else{
            $_chatroom = Message::where('chatroom', '=', $chatname)->
                            where('location', 'like', '%' . $state . '%')->where('id', '>', $id)->orderBy('id','DESC')->limit(100)->get();
        }

        //Return messages
        if(count($_chatroom) > 0){
            $chatroom = $_chatroom;
        }else{
            $chatroom = null;
        }

        return $chatroom; 
    }
   
    /**
    * Logout 
    */
    public function logout(){
        Session::flush();
        Auth::logout();
        return Redirect::back();
	}
}
