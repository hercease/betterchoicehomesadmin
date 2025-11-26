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
                            <h4 class="fw-bold"><i class="fas fa-user"></i> All Agencies</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAgencyModal"><i class="fas fa-plus"></i> Add Agency</button>
                        </div>
                        <!-- Illustration dashboard card example-->
                        <div class="row">
                            <table id="agencyTable" class="table table-striped caption-top">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap" scope="col">#</th>
                                        <th class="text-nowrap" scope="col">Name</th>
                                        <th class="text-nowrap" scope="col">Email</th>
                                        <th class="text-nowrap" scope="col">Address</th>
                                        <th class="text-nowrap" scope="col">Phone</th>
                                        <th class="text-nowrap" scope="col">Province</th>
                                        <th class="text-nowrap" scope="col">Zip Code</th>
                                        <th class="text-nowrap" scope="col">Created On</th>
                                        <th class="text-nowrap" scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        
                    </div>
                </main>

                <div class="modal fade" id="addAgencyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Agency</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="createagency" name="createagency">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Organization Name</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Enter agency name" />
                                </div>
                                <div class="mb-3">
                                    <label>Address</label>
                                    <input type="text" name="address" required class="form-control" placeholder="Enter address" />
                                </div>
                                <div class="mb-3">
                                    <label>Zip Code</label>
                                    <input type="text" name="zip" required class="form-control" placeholder="Enter zip code" />
                                </div>
                                <div class="mb-3">
                                    <label>Province</label>
                                    <input type="text" name="province" required required class="form-control" placeholder="Enter province" />
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" required class="form-control" placeholder="Enter agency email address" />
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
            
                var agencyDataTable = $('#agencyTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'responsive': true,
                'ajax': {
                    'url':'fetch_all_agencies',
                    'error': function(xhr, error, thrown) {
                        console.error('DataTables AJAX error:', xhr.responseText);
                    }
                },
                
                'columns': [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'address' },
                    { data: 'phone' },
                    { data: 'province' },
                    { data: 'zip' },
                    { data: 'created_on' },
                    { data: 'action' },
                ]
                });

                $('#addAgencyModal').on('show.bs.modal', function (event){
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var id = button.data('id'); // Extract info from data-* attributes
                    var name = button.data('name'); // Extract info from data-* attributes
                    var address = button.data('address'); // Extract info from data-* attributes
                    var phone = button.data('phone'); // Extract info from data-* attributes
                    var province = button.data('province'); // Extract info from data-* attributes
                    var email = button.data('email'); // Extract info from data-* attributes
                    var zip = button.data('zip'); // Extract info from data-* attributes


                    var modal = $(this);
                    modal.find('.modal-body input[name="id"]').val(id);
                    modal.find('.modal-body input[name="address"]').val(address);
                    modal.find('.modal-body input[name="email"]').val(email);
                    modal.find('.modal-body input[name="phone"]').val(phone);
                    modal.find('.modal-body input[name="province"]').val(province);
                    modal.find('.modal-body input[name="zip"]').val(zip);
                    modal.find('.modal-body input[name="name"]').val(name);
                    //$('select[name="country"').val(country).trigger('change');
                    
                });

        

            $("form[name='createagency']").validate({
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
                        
                    var data = $("form[name='createagency']").serialize();
                    var spinner = document.querySelector(".loader-container");
                    var loadingText = document.querySelector(".loading-text");
                    data += '&timezone=' + encodeURIComponent(timezone);


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
                                        url: "insertagency",
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

                                            agencyDataTable.ajax.reload(null, false);
                                            $("#createagency")[0].reset();
                                            $("#createagency").validate().resetForm();
                                            $("#addAgencyModal").modal('hide');
                                            showToast.success(data.message, 'Success');
                                        
                                        } else {

                                            showToast.success(data.message, 'Error');

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

                    $(document).on("click", ".del_agency", function (){

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
                            message: 'Are you sure you want to delete this agency, note that this is irreversible ?',
                            position: 'center',
                            buttons: [
                                ['<button><b>YES</b></button>', function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                    $.ajax({
                                        type: 'POST',
                                        url: 'delete_location',
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
                                                agencyDataTable.ajax.reload(null, false);
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
                    });


                });
        </script>
</body>
</html>
