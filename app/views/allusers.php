<!DOCTYPE html>
<html lang="en"> 
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>All Users - BetterChoiceHomes | Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="/public/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
        <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
        <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

           
            .sidebar { max-width: 320px; }
            
            .card-staff:hover { transform: translateY(-6px); }
            .dp {
                width: 60px;             /* fixed size */
                height: 45px;            /* same as width to stay round */
                border-radius: 50%;      /* makes it a circle */
                background-color: #007bff; /* Bootstrap primary color */
                color: #fff;             /* white text */
                display: flex;           /* flexbox for centering */
                align-items: center;     /* vertical centering */
                justify-content: center; /* horizontal centering */
                font-weight: bold;
                font-size: 15px;         /* adjust to taste */
                text-transform: uppercase; /* force uppercase letters */
            }
            .tiny { font-size:.82rem; }
            .muted { color:#6b7280; }
            .pill { padding:.25rem .5rem; border-radius:999px; font-size:.78rem; }
            .status-active { background:#e6f9f0; color:#0f8a4a; }
            .status-inactive { background:#fff3e6; color:#b45f00; }
            .controls { gap:.5rem; }
            @media (min-width: 992px) {
            .results-grid { display:grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
            }
            @media (min-width: 1400px) {
            .results-grid { grid-template-columns: repeat(3, 1fr); }
            }

            /* Centering the loader */
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
                display: none; /* Initially hidden */
                z-index: 9999;
            }

            /* Rotating Circle */
            .rotating-circle {
                position: relative;
                width: 80px;
                height: 80px;
                border-radius: 50%;
                border: 5px solid transparent;
                border-top: 5px solid #f58634;
                border-right: 5px solid #0b184d;
                animation: spin 1.5s linear infinite;
            }

            /* Static Logo in Center */
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

            /* Spinning Animation */
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Loading Text */
            .loading-text {
                margin-top: 10px;
                color: #fff;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
            }

            form .error{
                color : red;
                font-size: 13px;
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
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold"><i class="fas fa-users"></i> Staff Directory</h4>
                            <!--<span class="badge bg-secondary">Total Users: <?php echo number_format($data['total_users']) ?></span>-->
                        </div>

                        <!-- Illustration dashboard card example-->
                        <div class="row g-3">
                            <!-- Sidebar on lg+ -->
                            <aside class="col-lg-3 d-none d-lg-block sidebar">
                            <div class="card p-3 mb-3">
                                <h6 class="mb-3">Search & Filters</h6>

                                <div class="mb-2">
                                <label class="form-label tiny mb-1">Search</label>
                                <input id="filterSearch" name="q" class="form-control form-control-sm" placeholder="name, email...">
                                </div>

                                <div class="mb-2">
                                <label class="form-label tiny mb-1">Role</label>
                                <select id="filterRole" class="form-select form-select-sm">
                                    <option value="">Any Role</option>
                                    <option value="staff">Staff</option>
                                    <option value="manager">Manager</option>
                                    <option value="hr">HR</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="scheduler">Scheduler</option>
                                    <option value="directorofservices">Director of Services</option>
                                </select>
                                </div>

                                <div class="mb-2">
                                <label class="form-label tiny mb-1">Location</label>
                                <input id="filterLocation" class="form-control form-control-sm" placeholder="City, site...">
                                </div>

                                <div class="mb-2">
                                <label class="form-label tiny mb-1">Status</label>
                                <select id="filterStatus" class="form-select form-select-sm">
                                    <option value="">Any</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                </div>

                                <!--<div class="row gx-2">
                                <div class="col-6 mb-2">
                                    <label class="form-label tiny mb-1">From</label>
                                    <input id="filterFrom" type="date" class="form-control form-control-sm">
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label tiny mb-1">To</label>
                                    <input id="filterTo" type="date" class="form-control form-control-sm">
                                </div>
                                </div>-->

                                <div class="d-grid mt-2">
                                <button id="applyFilters" class="btn btn-primary btn-sm">Apply</button>
                                <button id="clearFilters" class="btn btn-link btn-sm mt-1 text-decoration-none">Clear</button>
                                </div>
                            </div>

                            <div class="card p-3 tiny">
                                <h6 class="mb-2">Quick stats</h6>
                                <div class="d-flex justify-content-between mb-1"><div>Total</div><div id="statTotal">—</div></div>
                                <div class="d-flex justify-content-between mb-1"><div>Active</div><div id="statActive">—</div></div>
                                <div class="d-flex justify-content-between mb-1"><div>Inactive</div><div id="statInactive">—</div></div>
                            </div>
                            </aside>

                            <!-- Results -->
                            <main class="col-lg-9">
                            <!-- top controls -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="muted tiny">Showing <span id="visibleCount">0</span> of <span id="totalCount">0</span></div>
                                <div class="d-flex controls">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text tiny">Sort</label>
                                    <select id="sortBy" class="form-select form-select-sm tiny">
                                    <option value="az">Name A→Z</option>
                                    <option value="za">Name Z→A</option>
                                    <option value="reg_new">Newest</option>
                                    <option value="oldest">Oldest</option>
                                    </select>
                                </div>
                                <button class="btn btn-outline-secondary btn-sm d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#filtersOffcanvas">
                                    <i class="bi bi-funnel"></i> Filters
                                </button>
                              
                                </div>
                            </div>

                            <!-- Cards grid -->
                            <div id="resultsGrid" class="results-grid mb-3"></div>

                            <!-- Pagination -->
                            <nav>
                                <ul id="pagination" class="pagination pagination-sm"></ul>
                            </nav>

                            </main>
                        </div>

                        
                    </div>
                </main>

             <?php include("app/views/includes/footer.php"); ?> 
            </div>
        </div>

        <!-- Offcanvas mobile filters -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="filtersOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Filters</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <!-- replicate filter form inside for mobile -->
            <div class="mb-2">
            <label class="form-label tiny mb-1">Search</label>
            <input id="m_filterSearch" class="form-control form-control-sm" placeholder="name, email...">
            </div>
            <div class="mb-2">
            <label class="form-label tiny mb-1">Role</label>
            <select id="m_filterRole" class="form-select form-select-sm">
                <option value="">Any Role</option>
                <option value="staff">Staff</option>
                <option value="manager">Manager</option>
                <option value="hr">HR</option>
                <option value="accountant">Accountant</option>
                <option value="scheduler">Scheduler</option>
                <option value="directorofservices">Director of Services</option>
            </select>
            </div>
            <div class="mb-2">
            <label class="form-label tiny mb-1">Location</label>
            <input id="m_filterLocation" class="form-control form-control-sm" placeholder="City, site...">
            </div>
            <div class="mb-2">
            <label class="form-label tiny mb-1">Status</label>
            <select id="m_filterStatus" class="form-select form-select-sm">
                <option value="">Any</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            </div>
            <!--<div class="row gx-2">
            <div class="col-6 mb-2">
                <label class="form-label tiny mb-1">From</label>
                <input id="m_filterFrom" type="date" class="form-control form-control-sm">
            </div>
            <div class="col-6 mb-2">
                <label class="form-label tiny mb-1">To</label>
                <input id="m_filterTo" type="date" class="form-control form-control-sm">
            </div>
            </div>-->

            <div class="d-grid mt-2">
            <button id="m_applyFilters" class="btn btn-primary btn-sm">Apply</button>
            <button id="m_clearFilters" class="btn btn-link btn-sm mt-1 text-decoration-none">Clear</button>
            </div>
        </div>
        </div>


        <div class="modal fade" id="modal-default" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="h6 modal-title"><i class="fas fa-pencil"></i> Edit User</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateuser" name="updateuser">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Firstname</label>
                                <input type="text" name="firstname" class="form-control" placeholder="Enter firstname" />
                            </div>
                            <div class="mb-3">
                                <label>Lastname</label>
                                <input type="text" name="lastname" class="form-control" placeholder="Enter lastname" />
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Enter email address" />
                            </div>
                            <div class="mb-3">
                                <label>Role</label>
                                <select id="isHr" name="role" class="form-select">
                                    <option value="">--------- Select Role --------</option>
                                    <option value="staff">Staff</option>
                                    <option value="manager">Manager</option>
                                    <option value="hr">HR</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="scheduler">Scheduler</option>
                                    <option value="directorofservices">Director of Services</option>
                                </select>
                            </div>
                            <div style="display: none" class="mb-3 location-select">
                                <label>Select Location</label>
                                <select name="location" class="form-select">
                                    <option value="">--------- Select location --------</option>
                                    <?php foreach($data['all_location'] as $location){ ?>
                                        <option value="<?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?>"><?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <input type="hidden" name="id" id="id">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="/public/js/bootstrap.bundle.min.js"></script>
        <script src="/public/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="/public/js/litepicker.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
	    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
        <script>
                iziToast.settings({
                    icon: 'fontawesome',             // Leave blank
                    iconUrl: null,        // ⛔ Disable default SVG icon
                // Other options...
                });
                // Toast configuration with Font Awesome icons
                const showToast = {
                success: (message, title = "Success") => {
                    iziToast.success({
                        title: `<i class="fas fa-check-circle"></i> ${title}`,
                        message: message,
                        position: 'bottomRight',
                        timeout: 5000,
                        backgroundColor: '#4CAF50',
                        titleColor: '#fff',
                        messageColor: '#fff',
                        iconColor: '#fff',
                        progressBarColor: '#388E3C',
                        close: false,
                        icon: 'fas fa-check-circle', // ✅ Font Awesome class
                        iconUrl: null
                    });
                },
                
                error: (message, title = "Error") => {
                    iziToast.error({
                        title: `<i class="fas fa-times-circle"></i> ${title}`,
                        message: message,
                        position: 'bottomRight',
                        timeout: 5000,
                        backgroundColor: '#F44336',
                        titleColor: '#fff',
                        messageColor: '#fff',
                        iconColor: '#fff',
                        progressBarColor: '#D32F2F',
                        close: false
                    });
                },
                
                warning: (message, title = "Warning") => {
                    iziToast.warning({
                        title: `<i class="fas fa-exclamation-triangle"></i> ${title}`,
                        message: message,
                        position: 'bottomRight',
                        timeout: 5000,
                        backgroundColor: '#FF9800',
                        titleColor: '#fff',
                        messageColor: '#fff',
                        iconColor: '#fff',
                        progressBarColor: '#F57C00',
                        close: false
                    });
                },
                
                info: (message, title = "Info") => {
                    iziToast.info({
                        title: `<i class="fas fa-info-circle"></i> ${title}`,
                        message: message,
                        position: 'bottomRight',
                        timeout: 5000,
                        backgroundColor: '#2196F3',
                        titleColor: '#fff',
                        messageColor: '#fff',
                        iconColor: '#fff',
                        progressBarColor: '#1976D2',
                        close: false
                    });
                }
            };

             $(function(){

                var usersDataTable = $('#all_users').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    'responsive': true,
                    'ajax': {
                        'url':'fetch_all_users',
                        'error': function(xhr, error, thrown) {
                            console.error('DataTables AJAX error:', xhr.responseText);
                        }
                    },
                    
                    'columns': [
                        { data: 'id' },
                        { data: 'firstname' },
                        { data: 'lastname' },
                        { data: 'email' },
                        { data: 'role' },
                        { data: 'location' },
                        { data: 'status' },
                        { data: 'reg_date' },
                        { data: 'action' },
                    ]
                });

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
                                            message: 'An error occurred, kindly check your network',
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

                
                    const isHrSelect = document.getElementById("isHr");
                    const locationDiv = document.querySelector(".location-select");
                    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                
                    function toggleLocationVisibility() {
                        console.log(isHrSelect.value);

                        if (isHrSelect.value === "staff") {
                            locationDiv.style.display = "block";
                        } else {
                            locationDiv.style.display = "none";
                        }
                    }

                    // Initial toggle on page load
                    toggleLocationVisibility();

                    // Toggle on change
                    isHrSelect.addEventListener("change", toggleLocationVisibility);

                    
                    $('#modal-default').on('show.bs.modal', function (event){
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var id = button.data('id'); // Extract info from data-* attributes
                        var firstname = button.data('firstname'); // Extract info from data-* attributes
                        var lastname = button.data('lastname'); // Extract info from data-* attributes
                        var email = button.data('email'); // Extract info from data-* attributes
                        var role = button.data('role'); // Extract info from data-* attributes
                        var location = button.data('location'); // Extract info from data-* attributes

                        //console.log(id, firstname, lastname, email, role, location);
                       

                        var modal = $(this);
                        modal.find('.modal-body input#id').val(id);
                        modal.find('.modal-body input[name="firstname"]').val(firstname);
                        modal.find('.modal-body input[name="lastname"]').val(lastname);
                        modal.find('.modal-body input[name="email"]').val(email);
                        modal.find('.modal-body select[name="role"]').val(role);
                        modal.find('.modal-body select[name="location"]').val(location);

                        toggleLocationVisibility();

                    });

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
                                            $('#modal-default').modal('hide');
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
                


/* ------------------------
   State + helpers
   ------------------------ */
let state = {
    page: 1, perPage: 8, compact: false, sort: 'name_asc',
    filters: { q: '', role: '', location: '', status: '', from: '', to: '' }
};

function debounce(fn, wait = 300) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), wait); }; }

function formatDateISO(d) { if (!d) return ''; const dt = new Date(d); return dt.toLocaleDateString(); }

/* ------------------------
     Data fetch (calls your POST endpoint)
     Expected server-format: { status: "success", data: [ {id, fullname, email, role, location, status, reg_date} ], total: N, page: P, limit: L, total_pages: T }
     ------------------------ */
async function fetchDataFromServer(filters, page, perPage, sort) {
    try {

        const formData = new URLSearchParams();
        formData.append('q', filters.q);
        formData.append('role', filters.role);
        formData.append('location', filters.location);
        formData.append('status', filters.status);
        formData.append('page', page);
        formData.append('perPage', perPage);
        formData.append('sort', sort);

        console.log(formData.toString());

        const res = await fetch('fetch_all_staffs', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString()
        });
        const json = await res.json();
        if (json.status === "success") {
            return { total: json.total, data: json.data, filtered_stats: json.filtered_stats, overall_stats: json.overall_stats };

        } else {
            console.error("Error fetching data:", json);
            return { total: 0, data: [] };
        }
    } catch (error) {
        console.error("Fetch error:", error);
        return { total: 0, data: [] };
    }
}

