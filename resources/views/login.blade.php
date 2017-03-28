@extends('layouts.app')

@section('title')
	<title>Login Page</title>
@stop

@section('style')
	<link rel="stylesheet" type="text/css" href="/css/login.css">
@stop

@section('content')
	<div class="container">	
		<!--col 1 -->
		<div class="col-md-3">
		</div>

		<!--col 2 -->
		<div class="col-md-6 myform">

			@if(Session::has('error_message'))

				<div class="alert alert-danger" role="alert">
				  {{Session::get('error_message')}}
				</div>

			@endif

			<h1 class="text-center">Welcome to ChatoGO</h1>
			<p class="text-center text-blue">Login to get started</p>

			{{Form::open(['action' => 'HomeController@loginRegister', 'method' => 'POST', 'class' => 'form-horizontal'])}}

			<div class="form-group">
				<label class="col-sm-2 control-label">Username</label>
				<div class="col-sm-10">
					{{ Form::text('username', null, [ 'placeholder' => 'Username', 
					'class' => 'form-control', 'required']) }}
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-2 control-label">Location</label>
				<div class="col-sm-10">
					{{ Form::text('location', 'San Antonio Texas', [ 'placeholder' => 'San Antonio Texas', 
					'class' => 'form-control', 'required']) }}
            </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
					{{ Form::password("password" , [ 'placeholder' => 'Password', 'class' => 'form-control', 'required'])}}
				</div>	
			</div>	
         
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				{{ Form:: submit('Login', [ 'class' => 'btn btn-primary btn-block']) }}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10 text-center">
				<p class="text-center">Don't have an account? <a href="/signup" class="btn btn-link">Sign up</a></p>	
				
				</div>
			</div>
			{{Form::close()}}
		</div>

		<!--col 3 -->
		<div class="col-md-3">
		</div>	
	</div>
@stop
