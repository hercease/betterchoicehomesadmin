<!DOCTYPE html>
<html lang="en"> 
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>All Schedules - BetterChoiceGroupHomes | Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="/public/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
        <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
        <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
        <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
            font-weight: 400;
            color: #333;
        }

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
        
        .location-cell {
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
            font-size: 0.8rem;
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
        
        .sticky-location {
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

        .form-select-sm, .form-control-sm {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }

        .date-header i, .location-cell i {
            font-size: 0.7rem;
        }

        .card-body {
            padding: 1rem;
        }

        .filters-card .card-body {
            padding: 0.75rem;
        }

        /* Calendar Modal Styles */
        .calendar-modal .modal-dialog {
            max-width: 500px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-bottom: 1rem;
        }

        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-bottom: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 0.8rem;
            color: #0b184d;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s ease;
        }

        .calendar-day:hover {
            background-color: #e9ecef;
        }

        .calendar-day.other-month {
            color: #6c757d;
            background-color: #f8f9fa;
        }

        .calendar-day.selected {
            background-color: #0b184d;
            color: white;
            border-color: #0b184d;
        }

        .calendar-day.range-start {
            background-color: #0b184d;
            color: white;
            border-radius: 4px 0 0 4px;
        }

        .calendar-day.range-end {
            background-color: #0b184d;
            color: white;
            border-radius: 0 4px 4px 0;
        }

        .calendar-day.in-range {
            background-color: #1a2b6d;
            color: white;
        }

        .calendar-day.today {
            border: 2px solid #f58634;
        }

        .calendar-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .calendar-month {
            font-weight: bold;
            font-size: 1.1rem;
            color: #0b184d;
        }

        .date-selection-info {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }

        .date-selection-info .selected-range {
            font-weight: bold;
            color: #0b184d;
        }

        .date-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .date-input-group {
            display: flex;
            flex-direction: column;
        }

        .date-input-group label {
            font-size: 0.8rem;
            font-weight: bold;
            margin-bottom: 4px;
            color: #0b184d;
        }

        .quick-range-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 1rem;
        }

        .quick-range-btn {
            font-size: 0.8rem;
            padding: 6px 12px;
        }

        .days-count {
            color: #28a745;
            font-weight: bold;
            margin-left: 5px;
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
            opacity: 0.8;
        }

        .action-btn:hover {
            transform: scale(1.05);
            opacity: 1;
        }

        .btn-edit {
            background: #007bff;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .action-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
            transform: none;
        }

        .action-btn:disabled:hover {
            transform: none;
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
                    <div class="container-fluid px-4 mt-5">
                        <!-- Custom page header alternative example-->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold"><i class="fas fa-calendar-alt me-2"></i> Schedule Spreadsheet View</h4>
                        </div>
                        <!-- Illustration dashboard card example-->
                        <div class="row">

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <div class="date-navigation d-flex align-items-center justify-content-between">
                                                <button class="btn btn-sm btn-light" id="prevPeriod" title="Previous Period">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <span class="week-range" id="dateRange" title="Click to select date range">Loading...</span>
                                                <button class="btn btn-sm btn-light" id="nextPeriod" title="Next Period">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-bold">Location Filter</label>
                                                    <select id="locationFilter" class="form-select form-select-sm">
                                                        <option value="">All Locations</option>
                                                        <?php foreach($data['all_location'] as $location){ ?>
                                                            <option value="<?php echo $location['id'] ?>">
                                                                <?php echo $location['address'].', '.$location['city'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-bold">Status Filter</label>
                                                    <select id="statusFilter" class="form-select form-select-sm">
                                                        <option value="">All Status</option>
                                                        <option value="scheduled">Scheduled</option>
                                                        <option value="ongoing">Ongoing</option>
                                                        <option value="completed">Completed</option>
                                                        <option value="missed">Missed</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 d-flex align-items-end">
                                                    <button id="btnRefresh" class="btn btn-primary btn-sm w-100">
                                                        <i class="fas fa-sync-alt me-1"></i>Refresh
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                                    <div class="schedule-container">
                                        <div id="spreadsheetView">
                                            <!-- Spreadsheet will be rendered here dynamically -->
                                            <div class="text-center py-5">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <p class="mt-2 text-muted">Loading schedule data...</p>
                                            </div>
                                        </div>
                                    </div>

                        </div>
                        
                    </div>
                </main>

                <!-- Calendar Week Picker Modal -->
                <div class="modal fade calendar-modal" data-bs-backdrop="static" id="dateRangePickerModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-2">
                                <h5 class="modal-title" style="font-size: 1.1rem;"><i class="fas fa-calendar-alt me-2"></i>Select Date Range</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body py-2">
                                <!-- Manual Date Inputs -->
                                <div class="date-inputs">
                                    <div class="date-input-group">
                                        <label for="startDateInput"><i class="fas fa-calendar-plus me-1"></i>Start Date</label>
                                        <input type="date" id="startDateInput" class="form-control form-control-sm">
                                    </div>
                                    <div class="date-input-group">
                                        <label for="endDateInput"><i class="fas fa-calendar-minus me-1"></i>End Date</label>
                                        <input type="date" id="endDateInput" class="form-control form-control-sm">
                                    </div>
                                </div>
                                
                                <div class="calendar-nav">
                                    <button class="btn btn-sm btn-outline-primary" id="prevMonth">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <span class="calendar-month" id="currentMonth">January 2024</span>
                                    <button class="btn btn-sm btn-outline-primary" id="nextMonth">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                
                                <div class="date-selection-info">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Selected: <span class="selected-range" id="selectedRangeDisplay">No dates selected</span>
                                    <span class="days-count" id="daysCountDisplay"></span>
                                </div>
                                
                                <div class="calendar-header">
                                    <div>Sun</div>
                                    <div>Mon</div>
                                    <div>Tue</div>
                                    <div>Wed</div>
                                    <div>Thu</div>
                                    <div>Fri</div>
                                    <div>Sat</div>
                                </div>
                                <div class="calendar-grid" id="calendarGrid">
                                    <!-- Calendar days will be populated here -->
                                </div>
                                
                                <div class="quick-range-buttons">
                                    <button class="btn btn-outline-secondary quick-range-btn" id="last7DaysBtn">
                                        <i class="fas fa-calendar-week me-1"></i>Last 7 Days
                                    </button>
                                    <button class="btn btn-outline-secondary quick-range-btn" id="thisMonthBtn">
                                        <i class="fas fa-calendar me-1"></i>This Month
                                    </button>
                                    <button class="btn btn-outline-secondary quick-range-btn" id="lastMonthBtn">
                                        <i class="fas fa-calendar me-1"></i>Last Month
                                    </button>
                                </div>
                            </div>
                            <div class="modal-footer py-2">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary btn-sm" id="applyDateRange">Apply Dates</button>
                            </div>
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
        // Global variables
        let currentStartDate = new Date();
        let currentEndDate = new Date();
        let scheduleData = {};
        let selectedStartDate = null;
        let selectedEndDate = null;
        let currentCalendarDate = new Date();

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

        // Initialize when page loads
        $(document).ready(function() {
            initializeDateRange();
            setupEventListeners();
            loadScheduleData();
        });

        function initializeDateRange() {
            // Set default to current week
            const today = new Date();
            const dayOfWeek = today.getDay();
            const diffToMonday = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
            
            currentStartDate = new Date(today);
            currentStartDate.setDate(today.getDate() + diffToMonday);
            
            currentEndDate = new Date(currentStartDate);
            currentEndDate.setDate(currentStartDate.getDate() + 6);
            
            updateDateRangeDisplay();
        }

        function updateDateRangeDisplay() {
            const options = { month: 'short', day: 'numeric' };
            const startStr = currentStartDate.toLocaleDateString('en-US', options);
            const endStr = currentEndDate.toLocaleDateString('en-US', options);
            const year = currentStartDate.getFullYear();
            
            const dayDiff = Math.ceil((currentEndDate - currentStartDate) / (1000 * 60 * 60 * 24)) + 1;
            
            $('#dateRange').html(`${startStr} - ${endStr}, ${year} <span class="days-count">(${dayDiff} days)</span>`);
        }

        function setupEventListeners() {
            $('#prevPeriod').click(function() {
                navigatePeriod(-1);
            });

            $('#nextPeriod').click(function() {
                navigatePeriod(1);
            });

            $('#dateRange').click(function() {
                openDateRangePicker();
            });

            $('#btnRefresh').click(function() {
                loadScheduleData();
            });

            $('#locationFilter, #statusFilter').change(function() {
                renderSpreadsheet();
            });

            // Calendar event listeners
            $('#prevMonth').click(function() {
                navigateCalendarMonth(-1);
            });

            $('#nextMonth').click(function() {
                navigateCalendarMonth(1);
            });

            // Date input listeners
            $('#startDateInput').change(function() {
                const date = new Date($(this).val());
                if (!isNaN(date.getTime())) {
                    selectStartDate(date);
                }
            });

            $('#endDateInput').change(function() {
                const date = new Date($(this).val());
                if (!isNaN(date.getTime())) {
                    selectEndDate(date);
                }
            });

            // Quick range buttons
            $('#last7DaysBtn').click(function() {
                selectLast7Days();
            });

            $('#thisMonthBtn').click(function() {
                selectThisMonth();
            });

            $('#lastMonthBtn').click(function() {
                selectLastMonth();
            });

            $('#applyDateRange').click(function() {
                applyDateRange();
            });
        }

        function navigatePeriod(direction) {
            const dayDiff = Math.ceil((currentEndDate - currentStartDate) / (1000 * 60 * 60 * 24));
            currentStartDate.setDate(currentStartDate.getDate() + (direction * (dayDiff + 1)));
            currentEndDate.setDate(currentEndDate.getDate() + (direction * (dayDiff + 1)));
            updateDateRangeDisplay();
            loadScheduleData();
        }

        function openDateRangePicker() {
            selectedStartDate = new Date(currentStartDate);
            selectedEndDate = new Date(currentEndDate);
            currentCalendarDate = new Date(currentStartDate);
            
            // Set date inputs
            $('#startDateInput').val(formatDateForInput(selectedStartDate));
            $('#endDateInput').val(formatDateForInput(selectedEndDate));
            
            renderCalendar();
            updateSelectedRangeDisplay();
            $('#dateRangePickerModal').modal('show');
        }

        function renderCalendar() {
            const year = currentCalendarDate.getFullYear();
            const month = currentCalendarDate.getMonth();
            
            // Update month display
            $('#currentMonth').text(currentCalendarDate.toLocaleDateString('en-US', { 
                month: 'long', 
                year: 'numeric' 
            }));

            // Get first day of month and last day of month
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            
            // Get the day of the week for the first day (0 = Sunday, 1 = Monday, etc.)
            const firstDayOfWeek = firstDay.getDay();
            
            // Calculate total days to show (6 weeks to ensure we cover all scenarios)
            const totalDays = 42;
            const calendarGrid = $('#calendarGrid');
            calendarGrid.empty();

            // Calculate the first date to show in the calendar
            const startDate = new Date(firstDay);
            startDate.setDate(firstDay.getDate() - firstDayOfWeek);

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            for (let i = 0; i < totalDays; i++) {
                const currentDate = new Date(startDate);
                currentDate.setDate(startDate.getDate() + i);
                
                const dayElement = $('<div class="calendar-day"></div>');
                dayElement.text(currentDate.getDate());

                // Check if this day is in the current month
                if (currentDate.getMonth() !== month) {
                    dayElement.addClass('other-month');
                }

                // Check if this is today
                if (currentDate.toDateString() === today.toDateString()) {
                    dayElement.addClass('today');
                }

                // Check if this day is in the selected range
                if (selectedStartDate && selectedEndDate) {
                    const currentDateClean = new Date(currentDate);
                    currentDateClean.setHours(0, 0, 0, 0);
                    const startClean = new Date(selectedStartDate);
                    startClean.setHours(0, 0, 0, 0);
                    const endClean = new Date(selectedEndDate);
                    endClean.setHours(0, 0, 0, 0);
                    
                    if (currentDateClean >= startClean && currentDateClean <= endClean) {
                        if (currentDateClean.toDateString() === startClean.toDateString()) {
                            dayElement.addClass('range-start');
                        } else if (currentDateClean.toDateString() === endClean.toDateString()) {
                            dayElement.addClass('range-end');
                        } else {
                            dayElement.addClass('in-range');
                        }
                    }
                }

                // Add click event - toggle selection
                dayElement.click(function() {
                    handleDateClick(currentDate);
                });

                calendarGrid.append(dayElement);
            }
        }

        function navigateCalendarMonth(direction) {
            currentCalendarDate.setMonth(currentCalendarDate.getMonth() + direction);
            renderCalendar();
        }

        function handleDateClick(date) {
            const clickedDate = new Date(date);
            clickedDate.setHours(0, 0, 0, 0);

            if (!selectedStartDate || (selectedStartDate && selectedEndDate)) {
                // Start new selection
                selectedStartDate = new Date(clickedDate);
                selectedEndDate = new Date(clickedDate);
            } else {
                // Extend selection
                if (clickedDate < selectedStartDate) {
                    selectedStartDate = new Date(clickedDate);
                } else {
                    selectedEndDate = new Date(clickedDate);
                }
            }

            // Update date inputs
            $('#startDateInput').val(formatDateForInput(selectedStartDate));
            $('#endDateInput').val(formatDateForInput(selectedEndDate));

            renderCalendar();
            updateSelectedRangeDisplay();
        }

        function selectStartDate(date) {
            selectedStartDate = new Date(date);
            if (!selectedEndDate || selectedEndDate < selectedStartDate) {
                selectedEndDate = new Date(selectedStartDate);
            }
            renderCalendar();
            updateSelectedRangeDisplay();
        }

        function selectEndDate(date) {
            selectedEndDate = new Date(date);
            if (!selectedStartDate || selectedStartDate > selectedEndDate) {
                selectedStartDate = new Date(selectedEndDate);
            }
            renderCalendar();
            updateSelectedRangeDisplay();
        }

        function updateSelectedRangeDisplay() {
            if (selectedStartDate && selectedEndDate) {
                const options = { month: 'short', day: 'numeric', year: 'numeric' };
                const startStr = selectedStartDate.toLocaleDateString('en-US', options);
                const endStr = selectedEndDate.toLocaleDateString('en-US', options);
                
                const dayDiff = Math.ceil((selectedEndDate - selectedStartDate) / (1000 * 60 * 60 * 24)) + 1;
                
                $('#selectedRangeDisplay').text(`${startStr} to ${endStr}`);
                $('#daysCountDisplay').text(`(${dayDiff} days)`);
            } else {
                $('#selectedRangeDisplay').text('No dates selected');
                $('#daysCountDisplay').text('');
            }
        }

        function selectLast7Days() {
            const today = new Date();
            selectedEndDate = new Date(today);
            selectedStartDate = new Date(today);
            selectedStartDate.setDate(today.getDate() - 6);
            
            $('#startDateInput').val(formatDateForInput(selectedStartDate));
            $('#endDateInput').val(formatDateForInput(selectedEndDate));
            
            renderCalendar();
            updateSelectedRangeDisplay();
        }

        function selectThisMonth() {
            const today = new Date();
            selectedStartDate = new Date(today.getFullYear(), today.getMonth(), 1);
            selectedEndDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            
            $('#startDateInput').val(formatDateForInput(selectedStartDate));
            $('#endDateInput').val(formatDateForInput(selectedEndDate));
            
            renderCalendar();
            updateSelectedRangeDisplay();
        }

        function selectLastMonth() {
            const today = new Date();
            selectedStartDate = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            selectedEndDate = new Date(today.getFullYear(), today.getMonth(), 0);
            
            $('#startDateInput').val(formatDateForInput(selectedStartDate));
            $('#endDateInput').val(formatDateForInput(selectedEndDate));
            
            renderCalendar();
            updateSelectedRangeDisplay();
        }

        function applyDateRange() {
            if (selectedStartDate && selectedEndDate) {
                currentStartDate = new Date(selectedStartDate);
                currentEndDate = new Date(selectedEndDate);
                
                updateDateRangeDisplay();
                loadScheduleData();
                $('#dateRangePickerModal').modal('hide');
            } else {
                showToast.error('Please select a date range first');
            }
        }

        function formatDateForInput(date) {
            return date.toISOString().split('T')[0];
        }

        function formatDateForAPI(date) {
            return date.toISOString().split('T')[0];
        }

        function loadScheduleData() {

            showLoader('Loading schedule data...');

            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            
            const formData = new FormData();
            formData.append('action', 'spreadsheet');
            formData.append('start_date', formatDateForAPI(currentStartDate));
            formData.append('end_date', formatDateForAPI(currentEndDate));
            formData.append('location', $('#locationFilter').val());
            formData.append('timezone', timezone);


            console.log('Loading data for:',{
                start: formatDateForAPI(currentStartDate),
                end: formatDateForAPI(currentEndDate)
            });

            fetch('schedule_testing',{
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                hideLoader();
                if (data.status) {
                    scheduleData = data.data;
                    renderSpreadsheet();
                    //showToast.success('Schedule data loaded successfully');
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
            if (!scheduleData.dates || !scheduleData.locations || !scheduleData.schedule_data) {
                $('#spreadsheetView').html('<div class="text-center py-4 text-muted">No schedule data available</div>');
                return;
            }

            const locationFilter = $('#locationFilter').val();
            const statusFilter = $('#statusFilter').val();
            
            let locations = scheduleData.locations;
            if (locationFilter) {
                locations = locations.filter(loc => {
                    return loc.toLowerCase().includes(locationFilter.toLowerCase());
                });
            }

            let html = `
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 schedule-table">
                        <thead class="sticky-header">
                            <tr>
                                <th class="location-cell"><i class="fas fa-map-marker-alt me-1"></i>Location / Date</th>
            `;

            scheduleData.dates.forEach(dateInfo => {
                html += `
                    <th class="date-header">
                        <div>${dateInfo.day}</div>
                        <div class="fw-normal">${dateInfo.display}</div>
                    </th>
                `;
            });

            html += `</tr></thead><tbody>`;

            locations.forEach(location => {
                html += `<tr class="location-row">`;
                html += `<td class="location-cell sticky-location">
                            <i class="fas fa-building me-1"></i>${location}
                        </td>`;

                scheduleData.dates.forEach(dateInfo => {
                    const dateSchedules = scheduleData.schedule_data[location]?.[dateInfo.date] || [];
                    
                    let filteredSchedules = dateSchedules;
                    if (statusFilter) {
                        filteredSchedules = dateSchedules.filter(schedule => 
                            schedule.status === statusFilter
                        );
                    }

                    html += `<td class="schedule-cell">`;
                    
                    if (filteredSchedules.length > 0) {
                        filteredSchedules.forEach(schedule => {
                            const statusClass = getStatusClass(schedule.status);
                            const canEditDelete = schedule.status === 'scheduled'; // Only allow edit/delete for scheduled status
                            
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
                                        <button class="action-btn btn-edit" 
                                                onclick="editSchedule(${schedule.id}, event)"
                                                ${!canEditDelete ? 'disabled' : ''}
                                                title="${canEditDelete ? 'Edit Schedule' : 'Cannot edit - schedule already started'}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn btn-delete" 
                                                onclick="deleteSchedule(${schedule.id}, event)"
                                                ${!canEditDelete ? 'disabled' : ''}
                                                title="${canEditDelete ? 'Delete Schedule' : 'Cannot delete - schedule already started'}">
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

        // Edit Schedule Function
        function editSchedule(scheduleId, event) {
            event.stopPropagation(); // Prevent triggering the card click
            
            // Check if schedule can be edited (status should be 'scheduled')
            const schedule = findScheduleById(scheduleId);
            if (!schedule) {
                showToast.error('Schedule not found');
                return;
            }
            
            if (schedule.status !== 'scheduled') {
                showToast.error('Cannot edit schedule that has already started');
                return;
            }

            showLoader('Loading schedule for editing...');
            
            fetch('get_schedule_details', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(`schedule_id=${scheduleId}`).toString()
            })
            .then(response => response.json())
            .then(data => {
                hideLoader();
                if (data.status) {
                    const schedule = data.data;
                    populateEditForm(schedule);
                } else {
                    showToast.error(data.message || 'Failed to load schedule details');
                }
            })
            .catch(error => {
                hideLoader();
                showToast.error('Network error occurred');
            });
        }

        function populateEditForm(schedule) {
            // Create and show edit modal
            const editModalHtml = `
                <div class="modal fade" data-bs-backdrop="static" id="editScheduleModal" tabindex="-1">
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
                                            <input type="time" name="start_time" class="form-control" value="${schedule.start_time.substring(0, 5)}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">End Time</label>
                                            <input type="time" name="end_time" class="form-control" value="${schedule.end_time.substring(0, 5)}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Pay Per Hour ($)</label>
                                            <input type="number" name="pay_per_hour" class="form-control" step="0.01" value="${schedule.pay_per_hour}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Shift Type</label>
                                            <select name="shift_type" class="form-select" required>
                                                <option value="day" ${schedule.shift_type === 'day' ? 'selected' : ''}>Day</option>
                                                <option value="evening" ${schedule.shift_type === 'evening' ? 'selected' : ''}>Evening</option>
                                                <option value="overnight" ${schedule.shift_type === 'overnight' ? 'selected' : ''}>Overnight</option>
                                            </select>
                                        </div>
                                        <div class="col-12 overnight-type ${schedule.shift_type === 'overnight' ? '' : 'd-none'}">
                                            <label class="form-label">Overnight Type</label>
                                            <select name="overnight_type" class="form-select">
                                                <option value="rest" ${schedule.overnight_type === 'rest' ? 'selected' : ''}>Rest</option>
                                                <option value="awake" ${schedule.overnight_type === 'awake' ? 'selected' : ''}>Awake</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="${schedule.id}">
                                    <input type="hidden" name="email" value="${schedule.email}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Schedule</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            $('#editScheduleModal').remove();
            
            // Add new modal to body
            $('body').append(editModalHtml);
            
            // Initialize the modal
            const editModal = new bootstrap.Modal(document.getElementById('editScheduleModal'));
            
            // Add event listeners
            $('#editScheduleForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                updateSchedule(this);
            });
            
            $('select[name="shift_type"]').off('change').on('change', function() {
                const isOvernight = $(this).val() === 'overnight';
                $(this).closest('.modal-body').find('.overnight-type').toggleClass('d-none', !isOvernight);
            });
            
            // Show modal
            editModal.show();
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

        //console.log('User Timezone:', timezone);

        function showScheduleDetails(scheduleId) {
            showLoader('Loading schedule details...');
            
            // Get user timezone
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            
            fetch('get_schedule_details', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(`schedule_id=${scheduleId}&timezone=${timezone}`).toString()
            })
            .then(response => response.json())
            .then(data => {
                console.log('Schedule details response:', data);
                hideLoader();
                
                if (data.status) {
                    const schedule = data.data;
                    
                    const detailsHtml = `
                        <div class="row g-2">
                            <div class="col-12">
                                <h6 class="border-bottom pb-1" style="font-size: 0.9rem;">Staff Information</h6>
                                <p class="mb-1 small"><strong>Email:</strong> ${schedule.email || 'N/A'}</p>
                            </div>
                            <div class="col-12">
                                <h6 class="border-bottom pb-1" style="font-size: 0.9rem;">Schedule Details</h6>
                                <p class="mb-1 small"><strong>Date:</strong> ${schedule.schedule_date_formatted}</p>
                                <p class="mb-1 small"><strong>Time:</strong> ${schedule.start_time_formatted} - ${schedule.end_time_formatted}</p>
                                <p class="mb-1 small"><strong>Shift Type:</strong> ${schedule.shift_type || 'day'}</p>
                                <p class="mb-1 small"><strong>Scheduled Hours:</strong> ${schedule.scheduled_hours}h</p>
                                <p class="mb-1 small"><strong>Location:</strong> ${schedule.location_name}</p>
                                <p class="mb-1 small"><strong>Status:</strong> <span class="badge ${getStatusClass(schedule.status).class}">${schedule.status}</span></p>
                            </div>
                            <div class="col-12">
                                <h6 class="border-bottom pb-1" style="font-size: 0.9rem;">Time Tracking</h6>
                                <p class="mb-1 small"><strong>Clock In:</strong> ${schedule.clockin_formatted}</p>
                                <p class="mb-1 small"><strong>Clock Out:</strong> ${schedule.clockout_formatted}</p>
                                <p class="mb-1 small"><strong>Hours Worked:</strong> ${schedule.worked_hours}h</p>
                            </div>
                            <div class="col-12">
                                <h6 class="border-bottom pb-1" style="font-size: 0.9rem;">Payment Information</h6>
                                <p class="mb-1 small"><strong>Pay Rate:</strong> $${parseFloat(schedule.pay_per_hour || 0).toFixed(2)}/hour</p>
                                <p class="mb-1 small"><strong>Expected Pay:</strong> $${schedule.expected_pay} CAD</p>
                                <p class="mb-1 small"><strong>Actual Pay:</strong> $${schedule.actual_pay} CAD</p>
                            </div>
                        </div>
                    `;
                    $('#scheduleDetails').html(detailsHtml);
                    $('#scheduleDetailModal').modal('show');
                } else {
                    showToast.error(data.message || 'Failed to load schedule details');
                }
            })
            .catch(error => {
                hideLoader();
                showToast.error('Network error occurred');
                console.error('Error:', error);
            });
        }

        function updateSchedule(form) {
            const formData = new FormData(form);
            const scheduleId = formData.get('schedule_id');
            
            showLoader('Updating schedule...');
            
            fetch('update_schedule', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideLoader();
                if (data.status) {
                    showToast.success('Schedule updated successfully');
                    $('#editScheduleModal').modal('hide');
                    loadScheduleData(); // Reload data
                } else {
                    showToast.error(data.message || 'Failed to update schedule');
                }
            })
            .catch(error => {
                hideLoader();
                showToast.error('Network error occurred while updating schedule');
            });
        }

        // Delete Schedule Function
        function deleteSchedule(scheduleId, event) {
            event.stopPropagation(); // Prevent triggering the card click
            
            // Check if schedule can be deleted (status should be 'scheduled')
            const schedule = findScheduleById(scheduleId);
            if (!schedule) {
                showToast.error('Schedule not found');
                return;
            }
            
            if (schedule.status !== 'scheduled') {
                showToast.error('Cannot delete schedule that has already started');
                return;
            }

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
                        
                        fetch('delete_schedule', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: new URLSearchParams(`schedule_id=${scheduleId}`).toString()
                        })
                        .then(response => response.json())
                        .then(data => {
                            hideLoader();
                            if (data.status) {
                                showToast.success('Schedule deleted successfully');
                                loadScheduleData(); // Reload data
                            } else {
                                showToast.error(data.message || 'Failed to delete schedule');
                            }
                        })
                        .catch(error => {
                            hideLoader();
                            showToast.error('Network error occurred while deleting schedule');
                        });
                        
                    }, true],
                    ['<button class="btn btn-secondary btn-sm">CANCEL</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ]
            });
        }

        // Helper function to find schedule by ID
        function findScheduleById(scheduleId) {
            // Search through all schedules to find the one with matching ID
            for (const location in scheduleData.schedule_data) {
                for (const date in scheduleData.schedule_data[location]) {
                    const schedule = scheduleData.schedule_data[location][date].find(s => s.id == scheduleId);
                    if (schedule) return schedule;
                }
            }
            return null;
        }

        // Helper function to calculate time difference in hours
        function calculateTimeDifference(startTime, endTime) {
            if (!startTime || !endTime) return 0;
            
            // Parse time strings (format: "HH:MM:SS")
            const [startHours, startMinutes, startSeconds] = startTime.split(':').map(Number);
            const [endHours, endMinutes, endSeconds] = endTime.split(':').map(Number);
            
            // Create date objects with the same date but different times
            const startDate = new Date();
            startDate.setHours(startHours, startMinutes, startSeconds, 0);
            
            const endDate = new Date();
            endDate.setHours(endHours, endMinutes, endSeconds, 0);
            
            // Handle overnight shifts (end time is next day)
            if (endDate < startDate) {
                endDate.setDate(endDate.getDate() + 1);
            }
            
            // Calculate difference in hours
            const diffMs = endDate - startDate;
            const diffHours = diffMs / (1000 * 60 * 60);
            
            return diffHours;
        }

        // Helper function to format time for display (convert "08:00:00" to "8:00 AM")
        function formatTimeForDisplay(timeString) {
            if (!timeString) return 'N/A';
            
            const [hours, minutes] = timeString.split(':').map(Number);
            const period = hours >= 12 ? 'PM' : 'AM';
            const displayHours = hours % 12 || 12; // Convert 0, 13, 14, etc. to 12, 1, 2, etc.
            const displayMinutes = minutes.toString().padStart(2, '0');
            
            return `${displayHours}:${displayMinutes} ${period}`;
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
