<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Agency Schedule - BetterChoiceGroupHomes | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="/public/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <style>
        .schedule-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .staff-schedule-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .date-header {
            background: #0b184d;
            color: white;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .staff-info {
            background: #e9ecef;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        
        .form-section {
            background: #f8fbff;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #007bff;
        }
        
        .overnight-options {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 10px;
            margin-top: 10px;
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

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
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

            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold"><i class="fas fa-calendar-plus me-2"></i> Create Agency Staff Schedule</h4>
                            <button class="btn btn-success" id="saveAllSchedules">
                                <i class="fas fa-save me-2"></i>Save All Schedules
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Schedule Configuration -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Schedule Configuration</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Location</label>
                                <select class="form-select" id="agencySelect" required>
                                    <option value="">Select Location</option>
                                    <?php foreach($data['all_agencies']['data'] as $agency): ?>
                                        <option value="<?php echo $agency['id']; ?>"><?php echo $agency['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Start Date</label>
                                <input type="date" class="form-control" id="startDate" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">End Date</label>
                                <input type="date" class="form-control" id="endDate" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-primary w-100" id="generateSchedules">
                                    <i class="fas fa-magic me-2"></i>Generate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Generated Schedules -->
                <div id="schedulesContainer">
                    <div class="empty-state">
                        <i class="fas fa-calendar-alt"></i>
                        <h4>No Schedules Generated</h4>
                        <p class="text-muted">Select a location and date range, then click Generate to create schedules.</p>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

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


        $(document).ready(function() {
            // Set default dates (today and +6 days)
            const today = new Date();
            const nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 6);
            
            $('#startDate').val(formatDate(today));
            $('#endDate').val(formatDate(nextWeek));

            // Event listeners
            $('#generateSchedules').click(generateSchedules);
            $('#saveAllSchedules').click(saveAllSchedules);
        });

        function generateSchedules() {
            const agencyId = $('#agencySelect').val();
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            // Validation
            if (!agencyId) {
                showToast.error('Please select a location');
                return;
            }

            if (!startDate || !endDate) {
                showToast.error('Please select both start and end dates');
                return;
            }

            const start = new Date(startDate);
            const end = new Date(endDate);
            
            if (start > end) {
                showToast.error('End date must be after start date');
                return;
            }

            showLoader('Loading staff and generating schedules...');

            // Fetch staff for the selected location
            fetch('get_agency_staff_by_location', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(`agency_id=${agencyId}`)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    const staffList = data.data;
                    const dateRange = getDateRange(start, end);
                    const locationName = $('#agencySelect option:selected').text();
                    
                    renderSchedules(staffList, dateRange, locationName, agencyId);
                    showToast.success(`Generated schedules for ${staffList.length} staff members across ${dateRange.length} days`);
                    hideLoader();
                } else {
                    showToast.error(data.message || 'Failed to load staff members');
                renderEmptyState('No staff found for this location');
                hideLoader();
                return;
                }
            })
            .catch(error => {
                hideLoader();
                showToast.error('Network error occurred while loading staff');
            });
        }

        function getDateRange(startDate, endDate) {
            const dates = [];
            const currentDate = new Date(startDate);
            
            while (currentDate <= endDate) {
                dates.push(new Date(currentDate));
                currentDate.setDate(currentDate.getDate() + 1);
            }
            
            return dates;
        }

        function renderSchedules(staffList, dateRange, locationName, locationId) {
            const container = $('#schedulesContainer');
            
            if (staffList.length === 0) {
                container.html(`
                    <div class="empty-state">
                        <i class="fas fa-users-slash"></i>
                        <h4>No Staff Found</h4>
                        <p class="text-muted">No staff members are assigned to this location.</p>
                    </div>
                `);
                return;
            }

            let html = `
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-check me-2"></i>
                            Generated Schedules for ${locationName}
                            <span class="badge bg-light text-dark ms-2">${staffList.length} staff × ${dateRange.length} days</span>
                        </h5>
                    </div>
                </div>
            `;

            dateRange.forEach(date => {
                const dateString = formatDate(date);
                const displayDate = date.toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });

                html += `
                    <div class="schedule-section">
                        <div class="date-header">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-calendar-day me-2"></i>
                                ${displayDate}
                            </h5>
                        </div>
                `;

                staffList.forEach(staff => {
                    html += `
                        <div class="staff-schedule-card">
                            <div class="staff-info">
                                <h6 class="mb-1">${staff.name}</h6>
                                <small class="text-muted">${staff.email}</small>
                            </div>
                            
                            <div class="form-section">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold">Start Time</label>
                                        <input type="time" 
                                               class="form-control form-control-sm schedule-input" 
                                               data-staff="${staff.id}" 
                                               data-date="${dateString}" 
                                               data-field="start_time">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold">End Time</label>
                                        <input type="time" 
                                               class="form-control form-control-sm schedule-input" 
                                               data-staff="${staff.id}" 
                                               data-date="${dateString}" 
                                               data-field="end_time">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold">Shift Type</label>
                                        <select class="form-select form-select-sm schedule-input shift-type" 
                                                data-staff="${staff.id}" 
                                                data-date="${dateString}" 
                                                data-field="shift_type">
                                            <option value="day">Day</option>
                                            <option value="evening">Evening</option>
                                            <option value="overnight">Overnight</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold">Pay Rate ($/hr)</label>
                                        <input type="number" 
                                               step="0.01" 
                                               min="0"
                                               class="form-control form-control-sm schedule-input" 
                                               data-staff="${staff.id}" 
                                               data-date="${dateString}" 
                                               data-field="pay_per_hour"
                                               placeholder="0.00">
                                    </div>
                                    <div class="col-md-2 overnight-options" style="display: none;">
                                        <label class="form-label small fw-bold">Overnight Type</label>
                                        <select class="form-select form-select-sm schedule-input" 
                                                data-staff="${staff.id}" 
                                                data-date="${dateString}" 
                                                data-field="overnight_type">
                                            <option value="rest">Rest</option>
                                            <option value="awake">Awake</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += `</div>`;
            });

            container.html(html);

            // Add event listeners for shift type changes
            $('.shift-type').change(function() {
                const isOvernight = $(this).val() === 'overnight';
                $(this).closest('.row').find('.overnight-options').toggle(isOvernight);
            });
        }

        function saveAllSchedules() {
            const schedules = [];
            let hasErrors = false;

            // Collect all schedule data
            $('.schedule-input').each(function() {
                const $input = $(this);
                const staffId = $input.data('staff');
                const date = $input.data('date');
                const field = $input.data('field');
                const value = $input.val();

                // Find or create schedule object
                let schedule = schedules.find(s => s.staff_id == staffId && s.schedule_date == date);
                if (!schedule) {
                    schedule = {
                        staff_id: staffId,
                        schedule_date: date,
                        agency_id: $('#agencySelect').val(),
                        start_time: '',
                        end_time: '',
                        shift_type: 'day',
                        overnight_type: '',
                        pay_per_hour: '0.00',
                        has_all_required_fields: false
                    };
                    schedules.push(schedule);
                }

                schedule[field] = value;
            });

            // Check if any schedule has all required fields filled
            const validSchedules = schedules.filter(schedule => {
                const hasRequiredFields = schedule.start_time && schedule.end_time && schedule.shift_type;
                schedule.has_all_required_fields = hasRequiredFields;
                return hasRequiredFields;
            });

            // If no schedule has all required fields, show error
            if (validSchedules.length === 0) {
                showToast.error('Please fill in at least one complete schedule (start time, end time, and shift type)');
                return;
            }

            // Validate pay rates only for schedules that have all required fields
            validSchedules.forEach(schedule => {
                if (!schedule.pay_per_hour || parseFloat(schedule.pay_per_hour) <= 0) {
                    showToast.error(`Invalid pay rate for staff ${schedule.staff_id} on ${schedule.schedule_date}`);
                    hasErrors = true;
                    
                    // Highlight the pay rate input for this schedule
                    $(`.schedule-input[data-staff="${schedule.staff_id}"][data-date="${schedule.schedule_date}"][data-field="pay_per_hour"]`)
                        .addClass('is-invalid');
                }
            });

            if (hasErrors) {
                showToast.error('Please fix validation errors before saving');
                return;
            }

            // Send only valid schedules to backend
            const schedulesToSave = validSchedules.filter(schedule => 
                schedule.pay_per_hour && parseFloat(schedule.pay_per_hour) > 0
            );

            if (schedulesToSave.length === 0) {
                showToast.error('No valid schedules to save after validation');
                return;
            }

            // Show confirmation dialog
            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: '<i class="fas fa-save me-2"></i> Confirm Schedule Creation',
                message: `You are about to create <strong>${schedulesToSave.length} schedules</strong>.<br><br>
                        <strong>Summary:</strong><br>
                        • Complete schedules: ${schedulesToSave.length}<br>
                        • Incomplete schedules: ${schedules.length - schedulesToSave.length}<br>
                        • Agency: ${$('#agencySelect option:selected').text()}<br><br>
                        Are you sure you want to proceed?`,
                position: 'center',
                backgroundColor: '#f8f9fa',
                titleColor: '#0b184d',
                messageColor: '#343a40',
                theme: 'light',
                buttons: [
                    ['<button class="btn btn-success btn-sm"><b>YES, CREATE SCHEDULES</b></button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                        // Proceed with saving schedules
                        proceedWithSaving(schedulesToSave, schedules.length);
                        
                    }, true],
                    ['<button class="btn btn-secondary btn-sm">CANCEL</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ]
            });
        }

        // Separate function to handle the actual saving process
        function proceedWithSaving(schedulesToSave, totalSchedulesCount) {
            showLoader('Creating schedules...');

            // Prepare form data
            const formData = new FormData();
            formData.append('agency_id', $('#agencySelect').val());

            schedulesToSave.forEach((schedule, index) => {
                // Append each field with array notation
                formData.append(`schedules[${index}][staff_id]`, schedule.staff_id);
                formData.append(`schedules[${index}][schedule_date]`, schedule.schedule_date);
                formData.append(`schedules[${index}][agency_id]`, schedule.agency_id);
                formData.append(`schedules[${index}][start_time]`, schedule.start_time);
                formData.append(`schedules[${index}][end_time]`, schedule.end_time);
                formData.append(`schedules[${index}][shift_type]`, schedule.shift_type);
                formData.append(`schedules[${index}][overnight_type]`, schedule.overnight_type || '');
                formData.append(`schedules[${index}][pay_per_hour]`, schedule.pay_per_hour);
            });

            // Send to backend
            fetch('process_agency_staff_schedules', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideLoader();
                if (data.status) {
                    showToast.success(`Successfully created ${data.saved_count} schedules!`);
                    
                    // Show success message with detailed summary
                    setTimeout(() => {
                        $('#schedulesContainer').html(`
                            <div class="empty-state">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                                <h4 class="mt-3">Schedules Created Successfully!</h4>
                                <div class="alert alert-success mt-3">
                                    <h6 class="alert-heading">Summary:</h6>
                                    <div class="row text-center mt-3">
                                        <div class="col-4">
                                            <div class="border-end">
                                                <h3 class="text-success mb-1">${data.saved_count}</h3>
                                                <small class="text-muted">Created</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border-end">
                                                <h3 class="text-warning mb-1">${totalSchedulesCount - data.saved_count}</h3>
                                                <small class="text-muted">Skipped</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div>
                                                <h3 class="text-danger mb-1">${data.failed_count || 0}</h3>
                                                <small class="text-muted">Failed</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-muted mt-3">All schedules have been processed successfully.</p>
                                <div class="mt-4">
                                    <button class="btn btn-primary me-2" onclick="location.reload()">
                                        <i class="fas fa-plus me-2"></i>Create More Schedules
                                    </button>
                                    <button class="btn btn-outline-secondary" onclick="window.location.href='schedules'">
                                        <i class="fas fa-calendar me-2"></i>View All Schedules
                                    </button>
                                </div>
                            </div>
                        `);
                    }, 1000);
                    
                } else {
                    showToast.error(data.message || 'Failed to create schedules');
                    
                    // Highlight failed schedules if specific errors are returned
                    if (data.failed_schedules) {
                        data.failed_schedules.forEach(failed => {
                            $(`.schedule-input[data-staff="${failed.staff_id}"][data-date="${failed.schedule_date}"]`)
                                .addClass('is-invalid');
                        });
                    }
                    
                    // Show detailed error message if available
                    if (data.failed_count > 0) {
                        iziToast.warning({
                            title: '<i class="fas fa-exclamation-triangle me-2"></i> Partial Success',
                            message: `${data.saved_count} schedules created, but ${data.failed_count} failed to save. Please check the highlighted fields.`,
                            position: 'topRight',
                            timeout: 8000
                        });
                    }
                }
            })
            .catch(error => {
                hideLoader();
                console.error('Error:', error);
                showToast.error('Network error occurred while creating schedules');
                
                // Show retry option
                iziToast.error({
                    title: '<i class="fas fa-wifi me-2"></i> Connection Error',
                    message: 'Failed to connect to server. Please check your connection and try again.',
                    position: 'topRight',
                    timeout: false,
                    buttons: [
                        ['<button class="btn btn-primary btn-sm">Retry</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            proceedWithSaving(schedulesToSave, totalSchedulesCount);
                        }],
                        ['<button class="btn btn-secondary btn-sm">Cancel</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }]
                    ]
                });
            });
        }

        function formatDate(date) {
            return date.toISOString().split('T')[0];
        }

        function showLoader(message) {
            $('.loader-container').css('display', 'flex');
            $('.loading-text').text(message);
        }

        function hideLoader() {
            $('.loader-container').css('display', 'none');
        }

        // Helper function to calculate hours between times (for potential auto-calculation)
        function calculateHours(startTime, endTime) {
            if (!startTime || !endTime) return 0;
            
            const [startHours, startMinutes] = startTime.split(':').map(Number);
            const [endHours, endMinutes] = endTime.split(':').map(Number);
            
            let hours = endHours - startHours;
            let minutes = endMinutes - startMinutes;
            
            if (minutes < 0) {
                hours--;
                minutes += 60;
            }
            
            return hours + (minutes / 60);
        }
    </script>
</body>
</html>