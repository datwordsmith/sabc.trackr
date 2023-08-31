<aside class="left-sidebar bg-danger-subtle">
    <!-- Sidebar scroll-->
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="{{ url('t/projects')}}" class="text-nowrap logo-img">
          <img src="{{ asset('assets/trackr_logo_main.png') }}" width="180" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler " id="sidebarCollapse">
            <i class="fas fa-bars" style="color: #ffffff;"></i>
        </div>
      </div>
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar mt-5 pb-5" data-simplebar="">
        <ul id="sidebarnav">
          {{-- <li class="nav-small-cap">
            <i class="ti ti-layout-dashboard"></i>
            <span class="hide-menu">Home</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('t/dashboard')}}" aria-expanded="false">
              <span>
                <i class="ti ti-layout-dashboard"></i>
              </span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>--}}
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('t/projects')}}" aria-expanded="false">
              <span>
                <i class="fas fa-project-diagram"></i>
              </span>
              <span class="hide-menu">Projects</span>
            </a>
          </li>
          {{-- <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">UI COMPONENTS</span>
          </li> --}}
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('t/user_roles')}}" aria-expanded="false">
              <span>
                <i class="fas fa-tasks"></i>
              </span>
              <span class="hide-menu">User Roles</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('t/users')}}" aria-expanded="false">
              <span>
                <i class="fas fa-users"></i>
              </span>
              <span class="hide-menu">Users</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('t/material-categories')}}" aria-expanded="false">
              <span>
                <i class="fas fa-puzzle-piece"></i>
              </span>
              <span class="hide-menu">Categories</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('t/measures')}}" aria-expanded="false">
              <span>
                <i class="fas fa-ruler-combined"></i>
              </span>
              <span class="hide-menu">Units/Measures</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('t/materials')}}" aria-expanded="false">
              <span>
                <i class="fas fa-tools"></i>
              </span>
              <span class="hide-menu">Site Materials</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('t/vendors')}}" aria-expanded="false">
              <span>
                <i class="fas fa-user-tag"></i>
              </span>
              <span class="hide-menu">Vendors</span>
            </a>
          </li>
          {{-- <li class="sidebar-item">
            <a class="sidebar-link" href="./ui-card.html" aria-expanded="false">
              <span>
                <i class="fas fa-file-invoice"></i>
              </span>
              <span class="hide-menu">Budgets</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="./ui-forms.html" aria-expanded="false">
              <span>
                <i class="fas fa-hand-holding"></i>
              </span>
              <span class="hide-menu">Requisitions</span>
            </a>
          </li> --}}

          {{-- <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">AUTH</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
              <span>
                <i class="ti ti-login"></i>
              </span>
              <span class="hide-menu">Login</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
              <span>
                <i class="ti ti-user-plus"></i>
              </span>
              <span class="hide-menu">Register</span>
            </a>
          </li>
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">EXTRA</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
              <span>
                <i class="ti ti-mood-happy"></i>
              </span>
              <span class="hide-menu">Icons</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
              <span>
                <i class="ti ti-aperture"></i>
              </span>
              <span class="hide-menu">Sample Page</span>
            </a>
          </li>
        </ul> --}}
        <div class="hide-menu position-relative mb-7 mt-5 rounded">
          <div class="d-flex">

            <div class="">
              {{-- <img src="{{ asset('admin/assets/images/backgrounds/rocket.png') }}" alt="" class="img-fluid"> --}}
              <img src="{{ asset('assets/sabc_logo.png') }}" alt="" class="img-fluid">
            </div>
          </div>
        </div>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>
