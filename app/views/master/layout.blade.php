<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <meta charset="utf-8">
    <title>@yield("title") | Planview Demos</title>
    <meta name="description" content="">
    <meta name="robots" content="{{{ $robots or 'noindex,nofollow' }}}">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8; IE=EmulateIE9">
    @section('styles')
      {{ HTML::style('/css/bootstrap.min.css') }}
      {{ HTML::style('//fast.fonts.net/cssapi/2efe21fa-d468-4c24-a867-67a8c2fb7004.css') }}
      {{ HTML::style('/css/style.css') }}
      <!-- individual page styles -->
    @show
  </head>
  <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>
  <header id="site-header">
    <nav id="nav-menu-demos" class="menu-top">
    <ul>
      <li>{{HTML::link('/demos', 'Home', array('id' => 'topnav-home'));}}</li>
      <li>{{HTML::link('/demos', 'Demos', array('id' => 'topnav-demos'));}}</li>
      <li>{{HTML::link('/demos', 'Logout', array('id' => 'topnav-logout'));}}</li>

        <li>{{HTML::link('/users', 'Admin', array('id' => 'topnav-admin'));}}
          <ul id="topnav-admin-dropdown">
            @section('nav_menu_admin')
            <li>{{HTML::link('/pvadmin/demos', 'All Demos', array('id' => 'topnav-admin-demos'));}}</li>
            <li>{{HTML::link('/pvadmin/users', 'Admin Users', array('id' => 'topnav-admin-users'));}}</li>
            <li>{{HTML::link('/pvadmin/roles', 'Roles', array('id' => 'topnav-admin-roles'));}}</li>
            <li>{{HTML::link('/pvadmin/permissions', 'Permissions', array('id' => 'topnav-admin-permissions'));}}</li>
            @show
          </ul>
      </li>     
    </ul>
    </nav>
  </header>
    <main id="page-body" class="container-fluid">
      @yield("page_messages",'')
      @yield('content')
    </main>
    @section('scripts')
      {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
      {{ HTML::script('/js/bootstrap.min.js') }}
      <!-- individual page scripts -->
    @show
    <footer id="site-footer">
      &copy; <?php echo date("Y"); ?> Planview, Inc., All Rights Reserved. 
    </footer>
  </body>
</html>
