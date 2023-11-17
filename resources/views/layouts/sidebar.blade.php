<aside class="main-sidebar sidebar-dark-primary elevation-4 bg-custom-gelap">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
      <img src="@image('/Logo.png')" alt="AdminLTE Logo" class="brand-image img-fluid elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">UFI Helpdesk</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <!--div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="@image('/Logo.png')" class="img-fluid elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">UFI Helpdesk</a>
        </div>
      </div-->

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt text-success"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('ticket') }}" class="nav-link">
              <i class="nav-icon fas fa-columns text-success"></i>
              <p>
                Ticket
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('user') }}" class="nav-link">
              <i class="nav-icon fas fa-user text-success"></i>
              <p>
                User
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('category') }}" class="nav-link">
              <i class="nav-icon fas fa-user text-success"></i>
              <p>
                category
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>