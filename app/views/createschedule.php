<!DOCTYPE html>
<html lang="en"> 
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Create Schedule - BetterChoiceGroupHomes | Admin</title>
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

        .is-invalid {
            border-color: red !important;
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
                            <h4 class="fw-bold"><i class="fas fa-clock"></i> Create Schedule</h4>
                        </div>
                        <!-- Illustration dashboard card example-->
                         <form id="scheduleForm" name="scheduleForm" class="mb-4">
                            <div class="card mb-4">
                                <div class="card-header">Select location and date range, then create the schedule for staff</div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <select class="form-select border-0 shadow" name="location" id="location">
                                                <option value="">--------- Select location --------</option>
                                                <?php foreach($data['all_location'] as $location){ ?>
                                                    <option value="<?php echo $location['id'] ?>"><?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-joined border-0 shadow">
                                                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
                                                <input class="form-control ps-0 pointer" name="daterange" id="litepickerRangePlugin" placeholder="Select date range...">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary w-100 align-item-center">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </form>
                          <form id="scheduleSaveForm">                          
                            <div id="scheduleResults"></div>
                            <button type="submit" class="btn btn-primary mt-3" style="display: none;" id="saveScheduleBtn">Save Schedule</button>
                          </form>

                          
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
            // Observer to watch for changes in scheduleResults
            const observer = new MutationObserver(function(mutations) {
                const scheduleResults = document.getElementById('scheduleResults');
                const saveButton = document.getElementById('saveScheduleBtn');
                
                if (scheduleResults.innerHTML.trim() !== '') {
                    saveButton.style.display = 'block';

                    document.querySelectorAll(".shift_type").forEach(function(select) {
                        select.addEventListener("change", function() {
                            const overnightSelect = this.parentElement.querySelector(".overnight-type");
                            if (this.value === "overnight") {
                                overnightSelect.classList.remove("d-none");
                                overnightSelect.setAttribute("required", "required");
                            } else {
                                overnightSelect.classList.add("d-none");
                                overnightSelect.removeAttribute("required");
                                overnightSelect.value = ""; // reset
                            }
                        });
                    });

                } else {
                    saveButton.style.display = 'none';
                }
            });


            // Start observing scheduleResults for changes
            observer.observe(document.getElementById('scheduleResults'), {
                childList: true,
                subtree: true,
                characterData: true
            });
        </script>
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


            $("form[name='scheduleForm']").validate({
                // Specify validation rules
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form){
                    
                var data = $("form[name='scheduleForm']").serialize();
                var spinner = document.querySelector(".loader-container");
                var loadingText = document.querySelector(".loading-text");
                const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                data += '&timezone=' + encodeURIComponent(timezone);
                console.log(data);


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
                                    url: "generatescheduleform", //URL to run
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

                                       iziToast.success({
                                           title: 'Success',
                                           message: "Schedules generated successfully",
                                       });

                                       $('#scheduleResults').html(data.html);


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

                const form = $('#scheduleSaveForm');

                    // Remove validation and handle form submission directly
                    form.off('submit').on('submit', function(e) {
                        e.preventDefault();
                        
                        const formData = $(this).serialize();

                        // Confirmation prompt
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
                                ['<button><b>Yes</b></button>', function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                                    // AJAX submission
                                    $.ajax({
                                        url: 'save_schedule',
                                        method: 'POST',
                                        data: formData,
                                        dataType: 'json',
                                        success: function (res) {
                                            if (res.status) {
                                                iziToast.show({
                                                    theme: 'dark',
                                                    icon: 'icon-check',
                                                    title: 'Success',
                                                    timeout: false,
                                                    message: res.message,
                                                    position: 'center',
                                                    progressBarColor: 'rgb(0, 255, 184)',
                                                    buttons: [
                                                        ['<button>View schedules</button>', function () {
                                                            window.location.href = "allschedules";
                                                        }, true],
                                                        ['<button>Create another</button>', function () {
                                                            window.location.href = "creatschedule";
                                                        }],
                                                        ['<button>Close</button>', function (instance, toast) {
                                                            instance.hide({ transitionOut: 'fadeOutUp' }, toast, 'button');
                                                        }]
                                                    ]
                                                });
                                            } else {
                                                iziToast.error({
                                                    title: 'Error',
                                                    message: 'Failed: ' + res.message,
                                                });
                                            }
                                        },
                                        error: function (xhr) {
                                            iziToast.error({
                                                title: 'Error',
                                                message: 'Error: ' + xhr.responseText,
                                            });
                                        }
                                    });
                                }, true],
                                ['<button>No</button>', function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                }]
                            ],
                            onClosing: function (instance, toast, closedBy) {
                                console.info('Closing | closedBy: ' + closedBy);
                            },
                            onClosed: function (instance, toast, closedBy) {
                                console.info('Closed | closedBy: ' + closedBy);
                            }
                        });
                    });


        </script>
</body>
</html>
