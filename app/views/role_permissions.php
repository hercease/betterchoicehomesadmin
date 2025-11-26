<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manage Roles & Permissions - BetterChoiceGroupHomes | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="/public/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
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
                <div class="container-xl px-4 mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold"><i class="fas fa-user-shield me-2"></i>Manage Roles & Permissions</h4>
                        <div>
                            <button class="btn btn-outline-secondary me-2 btn-sm" onclick="expandAllCards()">
                                <i class="fas fa-expand me-2"></i> <span class="d-none d-lg-inline ">Expand All</span>
                            </button>
                            <button class="btn btn-outline-secondary me-2 btn-sm" onclick="collapseAllCards()">
                                <i class="fas fa-compress me-2"></i> <span class="d-none d-lg-inline">Collapse All</span>
                            </button>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                                <i class="fas fa-plus me-2"></i> <span class="d-none d-lg-inline">Add New Role</span>
                            </button>
                        </div>
                    </div>

                    <!-- Roles and Permissions Container -->
                    <div class="row">
                        <div class="col-12">
                            <div id="rolesContainer" class="accordion">
                                <!-- Roles will be dynamically loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addRoleModal" data-bs-backdrop="static" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle"><i class="fas fa-edit me-2"></i>Add New Role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="addrole" name="addrole">
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Role Name</label>
                                            <input type="text" name="role_name" class="form-control" placeholder="Enter role name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Description</label>
                                            <input type="text" name="description" class="form-control" placeholder="Enter description ex: Human Resources Manager" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Welcome Message</label>
                                            <div class="alert alert-info">
                                                <small><strong>Available placeholders: <br></strong> 
                                                <code>{name}</code> - User's full name, <br>
                                                <code>{email}</code> - User's email, <br>
                                                <code>{password}</code> - Temporary password, <br>
                                                <code>{loginUrl}</code> - Login URL, <br>
                                                <code>{playstore}</code> - Play Store URL, <br>
                                                <code>{appstore}</code> - App Store URL
                                                </small>
                                            </div>
                                            <textarea id="welcome_message_editor" name="welcome_message" class="form-control" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Activation Message</label>
                                            <div class="alert alert-info">
                                                <small><strong>Available placeholders: <br></strong> 
                                                <code>{name}</code> - User's full name, <br>
                                                <code>{loginUrl}</code> - Login URL, <br>
                                                <code>{playstore}</code> - Play Store URL, <br>
                                                <code>{appstore}</code> - App Store URL
                                                </small>
                                            </div>
                                            <textarea id="activation_message_editor" name="activation_message" class="form-control" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Tag</label>
                                            <input type="text" name="tag" class="form-control" placeholder="Enter tag ex: hrm" required>
                                        </div>
                                        <input type="hidden" name="role_id" value="0">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add Role</button>
                                </div>
                            </form>
                        </div>
                    </div>
    </div>
            </main>

            <?php include("app/views/includes/footer.php"); ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="/public/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
        $('#addRoleModal').on('shown.bs.modal', function () {
            $('#welcome_message_editor, #activation_message_editor').summernote({
                placeholder: 'Start typing...',
                tabsize: 2,
                height: 100,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
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
        // Global variable to store roles and permissions data
        let rolesData = [];

        // Load roles and permissions when page loads
        $(document).ready(function() {
            loadRolesAndPermissions();
            initializeFormValidation();
        });

        async function handleFormSubmit(form) {
                const formData = new FormData(form);
                
                try {
                    const response = await fetch('add_new_role', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await response.json();
                    console.log(data);
                    if (data.status) {
                        // Close modal and reload roles
                        console.log('Success - attempting to close modal');

                        showToast.success(data.message);
            
                        // FIX: Use Bootstrap's modal instance properly
                        const modalElement = document.getElementById('addRoleModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);

                        
                        
                        if (modal) {
                            modal.hide();
                            console.log('Modal hide method called');
                        } else {
                            // Fallback: Use jQuery to hide the modal
                            $('#addRoleModal').modal('hide');
                            console.log('Fallback modal hide called');
                        }
                        loadRolesAndPermissions();
                        
                        // Remove validation classes
                        $('#addrole').find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
                        $('#addrole').find('.invalid-feedback').remove();
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
                $('#addrole').validate({
                    rules: {
                        role_name: {
                            required: true
                        },
                        tag: {
                            maxlength: 100
                        },
                        description: {
                            required: true,
                            minlength: 5,
                            maxlength: 500
                        },
                        welcome_message: {
                            required: true
                        }
                    },
                    messages: {
                        role_name: {
                            required: "Please enter a role name",
                            minlength: "Role name must be at least 2 characters long",
                            maxlength: "Role name cannot exceed 100 characters"
                        },
                        tag: {
                            maxlength: "Role tag name cannot exceed 100 characters"
                        },
                        description: {
                            required: "Please enter a role description",
                            minlength: "Role description must be at least 5 characters long",
                            maxlength: "Role description cannot exceed 500 characters"
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

        // Function to load all roles and their permissions
        function loadRolesAndPermissions() {
            showLoader('Loading roles and permissions...');
            
            $.ajax({
                url: 'get_roles_permissions',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    hideLoader();
                    if (response.status) {
                        rolesData = response.data;
                        renderRolesAndPermissions(rolesData);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to load roles and permissions'
                        });
                    }
                },
                error: function() {
                    hideLoader();
                    iziToast.error({
                        title: 'Error',
                        message: 'Failed to load data. Please try again.'
                    });
                }
            });
        }

        // Function to render roles and permissions
        function renderRolesAndPermissions(roles) {
            const container = $('#rolesContainer');
            container.empty();

            roles.forEach((role, index) => {
                const roleCard = createRoleCard(role, index);
                container.append(roleCard);
            });
        }

        // Function to create role card HTML
        function createRoleCard(role, index) {
            const isActive = role.is_active;
            const activeBadge = isActive ? 
                '<span class="badge bg-success ms-2">Active</span>' : 
                '<span class="badge bg-danger ms-2">Inactive</span>';
            
            const collapseId = `collapseRole${role.id}`;
            
            return `
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h2 class="accordion-header" id="heading${role.id}">
                        <button class="accordion-button ${index === 0 ? '' : 'collapsed'}" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#${collapseId}" 
                                aria-expanded="${index === 0 ? 'true' : 'false'}" 
                                aria-controls="${collapseId}">
                            <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 me-3">${role.name}</h5>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                     <span class="badge bg-primary">${role.permissions.filter(p => p.active).length}/${role.permissions.length} Permissions</span>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="${collapseId}" 
                         class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" 
                         aria-labelledby="heading${role.id}" 
                         data-bs-parent="#rolesContainer">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Manage Permissions:</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <a class="btn btn-sm btn-outline-secondary" onclick="event.stopPropagation(); deleteRole(${role.id})">
                                        <i class="fas fa-trash-alt me-1"></i>
                                    </a>
                                    <a class="btn btn-sm btn-outline-secondary" onclick="event.stopPropagation(); editRole(${role.id})">
                                        <i class="fas fa-pencil-alt me-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row g-3">
                                ${renderPermissionItems(role.permissions, role.id)}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Function to render permission items
        function renderPermissionItems(permissions, roleId) {
            if (!permissions || permissions.length === 0) {
                return '<div class="col-12 text-muted text-center">No permissions available</div>';
            }

            return permissions.map(perm => renderPermissionItem(perm, roleId)).join('');
        }

        // Function to render individual permission item
        function renderPermissionItem(permission, roleId) {
            const isActive = permission.active;
            const activeClass = isActive ? 'border-success bg-light' : '';
            
            return `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border ${activeClass}">
                        <div class="card-body d-flex align-items-center">
                            <div class="form-check me-3">
                                <input type="checkbox" 
                                    class="form-check-input" 
                                    data-role-id="${roleId}" 
                                    data-permission-id="${permission.id}"
                                    ${isActive ? 'checked' : ''}
                                    onchange="updatePermissionStatus(${roleId}, ${permission.id}, this.checked)"
                                    style="transform: scale(1.2);">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1 text-dark">${formatPermissionName(permission.name)}</h6>
                                <p class="card-text text-muted small mb-0">${permission.description || 'No description available'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Function to format permission name for better display
        function formatPermissionName(name) {
            return name.split('.')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        }

        // Function to expand all cards
        function expandAllCards() {
            const collapses = document.querySelectorAll('.accordion-collapse');
            collapses.forEach(collapse => {
                new bootstrap.Collapse(collapse, { show: true });
            });
        }

        // Function to collapse all cards
        function collapseAllCards() {
            const collapses = document.querySelectorAll('.accordion-collapse');
            collapses.forEach(collapse => {
                new bootstrap.Collapse(collapse, { hide: true });
            });
        }

        function editRole(roleId) {
            fetch(`get_role_details?role_id=${roleId}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status) {
                        const role = data.data;
                        // Populate modal fields
                        document.getElementById('modalTitle').textContent = `Edit ${role.name} Role`;
                        $('#addRoleModal input[name="role_id"]').val(role.id);
                        $('#addRoleModal input[name="role_name"]').val(role.name);
                        $('#addRoleModal input[name="description"]').val(role.description);
                        //$('#addRoleModal textarea[name="welcome_message"]').val(role.welcome_message);
                        $('#addRoleModal input[name="tag"]').val(role.tag);
                        $('#welcome_message_editor').summernote('code', role.role_message);
                        $('#activation_message_editor').summernote('code', role.activation_message);
                        
                        // Show modal
                        const editModal = new bootstrap.Modal(document.getElementById('addRoleModal'));
                        editModal.show();
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: data.message || 'Failed to fetch role details'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching role details:', error);
                    iziToast.error({
                        title: 'Error',
                        message: 'Network error occurred'
                    });
                });
        }

        $('#addRoleModal').on('hidden.bs.modal', function () {
            $('#welcome_message_editor').summernote('destroy');
            $('#addRoleModal input[name="role_id"]').val(0);
            document.getElementById('addrole').reset();
            document.getElementById('modalTitle').textContent = 'Add Role';
        });

        // Function to toggle role active status
        function toggleRole(roleId, isActive) {
            console.log(`Toggling role ${roleId} to ${isActive}`);
            showLoader('Updating role status...');
            
            $.ajax({
                url: 'toggle_role_status',
                type: 'POST',
                data: {
                    role_id: roleId,
                    is_active: isActive
                },
                dataType: 'json',
                success: function(response) {
                    hideLoader();
                    if (response.status) {
                        iziToast.success({
                            title: 'Success',
                            message: response.message || 'Role status updated successfully'
                        });
                        // Update local data and re-render
                        const role = rolesData.find(r => r.id === roleId);
                        if (role) {
                            role.is_active = isActive;
                        }
                        renderRolesAndPermissions(rolesData);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message || 'Failed to update role status'
                        });
                    }
                },
                error: function() {
                    hideLoader();
                    iziToast.error({
                        title: 'Error',
                        message: 'Failed to update role status'
                    });
                }
            });
        }

        // Function to update individual permission status
        function updatePermissionStatus(roleId, permissionId, isActive) {
            //console.log(`Updating permission ${permissionId} for role ${roleId} to ${isActive}`);
            const checkbox = document.querySelector(
                `input[data-role-id="${roleId}"][data-permission-id="${permissionId}"]`
            );

            // Store the previous state (before user clicked)
            const previousState = !isActive;

            // Temporarily disable the checkbox to prevent double-clicks
            checkbox.disabled = true;

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
                    [
                        '<button><b>Yes</b></button>',
                        function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                            $.ajax({
                                type: "POST",
                                url: "update_role_permission_status",
                                data: {
                                    role_id: roleId,
                                    permission_id: permissionId,
                                    is_active: isActive
                                },
                                beforeSend: function () {
                                    showLoader(message = 'Updating...');
                                },
                                dataType: 'json',
                                success: function (data) {
                                    hideLoader();

                                    if (data.status === true) {
                                        // ✅ Success - keep the new state
                                        checkbox.checked = isActive;
                                        iziToast.success({
                                            title: 'Success',
                                            message: data.message,
                                        });
                                    } else {
                                        // ❌ Server returned failure - revert
                                        checkbox.checked = previousState;
                                        iziToast.warning({
                                            title: 'Error',
                                            message: data.message,
                                        });
                                    }

                                    checkbox.disabled = false;
                                },
                                error: function () {
                                    spinner.style.display = 'none';
                                    loadingText.textContent = "Loading...";
                                    // ❌ Revert on AJAX error
                                    checkbox.checked = previousState;
                                    checkbox.disabled = false;

                                    iziToast.warning({
                                        title: 'Error',
                                        message: 'An error occurred, kindly check your network',
                                    });
                                }
                            });
                        },
                        true,
                    ],
                    [
                        '<button>No</button>',
                        function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            // ❌ Cancelled, revert the checkbox
                            checkbox.checked = previousState;
                            checkbox.disabled = false;
                        },
                    ],
                ],
            });
        }

        async function deleteRole(id) {
            console.log(`Deleting role with ID: ${id}`);
            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Confirm Deletion',
                message: 'Are you sure you want to delete this role?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', async function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                        try {
                            const response = await fetch('delete_role', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: new URLSearchParams({ role_id: id }).toString()
                            });
                            
                            const data = await response.json();
                            
                            if (data.status) {
                                iziToast.success({
                                    title: 'Success',
                                    message: data.message || 'Role deleted successfully',
                                    position: 'topRight'
                                });

                                loadRolesAndPermissions();
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: data.message || 'Failed to delete role',
                                    position: 'topRight'
                                });
                            }
                        } catch (error) {
                            console.error('Error deleting role:', error);
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


        // Utility functions for loader
        function showLoader(message = 'Loading...') {
            $('.loader-container').css('display', 'flex');
            $('.loading-text').text(message);
        }

        function hideLoader() {
            $('.loader-container').hide();
        }
    </script>
</body>
</html>