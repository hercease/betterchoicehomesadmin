<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Staff Management - BetterChoiceGroupHomes | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="/public/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0b184d;
            --secondary: #f58634;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
        }

        .staff-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .staff-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #1e3a8a);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            text-transform: uppercase;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--primary), #1e3a8a);
            color: white;
            border-radius: 12px;
            border: none;
        }

        .role-badge {
            background: var(--light);
            color: var(--dark);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid #e9ecef;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .status-active { background: var(--success); }
        .status-inactive { background: var(--danger); }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .search-box {
            border-radius: 10px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(11, 24, 77, 0.1);
        }

        .filter-section {
            background: var(--light);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            flex-direction: column;
            display: none;
            z-index: 9999;
        }

        .rotating-circle {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 5px solid transparent;
            border-top: 5px solid var(--secondary);
            border-right: 5px solid var(--primary);
            animation: spin 1.5s linear infinite;
        }

        .loader-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            position: absolute;
            width: 45px;
            height: 45px;
            object-fit: contain;
            border-radius: 50%;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            margin-top: 10px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .staff-card {
                margin-bottom: 1rem;
            }
            .avatar {
        width: 50px;
        height: 50px;
        min-width: 50px;
        min-height: 50px;
        font-size: 1rem;
    }
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body class="nav-fixed">

    <div class="loader-container">
        <div class="loader-wrapper">
            <div class="rotating-circle"></div>
            <img src="public/assets/img/favicon/favicon.ico" alt="Logo" class="logo">
        </div>
        <div class="loading-text"></div>
    </div>

    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
        <a class="navbar-brand d-flex align-items-center gap-2 pe-3 ps-4 ps-lg-2" href="/">
            <img src="/public/assets/img/better-icon-removebg-preview.png" style="height: 32px;" alt="Logo" />
            <span class="">BCGH</span>
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
                    <!-- Header Section -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1"><i class="fas fa-users me-2 text-primary"></i>Staff Management</h2>
                            <p class="text-muted mb-0">Manage your team members and their roles</p>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="quick-stats">
                        <div class="stat-item">
                            <div class="stat-number" id="statTotal">0</div>
                            <div class="stat-label">Total Staff</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" id="statActive">0</div>
                            <div class="stat-label">Active</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" id="statInactive">0</div>
                            <div class="stat-label">Inactive</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" id="visibleCount">0</div>
                            <div class="stat-label">Showing</div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Filters Sidebar -->
                        <div class="col-lg-3 mb-4">
                            <div class="filter-section d-none d-lg-block">
                                <h5 class="fw-bold mb-3"><i class="fas fa-filter me-2"></i>Filters</h5>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Search</label>
                                    <input type="text" id="filterSearch" class="form-control search-box" placeholder="Name, email...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Role</label>
                                    <select id="filterRole" class="form-select">
                                        <option value="">All Roles</option>
                                        <option value="staff">Staff</option>
                                        <option value="manager">Manager</option>
                                        <option value="hr">HR</option>
                                        <option value="accountant">Accountant</option>
                                        <option value="scheduler">Scheduler</option>
                                        <option value="directorofservices">Director of Services</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Location</label>
                                    <input type="text" id="filterLocation" class="form-control" placeholder="City, address...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Status</label>
                                    <select id="filterStatus" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="d-grid gap-2">
                                    <button id="applyFilters" class="btn btn-primary">Apply Filters</button>
                                    <button id="clearFilters" class="btn btn-outline-secondary">Clear All</button>
                                </div>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="col-lg-9">
                            <!-- Controls -->
                            <div class="card mb-4">
                                <div class="card-body py-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="text-muted">
                                                Showing <span id="visibleCountMain" class="fw-bold">0</span> of <span id="totalCount" class="fw-bold">0</span> staff members
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <select id="sortBy" class="form-select form-select-sm w-auto">
                                                    <option value="az">Name A-Z</option>
                                                    <option value="za">Name Z-A</option>
                                                    <option value="reg_new">Newest First</option>
                                                    <option value="oldest">Oldest First</option>
                                                </select>
                                                <button class="btn btn-outline-primary btn-sm d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#filtersOffcanvas">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Staff Grid -->
                            <div id="resultsGrid" class="row g-3">
                                <!-- Staff cards will be loaded here -->
                            </div>

                            <!-- Pagination -->
                            <nav class="mt-4">
                                <ul id="pagination" class="pagination justify-content-center"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </main>

            <?php include("app/views/includes/footer.php"); ?>
        </div>
    </div>

    <!-- Mobile Filters Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filtersOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><i class="fas fa-filter me-2"></i>Filters</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Mobile filter form -->
            <div class="mb-3">
                <label class="form-label small fw-semibold">Search</label>
                <input type="text" id="m_filterSearch" class="form-control" placeholder="Name, email...">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Role</label>
                <select id="m_filterRole" class="form-select">
                    <option value="">All Roles</option>
                    <option value="staff">Staff</option>
                    <option value="manager">Manager</option>
                    <option value="hr">HR</option>
                    <option value="accountant">Accountant</option>
                    <option value="scheduler">Scheduler</option>
                    <option value="directorofservices">Director of Services</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Location</label>
                <input type="text" id="m_filterLocation" class="form-control" placeholder="City, address...">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Status</label>
                <select id="m_filterStatus" class="form-select">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="d-grid gap-2">
                <button id="m_applyFilters" class="btn btn-primary">Apply Filters</button>
                <button id="m_clearFilters" class="btn btn-outline-secondary">Clear All</button>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="updateuser" name="updateuser">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="firstname" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lastname" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Role</label>
                                <select id="isHr" name="role" class="form-select" required>
                                    <option value="">Select Role</option>
                                    <?php foreach($data['all_roles']['roles'] as $role){ ?>
                                        <option value="<?php echo $role['tag'] ?>"><?php echo ucwords($role['name']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 location-select">
                                <label class="form-label">Location</label>
                                <select name="location" class="form-select">
                                    <option value="">Select Location</option>
                                    <?php foreach($data['all_location'] as $location){ ?>
                                        <option value="<?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?>">
                                            <?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="userId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="/public/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
        // Toast configuration
        const showToast = {
            success: (message, title = "Success") => {
                iziToast.success({
                    title: `<i class="fas fa-check-circle"></i> ${title}`,
                    message: message,
                    position: 'topRight',
                    timeout: 3000
                });
            },
            error: (message, title = "Error") => {
                iziToast.error({
                    title: `<i class="fas fa-times-circle"></i> ${title}`,
                    message: message,
                    position: 'topRight',
                    timeout: 5000
                });
            }
        };

        // State management
        let state = {
            page: 1,
            perPage: 8,
            sort: 'az',
            filters: { q: '', role: '', location: '', status: '' }
        };

        // Initialize
        $(document).ready(function() {
            loadAndRender();
            setupEventListeners();
        });

        function setupEventListeners() {
            // Debounced search
            $('#filterSearch').on('input', debounce(() => { state.page = 1; loadAndRender(); }, 350));
            $('#filterRole, #filterStatus').on('change', () => { state.page = 1; loadAndRender(); });
            $('#filterLocation').on('input', debounce(() => { state.page = 1; loadAndRender(); }, 350));
            $('#applyFilters').click(() => { state.page = 1; loadAndRender(); });
            $('#clearFilters').click(clearFilters);
            
            // Mobile filters
            $('#m_filterSearch').on('input', debounce(() => { state.page = 1; loadAndRender(); }, 350));
            $('#m_applyFilters').click(applyMobileFilters);
            $('#m_clearFilters').click(clearMobileFilters);

            // Sort
            $('#sortBy').on('change', function() { state.sort = this.value; loadAndRender(); });

            // Role change handler for location visibility
            $('select[name="role"]').on('change', function() {
                $('.location-select').toggle($(this).val() !== 'dos');
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        async function loadAndRender() {
            showLoader('Loading staff data...');
            
            const filters = {
                q: $('#filterSearch').val().trim(),
                role: $('#filterRole').val(),
                location: $('#filterLocation').val().trim(),
                status: $('#filterStatus').val()
            };

            try {
                const formData = new URLSearchParams({
                    q: filters.q,
                    role: filters.role,
                    location: filters.location,
                    status: filters.status,
                    page: state.page,
                    perPage: state.perPage,
                    sort: state.sort
                });

                const response = await fetch('fetch_all_staffs', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData.toString()
                });

                const data = await response.json();
                hideLoader();

                if (data.status === "success") {
                    renderStaffGrid(data.data);
                    updateStats(data.filtered_stats, data.overall_stats);
                    renderPagination(data.total, state.page, state.perPage);
                } else {
                    showToast.error('Failed to load staff data');
                }
            } catch (error) {
                hideLoader();
                showToast.error('Network error occurred');
            }
        }

        function renderStaffGrid(staff) {
            const grid = $('#resultsGrid');
            
            if (!staff || staff.length === 0) {
                grid.html(`
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-users text-muted"></i>
                            <h5 class="text-muted">No staff members found</h5>
                            <p class="text-muted">Try adjusting your search filters</p>
                        </div>
                    </div>
                `);
                return;
            }

            const html = staff.map(member => `
                <div class="col-xl-6 col-lg-12">
                    <div class="card staff-card h-100">
                        <div class="card-body bg-light">
                            <div class="d-flex align-items-start gap-3">
                                <div class="avatar">
                                    ${(member.firstname || '')[0]}${(member.lastname || '')[0]}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1 fw-bold">${member.firstname} ${member.lastname}</h6>
                                            <small class="text-muted">${member.email}</small>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="editUser(${member.id}, '${member.firstname}', '${member.lastname}', '${member.email}', '${member.role}', '${member.location}')">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a></li>
                                                <li><a class="dropdown-item" href="/userdetails/${member.id}">
                                                    <i class="fas fa-info-circle me-2"></i>Details
                                                </a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="toggleStatus(${member.id}, ${member.status === 'Active' ? 1 : 0})">
                                                    <i class="fas fa-toggle-${member.status === 'Active' ? 'on' : 'off'} me-2"></i>
                                                    ${member.status === 'Active' ? 'Deactivate' : 'Activate'}
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteUser(${member.id})">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                                        <span class="role-badge">${member.role}</span>
                                        <span class="badge ${member.status === 'Active' ? 'bg-success' : 'bg-danger'}">
                                            ${member.status}
                                        </span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between text-muted small">
                                        <div>
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            ${member.address || 'No address provided'}
                                        </div>
                                        <div>
                                            <i class="fas fa-calendar me-1"></i>
                                            ${member.reg_date}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');

            grid.html(html);
        }

        function updateStats(filtered, overall) {
            $('#statTotal').text(filtered.total_users);
            $('#statActive').text(filtered.total_active);
            $('#statInactive').text(filtered.total_inactive);
            $('#visibleCount').text(filtered.total_users);
            $('#visibleCountMain').text(filtered.total_users);
            $('#totalCount').text(overall.total_users);
        }

        function renderPagination(total, page, perPage) {
            const totalPages = Math.ceil(total / perPage);
            const pagination = $('#pagination');
            
            if (totalPages <= 1) {
                pagination.empty();
                return;
            }

            let html = '';
            
            // Previous button
            html += `<li class="page-item ${page === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${page - 1})">Previous</a>
            </li>`;
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                html += `<li class="page-item ${i === page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>`;
            }
            
            // Next button
            html += `<li class="page-item ${page === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${page + 1})">Next</a>
            </li>`;
            
            pagination.html(html);
        }

        function changePage(newPage) {
            state.page = newPage;
            loadAndRender();
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        }

        function clearFilters() {
            $('#filterSearch, #filterLocation').val('');
            $('#filterRole, #filterStatus').val('');
            state.page = 1;
            loadAndRender();
        }

        function applyMobileFilters() {
            $('#filterSearch').val($('#m_filterSearch').val());
            $('#filterRole').val($('#m_filterRole').val());
            $('#filterLocation').val($('#m_filterLocation').val());
            $('#filterStatus').val($('#m_filterStatus').val());
            state.page = 1;
            loadAndRender();
            bootstrap.Offcanvas.getInstance($('#filtersOffcanvas')).hide();
        }

        function clearMobileFilters() {
            $('#m_filterSearch, #m_filterLocation').val('');
            $('#m_filterRole, #m_filterStatus').val('');
        }

        function showLoader(message) {
            $('.loader-container').css('display', 'flex');
            $('.loading-text').text(message);
        }

        function hideLoader() {
            $('.loader-container').fadeOut();
        }

        const isHrSelect = document.getElementById("isHr");
        const locationDiv = document.querySelector(".location-select");
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    
        function toggleLocationVisibility() {
            console.log(isHrSelect.value);

            if (isHrSelect.value === "dos") {
                locationDiv.style.display = "none";
            } else {
                locationDiv.style.display = "block";
            }
        }

        // Initial toggle on page load
        toggleLocationVisibility();

        // Toggle on change
        isHrSelect.addEventListener("change", toggleLocationVisibility);

        $("form[name='updateuser']").validate({
            // Specify validation rules
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form){
                
            var data = $("form[name='updateuser']").serialize();
            var spinner = document.querySelector(".loader-container");
            var loadingText = document.querySelector(".loading-text");
            data += '&timezone=' + encodeURIComponent(timezone);

            console.log(data);

                iziToast.question({
                    timeout: false,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    title: 'Confirmation',
                    message: 'Are you sure you want to continue?',
                    position: 'center',
                    buttons: [
                        ['<button><b>Yes</b></button>', function (instance, toast){
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            
                            // Run your AJAX function here
                            $.ajax({
                                type: "POST",
                                url: "processcreateuser",
                                data: data,
                                beforeSend: function () {
                                    spinner.style.display = 'flex';
                                    loadingText.textContent = "Please wait, processing...";
                                },
                                dataType: 'json',
                                success: function(data) {

                                spinner.style.display = "none";
                                loadingText.textContent = "Loading...";
                                
                                console.log(data);
                                if (data.status===true) {

                                    loadAndRender(); // Reload the DataTable without resetting pagination
                                    $('#editUserModal').modal('hide');
                                    showToast.success(data.message);
                                
                                } else {

                                    showToast.error(data.message);

                                }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    loadingText.textContent = "Loading...";
                                    spinner.style.display = 'none';
                                    iziToast.warning({
                                        title: 'Error',
                                        message: 'An error occurred, kindly check your network',
                                    });
                                }
                            }); 

                        }, true],
                        ['<button>No</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }]
                    ],
                    onClosing: function(instance, toast, closedBy){
                        console.info('Closing | closedBy: ' + closedBy);
                    },
                    onClosed: function(instance, toast, closedBy){
                        console.info('Closed | closedBy: ' + closedBy);
                    }
                });

            
                
                }
            });

        // Placeholder functions for user actions
        function editUser(id, firstname, lastname, email, role, location) { 
            /* Implement edit functionality */
            var modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show(); 

            var modalElement = document.getElementById('editUserModal');
            modalElement.querySelector('input[name="firstname"]').value = firstname;
            modalElement.querySelector('input[name="lastname"]').value = lastname;
            modalElement.querySelector('input[name="email"]').value = email;
            modalElement.querySelector('select[name="role"]').value = role;
            modalElement.querySelector('select[name="location"]').value = location;
            modalElement.querySelector('input[name="id"]').value = id;

            toggleLocationVisibility();

        }

        function toggleStatus(id, status) {

            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Delete User',
                message: 'Are you sure you want to ' + (status === 1 ? 'deactivate' : 'activate') + ' this user?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        toggleUserStatus(id, status);
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ],
                onClosing: function(instance, toast, closedBy){
                    console.info('Closing | closedBy: ' + closedBy);
                },
                onClosed: function(instance, toast, closedBy){
                    console.info('Closed | closedBy: ' + closedBy);
                }
            });
         }

         function toggleUserStatus(id, status) {
            var spinner = document.querySelector(".loader-container");
            var loadingText = document.querySelector(".loading-text");

            $.ajax({
                type: 'POST',
                url: 'update_account_status',
                data: { id: id, status: status },
                beforeSend: function () {
                    spinner.style.display = 'flex';
                    loadingText.textContent = "Please wait, processing...";
                },
                dataType: 'json',
                success: function (response) {

                    spinner.style.display = "none";
                    loadingText.textContent = "Loading...";
                    if (response.status == true) {
                        loadAndRender();
                        showToast.success(response.message);
                    } else {
                        showToast.error(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    loadingText.textContent = "Loading...";
                    spinner.style.display = 'none';
                    iziToast.warning({
                        title: 'Error',
                        message: 'An error occurred ' + errorThrown,
                    });
                }
            });
         }
        
        function deleteUser (id){
            var spinner = document.querySelector(".loader-container");
            var loadingText = document.querySelector(".loading-text");
            
            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Delete User',
                message: 'Are you sure you want to delete this user, note that this will delete every other information belonging to the user which is not reversible?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        $.ajax({
                            type: 'POST',
                            url: 'delete_user_details',
                            data: { id: id },
                            beforeSend: function () {
                                spinner.style.display = 'flex';
                                loadingText.textContent = "Please wait, processing...";
                            },
                            dataType: 'json',
                            success: function (response) {

                                spinner.style.display = "none";
                                loadingText.textContent = "Loading...";

                                if (response.status == true) {
                                    loadAndRender();
                                    showToast.success(response.message);
                                } else {
                                    showToast.error(response.message);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                loadingText.textContent = "Loading...";
                                spinner.style.display = 'none';
                                //showToast.error(errorThrown);
                                iziToast.warning({
                                    title: 'Error',
                                    message: 'An error occurred ' + errorThrown,
                                });
                            }
                        });
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ]
            });
        }
    </script>
</body>
</html>