<div class="main-header">
  <div class="main-header-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="<?= base_url() ?>" class="logo">
        <img src="<?= base_url('assets/kaiaadmin/assets/img/kaiadmin/logo_light.svg') ?>" alt="navbar brand" class="navbar-brand" height="20"/>
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>

  <!-- Navbar Header -->
  <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
      <nav class="navbar navbar-header-left navbar-expand-lg p-0 d-none d-lg-flex"  >
        <h3><strong>Point of Sales</strong></h3>
      </nav>
      <ul class="navbar-nav topbar-nav justify-content-between ms-md-auto align-items-center">
        <li class="nav-item topbar-icon hidden-caret d-flex d-lg-none">
          <h3><strong>Point of Sales</strong></h3>      
        </li>
        <li class="nav-item topbar-user dropdown hidden-caret">
          <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false" >
            <div class="avatar-sm">
              <img src="<?= base_url('assets/img/avatar-1.png') ?>" alt="avatar" class="avatar-img rounded-circle" />
            </div>
            <span class="profile-username">
              <span class="op-7">Hi,</span>
              <span id="navbar-username" class="fw-bold"><?= $this->session->userdata('username') ?></span>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <div class="dropdown-user-scroll scrollbar-outer">
              <li>
                <div class="user-box">
                  <div class="avatar-lg">
                    <img src="<?= base_url('assets/img/avatar-1.png') ?>" alt="image profile" class="avatar-img rounded" />
                  </div>
                  <div class="u-text">
                    <h4 id="profile-username"><?= $this->session->userdata('username') ?></h4>
                    <p id="profile-email" class="text-muted"><?= $this->session->userdata('email') ?></p>
                    <span class="badge badge-secondary"><?= $this->session->userdata('role') ?></span>
                  </div>
                </div>
              </li>
              <li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('profile') ?>">My Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a>
              </li>
            </div>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->
</div>