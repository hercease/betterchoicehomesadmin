<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>All Schedule - BetterChoiceGroupHomes | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="/public/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet">
    <style>
        .schedule-table th {
            background-color: #0b184d;
            color: white;
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        .table-action-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .shift-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .shift-day { background-color: #4CAF50; }
        .shift-evening { background-color: #FF9800; }
        .shift-overnight { background-color: #2196F3; }
        
        .hours-cell {
            font-weight: 600;
            text-align: center;
        }
        
        .pay-cell {
            text-align: right;
            font-weight: 500;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
        }

        .dt-buttons .btn {
            border-radius: 0.375rem;
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
            border-top: 5px solid #f58634;
            border-right: 5px solid #0b184d;
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
                    <a class="dropdown-item" href="profile_details">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Account
                    </a>
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
                <div class="container-xl mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold"><i class="fas fa-calendar-alt me-2"></i> Schedule Management</h4>
                    </div>

                    <!-- Filters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Date</label>
                                    <input type="date" id="fromDate" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Staff Name</label>
                                    <input type="text" id="searchName" class="form-control form-control-sm" placeholder="Search staff...">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Location</label>
                                    <select id="searchLocation" class="form-select form-select-sm">
                                        <option value="">All Locations</option>
                                        <?php foreach($data['all_location'] as $location){ ?>
                                            <option value="<?php echo $location['id'] ?>"><?php echo $location['address'].', '.$location['city'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Status</label>
                                    <select id="status" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="scheduled">Scheduled</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <!--<div class="col-md-2 d-flex align-items-end">
                                    <div class="d-grid w-100">
                                        <button id="btnSearch" class="btn btn-primary btn-sm">
                                            <i class="fas fa-search me-1"></i>Search
                                        </button>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>

                    <!-- DataTable -->
                            <div class="table-responsive">
                                <table id="scheduleTable" class="table table-hover table-bordered schedule-table w-100">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Staff Name</th>
                                            <th>Location</th>
                                            <th>Shift Type</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Scheduled Hours</th>
                                            <th>Worked Hours</th>
                                            <th>Pay Rate</th>
                                            <th>Total Pay</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DataTables will populate this automatically -->
                                    </tbody>
                                </table>
                            </div>
                </div>
            </main>

            <?php include("app/views/includes/footer.php"); ?>
        </div>
    </div>

    <!-- Edit Schedule Modal -->
    <div class="modal fade" id="editScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="updateschedule" name="updateschedule">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Start Time</label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Time</label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pay Per Hour ($)</label>
                                <input type="number" name="pay_per_hour" class="form-control" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Shift Type</label>
                                <select name="shift_type" class="form-select" required>
                                    <option value="">Select Shift</option>
                                    <option value="day">Day</option>
                                    <option value="evening">Evening</option>
                                    <option value="overnight">Overnight</option>
                                </select>
                            </div>
                            <div class="col-12 overnight-type d-none">
                                <label class="form-label">Overnight Type</label>
                                <select name="overnight_type" class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="rest">Rest</option>
                                    <option value="awake">Awake</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="scheduleId">
                        <input type="hidden" name="email" id="staffEmail">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="/public/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.js"></script>

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

        // DataTable instance
        let scheduleTable;

        // Initialize when page loads
        $(document).ready(function() {
            initializeDataTable();
            setupEventListeners();
        });

        function initializeDataTable() {
            scheduleTable = $('#scheduleTable').DataTable({
                dom: '<"row"<"col-md-12"B>>rt<"row"<"col-md-6"l><"col-md-6"p>>',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-outline-secondary text-light btn-sm',
                        text: '<i class="fas fa-copy me-1"></i>Copy'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-outline-success btn-sm',
                        text: '<i class="fas fa-file-excel me-1"></i>Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-outline-danger btn-sm',
                        text: '<i class="fas fa-file-pdf me-1"></i>PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-outline-info btn-sm',
                        text: '<i class="fas fa-print me-1"></i>Print'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-outline-primary btn-sm',
                        text: '<i class="fas fa-file-csv me-1"></i>CSV'
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'schedule_testing',
                    type: 'POST',
                    data: function (d) {
                        d.action = 'datatable';
                        d.date = $('#fromDate').val();
                        d.name = $('#searchName').val();
                        d.location = $('#searchLocation').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    { 
                        data: 'date',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString() : '—';
                        }
                    },
                    { 
                        data: 'staff_name',
                        render: function(data) {
                            return data || '—';
                        }
                    },
                    { 
                        data: 'location',
                        render: function(data) {
                            return data || '—';
                        }
                    },
                    { 
                        data: null,
                        render: function(data) {
                            const shiftClass = `shift-${data.shift_type}`;
                            const shiftIndicator = `<span class="shift-indicator ${shiftClass}"></span>`;
                            return shiftIndicator + data.shift_type + 
                                (data.shift_type === 'overnight' && data.overnight_type ? ` (${data.overnight_type})` : '');
                        }
                    },
                    { 
                        data: 'start_time_fmt',
                        render: function(data, type, row) {
                            return data || row.start_time || '—';
                        }
                    },
                    { 
                        data: 'end_time_fmt',
                        render: function(data, type, row) {
                            return data || row.end_time || '—';
                        }
                    },
                    { 
                        data: 'scheduled_hours',
                        className: 'hours-cell',
                        render: function(data) {
                            return data ? Number(data).toFixed(2) + 'h' : '0.00h';
                        }
                    },
                    { 
                        data: 'hours_worked',
                        className: 'hours-cell',
                        render: function(data) {
                            return data ? Number(data).toFixed(2) + 'h' : '0.00h';
                        }
                    },
                    { 
                        data: 'pay_per_hour',
                        className: 'pay-cell',
                        render: function(data) {
                            return '$' + (data ? Number(data).toFixed(2) : '0.00');
                        }
                    },
                    { 
                        data: null,
                        className: 'pay-cell',
                        render: function(data) {
                            const totalPay = (Number(data.hours_worked || 0) * Number(data.pay_per_hour || 0)).toFixed(2);
                            return '$' + totalPay;
                        }
                    },
                    { 
                        data: 'clockin_fmt',
                        render: function(data, type, row) {
                            return data || row.clockin || '—';
                        }
                    },
                    { 
                        data: 'clockout_fmt',
                        render: function(data, type, row) {
                            return data || row.clockout || '—';
                        }
                    },
                    { 
                        data: 'status',
                        render: function(data) { 
                            const statusClass = getStatusClass(data);
                            console.log(statusClass.class);
                            return `<span class="badge ${statusClass.class}">${statusClass.icon} ${data || 'scheduled'}</span>`;
                        }
                    },
                    { 
                        data: 'id',
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary table-action-btn" 
                                            onclick="editSchedule(${data})"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger table-action-btn" 
                                            onclick="deleteSchedule(${data})"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                order: [[0, 'desc']],
                pageLength: 25,
                responsive: true,
                search: false,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        }

        function setupEventListeners() {
            $('#btnSearch').click(function() {
                scheduleTable.ajax.reload();
            });

            $('#searchName, #searchLocation, #status, #fromDate').on('change keyup', function() {
                if ($(this).attr('id') !== 'searchName') {
                    scheduleTable.ajax.reload();
                }
            });

            // Debounced search for name field
            let searchTimeout;
            $('#searchName').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    scheduleTable.ajax.reload();
                }, 500);
            });
            
            // Shift type change handler
            $('select[name="shift_type"]').on('change', function() {
                if ($(this).val() === 'overnight') {
                    $('.overnight-type').removeClass('d-none');
                    $('select[name="overnight_type"]').prop('required', true);
                } else {
                    $('.overnight-type').addClass('d-none');
                    $('select[name="overnight_type"]').prop('required', false);
                }
            });

            // Form submission
            $("form[name='updateschedule']").validate({
                submitHandler: function(form) {
                    updateSchedule(form);
                }
            });
        }

        function getStatusClass(status) {
            console.log(status);
            switch(status) {
                case 'completed':
                    return {
                        icon: '<i class="bi bi-check-circle me-1"></i>',
                        class: 'bg-success text-light'
                    };
                case 'in-progress':
                    return {
                        icon: '<i class="bi bi-clock-history me-1"></i>', 
                        class: 'bg-warning text-light'
                    };
                case 'missed':
                    return {
                        icon: '<i class="bi bi-x-circle me-1"></i>',
                        class: 'bg-danger text-light'
                    };
                case 'scheduled':
                    return {
                        icon: '<i class="bi bi-calendar-event me-1"></i>',
                        class: 'bg-primary text-light'
                    };
                default:
                    return {
                        icon: '<i class="bi bi-dash-circle me-1"></i>',
                        class: 'bg-secondary text-light'
                    };
            }
        }

        function editSchedule(id) {
            showLoader('Loading schedule details...');
            
            // Fetch schedule details
            fetch('get_schedule_details', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(`schedule_id=${id}`).toString()
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                hideLoader();
                if (data.status) {
                    const schedule = data.data;
                    $('#scheduleId').val(schedule.id);
                    $('#staffEmail').val(schedule.email);
                    $('input[name="start_time"]').val(schedule.start_time);
                    $('input[name="end_time"]').val(schedule.end_time);
                    $('input[name="pay_per_hour"]').val(schedule.pay_per_hour);
                    $('select[name="shift_type"]').val(schedule.shift_type);
                    
                    if (schedule.shift_type === 'overnight') {
                        $('.overnight-type').removeClass('d-none');
                        $('select[name="overnight_type"]').val(schedule.overnight_type);
                    } else {
                        $('.overnight-type').addClass('d-none');
                    }
                    
                    $('#editScheduleModal').modal('show');
                } else {
                    showToast.error(data.message || 'Failed to load schedule details');
                }
            })
            .catch(error => {
                hideLoader();
                showToast.error('Network error occurred');
            });
        }

        function updateSchedule(form) {
            showLoader('Updating schedule...');
            
            const formData = new FormData(form);
            formData.append('timezone', Intl.DateTimeFormat().resolvedOptions().timeZone);
            
            fetch('update_schedule', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(formData).toString()
            })
            .then(response => response.json())
            .then(data => {
                hideLoader();
                if (data.status) {
                    $('#editScheduleModal').modal('hide');
                    showToast.success(data.message);
                    scheduleTable.ajax.reload();
                } else {
                    showToast.error(data.message);
                }
            })
            .catch(error => {
                hideLoader();
                showToast.error('Network error occurred');
            });
        }

        function deleteSchedule(id) {
            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: '<i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion',
                message: 'Are you sure you want to delete this schedule?<br><br><strong>This action cannot be undone.</strong>',
                position: 'center',
                backgroundColor: '#f8f9fa',
                titleColor: '#dc3545',
                messageColor: '#343a40',
                theme: 'light',
                buttons: [
                    ['<button class="btn btn-danger btn-sm"><b>YES, DELETE</b></button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                        // Proceed with deletion
                        showLoader('Deleting schedule...');
                        
                        fetch('delete_schedule', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: new URLSearchParams(`schedule_id=${id}`).toString()
                        })
                        .then(response => response.json())
                        .then(data => {
                            hideLoader();
                            if (data.status) {
                                showToast.success(data.message);
                                scheduleTable.ajax.reload();
                            } else {
                                showToast.error(data.message);
                            }
                        })
                        .catch(error => {
                            hideLoader();
                            showToast.error('Network error occurred');
                        });
                        
                    }, true],
                    ['<button class="btn btn-secondary btn-sm">CANCEL</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ]
            });
        }

        function showLoader(message) {
            $('.loader-container').show();
            $('.loading-text').text(message);
        }

        function hideLoader() {
            $('.loader-container').hide();
        }
    </script>
</body>
</html>