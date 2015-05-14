<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Emmanuels</title>

    <!-- Bootstrap -->
	{{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('css/admin_layout.css')}}
    {{ HTML::style('packages/totop/css/ui.totop.css') }}
    {{ HTML::style('packages/datepicker/css/datepicker3.css') }}
    @yield('stylesheets')
  </head>
  <body >
    <div class="navbar navbar-static-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button id="menuButton" type="button" class="pull-left navbar-toggle" data-toggle="offcanvas" style="display:block; border:none;">
            <span class="glyphicon glyphicon-tasks white"></span>
          </button>
     
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand pull-left" href="{{ action('AdminsController@getIndex') }}" style="padding-top:10px;">
            <img src="/img/emmanuels_compact_logo.png" alt="..." height="35" width="136">
          </a>
        </div>
        <div class="collapse navbar-collapse">

          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Users <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>{{ HTML::link('admins/', 'View Users') }}</li>
                <li>{{ HTML::link('admins/edit/2', 'Edit Users') }}</li>
                <li>{{ HTML::link('admins/add', 'Add Users') }}</li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-camera"></span> Resources <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>{{ HTML::link('/resources/edit', 'Manage Resources') }}</li>
               
              </ul>
            </li>            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list-alt"></span> Company <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>{{ HTML::link('/companies/view', 'View Company') }}</li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-wrench"></span> Setup <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>{{ HTML::link('/taxes', 'View Taxes') }}</li>
                <li>{{ HTML::link('/taxes/add', 'Add Tax') }}</li>
                <li>{{ HTML::link('/pages/index', 'Pages') }}</li>
                <li>{{ HTML::link('/menus/index', 'Menus') }}</li>
                <li>{{ HTML::link('/menu-items/index', 'Menu Items') }}</li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> setup <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                @if(!Auth::check())
                <li>{{ HTML::link('users/register', 'Register') }}</li>   
                <li>{{ HTML::link('admins/login', 'Login') }}</li>   
                @else
                  @if(Auth::user()->roles == 3) 

                  <li><a href="/owners/edit/{{ Auth::user()->id }}">Edit User</a></li>
                  @endif
                  @if(Auth::user()->roles == 4)
                  <li><a href="/employees/edit/{{ Auth::user()->id }}">Edit User</a></li>
                  @endif

                  <li>{{ HTML::link('admins/logout', 'Logout') }}</li>
                @endif
              </ul>
            </li>

          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-left side-toggle">
        <div class="col-xs-8 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

        </div>
        <!--/span-->
      <div class="col-xs-12 col-sm-9 col-main">        
        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert_type') }} alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message') }}
            </div>
        @endif
        @yield('content')

      </div><!--/row-->

      <hr>


    </div><!--/.container-->
	<footer class="row-fluid"> 
		<br/>
		<p>&copy; Eyelevate LLC 2014</p>
		<br/>
	</footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {{ HTML::script('packages/bootstrap/js/bootstrap.min.js') }}
    {{ HTML::script('packages/typeahead/js/bootstrap3-typeahead.min.js') }}
    {{ HTML::script('js/admin_layout.js') }}
    {{ HTML::script('js/global_setup.js') }}
    {{ HTML::script('packages/totop/js/easing.js') }}
    {{ HTML::script('packages/totop/js/jquery.ui.totop.min.js') }}
    {{ HTML::script('packages/datepicker/js/bootstrap-datepicker.js') }}
    @yield('scripts')

    <script type="text/javascript">
    $(document).ready(function() {      
      $().UItoTop({ easingType: 'easeOutQuart' });
      
    });
  </script>
  
  </body>

</html>