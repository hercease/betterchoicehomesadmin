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
        .schedule-container {
            overflow-x: auto;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }
        
        .date-header {
            background: #0b184d;
            padding: 8px 6px !important;
            text-align: center;
            border-right: 1px solid #dee2e6;
            min-width: 140px;
            font-size: 0.85rem;
            line-height: 1.2;
        }
        
        .agency-cell {
            background: #1a2b6d;
            padding: 10px 8px !important;
            font-weight: bold;
            min-width: 120px;
            border-right: 2px solid #dee2e6;
            vertical-align: top;
            font-size: 0.85rem;
            line-height: 1.2;
        }
        
        .schedule-cell {
            min-width: 160px;
            min-height: 100px;
            padding: 6px;
            border-right: 1px solid #dee2e6;
            background: #f8f9fa;
            vertical-align: top;
        }
        
        .schedule-card {
            background: white;
            border-radius: 6px;
            padding: 8px;
            margin-bottom: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 3px solid #007bff;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .schedule-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }
        
        .schedule-card.completed {
            border-left-color: #28a745;
            background: #f8fff9;
        }
        
        .schedule-card.ongoing {
            border-left-color: #ffc107;
            background: #fffdf2;
        }
        
        .schedule-card.missed {
            border-left-color: #dc3545;
            background: #fff5f5;
        }
        
        .schedule-card.scheduled {
            border-left-color: #007bff;
            background: #f8fbff;
        }
        
        .status-badge {
            font-size: 0.65em;
            padding: 3px 6px;
            border-radius: 10px;
        }
        
        .person-name {
            font-weight: bold;
            font-size: 0.75em;
            margin-bottom: 3px;
            line-height: 1.2;
        }
        
        .time-slot {
            font-size: 0.7em;
            color: #6c757d;
            margin-bottom: 2px;
            line-height: 1.2;
        }
        
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .sticky-agency {
            position: sticky;
            left: 0;
            z-index: 5;
            background: #1a2b6d;
        }
        
        .schedule-table {
            font-size: 0.85rem;
        }
        
        .schedule-table th {
            padding: 8px 6px !important;
        }
        
        .schedule-table td {
            padding: 6px !important;
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

        .date-navigation {
            background: #0b184d;
            color: white;
            border-radius: 8px;
            padding: 8px 12px;
        }

        .week-range {
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .week-range:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            padding: 2px 8px;
        }

        .empty-cell {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 15px;
            font-size: 0.8rem;
        }

        .action-buttons {
            display: flex;
            gap: 4px;
            justify-content: center;
            margin-top: 5px;
        }

        .action-btn {
            padding: 2px 6px;
            font-size: 0.7rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-btn:hover {
            transform: scale(1.05);
        }

        .btn-edit {
            background: #007bff;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
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
                    <!-- Header and Controls -->
                <div class="container-xl px-4 mt-5">

                    <div class="row mb-4">
                        <div class="col">
                            <h4 class="fw-bold"><i class="fas fa-calendar-alt me-2"></i> Agency Schedule Spreadsheet</h4>
                            <p class="text-muted">View and manage schedules across agencies and dates</p>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Start Date</label>
                                    <input type="date" id="startDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">End Date</label>
                                    <input type="date" id="endDate" class="form-control" value="<?php echo date('Y-m-d', strtotime('+6 days')); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Agency</label>
                                    <select id="agencyFilter" class="form-select">
                                        <option value="">All Agencies</option>
                                        <!-- Agencies will be populated dynamically -->
                                        <?php foreach($data['all_agencies']['data'] as $agency): ?>
                                                <option value="<?php echo $agency['id']; ?>"><?php echo $agency['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button class="btn btn-primary w-100" id="btnSearch">
                                        <i class="fas fa-search me-2"></i>Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Spreadsheet View -->
                        <div class="schedule-container">
                            <div id="spreadsheetView">
                                <div class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Select date range and click Search to load schedules</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            <?php include("app/views/includes/footer.php"); ?> 
            </div>
        </div>

    <!-- Edit Schedule Modal -->
    <div class="modal fade" id="editScheduleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editScheduleForm">
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
                                    <option value="day">Day</option>
                                    <option value="evening">Evening</option>
                                    <option value="overnight">Overnight</option>
                                </select>
                            </div>
                            <div class="col-12 overnight-type d-none">
                                <label class="form-label">Overnight Type</label>
                                <select name="overnight_type" class="form-select">
                                    <option value="rest">Rest</option>
                                    <option value="awake">Awake</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="schedule_id" id="editScheduleId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Schedule Details Modal -->
    <div class="modal fade" id="scheduleDetailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-calendar-day me-2"></i>Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="scheduleDetails">
                    <!-- Details will be populated here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
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

        // Global variables
        let scheduleData = {};

        $(document).ready(function() {
            //loadAgencies();
            setupEventListeners();
            loadScheduleData(); // Load initial data
        });

        function setupEventListeners() {
            $('#btnSearch').click(loadScheduleData);
            $('#editScheduleForm').submit(updateSchedule);
            
            // Shift type change handler
            $('select[name="shift_type"]').on('change', function() {
                if ($(this).val() === 'overnight') {
                    $('.overnight-type').removeClass('d-none');
                } else {
                    $('.overnight-type').addClass('d-none');
                }
            });
        }

        function loadScheduleData() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();
            const agencyId = $('#agencyFilter').val();

            if (!startDate || !endDate) {
                showToast.error('Please select both start and end dates');
                return;
            }

            showLoader('Loading schedules...');

            const formData = new FormData();
            formData.append('action', 'spreadsheet');
            formData.append('start_date', startDate);
            formData.append('end_date', endDate);
            formData.append('agency', agencyId);

            fetch('fetch_agency_schedules', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideLoader();
                if (data.status) {
                    scheduleData = data.data;
                    renderSpreadsheet();
                    showToast.success(`Loaded ${Object.keys(scheduleData.schedule_data || {}).length} agencies`);
                } else {
                    showToast.error(data.message || 'Failed to load schedule data');
                }
            })
            .catch(error => {
                hideLoader();
                showToast.error('Network error occurred while loading data');
            });
        }

        function renderSpreadsheet() {

            if (!scheduleData.dates || !scheduleData.agencies || !scheduleData.schedule_data) {
                $('#spreadsheetView').html('<div class="text-center py-4 text-muted">No schedule data available</div>');
                return;
            }

            let html = `
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 schedule-table">
                        <thead class="sticky-header">
                            <tr>
                                <th class="agency-cell"><i class="fas fa-building me-1"></i>Agency / Date</th>
            `;

            // Add date headers
            scheduleData.dates.forEach(dateInfo => {
                html += `
                    <th class="date-header">
                        <div>${dateInfo.day}</div>
                        <div class="fw-normal">${dateInfo.display}</div>
                    </th>
                `;
            });

            html += `</tr></thead><tbody>`;

            // Add agency rows
            scheduleData.agencies.forEach(agency => {
                html += `<tr class="agency-row">`;
                html += `<td class="agency-cell sticky-agency">
                            <i class="fas fa-building me-1"></i>${agency}
                         </td>`;

                // Add schedule cells for each date
                scheduleData.dates.forEach(dateInfo => {
                    const dateSchedules = scheduleData.schedule_data[agency]?.[dateInfo.date] || [];

                    html += `<td class="schedule-cell">`;
                    
                    if (dateSchedules.length > 0) {
                        dateSchedules.forEach(schedule => {
                            const statusClass = getStatusClass(schedule.status);
                            html += `
                                <div class="schedule-card ${schedule.status}" 
                                     onclick="showScheduleDetails(${schedule.id})"
                                     title="Click for details">
                                    <div class="person-name">${schedule.staff_name}</div>
                                    <div class="time-slot">
                                        <i class="far fa-clock me-1"></i>${schedule.start_time} - ${schedule.end_time}
                                    </div>
                                    <span class="badge ${statusClass.class} status-badge">
                                        ${statusClass.icon} ${schedule.status}
                                    </span>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-edit" onclick="editSchedule(${schedule.id}, event)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn btn-delete" onclick="deleteSchedule(${schedule.id}, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        html += `<div class="empty-cell">No schedules</div>`;
                    }
                    
                    html += `</td>`;
                });

                html += `</tr>`;
            });

            html += `</tbody></table></div>`;
            $('#spreadsheetView').html(html);
        }

        function getStatusClass(status) {
            switch(status) {
                case 'completed':
                    return {
                        icon: '<i class="fas fa-check me-1"></i>',
                        class: 'bg-success text-light'
                    };
                case 'ongoing':
                    return {
                        icon: '<i class="fas fa-clock me-1"></i>',
                        class: 'bg-warning text-dark'
                    };
                case 'missed':
                    return {
                        icon: '<i class="fas fa-times me-1"></i>',
                        class: 'bg-danger text-light'
                    };
                case 'scheduled':
                    return {
                        icon: '<i class="fas fa-calendar me-1"></i>',
                        class: 'bg-primary text-light'
                    };
                default:
                    return {
                        icon: '<i class="fas fa-circle me-1"></i>',
                        class: 'bg-secondary text-light'
                    };
            }
        }

        function showScheduleDetails(scheduleId) {

            showLoader('Loading schedule details...');
            
            // This would typically fetch detailed schedule info from an API
            // For now, we'll use the data we already have
            const schedule = findScheduleById(scheduleId);
            
            hideLoader();
            if (schedule) {
                const detailsHtml = `
                    <div class="row g-3">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2">Staff Information</h6>
                            <p class="mb-1"><strong>Name:</strong> ${schedule.staff_name}</p>
                            <p class="mb-1"><strong>Agency:</strong> ${schedule.agency}</p>
                        </div>
                        <div class="col-12">
                            <h6 class="border-bottom pb-2">Schedule Details</h6>
                            <p class="mb-1"><strong>Date:</strong> ${new Date(schedule.date).toLocaleDateString()}</p>
                            <p class="mb-1"><strong>Time:</strong> ${schedule.start_time} - ${schedule.end_time}</p>
                            <p class="mb-1"><strong>Status:</strong> <span class="badge ${getStatusClass(schedule.status).class}">${schedule.status}</span></p>
                        </div>
                    </div>
                `;
                $('#scheduleDetails').html(detailsHtml);
                $('#scheduleDetailModal').modal('show');
            } else {
                showToast.error('Schedule not found');
            }
        }

        function findScheduleById(scheduleId) {
            // Search through all schedules to find the one with matching ID
            for (const agency in scheduleData.schedule_data) {
                for (const date in scheduleData.schedule_data[agency]) {
                    const schedule = scheduleData.schedule_data[agency][date].find(s => s.id == scheduleId);
                    if (schedule) return schedule;
                }
            }
            return null;
        }

        function editSchedule(scheduleId, event) {
            event.stopPropagation(); // Prevent triggering the card click
            showLoader('Loading schedule for editing...');
            
            // This would typically fetch schedule details from an API
            const schedule = findScheduleById(scheduleId);
            
            hideLoader();
            if (schedule) {
                // Populate the edit form
                $('#editScheduleId').val(schedule.id);
                $('input[name="start_time"]').val(schedule.start_time.replace(' AM', '').replace(' PM', ''));
                $('input[name="end_time"]').val(schedule.end_time.replace(' AM', '').replace(' PM', ''));
                // Note: You may need additional API calls to get pay_per_hour and shift_type
                
                $('#editScheduleModal').modal('show');
            } else {
                showToast.error('Schedule not found');
            }
        }

        function updateSchedule(e) {
            e.preventDefault();
            const scheduleId = $('#editScheduleId').val();
            
            showLoader('Updating schedule...');
            
            const formData = new FormData(this);
            formData.append('schedule_id', scheduleId);
            
            // This would typically send the update to your backend
            setTimeout(() => {
                hideLoader();
                showToast.success('Schedule updated successfully');
                $('#editScheduleModal').modal('hide');
                loadScheduleData(); // Reload the data
            }, 1000);
        }

        function deleteSchedule(scheduleId, event) {
            event.stopPropagation(); // Prevent triggering the card click
            
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
                        
                        showLoader('Deleting schedule...');
                        
                        // This would typically send delete request to your backend
                        setTimeout(() => {
                            hideLoader();
                            showToast.success('Schedule deleted successfully');
                            loadScheduleData(); // Reload the data
                        }, 1000);
                        
                    }, true],
                    ['<button class="btn btn-secondary btn-sm">CANCEL</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ]
            });
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