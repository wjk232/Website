<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	@yield('title')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        @yield('nav-name')
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @if(Session::has('message'))
                        <li class="alert alert-info" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>  
                            {{Session::get('message')}}
                        </li>
                        @endif
                        @if(Session::has('validation_messages'))
                            <li class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button> 
                                @foreach(Session::get('validation_messages')->all() as $error)
                                    {{$error}}<br>
                                @endforeach
                            </li>
                        @endif
                        <!-- Authentication Links -->
                        @if (Request::path() == '/')
                            <li><a href="/">Home</a></li>
                            <li><a href="/chat/nearme">Chat</a></li>
                        @else
                            @if (Auth::guest())
                                <li><a href="/">Home</a></li>
                                <li class="dropdown">
                                    <a id="logIn" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >Login
                                    <span class="caret"></span></a>
                                    <ul class="dropdown-menu" style="width: 250px">
                                        {{Form::open([ 'action' => 'HomeController@loginRegister', 'method' => 'POST'])}}
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Username:</label>
                                            <div class="col-sm-11 ">
                                            {{ Form::text('username', null, [ 'placeholder' => 'Username', 
                                            'class' => 'form-control', 'required']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Password:</label>
                                            <div class="col-sm-11">
                                            {{ Form::password("password" , [ 'placeholder' => 'Password',
                                            'class' => 'form-control', 'required'])}}
                                            </div>	
                                        </div>	
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Location:</label>
                                            <div class="col-sm-11 ">
                                            {{ Form::text('location', 'San Antonio,Texas', [ 'style'=>'color:#a89f9c', 
                                            'class' => 'form-control', 'required']) }}
                                            </div>
                                        </div>
                                        <div class="form-group" id="form" >
                                            <div class="col-sm-offset-5 col-sm-11 " style="margin-top:20px">
                                            {{ Form:: submit('Login/Register',
                                            ['class' => 'col-md-6 btn btn-warning btn-sm button','style'=>'width:auto']) }}
                                            </div>
                                        </div>
                                        {{Form::close()}}
                                    </ul>
                                </li>
                            @else
                                <li><a href="/">Home</a></li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->username }} <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" >
                                        <li><a id="logOut" href="/logout" >Logout</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                  <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Chatroom<span class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                     <li><a href="/chat/nearme">Nearme<sup> (Same city)</sup></a></li>
                                     <li><a href="/chat/region">Region<sup> (Same state)</sup></a></li>
                                  </ul>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Latest compiled and minified JavaScript -->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    
    @yield('footer')
</body>
</html>
