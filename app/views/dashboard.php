<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - BetterChoiceGroupHomes | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="/public/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0b184d;
            --secondary: #f58634;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
        }

        .dashboard-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary), #1e3a8a);
            color: white;
            border-radius: 12px;
            border: none;
        }

        .stat-card-secondary {
            background: linear-gradient(135deg, var(--secondary), #ff9a52);
            color: white;
            border-radius: 12px;
            border: none;
        }

        .stat-card-success {
            background: linear-gradient(135deg, var(--success), #34ce57);
            color: white;
            border-radius: 12px;
            border: none;
        }

        .stat-card-info {
            background: linear-gradient(135deg, var(--info), #5bc0de);
            color: white;
            border-radius: 12px;
            border: none;
        }

        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 16px;
            border: none;
        }

        .quick-action-btn {
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 500;
        }

        .quick-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .metric-badge {
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .progress-thin {
            height: 6px;
            border-radius: 3px;
        }

        @media (max-width: 768px) {
            .dashboard-card {
                margin-bottom: 1rem;
            }
            
            .welcome-card .row {
                text-align: center;
            }
        }
    </style>
</head>
<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
        <a class="navbar-brand d-flex align-items-center gap-2 pe-3 ps-4 ps-lg-2" href="/">
            <img src="/public/assets/img/better-icon-removebg-preview.png" style="height: 32px;" alt="Logo" />
            <span class="fw-bold">BCGH</span>
        </a>
        <ul class="navbar-nav align-items-center ms-auto">
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
                <div class="container-fluid px-4 mt-4">
                    <!-- Welcome Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card welcome-card shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h4 class="fw-bold mb-2">Welcome back, <?php echo $data['user_info']['firstname'] . ' ' . $data['user_info']['lastname'] ?>! 👋</h4>
                                            <p class="mb-0 opacity-75" id="dateTime"><?php echo $data['date_display']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card dashboard-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title text-white-50 mb-2">Total Users</h6>
                                            <h3 class="fw-bold text-white mb-0"><?php echo number_format($data['total_users']); ?></h3>
                                            <span class="metric-badge mt-2"><?php echo $data['user_registration_growth']. ' this month'; ?></span>
                                        </div>
                                        <div class="ms-3">
                                            <i class="fas fa-users fa-2x text-white-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card-secondary dashboard-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title text-white-50 mb-2">Locations</h6>
                                            <h3 class="fw-bold text-white mb-0"><?php echo number_format($data['total_location']); ?></h3>
                                            <span class="metric-badge mt-2">Active sites</span>
                                        </div>
                                        <div class="ms-3">
                                            <i class="fas fa-map-marker-alt fa-2x text-white-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card-success dashboard-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title text-white-50 mb-2">Schedules</h6>
                                            <h3 class="fw-bold text-white mb-0"><?php echo number_format($data['total_schedules']); ?></h3>
                                            <span class="metric-badge mt-2">This week</span>
                                        </div>
                                        <div class="ms-3">
                                            <i class="fas fa-calendar-alt fa-2x text-white-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card-info dashboard-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title text-white-50 mb-2">Completion Rate</h6>
                                            <h3 class="fw-bold text-white mb-0"><?php echo $data['schedule_completion_rate'] ?? '0%'; ?></h3>
                                            <span class="metric-badge mt-2">This week</span>
                                        </div>
                                        <div class="ms-3">
                                            <i class="fas fa-chart-line fa-2x text-white-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="row g-4">
                        <!-- Weekly Report -->
                        <div class="col-xl-6">
                            <div class="card dashboard-card h-100">
                                <div class="card-header bg-transparent border-bottom-0 pb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0"><i class="fas fa-chart-bar text-primary me-2"></i>Weekly Performance</h5>
                                        <span class="badge bg-primary">Current Week</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6 mb-4">
                                            <div class="p-3">
                                                <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                                                <h4 class="fw-bold text-dark"><?php echo number_format($data['total_schedule_weekly']) ?></h4>
                                                <small class="text-muted">Schedules Created</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-4">
                                            <div class="p-3">
                                                <i class="fas fa-users fa-2x text-success mb-2"></i>
                                                <h4 class="fw-bold text-dark"><?php echo number_format($data['total_appointment_weekly']) ?></h4>
                                                <small class="text-muted">Active Appointments</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3">
                                                <i class="fas fa-bullseye fa-2x text-warning mb-2"></i>
                                                <h4 class="fw-bold text-dark"><?php echo $data['total_expected_hours_weekly'] ?></h4>
                                                <small class="text-muted">Expected Hours</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3">
                                                <i class="fas fa-check-circle fa-2x text-info mb-2"></i>
                                                <h4 class="fw-bold text-dark"><?php echo $data['total_completed_hours_weekly'] ?></h4>
                                                <small class="text-muted">Completed Hours</small>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Weekly Progress</small>
                                            <small><?php echo $data['schedule_completion_rate'] ?? '0%'; ?></small>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-success" style="width: <?php echo $data['schedule_completion_rate'] ?? '0%'; ?>"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Users -->
                        <div class="col-xl-6">
                            <div class="card dashboard-card h-100">
                                <div class="card-header bg-transparent border-bottom-0 pb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0"><i class="fas fa-user-plus text-success me-2"></i>Recent Registrations</h5>
                                        <a href="allusers" class="btn btn-sm btn-outline-primary">View All</a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <?php foreach($data['recent_users'] as $user): ?>
                                            <div class="list-group-item border-0 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user text-muted"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 fw-semibold"><?php echo $user['firstname'].' '.$user['lastname']; ?></h6>
                                                        <small class="text-muted"><?php echo $user['email'] ?? 'No email'; ?></small>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <?php 
                                                            $dt = new DateTime($user['reg_date']);
                                                        ?>
                                                        <small class="text-muted"><?php echo $dt->format('M j'); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-xl-6">
                            <div class="card dashboard-card">
                                <div class="card-header bg-transparent border-bottom-0 pb-3">
                                    <h5 class="card-title mb-0"><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <a href="createschedule" class="btn btn-primary quick-action-btn w-100 text-start">
                                                <i class="fas fa-plus-circle me-2"></i>
                                                <div>
                                                    <strong>New Schedule</strong>
                                                    <small class="d-block opacity-75">Create staff schedule</small>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="createlocation" class="btn btn-success quick-action-btn w-100 text-start">
                                                <i class="fas fa-location-dot me-2"></i>
                                                <div>
                                                    <strong>Add Location</strong>
                                                    <small class="d-block opacity-75">Register new site</small>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="createuser" class="btn btn-info quick-action-btn w-100 text-start">
                                                <i class="fas fa-user-plus me-2"></i>
                                                <div>
                                                    <strong>Add User</strong>
                                                    <small class="d-block opacity-75">Create staff account</small>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="allschedules" class="btn btn-warning quick-action-btn w-100 text-start">
                                                <i class="fas fa-list me-2"></i>
                                                <div>
                                                    <strong>View Schedules</strong>
                                                    <small class="d-block opacity-75">Manage all schedules</small>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Status -->
                        <div class="col-xl-6">
                            <div class="card dashboard-card">
                                <div class="card-header bg-transparent border-bottom-0 pb-3">
                                    <h5 class="card-title mb-0"><i class="fas fa-server text-info me-2"></i>System Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 text-center">
                                        <div class="col-4">
                                            <div class="p-3 rounded-3 bg-light">
                                                <i class="fas fa-database fa-2x text-primary mb-2"></i>
                                                <h6 class="fw-bold mb-1">Database</h6>
                                                <span class="badge bg-success">Online</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="p-3 rounded-3 bg-light">
                                                <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                                                <h6 class="fw-bold mb-1">Security</h6>
                                                <span class="badge bg-success">Active</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="p-3 rounded-3 bg-light">
                                                <i class="fas fa-sync fa-2x text-info mb-2"></i>
                                                <h6 class="fw-bold mb-1">Updates</h6>
                                                <span class="badge bg-info">Current</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include("app/views/includes/footer.php"); ?>  
        </div>
    </div>
   
    <script src="/public/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="/public/js/litepicker.js"></script>

    <script>
        // Live date time update
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('dateTime').textContent = now.toLocaleDateString('en-US', options);
        }

        // Update every second
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Initial call

        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on load
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>