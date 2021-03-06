@extends('layouts.app')

@section('title')
  <title>My Website</title>
@stop

@section('style')
  <link rel="stylesheet" type="text/css" href="/css/profile.css">
@stop

@section('content')
    @section('nav-name')
        <a class="navbar-brand" href="#">Rogelio Espinoza</a>
    @stop
    <div class="container-fluid">
        <div class="row profile_header " >
         <!-- Profile picture-->
         <div class="col-sm-5 col-md-4 " align="middle" >
            <img width="300" height="300" class="img-circle" src="{{url('/images/yo.jpg')}}">
            <h1>Rogelio Espinoza</h1>
            <h2>Software Engineer</h2>
         </div>
         <!-- Carousel-->
         <div id="myCarousel" class="carousel slide col-sm-7 col-md-8" data-ride="carousel">
            <h1 align="middle">My Work</h1>
            <!-- Indicators -->
            <ol class="carousel-indicators">
               <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
               <li data-target="#myCarousel" data-slide-to="1"></li>
               <li data-target="#myCarousel" data-slide-to="2"></li>
               <li data-target="#myCarousel" data-slide-to="3"></li>
               <li data-target="#myCarousel" data-slide-to="4"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <div class="container">
                     <div class="carousel-caption">
                        <img class="img-circle"  src="{{url('/images/chatogo.png')}}" align="middle">
                        <h1>ChatoGo</h1>
                        <p>Android App/Own Project</p>
                        <p><a class="btn btn-lg btn-primary" href="https://play.google.com/store/apps/details?id=com.cyr.chatogo&hl=en" role="button">Check it out</a></p>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="container">
                     <div class="carousel-caption">
                        <img class="img-circle"  src="{{url('/images/jumpingtherope.png')}}" align="middle">
                        <h1>Jumping The Rope</h1>
                        <p>Android Game/Own Project</p>
                        <p><a class="btn btn-lg btn-primary" href="https://play.google.com/store/apps/details?id=com.ryc.jumpingtheropegame&hl=en" role="button">Check it out</a></p>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="container">
                  <div class="carousel-caption">
                     <img class="img-circle" src="{{url('/images/shootingplates.png')}}" align="middle">
                     <h1>Shooting Plates</h1>
                     <p>Android Game/Own Project</p>
                     <p><a class="btn btn-lg btn-primary" href="https://play.google.com/store/apps/details?id=com.RogeryCecy.Fps&hl=en" role="button">Check it out</a></p>
                  </div>
                  </div>
               </div>
               <div class="item">
                  <div class="container">
                     <div class="carousel-caption">
                        <img class="img-circle"  src="{{url('/images/rycracing.png')}}" align="middle">
                        <h1>RYC Racing</h1>
                        <p>Android Game/Own Project</p>
                        <p><a class="btn btn-lg btn-primary" href="https://play.google.com/store/apps/details?id=com.rycracing.ryc&hl=en" role="button">Check it out</a></p>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="container">
                     <div class="carousel-caption">
                        <img class="img-circle"  src="{{url('/images/lockerapp.png')}}" align="middle">
                        <h1>Locker App</h1>
                        <p>Android App/Team Project</p>
                        <p><a class="btn btn-lg btn-primary" href="https://play.google.com/store/apps/details?id=com.archangel.locker&hl=en" role="button">Check it out</a></p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Carousel buttons-->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
               <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
         </div><!-- /.carousel -->
      </div>
      <div class="row .col-xs-6 .col-md-4" align='middle'>
         <h2>Education</h2>
         <b>The University of Texas at San Antonio</b>
         <p>· B.S. in Computer Science</p>
         <b>Relevant Courses</b>
         <p>· Intro Comp Prog II, Data Structures, Analysis Of Algorithms, Application Programming, Software Engineering, Programming Languages, Computer Architecture, System Programming, Operating Systems, Web technologies, Computer Org, Artificial Intelligence, Parallel Programming, Computer Networks, Project Management, Software Validation and Quality Assurance
         </p>
         <h2>Skills & Abilities</h2>
         <b>Programming Languages & Frameworks</b>
         <p>· Perl, Sed, AWK, Java, C, Python, Lisp, MySQL, PHP, Shell, Bash , IA32 Assembly Language , RxJava ,HTML, CSS, Laravel, Bootstrap, JQuery, JavaScript ,Lamp, Wamp</p>
         <b>Software</b>
         <p>· Microsoft Word, Adobe Photoshop, Blender, Unity, Eclipse, Android Studio, Eclipse</p>
         <b>Operating Systems</b>
         <p>· Windows(7, 8, 10), Linux, Unix</p>
         <b>Professional</b>
         <p>· Strong motivational skills, Passionate about computers, Good analytical & logical thinking, Hardworking</p>
      </div>
   </div><!-- /container -->
   
      
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
@stop
