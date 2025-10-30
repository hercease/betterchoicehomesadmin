<!DOCTYPE html>
<html lang="en"> 
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Create Staff - BetterChoiceGroupHomes | Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="/public/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
        <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
        <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
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
                            <h4 class="fw-bold"><i class="fas fa-user"></i> Add Staff</h4>
                        </div>
                        <!-- Illustration dashboard card example-->
                        <div class="row">
                            <div class="col-md-12 col-lg-4 mx-auto">
                                <div class="card">
                                    <div class="card-body shadow border-0">
                                        <form name="createuser" id="createuser">
                                            <div class="mb-3">
                                                <label>Firstname</label>
                                                <input type="text" name="firstname" class="form-control border-0 shadow" placeholder="Enter firstname" />
                                            </div>
                                            <div class="mb-3">
                                                <label>Lastname</label>
                                                <input type="text" name="lastname" class="form-control border-0 shadow" placeholder="Enter lastname" />
                                            </div>
                                            <div class="mb-3">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control border-0 shadow" placeholder="Enter email address" />
                                            </div>
                                            <div class="mb-3">
                                                <label>Role</label>
                                                <select id="isHr" name="role" class="form-select border-0 shadow">
                                                    <option value="">--------- Select Role --------</option>
                                                    <?php foreach($data['all_roles']['roles'] as $role){ ?>
                                                        <option value="<?php echo $role['tag'] ?>"><?php echo ucwords($role['name']) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                           
                                            <div class="mb-3 location-select">
                                                <label>Select Location</label>
                                                <select name="location" class="form-select border-0 shadow">
                                                    <option value="">--------- Select location --------</option>
                                                    <?php foreach($data['all_location'] as $location){ ?>
                                                        <option value="<?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?>"><?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <button class="btn btn-primary btn-sm w-100">Continue</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </main>

             <?php include("app/views/includes/footer.php"); ?> 
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
                    { data: 'status' },
                    { data: 'reg_date' },
                    { data: 'action' },
                ]
                });

            });

            document.addEventListener("DOMContentLoaded", function () {
                const isHrSelect = document.getElementById("isHr");
                const locationDiv = document.querySelector(".location-select");

                function toggleLocationVisibility() {
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
            });

            $("form[name='createuser']").validate({
                // Specify validation rules
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form){
                    
                var data = $("form[name='createuser']").serialize();
                var spinner = document.querySelector(".loader-container");
                var loadingText = document.querySelector(".loading-text");
                const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
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
                                    url: "processcreateuser", //URL to run
                                    data: data,
                                    beforeSend: function () {
                                        spinner.style.display = 'flex';
                                        loadingText.textContent = "Please wait, processing...";
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                    console.log(data);
                                    spinner.style.display = "none";
                                    loadingText.textContent = "Loading...";
                                    
                                    console.log(data);
                                    if (data.status===true) {

                                        iziToast.show({
                                                theme: 'dark',
                                                icon: 'icon-check',
                                                title: 'Success',
                                                timeout: false,
                                                message: data.message,
                                                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                                progressBarColor: 'rgb(0, 255, 184)',
                                                buttons: [
                                                    ['<button>View user</button>', function (instance, toast) {
                                                        window.location.href = "allusers";
                                                    }, true], // true to focus
                                                    ['<button>Create another</button>', function (instance, toast) {
                                                        window.location.href = "createuser";
                                                    }],
                                                    ['<button>Close</button>', function (instance, toast) {
                                                        instance.hide({
                                                            transitionOut: 'fadeOutUp',
                                                            onClosing: function(instance, toast, closedBy){
                                                                console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                                                            }
                                                        }, toast, 'buttonName');
                                                    }]
                                                ],
                                                onOpening: function(instance, toast){
                                                    console.info('callback abriu!');
                                                },
                                                onClosing: function(instance, toast, closedBy){
                                                    console.info('closedBy: ' + closedBy); // tells if it was closed by 'drag' or 'button'
                                                }
                                            });
                                    
                                    } else {

                                        iziToast.warning({
                                            title: 'Error',
                                            message: data.message,
                                        });

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
        </script>
</body>
</html>
