<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Apartment Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    {{ Asset::container('bootstrapper')->styles() }}
    {{ Asset::container('bootstrapper')->scripts() }}    
    {{ Asset::styles() }}
    {{ Asset::scripts() }}
    @yield('header-include')


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
           <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="brand">Apartment Management</span>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as {{Auth::user()->name}}
            </p>
            <script>
            function logout_function()
            {
              //remove the key
              sessionStorage.removeItem("root_url");
              sessionStorage.removeItem("back-url");
            }
            </script>
            <ul class="nav" id="app-top-nav">
                <li>{{HTML::link('members', 'Members');}}</li>
                <li>{{HTML::link('flats', 'Flats');}}</li>
                <li>{{HTML::link('communication', 'Communication');}}</li>
                <li>{{HTML::link('settings', 'Settings');}}</li>
                <li onclick="logout_function()">{{HTML::link('logout', 'Logout');}}</li>
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
