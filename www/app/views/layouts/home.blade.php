<?php
/**
* Declare or set any page wide variables here
*/


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="img/yongs_red.svg" type="image/icon">
    <title>Emmanuel's</title>

    <!-- Bootstrap -->
	{{ HTML::style('http://fonts.googleapis.com/css?family=Lobster|Oswald:400,300,700') }}
	{{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('css/image_lightbox.css') }}
    {{ HTML::style('css/home_layout.css')}}
    @yield('stylesheets')

    <!--[if lt IE 9]>
      <script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body id="top" class="clearfix homepoint" data-spy="scroll" data-target="#nav">
    
    <header class="site-header">
      <div id="headerNav" class="container col-md-8 col-md-offset-2">
        <a href="/" class="my-svg-container">
            <img src="/img/emmanuels_logo.png" onerror="this.onerror=null; this.src='/img/emmanuels_logo.jpg'" alt="..." >
        </a>
          
        <nav class="top-nav center">
			<ul id="mainMenuList" class="mainMenuListFull">
				<li class="{{ $home_active }}"><a href="/"> Home</a></li>
				<li class="{{ $services_active }}"><a href="/services"> Services</a></li>
				<li class="{{ $market_active }}"><a href="/marketplace"> Marketplace</a></li>
				<li class="{{ $aboutus_active }}"><a href="/aboutus"> About Us</a></li>
				<li class="{{ $advice_active }}"><a href="/advice"> Advice</a></li>
				<li class="{{ $contactus_active }}"><a href="/contactus"> Contact Us</a></li>
			</ul>
			<select id="mainMenuSelect" class="form-control">
			  <option value="/" {{ $home_nav_active }}>Home</option>
			  <option value="/services" {{ $services_nav_active }}>Services</option>
			  <option value="/marketplace" {{ $market_nav_active }}>Marketplace</option>
			  <option value="aboutus" {{ $aboutus_nav_active }}>About Us</option>
			  <option value="advice" {{ $advice_nav_active }}>Advice</option>
			  <option value="contactus" {{ $contactus_nav_active }}>Contact Us</option>
			</select>
<!--           <ul >
          	<li class="{{ $home_active }}"><a href="/"> Home</a></li>
            <li class="{{ $services_active }}"><a href="/services"> Services</a></li>
            <li class="{{ $market_active }}"><a href="/marketplace"> Marketplace</a></li>
            <li class="{{ $aboutus_active }}"><a href="/aboutus"> About Us</a></li>
            <li class="{{ $advice_active }}"><a href="/advice"> Advice</a></li>
            <li class="{{ $contactus_active }}"><a href="/contactus"> Contact Us</a></li>
          </ul> -->
        </nav>


      </div>

    </header> 
    
    <!-- stickyNav -->

    <nav id="nav" class="navbar navbar-inverse navbar-static-top" role="navigation">
      <div class="container">
        
        <div class="navbar-header">

          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/" style="position:absolute; top:-10px; left:10px;">        	
          	<img src="/img/emmanuels_compact_logo.png" onerror="this.onerror=null; this.src='/img/emmanuels_compact_logo.jpg'" alt="..." style="height:40px; width:136px;"/>
          </a>
        </div>
        
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right" >
          	<li class="{{ $home_nav_active }}"><a href="/"> Home</a></li>
            <li class="{{ $services_nav_active }}"><a href="/services"> Services</a></li>
            <li class="{{ $market_nav_active }}"><a href="/marketplace"> Marketplace</a></li>
            <li class="{{ $aboutus_nav_active }}"><a href="/aboutus"> About Us</a></li>
            <li class="{{ $advice_nav_active }}"><a href="/advice"> Advice</a></li>
            <li class="{{ $contactus_nav_active }}"><a href="/contactus"> Contact Us</a></li>
          </ul>
        </div>
      </div>
    </nav>    
    <section id="start-offset" class="section" style="padding:0px; margin:0px;" data-url="/"></section> <!-- Home Waypoint Trigger -->

	<div style="width:100%;" data-parallax="scroll" data-image-src="/img/black-silver.jpg">
		<!-- Jssor Slider Begin -->
	    <!-- You can move inline styles to css file or css block. -->
		<div id="slider1_container" >
	        <!-- Loading Screen -->
	        <div class="slider_loading" u="loading">
	            <div id="slider_block1">
	            </div>
	            <div id="slider_block2">
	            </div>
	        </div>
	        <!-- Slides Container -->
	        <div class="slides_container" u="slides" style="">
	            <div class="fullscreen background" style="background-image:url('http://lorempixel.com/1300/500/');" data-img-width="1300" data-img-height="500"></div>
	            <div class="fullscreen background" style="background-image:url('http://lorempixel.com/1300/500/');" data-img-width="1300" data-img-height="500"></div>
	            <div class="fullscreen background" style="background-image:url('http://lorempixel.com/1300/500/');" data-img-width="1300" data-img-height="500"></div>
	        </div>

	        <!-- bullet navigator container -->
	        <div u="navigator" class="jssorb21">
	            <!-- bullet navigator item prototype -->
	            <div u="prototype"></div>
	        </div>
	        <!-- Bullet Navigator Skin End -->

	        <!-- Arrow Left -->
	        <span u="arrowleft" class="jssora21l">
	        </span>
	        <!-- Arrow Right -->
	        <span u="arrowright" class="jssora21r">
	        </span>

	    </div>
	    <!-- Jssor Slider End -->
	</div>
    

    <div class="container-fluid">
    	<div id="startContent" class="row" data-parallax="scroll" data-image-src="/img/parallax_rug2.jpg">
	        <div id="contentDiv" class="col-md-8 col-md-offset-2" >
            @if(Session::has('message'))
                <div class="alert {{ Session::get('alert_type') }} alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  {{ Session::get('message') }}
                </div>
            @endif
            @yield('content')
	      	</div><!--/row-->
    	</div>
    </div>
	<footer class="row-fluid clearfix">
		<p>&copy; emmanuel's {{ date('Y') }}</p>
	</footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {{ HTML::script('packages/jssor/js/jssor.js') }}
   	{{ HTML::script('packages/jssor/js/jssor.slider.min.js') }}
    {{ HTML::script('packages/modernizr/modernizr.custom.20702.js') }}
    {{ HTML::script('packages/bootstrap/js/bootstrap.min.js') }}
    {{ HTML::script('packages/waypoints/waypoints.min.js') }}
    {{ HTML::script('packages/history/scripts/compressed/history.js') }}
    {{ HTML::script('packages/lazyload/jquery.lazyload.min.js')}}
    {{ HTML::script('packages/parallax/parallax.min.js') }}
    {{ HTML::script('packages/lightbox/lightbox.min.js') }}
    {{ HTML::script('js/home_layout.js') }}
    @yield('scripts')
  </body>
</html>