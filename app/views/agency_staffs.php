<!DOCTYPE html>
<html lang="en"> 
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Agency Staffs - BetterChoiceGroupHomes | Admin</title>
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
                            <h4 class="fw-bold"><i class="fas fa-user"></i> Agency staffs</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAgencystaffModal"><i class="fas fa-plus me-2"></i> Add Staff</button>
                        </div>
                        <!-- Illustration dashboard card example-->
                        <div class="row">
                            <table id="agencyStaffsTable" class="table table-striped caption-top">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap" scope="col">#</th>
                                        <th class="text-nowrap" scope="col">FirstName</th>
                                        <th class="text-nowrap" scope="col">LastName</th>
                                        <th class="text-nowrap" scope="col">Email</th>
                                        <th class="text-nowrap" scope="col">Address</th>
                                        <th class="text-nowrap" scope="col">Phone</th>
                                        <th class="text-nowrap" scope="col">Created On</th>
                                        <th class="text-nowrap" scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        
                    </div>
                </main>

                <div class="modal fade" id="addAgencystaffModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Staff</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="creatagencystaff" name="creatagencystaff">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Select Agency</label>
                                    <select id="agency" name="agency" required class="form-control border-0 shadow">
                                        <option value="">--------- Select Agency --------</option>
                                        <?php foreach($data['all_agencies']['data'] as $agency){ ?>
                                            <option value="<?php echo $agency['id'] ?>"><?php echo ucwords($agency['name']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>FirstName</label>
                                    <input type="text" name="firstname" required class="form-control" placeholder="Enter firstname" />
                                </div>
                                <div class="mb-3">
                                    <label>LastName</label>
                                    <input type="text" name="lastname" required class="form-control" placeholder="Enter lastname" />
                                </div>
                                <div class="mb-3">
                                    <label>Address</label>
                                    <input type="text" name="address" required class="form-control" placeholder="Enter address" />
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" required class="form-control" placeholder="Enter email address" />
                                </div>
                                <div class="mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" required class="form-control" placeholder="Enter agency phone" />
                                </div>
                                <input type="hidden" name="id" />
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

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
            
                var agencyStaffsDataTable = $('#agencyStaffsTable').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    'responsive': true,
                    'ajax': {
                        'url':'fetch_all_agency_users',
                        'error': function(xhr, error, thrown) {
                            console.error('DataTables AJAX error:', xhr.responseText);
                        }
                    },
                    
                    'columns': [
                        { data: 'id' },
                        { data: 'firstname' },
                        { data: 'lastname' },
                        { data: 'email' },
                        { data: 'address' },
                        { data: 'phone' },
                        { data: 'created_on' },
                        { data: 'action' },
                    ]
                });

                $('#addAgencystaffModal').on('show.bs.modal', function (event){
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var id = button.data('id'); // Extract info from data-* attributes
                    var firstname = button.data('firstname'); // Extract info from data-* attributes
                    var address = button.data('address'); // Extract info from data-* attributes
                    var phone = button.data('phone'); // Extract info from data-* attributes
                    var lastname = button.data('lastname'); // Extract info from data-* attributes
                    var email = button.data('email'); // Extract info from data-* attributes
                    var agency = button.data('agency'); // Extract info from data-* attributes


                    var modal = $(this);
                    modal.find('.modal-body input[name="id"]').val(id);
                    modal.find('.modal-body input[name="address"]').val(address);
                    modal.find('.modal-body input[name="email"]').val(email);
                    modal.find('.modal-body input[name="phone"]').val(phone);
                    modal.find('.modal-body input[name="firstname"]').val(firstname);
                    modal.find('.modal-body input[name="lastname"]').val(lastname);
                    modal.find('.modal-body select[name="agency"]').val(agency).trigger('change');
                    //$('select[name="country"').val(country).trigger('change');
                    
                });

                $(document).on("click", ".del_agencystaff", function (){

                        var id = $(this).data('id');

                        var spinner = document.querySelector(".loader-container");
                        var loadingText = document.querySelector(".loading-text");
                        
                        iziToast.question({
                            timeout: false,
                            close: false,
                            overlay: true,
                            displayMode: 'once',
                            id: 'question',
                            zindex: 999,
                            title: 'Delete Location',
                            message: 'Are you sure you want to delete this staff, note that this is irreversible ?',
                            position: 'center',
                            buttons: [
                                ['<button><b>YES</b></button>', function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                    $.ajax({
                                        type: 'POST',
                                        url: 'delete_agencystaff',
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
                                                agencyStaffsDataTable.ajax.reload(null, false);
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
                                                message: 'An error occurred',
                                            });
                                        }
                                    });
                                }, true],
                                ['<button>NO</button>', function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                }]
                            ]
                        });
                    });

        
            $("form[name='creatagencystaff']").validate({
                    // Specify validation rules
                    // Make sure the form is submitted to the destination defined
                    // in the "action" attribute of the form when valid
                    errorPlacement: function (error, element) {
                        error.insertAfter(element);
                    },
                    highlight: function (element) {
                        $(element).addClass('is-invalid');


                        // 🔽 Scroll to the field
                        $('html, body').animate({
                            scrollTop: $(element).offset().top - 100
                        }, 600);
                    },
                    unhighlight: function (element) {
                        $(element).removeClass('is-invalid');
                    },
                    submitHandler: function(form){

                    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                        
                    var data = $("form[name='creatagencystaff']").serialize();
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
                                        url: "insertagencystaff",
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
                                        if (data.status) {

                                            agencyStaffsDataTable.ajax.reload(null, false);
                                            $("#creatagencystaff")[0].reset();
                                            $("#creatagencystaff").validate().resetForm();
                                            $("#addAgencystaffModal").modal('hide');
                                            showToast.success(data.message, 'Success');
                                        
                                        } else {

                                            showToast.error(data.message, 'Error');

                                        }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {

                                            loadingText.textContent = "Loading...";
                                            spinner.style.display = 'none';
                                            iziToast.warning({
                                                title: 'Error',
                                                message: errorThrown,
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
                });
        </script>
</body>
</html>
