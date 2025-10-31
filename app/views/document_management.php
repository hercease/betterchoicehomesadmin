<!DOCTYPE html>
<html lang="en"> 
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Manage Documents - BetterChoiceGroupHomes | Admin</title>
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
                            <h4 class="fw-bold"><i class="fas fa-file-alt me-2"></i> Manage Documents</h4>
                        </div>
                        <!-- Illustration dashboard card example-->
                          <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0"><i class="fas fa-file-alt me-2"></i>Document Management</h4>
                                        <button class="btn btn-primary btn-sm" onclick="showAddModal()" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                                            <i class="fas fa-plus me-1"></i><span class="d-none d-lg-inline">Add Document</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="documentsTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Name</th>
                                                        <th>Tag</th>
                                                        <th>Required</th>
                                                        <th>Sort Order</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="documentsList">
                                                    <!-- Documents will be loaded here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </main>

                <div class="modal fade" id="addDocumentModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle">Add Document</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="documentForm">
                                <div class="modal-body">
                                    <input type="hidden" id="documentId" name="id">
                                    <div class="mb-3">
                                        <label class="form-label">Document Name *</label>
                                        <input type="text" placeholder="Enter document name" class="form-control form-control-md" id="documentName" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tag (unique identifier)</label>
                                        <input type="text" class="form-control form-control-md" id="documentTag" placeholder="Enter document tag" name="tag" required>
                                        <small class="text-muted">E.g (education_doc)</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sort Order</label>
                                        <input type="number" class="form-control form-control-md" id="documentOrder" min="0" name="sort_order" value="0">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="documentRequired" name="is_required" checked>
                                                <label class="form-check-label" for="documentRequired">Required Document</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Document</button>
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
            // Load documents when page loads
            document.addEventListener('DOMContentLoaded', function() {
                loadDocuments();
                initializeFormValidation();
            });

            async function handleFormSubmit(form) {
                const formData = new FormData(form);
                
                try {
                    const response = await fetch('process_documents', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    if (data.status) {
                        // Close modal and reload documents

                        const modalElement = document.getElementById('addDocumentModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                        loadDocuments();
                        form.reset();
                        
                        // Remove validation classes
                        $('#documentForm').find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
                        $('#documentForm').find('.invalid-feedback').remove();
                    } else {
                        showToast.error('Error: ' + data.message);
                    }
                } catch (error) {
                    console.error('Error saving document:', error);
                    showToast.error('Error saving document');
                }
            }

            // Initialize jQuery Validate
            function initializeFormValidation() {
                $('#documentForm').validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 2,
                            maxlength: 100
                        },
                        tag: {
                            maxlength: 100,
                        },
                        sort_order: {
                            number: true,
                            min: 0
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter a document name",
                            minlength: "Document name must be at least 2 characters long",
                            maxlength: "Document name cannot exceed 100 characters"
                        },
                        tag: {
                            maxlength: "Document tag name cannot exceed 100 characters"
                        },
                        sort_order: {
                            number: "Please enter a valid number",
                            min: "Sort order cannot be negative"
                        }

                    },
                    errorElement: 'div',
                    errorClass: 'invalid-feedback',
                    highlight: function(element) {
                        $(element).addClass('is-invalid').removeClass('is-valid');
                    },
                    unhighlight: function(element) {
                        $(element).addClass('is-valid').removeClass('is-invalid');
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") === "category_id") {
                            error.insertAfter(element.parent());
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        // This will be called when form is valid
                        handleFormSubmit(form);
                    }
                });

            }

            // Load documents
            async function loadDocuments() {
                try {
                    const response = await fetch('fetch_all_documents');
                    const data = await response.json();
                    console.log(data);
                    renderDocuments(data.documents);
                } catch (error) {
                    console.error('Error loading documents:', error);
                    showToast.error('Error loading documents');
                }
            }

            // Render documents in table
            function renderDocuments(documents) {
                const tbody = document.getElementById('documentsList');
                tbody.innerHTML = '';

                documents.forEach((doc, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${doc.name}</td>
                        <td>${doc.tag}</td>
                        <td><span class="badge ${doc.is_required ? 'bg-warning' : 'bg-secondary'}">${doc.is_required ? 'Required' : 'Optional'}</span></td>
                        <td>${doc.sort_order}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1" onclick="editDocument(${doc.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteDocument(${doc.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }

            // Edit document
            async function editDocument(id) {
                try {
                    const response = await fetch(`fetch_document_details?id=${id}`);
                    const data = await response.json();
                    console.log(data);
                    
                    if (data.status) {
                        const doc = data.document;
                        document.getElementById('modalTitle').textContent = 'Edit Document';
                        document.getElementById('documentId').value = doc.id;
                        document.getElementById('documentName').value = doc.name;
                        document.getElementById('documentTag').value = doc.tag || '';
                        document.getElementById('documentOrder').value = doc.sort_order;
                        document.getElementById('documentRequired').checked = doc.is_required;
                        
                        const modal = new bootstrap.Modal(document.getElementById('addDocumentModal'));
                        modal.show();
                    }
                } catch (error) {
                    console.error('Error loading document:', error);
                }
            }

            // Delete document
           async function deleteDocument(id) {
                iziToast.question({
                    timeout: false,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm Deletion',
                    message: 'Are you sure you want to delete this document?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', async function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            
                            try {
                                const response = await fetch('delete_document_type', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: new URLSearchParams({ id: id }).toString()
                                });
                                
                                const data = await response.json();
                                
                                if (data.status) {
                                    iziToast.success({
                                        title: 'Success',
                                        message: data.message || 'Document deleted successfully',
                                        position: 'topRight'
                                    });
                                    
                                    loadDocuments();
                                } else {
                                    iziToast.error({
                                        title: 'Error',
                                        message: data.message || 'Failed to delete document',
                                        position: 'topRight'
                                    });
                                }
                            } catch (error) {
                                console.error('Error deleting document:', error);
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Network error occurred',
                                    position: 'topRight'
                                });
                            }
                            
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }]
                    ]
                });
            }

            // Show add modal
            function showAddModal() {
                document.getElementById('modalTitle').textContent = 'Add Document';
                document.getElementById('documentForm').reset();
                document.getElementById('documentId').value = '';
            }

            function showLoader(message) {
                $('.loader-container').css('display', 'flex');
                $('.loading-text').text(message);
            }

            function hideLoader() {
                $('.loader-container').hide();
            }
    </script>

</body>
</html>
