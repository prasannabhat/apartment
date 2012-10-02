<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Apartment Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    {{ Asset::styles() }}
    {{ Asset::scripts() }}
    {{ Asset::container('bootstrapper')->styles() }}
    {{ Asset::container('bootstrapper')->scripts() }}    


    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">Apartment Management</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as {{Auth::user()->name}}
            </p>
            <ul class="nav">
                <li>{{HTML::link('members', 'Members');}}</li>
                <li>{{HTML::link('flats', 'Flats');}}</li>
                <li>{{HTML::link('logout', 'Logout');}}</li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
             @yield('nav-sidebar')
        </div><!--/span-->
        <div class="span10">
            @yield('content')
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p class="navbar-fixed-bottom">&copy; Prasanna 2012</p>
      </footer>

    </div><!--/.fluid-container-->
  </body>
</html>
