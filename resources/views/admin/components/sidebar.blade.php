 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
      <span class="brand-text font-weight-light">SSG ADMIN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ url('static/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('admin.home') }}" class="d-block">{{ session()->get('admin_auth')['username'] }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" id="sidenav" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('admin.home') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.voters.index') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Voters
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.candidates.index') }}" class="nav-link">
              <i class="nav-icon fas fa-user-shield"></i>
              <p>
                Candidates
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.positions.index') }}" class="nav-link">
              <i class="nav-icon fas fa-poll"></i>
              <p>
                Positions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.votes.index') }}" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Votes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script>
  const sidebar = document.querySelectorAll('#sidenav > .nav-item > a')
  const url = window.location.href.split('?')[0]

  sidebar.forEach((el) => {
    const link = el.getAttribute('href')

    if(url === link) {
      el.classList.add('active')
    } else {
      el.classList.remove('active')
    }
  })

</script>