/* ------------------------
     Render single card markup
     ------------------------ */
function renderCard(s) {
    return `
    <div class="card card-staff shadow border p-3 mb-3">
        <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold text-uppercase p-2">${(s.firstname || '')[0]}${(s.lastname || '')[0]}</div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-0">${s.firstname || ''} ${s.lastname || ''} <small class="muted tiny">#${s.id}</small></h6>
                        <div class="tiny muted">${s.email}</div>
                    </div>
                    <div class="text-end">
                        <div class="mb-2 d-flex align-items-center">
                                <span class="badge rounded-pill ${s.status === 'Active' ? 'bg-success' : 'bg-warning'}">${s.status}</span>
                                <span>
                                        <div class="dropdown">
                                                <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="0#" data-bs-toggle='modal'  data-bs-target='#modal-default' data-role="${s.role}" data-lastname="${s.lastname}" data-email="${s.email}" data-location="${s.location}" data-firstname="${s.firstname}" data-action="edit" data-id="${s.id}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                        <li><a class="dropdown-item" href="#" data-action="info" data-id="${s.id}"><i class="bi bi-person-lines-fill me-2"></i>User Info</a></li>
                                                        <li><a class="dropdown-item" href="#" data-action="toggle" data-status="${s.status === 'Active' ? 1 : 0 }" data-id="${s.id}"><i class="bi bi-toggle-on me-2"></i>Toggle Status</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#" data-action="delete" data-id="${s.id}"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                        </div>
                                </span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 flex-wrap align-items-center mt-2">
                    <div class="tiny"><strong class="muted">Role:</strong> <span class="badge bg-dark text-light">${s.role}</span></div>
                    <div class="tiny"><strong class="muted">Address:</strong> <span class="badge bg-info text-dark">${s.address}</span></div>
                    <div class="tiny"><strong class="muted">Reg:</strong> <span class="muted">${s.reg_date}</span></div>
                </div>

            </div>
        </div>
    </div>
    `;
}

                function toggleAccountStatus(id, status) {
                    
                    var spinner = document.querySelector(".loader-container");
                    var loadingText = document.querySelector(".loading-text");

                    var msg = status > 0 ? 'Are you sure you want to deactivate this user account ?' : 'Are you sure you want to activate this user account ?';
                    
                    iziToast.question({
                        timeout: false,
                        close: false,
                        overlay: true,
                        displayMode: 'once',
                        id: 'question',
                        zindex: 999,
                        title: 'Update Status',
                        message: msg,
                        position: 'center',
                        buttons: [
                            ['<button><b>YES</b></button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                $.ajax({
                                    type: 'POST',
                                    url: 'update_account_status',
                                    data: { id: id, status : status },
                                    beforeSend: function () {
                                        spinner.style.display = 'flex';
                                        loadingText.textContent = "Please wait, processing...";
                                    },
                                    dataType: 'json',
                                    success: function (response) {

                                        spinner.style.display = "none";
                                        loadingText.textContent = "Loading...";
                                        state.page = 1; loadAndRender();
                                        if (response.status == true) {
                                           
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
                                            message: 'An error occurred, kindly check your network',
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

/* ------------------------
     Render page of results
     ------------------------ */
async function loadAndRender() {
    // read UI filters
    const filters = {
        q: document.getElementById('filterSearch').value.trim(),
        role: document.getElementById('filterRole').value,
        location: document.getElementById('filterLocation').value.trim(),
        status: document.getElementById('filterStatus').value
        //from: document.getElementById('filterFrom').value,
        //to: document.getElementById('filterTo').value
    };

    // mobile offcanvas values fallback
    if (document.getElementById('m_filterSearch').value) filters.q = document.getElementById('m_filterSearch').value.trim();
    if (document.getElementById('m_filterRole').value) filters.role = document.getElementById('m_filterRole').value;
    if (document.getElementById('m_filterLocation').value) filters.location = document.getElementById('m_filterLocation').value.trim();
    if (document.getElementById('m_filterStatus').value) filters.status = document.getElementById('m_filterStatus').value;
    //if (document.getElementById('m_filterFrom').value) filters.from = document.getElementById('m_filterFrom').value;
    //if (document.getElementById('m_filterTo').value) filters.to = document.getElementById('m_filterTo').value;

    const page = state.page; const perPage = state.perPage;
    const sort = state.sort;

    // show loader
    const grid = document.getElementById('resultsGrid');
    grid.innerHTML = `<div class="text-center p-5 muted tiny">Loading…</div>`;

    // fetch data
    const json = await fetchDataFromServer(filters, page, perPage, sort);

    // render
    const html = json.data.map(renderCard).join('');
    grid.innerHTML = html || '<div class="text-center p-4 muted">No staff match those filters.</div>';
    console.log(json);
    // stats
    document.getElementById('visibleCount').textContent = json.data.length;
    document.getElementById('totalCount').textContent = json.total;
    document.getElementById('statTotal').textContent = json.filtered_stats.total_users  +' (Out of '+ json.overall_stats.total_users +')';
    document.getElementById('statActive').textContent = json.filtered_stats.total_active +' (Out of '+ json.overall_stats.total_active +')';
    document.getElementById('statInactive').textContent = json.filtered_stats.total_inactive   +' (Out of '+ json.overall_stats.total_inactive +')';


    renderPagination(json.total, page, perPage);
}

/* ------------------------
     Pagination
     ------------------------ */
function renderPagination(total, page, perPage) {
    const pages = Math.max(1, Math.ceil(total / perPage));
    const ul = document.getElementById('pagination');
    ul.innerHTML = '';

    const makeLi = (p, label = null, disabled = false, active = false) => {
        const li = document.createElement('li');
        li.className = 'page-item ' + (active ? 'active' : '') + (disabled ? ' disabled' : '');
        li.innerHTML = `<a class="page-link" href="#">${label ?? p}</a>`;
        li.onclick = (e) => { e.preventDefault(); if (!disabled) { state.page = p; loadAndRender(); } };
        return li;
    };

    ul.appendChild(makeLi(1, '«', page === 1, false));
    const start = Math.max(1, page - 2);
    const end = Math.min(pages, page + 2);
    for (let p = start; p <= end; p++) ul.appendChild(makeLi(p, null, false, p === page));
    ul.appendChild(makeLi(pages, '»', page === pages, false));
}

/* ------------------------
     Events: filters, debounce, actions
     ------------------------ */
const debouncedLoad = debounce(() => { state.page = 1; loadAndRender(); }, 350);

document.getElementById('filterSearch').addEventListener('input', debouncedLoad);
document.getElementById('filterRole').addEventListener('change', () => { state.page = 1; loadAndRender(); });
document.getElementById('filterLocation').addEventListener('input', debouncedLoad);
document.getElementById('filterStatus').addEventListener('change', () => { state.page = 1; loadAndRender(); });
//document.getElementById('filterFrom').addEventListener('change', () => { state.page = 1; loadAndRender(); });
//document.getElementById('filterTo').addEventListener('change', () => { state.page = 1; loadAndRender(); });
document.getElementById('applyFilters').addEventListener('click', () => { state.page = 1; loadAndRender(); });
document.getElementById('clearFilters').addEventListener('click', () => {
    ['filterSearch', 'filterRole', 'filterLocation', 'filterStatus'].forEach(id => document.getElementById(id).value = '');
    state.page = 1; loadAndRender();
});

// mobile offcanvas controls mirror
document.getElementById('m_filterSearch').addEventListener('input', debouncedLoad);
document.getElementById('m_filterRole').addEventListener('change', () => { state.page = 1; loadAndRender(); });
document.getElementById('m_filterLocation').addEventListener('input', debouncedLoad);
document.getElementById('m_filterStatus').addEventListener('change', () => { state.page = 1; loadAndRender(); });
//document.getElementById('m_filterFrom').addEventListener('change', () => { state.page = 1; loadAndRender(); });
//document.getElementById('m_filterTo').addEventListener('change', () => { state.page = 1; loadAndRender(); });
document.getElementById('m_applyFilters').addEventListener('click', () => {
    // copy mobile values into desktop inputs (keeps single source)
    ['filterSearch', 'filterRole', 'filterLocation', 'filterStatus'].forEach((id, idx) => {
        const mv = ['m_filterSearch', 'm_filterRole', 'm_filterLocation', 'm_filterStatus'][idx];
        document.getElementById(id).value = document.getElementById(mv).value;
    });
    state.page = 1; loadAndRender();
    // hide offcanvas
    const off = bootstrap.Offcanvas.getInstance(document.getElementById('filtersOffcanvas'));
    off.hide();
});
document.getElementById('m_clearFilters').addEventListener('click', () => {
    ['m_filterSearch', 'm_filterRole', 'm_filterLocation', 'm_filterStatus'].forEach(id => document.getElementById(id).value = '');
});


/* action handlers (delegated) */
document.getElementById('resultsGrid').addEventListener('click', (e)=>{
  const a = e.target.closest('[data-action]');
  if(!a) return;
  e.preventDefault();
  const action = a.getAttribute('data-action');
  const id = a.getAttribute('data-id');
  if(action==='edit') {  /* show modal, navigate etc */ }
  if(action==='info') { window.location.href="/userdetails/"+id; }
  if(action==='toggle') { const status = a.getAttribute('data-status');  toggleAccountStatus(id, status); }
  if(action==='delete') {
    deleteUser(id);
  }
});

/* initial load (optionally you can keep empty until a filter is applied by not calling this) */
loadAndRender();
             


            });
        </script>
</body>
</html>
