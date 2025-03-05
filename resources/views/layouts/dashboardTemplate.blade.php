<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Default Title')</title>

    <!-- Plugins: CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <!-- Favicon -->
    <!-- Material Design Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

  </head>
  <body>
    <div class="container-scroller">
      <!-- Navbar -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
          </a>
          <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo-mini">
          </a>
        </div>

        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>

          <!-- Search Field -->
          <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" method="GET" action="{{ url()->current() }}" id="searchForm">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" name="search" 
                       placeholder="Search..." value="{{ request('search') }}" id="searchInput">
              </div>
            </form>
          </div>

          <!-- Profile Dropdown -->
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                <img src="{{ Auth::user()->role === 'admin' 
                  ? asset('assets/images/faces/teacher.svg') 
                  : asset('assets/images/faces/student.svg') }}" 
                  alt="{{ Auth::user()->role }} profile">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="#"><i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="mdi mdi-logout me-2 text-primary"></i> Sign out
                    </button>
                </form>
            </div>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Navbar -->

      <div class="container-fluid page-body-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                <img src="{{ Auth::user()->role === 'admin' 
                  ? asset('assets/images/faces/teacher.svg') 
                  : asset('assets/images/faces/student.svg') }}" 
                  alt="{{ Auth::user()->role }} profile">
                  <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                  <span class="text-secondary text-small">{{ Auth::user()->role }}</span>
                </div>
              </a>
            </li>

            @if(Auth::user()->role == 'admin')
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('students') }}">
                <span class="menu-title">Student Table</span>
                <i class="mdi mdi-account-details menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('subjects') }}">
                <span class="menu-title">Subjects</span>
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
              </a>
            </li>
            @endif

            @if(Auth::user()->role == 'student')
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboardStudent') }}">
                <span class="menu-title">Student Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            @endif

            
          </ul>
        </nav>
        <!-- End Sidebar -->

        <div class="main-panel">
          @yield('content')
        </div>

        <!-- Footer -->
        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © bootstrapdash.com 2021</span>
            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">
              Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin template</a> from Bootstrapdash.com
            </span>
          </div>
        </footer>
        <!-- End Footer -->
      </div>
    </div>

    <!-- Plugins: JS -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>

    <!-- Search Auto-Submit -->
    <script>
      document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(this.delay);
        this.delay = setTimeout(() => {
          document.getElementById('searchForm').submit();
        }, 500);
      });
    </script>
  </body>
</html>
