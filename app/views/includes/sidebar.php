<?php
    $currentPath = preg_replace('/\s+/', '', basename($_SERVER['REQUEST_URI']));
    function isActive($routes, $currentPath) {
        return in_array($currentPath, (array)$routes) ? 'active' : '';
    }

    function isShow($routes, $currentPath) {
        return in_array($currentPath, (array)$routes) ? 'show' : '';
    }
?>

<!-- Sidebar Start -->
<div id="layoutSidenav_nav">
  <nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
      <div class="nav accordion" id="accordionSidenav">

        <div class="sidenav-menu-heading">Core</div>
        <a class="nav-link <?= isActive(['dashboard'], $currentPath) ?>" href="<?php echo $rootUrl ?>/dashboard">
          <div class="nav-link-icon text-secondary"><i data-feather="activity"></i></div>
          Dashboard
        </a>

        <div class="sidenav-menu-heading">Admin</div>

        <!-- Users -->
        <a class="nav-link collapsed <?= isActive(['allusers', 'createuser'], $currentPath) ?>" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false">
          <div class="nav-link-icon"><i data-feather="users"></i></div> Staff
          <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse <?= isShow(['allusers', 'createuser'], $currentPath) ?>" id="collapseUsers" data-bs-parent="#accordionSidenav">
          <nav class="sidenav-menu-nested nav">
            <a class="nav-link <?= isActive('allusers', $currentPath) ?>" href="<?php echo $rootUrl ?>/allusers">All Staffs</a>
            <a class="nav-link <?= isActive('createuser', $currentPath) ?>" href="<?php echo $rootUrl ?>/createuser">Create Staff Account</a>
          </nav>
        </div>

        <!-- Locations -->
        <a class="nav-link collapsed <?= isActive(['createlocation', 'locations'], $currentPath) ?>" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLocations" aria-expanded="false">
          <div class="nav-link-icon"><i data-feather="navigation"></i></div> Location
          <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse <?= isShow(['createlocation', 'locations'], $currentPath) ?>" id="collapseLocations" data-bs-parent="#accordionSidenav">
          <nav class="sidenav-menu-nested nav">
            <a class="nav-link <?= isActive('createlocation', $currentPath) ?>" href="<?php echo $rootUrl ?>/createlocation">Create Location</a>
            <a class="nav-link <?= isActive('locations', $currentPath) ?>" href="<?php echo $rootUrl ?>/locations">View All Locations</a>
          </nav>
        </div>

        <!-- Schedules -->
        <a class="nav-link collapsed <?= isActive(['createschedule', 'allschedules'], $currentPath) ?>" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseSchedules" aria-expanded="false">
          <div class="nav-link-icon"><i data-feather="clock"></i></div> Schedule
          <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse <?= isShow(['createschedule', 'allschedules'], $currentPath) ?>" id="collapseSchedules" data-bs-parent="#accordionSidenav">
          <nav class="sidenav-menu-nested nav">
            <a class="nav-link <?= isActive('createschedule', $currentPath) ?>" href="<?php echo $rootUrl ?>/createschedule">Create Schedule</a>
            <a class="nav-link <?= isActive('allschedules', $currentPath) ?>" href="<?php echo $rootUrl ?>/allschedules">View All Schedules</a>
          </nav>
        </div>

        <!-- Reports -->
        <a class="nav-link <?= isActive('generatereport', $currentPath) ?>" href="<?php echo $rootUrl ?>/generatereport">
          <div class="nav-link-icon"><i data-feather="printer"></i></div>
          Generate Report
        </a>

        <div class="sidenav-menu-heading">Profile</div>

        <a class="nav-link <?= isActive('profile_details', $currentPath) ?>" href="<?php echo $rootUrl ?>/profile_details">
          <div class="nav-link-icon"><i data-feather="user"></i></div> View Profile
        </a>

        <a class="nav-link <?= isActive('change_password', $currentPath) ?>" href="<?php echo $rootUrl ?>/change_password">
          <div class="nav-link-icon"><i data-feather="lock"></i></div> Change Password
        </a>

        <a class="nav-link <?= isActive('logout', $currentPath) ?>" href="<?php echo $rootUrl ?>/logout">
          <div class="nav-link-icon"><i data-feather="log-out"></i></div> Logout
        </a>

        <div class="sidenav-menu-heading">Third Party Agency</div>

        <a class="nav-link <?= isActive('create_agency', $currentPath) ?>" href="<?php echo $rootUrl ?>/create_agency">
          <div class="nav-link-icon"><i data-feather="users"></i></div>
          View Agencies
        </a>

        <a class="nav-link <?= isActive('create_agency_schedule', $currentPath) ?>" href="<?php echo $rootUrl ?>/create_agency_schedule">
          <div class="nav-link-icon"><i data-feather="users"></i></div>
          Create Agency Schedules
        </a>

        <a class="nav-link <?= isActive('agency_schedules', $currentPath) ?>" href="<?php echo $rootUrl ?>/agency_schedules">
          <div class="nav-link-icon"><i data-feather="clock"></i></div>
          View Agencies Schedules
        </a>

        <a class="nav-link <?= isActive('agency_staffs', $currentPath) ?>" href="<?php echo $rootUrl ?>/agency_staffs">
          <div class="nav-link-icon"><i data-feather="users"></i></div>
          Agencies Staffs
        </a>

      <?php if ($data['admin_info']['isAdmin'] > 0) { ?>

        <div class="sidenav-menu-heading">Settings</div>

        <a class="nav-link <?= isActive('role_permissions', $currentPath) ?>" href="<?php echo $rootUrl ?>/role_permissions">
          <div class="nav-link-icon"><i data-feather="paperclip"></i></div>
          Role & Permissions
        </a>
        <a class="nav-link <?= isActive('document_management', $currentPath) ?>" href="<?php echo $rootUrl ?>/document_management">
          <div class="nav-link-icon"><i data-feather="file-text"></i></div>
          Document Uploads Settings
        </a>
      <?php } ?>
      </div>
    </div>

    <div class="sidenav-footer">
      <div class="sidenav-footer-content">
        <div class="sidenav-footer-subtitle">Logged in as:</div>
        <div class="sidenav-footer-title text-secondary"><?php echo $data['admin_info']['email'] ?? ''; ?></div>
      </div>
    </div>
  </nav>
</div>
