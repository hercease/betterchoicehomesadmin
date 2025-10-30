<!DOCTYPE html>
<html lang="en"> 
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>User Details - BetterChoiceGroupHomes | Admin</title>
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
                            <img class="dropdown-user-img" src="/public/assets/img/illustrations/profiles/profile-1.png">
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name"><?php echo $data['user_info']['firstname'].' '.$data['user_info']['lastname']; ?></div>
                                <div class="dropdown-user-details-email"><?php echo $data['user_info']['email'] ?></div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../logout">
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
                            <h4 class="fw-bold"><i class="fas fa-user"></i> Staff Details</h4>
                        </div>
                        <!-- Illustration dashboard card example-->
                        <div class="row">
                            <div class="col-md-6 col-lg-6 g-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-user-plus"></i> Personal info</h5>
                                    </div>
                                    <table class="table table-striped table-borderless">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Firstname</th>
                                                    <td>
                                                        <?php echo $fetchuserinfo['firstname']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Lastname</th>
                                                    <td>
                                                        <?php echo $fetchuserinfo['lastname']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Address</th>
                                                    <td>
                                                        <?php echo $fetchuserinfo['userdetails']['address']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Emmergency Contact</th>
                                                    <td>
                                                        <?php echo $fetchuserinfo['userdetails']['contact_number']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Reg Date</th>
                                                    <td>
                                                        <?php echo date('l, F j, Y g:i A', strtotime($fetchuserinfo['reg_date'])); ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    
                                </div>
                            </div>

                                
                                <div class="col-md-6 col-lg-6 g-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title"><i class="fas fa-building"></i> Bank Information</h5>
                                        </div>
                                        
                                        <table class="table table-striped table-borderless">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Transit number</th>
                                                    <td>
                                                        <?php echo $fetchuserinfo['userdetails']['transit_number']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Account number</th>
                                                    <td>
                                                        <?php echo $fetchuserinfo['userdetails']['account_number'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Institution number</th>
                                                    <td>
                                                        <?php echo $fetchuserinfo['userdetails']['institution_number'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">SIN</th>
                                                    <td>
                                                        <?php echo $fetchuserinfo['userdetails']['sin'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            

                                <div class="col-md-6 col-lg-6 g-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title"><i class="fas fa-map"></i> Appointment</h5>
                                        </div>
                                        
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Location</th>
                                                    <td>
                                                        <?php echo $fetchuserinfo['location']; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-12 mx-auto mt-3 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3"><i class="fas fa-file"></i> Documents</h5>
                                            <table id="all_documents" class="table table-striped caption-top">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Doc Tag</th>
                                                        <th scope="col">Doc Name</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Upload date</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-file"></i> My Certificates</h5>
                                    </div>
                                    <div class="card-body">
                                        <table id="all_certificates" class="table table-striped caption-top">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Cert Tag</th>
                                                    <th scope="col">Cert Name</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Upload date</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </main>

                <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel">Document Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="pdf-preview-container"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
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
            
                var userId = <?php echo json_encode($userId); ?>;

                var documentDataTable = $('#all_documents').DataTable({
                    processing: true,
                    serverSide: true,
                    serverMethod: 'post',
                    responsive: true,
                    ajax: {
                        url: '../fetch_user_documents',
                        data: function(d) {
                            d.id = userId; // dynamic per request
                        },
                        error: function(xhr, error, thrown) {
                            
                            console.error('DataTables AJAX error:', xhr.responseText);
                        }
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'tag' },
                        { data: 'name' },
                        { data: 'status' },
                        { data: 'uploaded_date' },
                        { data: 'action' }
                    ]
                });

                var certificateDataTable = $('#all_certificates').DataTable({
                    processing: true,
                    serverSide: true,
                    serverMethod: 'post',
                    responsive: true,
                    ajax: {
                        url: '../fetch_user_certificates',
                        data: function(d) {
                            d.id = userId; // dynamic per request
                        },
                        error: function(xhr, error, thrown) {
                            console.error('DataTables AJAX error:', xhr.responseText);
                        }
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'tag' },
                        { data: 'name' },
                        { data: 'status' },
                        { data: 'uploaded_date' },
                        { data: 'action' }
                    ]
                });

                $(document).on("click", ".preview-btn", function (){
                    const button = $(this);
                    const url = button.data('file'); // jQuery data() method
                    
                    if (!url) {
                        console.error('No file URL found in data-file attribute');
                        alert("File URL not specified");
                        return;
                    }

                    const container = $("#pdf-preview-container");
                    if (!container.length) {
                        console.error('Preview container not found');
                        return;
                    }

                    // Show loading state
                    container.html('<div class="loading">Loading PDF preview...</div>');
                    
                    // Initialize PDF.js
                    const loadingTask = pdfjsLib.getDocument({
                        url: url,
                        httpHeaders: { 'Access-Control-Allow-Origin': '*' }
                    });

                    loadingTask.promise
                        .then(function(pdfDoc) {
                            container.empty(); // Clear loading message
                            const numPages = pdfDoc.numPages;
                            const pageRenderPromises = [];

                            // Create a promise for each page
                            for (let pageNum = 1; pageNum <= numPages; pageNum++) {
                                pageRenderPromises.push(
                                    pdfDoc.getPage(pageNum).then(function(page) {
                                        const viewport = page.getViewport({ scale: 1.5 });
                                        const canvas = $('<canvas/>')[0];
                                        const ctx = canvas.getContext('2d');
                                        canvas.width = viewport.width;
                                        canvas.height = viewport.height;

                                        return page.render({
                                            canvasContext: ctx,
                                            viewport: viewport
                                        }).promise.then(function() {
                                            const wrapper = $('<div class="pdf-page mb-4"></div>');
                                            wrapper.append(`<div class="page-number">Page ${pageNum}</div>`);
                                            wrapper.append(canvas);
                                            return wrapper;
                                        });
                                    }).catch(function(pageError) {
                                        console.error(`Error rendering page ${pageNum}:`, pageError);
                                        return $(`<div class="error">Failed to load page ${pageNum}</div>`);
                                    })
                                );
                            }

                            // Render all pages
                            return Promise.all(pageRenderPromises);
                        })
                        .then(function(pageElements) {
                            container.append(pageElements);
                        })
                        .catch(function(error) {
                            console.error('PDF preview error:', error);
                            container.html(`<div class="error">Failed to load PDF: ${error.message}</div>`);
                            alert("Failed to load PDF document");
                        });
                });

                 $(document).on("click", ".del_document", function (){

                    var id = $(this).data('id');
                    var type = $(this).data('type');

                    var spinner = document.querySelector(".loader-container");
                    var loadingText = document.querySelector(".loading-text");
                    
                    iziToast.question({
                        timeout: false,
                        close: false,
                        overlay: true,
                        displayMode: 'once',
                        id: 'question',
                        zindex: 999,
                        title: 'Delete Document',
                        message: 'Are you sure you want to remove this document ?',
                        position: 'center',
                        buttons: [
                            ['<button><b>YES</b></button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                $.ajax({
                                    type: 'POST',
                                    url: '../delete_user_document',
                                    data: { id: id, type: type },
                                    beforeSend: function () {
                                        spinner.style.display = 'flex';
                                        loadingText.textContent = "Please wait, processing...";
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        console.log(response);
                                        spinner.style.display = "none";
                                        loadingText.textContent = "Loading...";

                                        if (response.status == true) {

                                            documentDataTable.ajax.reload(null, false);
                                            certificateDataTable.ajax.reload(null, false);
                                            iziToast.success({
                                                title: 'Success',
                                                message: response.message,
                                            });

                                        } else {

                                            iziToast.warning({
                                                title: 'Error',
                                                message: response.message,
                                            });

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
                });


                $(document).on("click", ".decision-btn", function () {

                    const id = $(this).data('id');
                    const status = $(this).data('status');
                    const type = $(this).data('type');

                    console.log(status);

                    const msg = status === 0
                        ? 'Are you sure you want to reject this document?'
                        : 'Are you sure you want to approve this document?';

                    const spinner = document.querySelector(".loader-container");
                    const loadingText = document.querySelector(".loading-text");

                    iziToast.question({
                        timeout: false,
                        close: false,
                        overlay: true,
                        displayMode: 'once',
                        id: 'question',
                        zindex: 999,
                        title: 'Confirm Document',
                        message: msg,
                        position: 'center',
                        buttons: [
                            [
                                '<button><b>YES</b></button>',
                                function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                    $.ajax({
                                        type: 'POST',
                                        url: '../document_activation',
                                        data: { id: id, status: status, type: type },
                                        beforeSend: function () {
                                            spinner.style.display = 'flex';
                                            loadingText.textContent = "Please wait, processing...";
                                        },
                                        dataType: 'json',
                                        success: function (response) {
                                            spinner.style.display = "none";
                                            loadingText.textContent = "Loading...";

                                            if (response.status) {
                                                documentDataTable.ajax.reload(null, false);
                                                certificateDataTable.ajax.reload(null, false);
                                                iziToast.success({
                                                    title: 'Success',
                                                    message: response.message,
                                                });
                                            } else {
                                                iziToast.warning({
                                                    title: 'Error',
                                                    message: response.message,
                                                });
                                            }
                                        },
                                        error: function (jqXHR, textStatus) {
                                            spinner.style.display = 'none';
                                            loadingText.textContent = "Loading...";
                                            iziToast.warning({
                                                title: 'Error',
                                                message: 'An error occurred: ' + jqXHR.responseText,
                                            });
                                        }
                                    });
                                },
                                true
                            ],
                            [
                                '<button>NO</button>',
                                function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                }
                            ]
                        ]
                    });
                });

            });

        </script>
</body>
</html>
