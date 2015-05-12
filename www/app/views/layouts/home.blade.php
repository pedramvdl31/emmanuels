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
      <nav class="top-nav text-center">
        {{$menu_html}}
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
      {{$nav_html}}
    </div>
  </div>
</nav>    
<section id="start-offset" class="section" style="padding:0px; margin:0px;" data-url="/"></section> <!-- Home Waypoint Trigger -->

<div style="min-height: 50px;">
  <!-- Jssor Slider Begin -->
  <!-- To move inline styles to css file/block, please specify a class name for each element. --> 
  <!-- ================================================== -->
  <div id="slider1_container" style="display: none; position: relative; margin: 0 auto;
  top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
  <!-- Loading Screen -->
  <div u="loading" style="position: absolute; top: 0px; left: 0px;">
    <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
    top: 0px; left: 0px; width: 100%; height: 100%;">
  </div>
  <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
  top: 0px; left: 0px; width: 100%; height: 100%;">
</div>
</div>
<!-- Slides Container -->
<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px; overflow: hidden;">
  <div>
    <img u="image" src2="packages/jssor.carousel.slider.for.bootstrap.example/img/home/01.jpg" />
  </div>
  <div>
    <img u="image" src2="packages/jssor.carousel.slider.for.bootstrap.example/img/home/02.jpg" />
  </div>
  <div>
    <img u="image" src2="packages/jssor.carousel.slider.for.bootstrap.example/img/home/03.jpg" />
  </div>
</div>

<!--#region Bullet Navigator Skin Begin -->
<!-- Help: http://www.jssor.com/development/slider-with-bullet-navigator-jquery.html -->
<style>
/* jssor slider bullet navigator skin 21 css */
                /*
                .jssorb21 div           (normal)
                .jssorb21 div:hover     (normal mouseover)
                .jssorb21 .av           (active)
                .jssorb21 .av:hover     (active mouseover)
                .jssorb21 .dn           (mousedown)
                */
                .jssorb21 {
                  position: absolute;
                }
                .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
                  position: absolute;
                  /* size of bullet elment */
                  width: 19px;
                  height: 19px;
                  text-align: center;
                  line-height: 19px;
                  color: white;
                  font-size: 12px;
                  background: url(packages/jssor.carousel.slider.for.bootstrap.example/img/b21.png) no-repeat;
                  overflow: hidden;
                  cursor: pointer;
                }
                .jssorb21 div { background-position: -5px -5px; }
                .jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
                .jssorb21 .av { background-position: -65px -5px; }
                .jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
                </style>
                <!-- bullet navigator container -->
                <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
                  <!-- bullet navigator item prototype -->
                  <div u="prototype"></div>
                </div>
                <!--#endregion Bullet Navigator Skin End -->

                <!--#region Arrow Navigator Skin Begin -->
                <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
                <style>
                /* jssor slider arrow navigator skin 21 css */
                /*
                .jssora21l                  (normal)
                .jssora21r                  (normal)
                .jssora21l:hover            (normal mouseover)
                .jssora21r:hover            (normal mouseover)
                .jssora21l.jssora21ldn      (mousedown)
                .jssora21r.jssora21rdn      (mousedown)
                */
                .jssora21l, .jssora21r {
                  display: block;
                  position: absolute;
                  /* size of arrow element */
                  width: 55px;
                  height: 55px;
                  cursor: pointer;
                  background: url(packages/jssor.carousel.slider.for.bootstrap.example/img/a11.png) center center no-repeat;
                  overflow: hidden;
                }
                .jssora21l { background-position: -3px -33px; }
                .jssora21r { background-position: -63px -33px; }
                .jssora21l:hover { background-position: -123px -33px; }
                .jssora21r:hover { background-position: -183px -33px; }
                .jssora21l.jssora21ldn { background-position: -243px -33px; }
                .jssora21r.jssora21rdn { background-position: -303px -33px; }
                </style>
                <!-- Arrow Left -->
                <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
                </span>
                <!-- Arrow Right -->
                <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
                </span>
                <!--#endregion Arrow Navigator Skin End -->
                <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a>
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
            {{ HTML::script('packages/jssor.carousel.slider.for.bootstrap.example/js/jquery-1.9.1.min.js') }}
            {{ HTML::script('packages/bootstrap/js/bootstrap.min.js') }}
            {{ HTML::script('packages/jssor.carousel.slider.for.bootstrap.example/examples-bootstrap/docs.min.js') }}
            {{ HTML::script('packages/jssor.carousel.slider.for.bootstrap.example/examples-bootstrap/ie10-viewport-bug-workaround.js') }}
            {{ HTML::script('packages/jssor.carousel.slider.for.bootstrap.example/js/jssor.slider.mini.js') }}
            {{ HTML::script('packages/modernizr/modernizr.custom.20702.js') }}

            {{ HTML::script('packages/waypoints/waypoints.min.js') }}
            {{ HTML::script('packages/history/scripts/compressed/history.js') }}
            {{ HTML::script('packages/lazyload/jquery.lazyload.min.js')}}
            {{ HTML::script('packages/parallax/parallax.min.js') }}
            {{ HTML::script('packages/lightbox/lightbox.min.js') }}
            {{ HTML::script('js/home_layout.js') }}
            @yield('scripts')
          </body>
          </html>