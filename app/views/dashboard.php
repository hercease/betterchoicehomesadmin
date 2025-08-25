<!DOCTYPE html>
<html lang="en"> 
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - BetterChoiceHomes | Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="/public/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
        <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
        <style>
            @media (max-width: 576px) { /* Small devices */
                .card-custom-padding {
                padding: 6px 0px 0px 11px !important;
                }
            }

             body {
                font-family: 'Nunito Sans', sans-serif;
                font-weight: 400;
                color: #333;
            }
        </style>
    </head>
    <body class="nav-fixed">
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <!-- Sidenav Toggle Button-->
            <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
            <!-- Navbar Brand-->
            <!-- * * Tip * * You can use text or an image for your navbar brand.-->
            <!-- * * * * * * When using an image, we recommend the SVG format.-->
            <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
           <a class="navbar-brand d-flex align-items-center gap-2 pe-3 ps-4 ps-lg-2" href="/">
                <img src="/public/assets/img/better-icon-removebg-preview.png" style="height: 32px;" alt="Logo" />
                <span class="">BCGH</span>
           </a>

            <!-- Navbar Search Input-->
            <!-- * * Note: * * Visible only on and above the lg breakpoint-->
            
            <!-- Navbar Items-->
            <ul class="navbar-nav align-items-center ms-auto">
               
                <!-- User Dropdown-->
                <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="img-fluid" src="/public/assets/img/illustrations/profiles/profile-1.png" /></a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="public/assets/img/illustrations/profiles/profile-1.png">
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name"><?php echo $data['user_info']['firstname'].' '.$data['user_info']['lastname']; ?></div>
                                <div class="dropdown-user-details-email"><?php echo $data['user_info']['email'] ?></div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout">
                            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>

        </nav>
        <div id="layoutSidenav">

            <?php include("app/views/includes/sidebar.php"); ?>

            <div id="layoutSidenav_content">

                <main>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-5">
                        <!-- Custom page header alternative example-->
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <!-- User Icon -->
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-user fs-4"></i>
                            </div>

                            <!-- Welcome Message + Date/Time -->
                            <div>
                            <h6 class="mb-0 fw-semibold">Welcome back, <?php echo $data['user_info']['lastname'] .' '. $data['user_info']['firstname']  ?></h6>
                            <small class="text-muted" id="dateTime"><?php echo $data['date_display']; ?></small>
                            </div>
                        </div>
                        <!-- Illustration dashboard card example-->
                        
                        <div class="row">

                            <div class="col-6 col-xl-3 col-md-3 mb-4">
                                <!-- Dashboard info widget 1-->
                                <div class="card border-start-lg border-start-warning rounded-4">
                                    <div class="card-body card-custom-padding">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold mb-1">All Users</div>
                                                <div class="h6 small"><?php echo number_format($data['total_users']); ?></div>
                                            </div>
                                            <div class="me-1"><i class="fas fa-users fa-2x text-blue-400"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-3 col-md-3 mb-4">
                                <!-- Dashboard info widget 2-->
                                <div class="card border-start-lg border-start-dark rounded-4">
                                    <div class="card-body card-custom-padding">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold text-warning mb-1">Locations</div>
                                                <div class="h6 small"><?php echo number_format($data['total_location']); ?></div>
                                            </div>
                                            <div class="me-2"><i class="fas fa-map fa-2x text-blue-400"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-3 col-md-3 mb-4">
                                <!-- Dashboard info widget 3-->
                                <div class="card border-start-lg border-start-dark rounded-4">
                                    <div class="card-body card-custom-padding">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold text-warning mb-1">Schedules</div>
                                                <div class="h6 small text-dark"><?php echo number_format($data['total_schedules']); ?></div>
                                            </div>
                                            <div class="me-2"><i class="fas fa-clock fa-2x text-blue-400"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="col-6 col-xl-3 col-md-3 mb-4">
                                <div class="card border-start-lg border-start-warning rounded-4">
                                    <div class="card-body card-custom-padding">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold mb-1">All earnings</div>
                                                <div class="h5 small">0</div>
                                            </div>
                                            <div class="me-2"><i class="fas fa-vault fa-2x text-blue-400"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>

                        <div class="row g-4 mb-3">
                             <!-- Weekly Report -->
                            <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                <h6 class="mb-0">
                                    <i class="fa-solid fa-chart-line me-2"></i>Weekly Report
                                </h6>
                                </div>
                                <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6 mb-3">
                                    <h5 class="text-primary mb-0"><?php echo number_format($data['total_schedule_weekly']) ?></h5>
                                    <small class="text-muted">Schedules This Week</small>
                                    </div>
                                    <div class="col-6 mb-3">
                                    <h5 class="text-success mb-0"><?php echo number_format($data['total_appointment_weekly']) ?></h5>
                                    <small class="text-muted">Users with Appointments</small>
                                    </div>
                                    <div class="col-6 mb-3">
                                    <h5 class="text-warning mb-0"><?php echo $data['total_expected_hours_weekly'] ?></h5>
                                    <small class="text-muted">Expected Hours</small>
                                    </div>
                                    <div class="col-6 mb-3">
                                    <h5 class="text-danger mb-0"><?php echo $data['total_completed_hours_weekly'] ?></h5>
                                    <small class="text-muted">Hours Completed</small>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>

                            <!-- Recently Registered Users -->
                            <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                <h6 class="mb-0">
                                    <i class="fa-solid fa-users me-2"></i>Recently Registered Users
                                </h6>
                                </div>
                                
                                <ul class="list-group list-group-flush">
                                    <?php foreach($data['recent_users'] as $user){ ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo $user['firstname'].' '.$user['lastname']; ?>
                                            <?php 
                                                $dt = new DateTime($user['reg_date']);
                                            ?>
                                            <small class="text-muted"><?php echo $dt->format('M j, Y');  ?></small>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="card-footer text-center">
                                <a href="allusers" class="small text-primary">View all users</a>
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0"><i class="fa-solid fa-bolt me-2"></i>Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <a href="createschedule" class="btn btn-sm btn-outline-primary me-2 mb-2"><i class="fa fa-plus me-1"></i> New Schedule</a>
                                    <a href="createlocation" class="btn btn-sm btn-outline-secondary me-2 mb-2"><i class="fa fa-location-dot me-1"></i> Add Location</a>
                                    <a href="createuser" class="btn btn-sm btn-outline-success mb-2"><i class="fa fa-user-plus me-1"></i> Add User</a>
                                </div>
                                </div>
                            </div>

                            <!-- Latest Schedules -->
                         
                     </div>
                        
                    
                </main>
                <?php include("app/views/includes/footer.php"); ?>  
            </div>
        </div>
       
		<script src="/public/js/bootstrap.bundle.min.js"></script>
        <script src="/public/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="/public/js/litepicker.js"></script>

        <script src="/public/js/sb-customizer.js"></script>
        <script>

        </script>
</body>
</html>
