<!DOCTYPE html>
<html lang="en"> 
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Profile Details - BetterChoiceHomes | Admin</title>
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
                            <h4 class="fw-bold"><i class="fas fa-edit"></i> Edit Profile</h4>
                        </div>
                        <!-- Illustration dashboard card example-->
                        <form id="updateprofile">

                        <div class="row">
                            <div class="col-md-12 col-lg-6 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-user-plus"></i> Personal info</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Firstname</label>
                                            <input type="text" name="firstname" placeholder="Enter firstname" class="form-control" required value="<?php echo $data['user_info']['firstname'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Lastname</label>
                                            <input type="text" name="lastname" placeholder="Enter lastname" class="form-control" required value="<?php echo $data['user_info']['lastname'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>City</label>
                                            <input type="text" name="city" placeholder="Enter city" class="form-control" required value="<?php echo $data['user_info']['userdetails']['city'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Province</label>
                                            <input type="text" name="province" placeholder="Enter province" class="form-control" required value="<?php echo $data['user_info']['userdetails']['province'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Address</label>
                                            <input type="text" name="address" placeholder="Enter Address" class="form-control" required value="<?php echo $data['user_info']['userdetails']['address'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Postal Code</label>
                                            <input type="text" name="postal_code" placeholder="Enter Postal Code" class="form-control" required value="<?php echo $data['user_info']['userdetails']['postal_code'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Contact No</label>
                                            <input type="number" class="form-control" placeholder="Enter contact number" required name="emergencyContact" value="<?php echo $data['user_info']['userdetails']['contact_number'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Date Of Birth</label>
                                            <input type="date" class="form-control" placeholder="Enter contact number" required name="dateOfBirth" value="<?php echo $data['user_info']['userdetails']['dob'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>SIN (Social Insurance Number)</label>
                                            <input type="number" class="form-control" placeholder="Enter social insurance number" required name="sin" value="<?php echo $data['user_info']['userdetails']['sin'] ?? ''; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6 mb-3">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-car"></i> Driver license Info</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>License No</label>
                                            <input type="number" class="form-control" placeholder="Enter license number" required name="driverlicensenumber" value="<?php echo $data['user_info']['userdetails']['driver_license_number'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Expiry Date</label>
                                            <input type="date" class="form-control" required name="driverlicenseexpirationdate" value="<?php echo $data['user_info']['userdetails']['driver_license_expiry_date'] ?? ''; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-house"></i> Bank Info</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Transit No</label>
                                            <input type="number" class="form-control" placeholder="Enter Transit No" required name="transitNumber" value="<?php echo $data['user_info']['userdetails']['transit_number'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Institution No</label>
                                            <input type="number" class="form-control" placeholder="Enter Institution No" required name="institutionNumber" value="<?php echo $data['user_info']['userdetails']['institution_number'] ?? ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Account No</label>
                                            <input type="number" class="form-control" placeholder="Enter Account No" required name="accountNumber" value="<?php echo $data['user_info']['userdetails']['account_number'] ?? ''; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 mb-3">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-file"></i> Documents</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php foreach($data['user_info']['documents'] as $key => $documents): ?>
                                            <div class="mb-3">
                                                <label><?php echo $documents['title'] ?></label>
                                                <input 
                                                    type="file" 
                                                    accept="application/pdf" 
                                                    <?php echo $documents['optional'] ? '' : 'required' ?> 
                                                    name="document_files[<?php echo $documents['tag']; ?>]" 
                                                    class="form-control" 
                                                />
                                                <input type="hidden" name="tags[]" value="<?php echo $documents['tag']; ?>" />
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6 mb-3">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-file"></i> Certifications (If Any)</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php foreach($data['user_info']['certificates'] as $key => $certificates): ?>
                                            <div class="mb-3">
                                                <label><?php echo $certificates['title'] ?></label>
                                                <input 
                                                    type="file" 
                                                    accept="application/pdf" 
                                                    name="certificate_files[<?php echo $certificates['cert_tag']; ?>]" 
                                                    class="form-control" 
                                                />
                                                <input type="hidden" name="certificates_tags[]" value="<?php echo $certificates['cert_tag']; ?>" />
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Continue</button>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
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

        const form = $('#updateprofile');

                // Add validation rules
                form.validate({

                    errorPlacement: function (error, element) {
                        error.insertAfter(element);
                    },
                    highlight: function (element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element) {
                        $(element).removeClass('is-invalid');
                    },
                    submitHandler: function (formElement) {

                        const formData = new FormData(formElement);
                        var spinner = document.querySelector(".loader-container");
                        var loadingText = document.querySelector(".loading-text");

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
                                        url: 'update_profile',
                                        method: 'POST',
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        dataType: 'json',
                                        beforeSend: function () {
                                            spinner.style.display = 'flex';
                                            loadingText.textContent = "Please wait, processing...";
                                        },
                                        success: function (res) {

                                        spinner.style.display = "none";
                                        loadingText.textContent = "Loading...";

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
                                                        ['<button>View Profile</button>', function () {
                                                            window.location.href = "profile";
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

                                            spinner.style.display = "none";
                                            loadingText.textContent = "Loading...";

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
                    }
                });
            
                
    });

        </script>
        
</body>
</html>
