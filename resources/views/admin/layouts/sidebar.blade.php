<div id="wrapper">
 
  <!--Start sidebar-wrapper-->
   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="{{route('admin.dashboard')}}">
       <img src="{{asset('/images/logo-icon2.png')}}" class="logo-icon" alt="logo icon">
      <!--  <h5 class="logo-text">TRUENET</h5> -->
     </a>
   </div>
   <ul class="sidebar-menu do-nicescrol">
     <!--  <li class="sidebar-header">MOVIE DASHBOARD</li> -->
      <li>
        <a href="{{route('admin.dashboard')}}">
          <i class="zmdi zmdi-view-dashboard"></i><span>Dashboard</span>
        </a>
      </li>
     @canany(['issuper', 'isadmin']) 
      <li>
        <a href="{{route('admin.list')}}">
          <i class="zmdi zmdi-account-circle"></i><span>Admin</span>
        </a>
      </li>
      @endcanany
     
      <li>
        <a href="{{route('category.list')}}">
          <i class="zmdi zmdi-format-list-bulleted"></i><span>Categories</span>
        </a>
      </li>
      <li>
        <a href="{{route('subcategory.list')}}">
          <i class="zmdi zmdi-invert-colors"></i><span>Sub-Categories</span>
        </a>
      </li>
      <li>
        <a href="{{route('moviename.list')}}">
          <i class="fa fa-th-large"></i><span>Movie Names</span>
        </a>
      </li>
       <li>
        <a href="{{route('moviesearch.list')}}">
         <i class="fa fa-film"></i><span>Movie Upload</span>
        </a>
      </li>
       <li>
        <a href="{{route('ads.list')}}">
         <i class="zmdi zmdi-calendar-check"></i><span>Advertising</span>
        </a>
      </li>
       <li>
        <a href="{{route('user.list')}}">
         <i class="fa fa-user"></i><span>User</span>
        </a>
      </li>
       <li>
        <a href="{{route('contact.index')}}">
         <i class="fa fa-home"></i><span>Contact</span>
        </a>
      </li>
      @canany(['issuper', 'isadmin']) 
      <li>
        <a href="{{route('comment.list')}}">
         <i class="fa fa-history"></i><span>History</span>
        </a>
      </li>
      @endcanany

     
     <!--  <li>
        <a href="icons.html">
          <i class="zmdi zmdi-invert-colors"></i> <span>UI Icons</span>
        </a>
      </li>

      <li>
        <a href="forms.html">
          <i class="zmdi zmdi-format-list-bulleted"></i> <span>Forms</span>
        </a>
      </li>

      <li>
        <a href="tables.html">
          <i class="zmdi zmdi-grid"></i> <span>Tables</span>
        </a>
      </li>

      <li>
        <a href="calendar.html">
          <i class="zmdi zmdi-calendar-check"></i> <span>Calendar</span>
          <small class="badge float-right badge-light">New</small>
        </a>
      </li>

      <li>
        <a href="profile.html">
          <i class="zmdi zmdi-face"></i> <span>Profile</span>
        </a>
      </li>

      <li>
        <a href="login.html" target="_blank">
          <i class="zmdi zmdi-lock"></i> <span>Login</span>
        </a>
      </li>

       <li>
        <a href="register.html" target="_blank">
          <i class="zmdi zmdi-account-circle"></i> <span>Registration</span>
        </a>
      </li> -->

   <!--    <li class="sidebar-header">LABELS</li>
      <li><a href="javaScript:void();"><i class="zmdi zmdi-coffee text-danger"></i> <span>Important</span></a></li>
      <li><a href="javaScript:void();"><i class="zmdi zmdi-chart-donut text-success"></i> <span>Warning</span></a></li>
      <li><a href="javaScript:void();"><i class="zmdi zmdi-share text-info"></i> <span>Information</span></a></li> -->

    </ul>
   
   </div>
