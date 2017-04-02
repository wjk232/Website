@extends('layouts.app')

@section('title')
  <title>ChatoGo</title>
@stop

@section('style')
  <link rel="stylesheet" type="text/css" href="/css/chat.css">
@stop

@section('content')
    @section('nav-name')
        <a class="navbar-brand" href="#">ChatoGo</a>
    @stop
    <div class="container">
        <div class="container-fluid" >
            <img width="72" height="72" style="display:block; margin:auto;" src="{{url('/images/ChatoGo-icon.png')}}">
            <!-- Chat window for messages -->
            <div class="row" >
                <div id="showMessages"  class="chat-messages col-sm-12 col-md-12" >
                   <!--- Append messages-->
                </div>
            </div>
            <div class="row">
                @if(Auth::check())
                <?php $username = Auth::user()->username; ?>
                <!--- Form to send messages using ajax for not reloading page--->
                <div class="chat-textbox " align="middle" style="background:#D3D3D3">
                    {{Form::open(['id'=>'formM','action' => 'API\FirebaseController@sendChatroomMessage', 'method' => 'POST'])}}
                    {{ csrf_field() }}
                    <div class="input-group ">
                        {{ Form::textarea('message' , null ,[ 'id' => 'output' , 'placeholder' => 'Message....', 'class' => 'form-control input-sm','maxlength' => '160','wrap' => 'hard','rows' => '2', 'required'])}}
                        {{ Form::hidden('username', Auth::user()->username) }}
                        {{ Form::hidden('location', Auth::user()->location) }}
                        {{ Form::hidden('chatname', $chatname) }}
                        {{Form::hidden('api_token', Auth::user()->api_token)}}
                      <span class="input-group-btn" >
                        {{ Form:: submit('Send',['id'=>'sendM','class' => 'btn btn-success button']) }}  
                      </span>
                    </div>
                    {{Form::close()}}
                </div>
                @endif
            </div>
        </div>
    </div>
   
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
@stop


@section('footer')
<!--jQuery--->
	<script>
    $(document).ready(function(){  
        var userIsLoggedIn = '<?php echo Auth::check() ?>';
        var username = '<?php echo $username ?>';
        if(userIsLoggedIn){
          var num = 0;
          var objDiv = document.getElementById("showMessages");
          objDiv.scrollTop = objDiv.scrollHeight;
        }
        //Ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //Ajax call for getting new messages
        var refresh = function(){
            var pathname = window.location.pathname;
            $.ajax(
            {
               url : "/messages"+pathname.substr(1)+"?id="+num,
               type: "GET",
               success:function(data, textStatus, jqXHR)
               {
                    for (var i = data.length-1; i >= 0; i--) {
                        if (data[i].username != username) {
                        $("#showMessages").append('<div id="message" >'+data[i].username+'<div id="message" class="bubble">'+data[i].message+'</div></div><br>'); 
                     }else{
                        $("#showMessages").append('<div id="message" align="right"><div id="message" class="bubble">'+data[i].message+'</div>'+data[i].username+'</div><br>');
                     }
                        num = data[i].id;
                        objDiv.scrollTop = objDiv.scrollHeight;
                    }  
                    
               },
               error: function(jqXHR, textStatus, errorThrown)
               {
               // do something on error
               }
            });

        };
        if(userIsLoggedIn){
            refresh();
            setInterval( refresh, 3000 );
        }
        //Ajax call for posting new messages
        $("#formM").submit(function(e){
            e.preventDefault();
            var data = $("#formM").serializeArray();
            $.ajax(
                {
                    url : "/api/firebase/messagechatroom",
                    type: "POST",
                    data : data,
                    success:function(data, textStatus, jqXHR)
                    {
                        //success
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        // do something on error
                    }
                });
            document.getElementById("output").value = ""; 
        });
    });
	</script>
@stop
