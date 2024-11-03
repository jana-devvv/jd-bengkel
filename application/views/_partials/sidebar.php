<?php 
$url1 = $this->uri->segment(1);
$url2 = $this->uri->segment(2);
 ?>

<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="<?= base_url() ?>" class="logo">
        <img
          src="<?= base_url('assets/kaiaadmin/assets/img/kaiadmin/logo_light.svg') ?>"
          alt="navbar brand"
          class="navbar-brand"
          height="20"
        />
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

  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <!-- Beranda/Dashboard -->
        <li class="nav-item <?= $url1 == 'dashboard' ? 'active' : '' ?>">
          <a href="<?= base_url('dashboard') ?>">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <!-- Pengelolaan/Management -->
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Management</h4>
        </li>
          <!-- Barang/Item -->
          <li class="nav-item <?= $url1 == 'management' && $url2 == 'item' ? 'active' : '' ?>">
            <a href="<?= base_url('management/item') ?>">
              <i class="fas fa-box"></i>
              <p>Item</p>
            </a>
          </li>
          <!-- Jasa/Service -->
          <li class="nav-item <?= $url1 == 'management' && $url2 == 'service' ? 'active' : '' ?>">
            <a href="<?= base_url('management/service') ?>">
              <i class="fas fa-wrench"></i>
              <p>Service</p>
            </a>
          </li>
          <!-- Pelanggan/Customer -->
          <li class="nav-item <?= $url1 == 'management' && $url2 == 'customer' ? 'active' : '' ?>">
            <a href="<?= base_url('management/customer') ?>">
              <i class="fas fa-user-friends"></i>
              <p>Customer</p>
            </a>
          </li>
          <!-- Pengguna/User -->
          <li class="nav-item <?= $url1 == 'management' && $url2 == 'user' ? 'active' : '' ?>">
            <a href="<?= base_url('management/user') ?>">
              <i class="fas fa-user-cog"></i>
              <p>User</p>
            </a>
          </li>
        
        <!-- Transaction/Transaksi -->
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Transaction</h4>
        </li>
          <!-- Penjualan/Sale -->
          <li class="nav-item <?= ($url1 == 'transaction' && $url2 == 'sale') ? 'active' : '' ?>">
            <a href="<?= base_url('transaction/sale') ?>">
              <i class="fas fa-receipt"></i>
              <p>Sale Transaction</p>
            </a>
          </li>

        <!-- Report/Laporan -->
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Report</h4>
        </li>
          <!-- Penjualan/Sale -->
          <li class="nav-item <?= ($url1 == 'report' && $url2 == 'sale') ? 'active' : '' ?>">
            <a href="<?= base_url('report/sale') ?>">
              <i class="fas fa-chart-line"></i>
              <p>Sale Report</p>
            </a>
          </li>
      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->