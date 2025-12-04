<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Schedule Report Generator - BetterChoiceGroupHomes | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="/public/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="public/css/print.css">
    <style>
        body {
            background-color: #f5f6fa;
            font-family: 'Nunito Sans', sans-serif;
            font-weight: 400;
            color: #333;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
        }
        .table thead {
            background-color: #f0f2f5;
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
            display: none;
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

        .is-invalid {
            border-color: red !important;
        }

        .report-header {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .result-card {
            border-left: 4px solid #0d6efd;
            transition: all 0.3s ease;
        }
        .result-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .export-btn-group .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .total-hours {
            font-size: 1.2rem;
            font-weight: bold;
            color: #0d6efd;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
                margin: 0;
            }
            .container {
                max-width: 100%;
                padding: 0;
            }
            table {
                font-size: 11px !important;
            }
        }
        
        .staff-header {
            border-left: 4px solid #0d6efd;
        }

        .staff-summary {
            background-color: #f8f9fa !important;
        }

        .spacer-row td {
            border: none !important;
            background-color: transparent !important;
        }

        .staff-schedule td:first-child {
            border-left: 2px solid #dee2e6;
        }

        .staff-schedule:last-child td {
            border-bottom: 1px solid #dee2e6;
        }
        
        /* Efficiency color coding */
        .efficiency-high { color: #28a745 !important; }
        .efficiency-medium { color: #ffc107 !important; }
        .efficiency-low { color: #dc3545 !important; }
        
        /* Print styles */
        @media print {
            .staff-section {
                page-break-inside: avoid;
                margin-bottom: 20px;
            }
            .staff-name {
                background-color: #f8f9fa !important;
                color: #000 !important;
                border: 1px solid #dee2e6 !important;
            }
        }
        
        /* Additional styling for new columns */
        .hours-cell {
            min-width: 120px;
        }
        .efficiency-badge {
            font-size: 0.75rem;
            padding: 0.15rem 0.5rem;
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
                    <h3 class="mb-4"><i class="bi bi-file-earmark-bar-graph"></i> Schedule Report Generator</h3>
                    
                    <div class="card p-4 mb-3 shadow">
                        <form id="reportForm" class="row g-3">
                            <!-- Location -->
                            <div class="col-md-4">
                                <label class="form-label">Location</label>
                                <select class="form-control border-0 shadow" name="location" id="location">
                                    <option value="">--------- Select location --------</option>
                                    <?php foreach($data['all_location'] as $location){ ?>
                                        <option value="<?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?>">
                                            <?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Date Range -->
                            <div class="col-md-4">
                                <label for="dateRange" class="form-label">Date Range</label>
                                <div class="input-group input-group-joined border-0 shadow">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </span>
                                    <input class="form-control ps-0 pointer" name="daterange" id="litepickerDateRange2" placeholder="Select date range...">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-4">
                                <label class="form-label">Email (optional)</label>
                                <input type="email" class="form-control border-0 shadow" name="email" placeholder="someone@example.com">
                            </div>

                            <!-- Buttons -->
                            <div class="w-100 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary w-100" id="generateReport" disabled>
                                    <i class="bi bi-play-fill"></i> Generate Report
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Report Results Section -->
                    <div id="reportResults" class="d-none">
                        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
                            <h4><i class="bi bi-list-check"></i> Report Results</h4>
                            <div class="export-btn-group">
                                <button id="printAll" onclick="printAllRecords()" class="btn btn-outline-dark">
                                    <i class="bi bi-printer"></i> Print All Records
                                </button>
                            </div>
                        </div>

                        <!-- Summary Stats -->
                        <div class="row mb-4" id="summaryStats">
                            <div class="col-md-3">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Total Records</h6>
                                        <h3 class="card-title" id="totalRecords">0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Worked Hours</h6>
                                        <h3 class="card-title total-hours" id="totalHoursWorked">0h 0m</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Scheduled Hours</h6>
                                        <h3 class="card-title text-info" id="totalHoursScheduled">0h 0m</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Efficiency</h6>
                                        <h3 class="card-title" id="totalEfficiency">N/A</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Results Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="resultsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap">#</th>
                                        <th class="text-nowrap">Staff Name</th>
                                        <th class="text-nowrap">Location</th>
                                        <th class="text-nowrap">Schedule Date</th>
                                        <th class="text-nowrap">Scheduled Time</th>
                                        <th class="text-nowrap">Shift Type</th>
                                        <th class="text-nowrap">Pay Rate/hr</th>
                                        <th class="text-nowrap">Actual Time</th>
                                        <th class="text-nowrap hours-cell">Hours (Worked/Scheduled)</th>
                                        <th class="text-nowrap">Efficiency</th>
                                        <th class="text-nowrap">Pay</th>
                                        <th class="text-nowrap">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="resultsBody">
                                    <!-- Will be populated via AJAX -->
                                </tbody>
                                <tfoot id="resultsFooter" class="fw-bold table-light">
                                    <!-- Will be populated via AJAX -->
                                </tfoot>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation" class="mt-4 no-print">
                            <ul class="pagination justify-content-center" id="pagination">
                                <!-- Will be populated via AJAX -->
                            </ul>
                        </nav>
                    </div>

                    <!-- No Results Message -->
                    <div id="noResults" class="text-center py-5 d-none">
                        <div class="mb-3">
                            <i class="bi bi-exclamation-circle text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="text-muted">No records found</h4>
                        <p class="text-muted">Try adjusting your filter criteria</p>
                        <button class="btn btn-primary mt-3 no-print" id="resetFilters">
                            <i class="bi bi-funnel"></i> Reset Filters
                        </button>
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
        // Initialize Litepicker for date range
        $(document).ready(function() {
            // Enable/disable generate button based on form inputs
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('reportForm');
                const button = document.getElementById('generateReport');

                function checkInputs() {
                    let hasValue = false;
                    form.querySelectorAll('input, select').forEach(el => {
                        if (el.value.trim() !== '') {
                            hasValue = true;
                        }
                    });
                    button.disabled = !hasValue;
                }

                form.addEventListener('input', checkInputs);
                form.addEventListener('change', checkInputs);
                checkInputs();
            });

            // Handle form submission
            $('#reportForm').on('submit', function(e) {
                e.preventDefault();
                loadReportData(1);
            });

            // Handle reset filters
            $('#resetFilters').on('click', function() {
                $('#reportForm')[0].reset();
                $('#reportResults').addClass('d-none');
                $('#noResults').addClass('d-none');
            });

            // Function to format minutes to hours
            function formatMinutes(minutes) {
                if (!minutes || minutes < 0) return '0h 00m';
                const hours = Math.floor(minutes / 60);
                const mins = minutes % 60;
                return `${hours}h ${mins.toString().padStart(2, '0')}m`;
            }

            // Function to calculate efficiency color
            function getEfficiencyColor(efficiency) {
                if (efficiency >= 90) return 'efficiency-high';
                if (efficiency >= 70) return 'efficiency-medium';
                return 'efficiency-low';
            }

            // Function to load report data
            function loadReportData(page) {
                const spinner = document.querySelector(".loader-container");
                const loadingText = document.querySelector(".loading-text");
                
                spinner.style.display = 'flex';
                loadingText.textContent = "Please wait, processing...";
                
                const email = $('form#reportForm input[name="email"]').val();
                const location = $('form#reportForm select[name="location"]').val();
                const dateRange = $('form#reportForm input[name="daterange"]').val();
                
                $.ajax({
                    url: 'generate_report_result',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        email: email,
                        location: location,
                        daterange: dateRange,
                        page: page,
                        perPage: 10
                    },
                    success: function(response) {
                        console.log('API Response:', response);
                        spinner.style.display = "none";
                        loadingText.textContent = "Loading...";
                        
                        if (response.success && response.data && response.data.length > 0) {
                            // Update summary info
                            $('#totalRecords').text(response.pagination.totalRecords);
                            $('#totalHoursWorked').text(response.summary.totalHoursWorked || '0h 00m');
                            $('#totalHoursScheduled').text(response.summary.totalHoursScheduled || '0h 00m');
                            
                            // Calculate and display efficiency
                            if (response.summary.efficiencyPercentage) {
                                const efficiency = parseFloat(response.summary.efficiencyPercentage);
                                $('#totalEfficiency').text(response.summary.efficiencyPercentage);
                                $('#totalEfficiency').addClass(getEfficiencyColor(efficiency));
                            }
                            
                            // Display date range
                            if (dateRange) {
                                $('#displayDateRange').text(dateRange);
                            }
                            
                            // Populate table
                            const $tbody = $('#resultsBody');
                            const $tfooter = $('#resultsFooter');
                            $tbody.empty();
                            $tfooter.empty();
                            
                            let rowNum = ((page - 1) * 10) + 1;
                            let grandTotalWorked = 0;
                            let grandTotalScheduled = 0;
                            let grandTotalPay = 0;
                            
                            response.data.forEach(function(staff) {
                                // Staff header row
                                $tbody.append(`
                                    <tr class="staff-header bg-light">
                                        <td colspan="12" class="p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0 text-primary">
                                                    <i class="bi bi-person-circle me-2"></i>
                                                    ${staff.name}
                                                    <small class="text-muted ms-2">(${staff.email})</small>
                                                </h5>
                                                <div class="text-end">
                                                    <small class="text-muted">Scheduled: ${staff.total_hours_scheduled || '0h 00m'}</small><br>
                                                    <small class="text-muted">Worked: ${staff.total_hours_worked || '0h 00m'}</small>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                `);
                                
                                // Staff schedules
                                staff.schedules.forEach(function(schedule) {
                                    const statusClass = schedule.status === 'Completed' ? 'bg-success' : 
                                                        schedule.status === 'In Progress' ? 'bg-warning' : 'bg-secondary';
                                    const overnight_type = schedule.shift_type === 'overnight' ? `(${schedule.overnight_type || 'N/A'})` : '';
                                    
                                    // Calculate efficiency for this shift
                                    let efficiencyHtml = 'N/A';
                                    let efficiencyClass = '';
                                    if (schedule.minutes_scheduled > 0 && schedule.minutes_worked > 0) {
                                        const efficiencyPercent = (schedule.minutes_worked / schedule.minutes_scheduled * 100).toFixed(1);
                                        efficiencyClass = getEfficiencyColor(efficiencyPercent);
                                        efficiencyHtml = `<span class="${efficiencyClass} fw-bold">${efficiencyPercent}%</span>`;
                                    }
                                    
                                    $tbody.append(`
                                        <tr class="staff-schedule">
                                            <td>${rowNum++}</td>
                                            <td></td>
                                            <td>${schedule.location || 'N/A'}</td>
                                            <td>${schedule.schedule_date || 'N/A'}</td>
                                            <td>${schedule.scheduled_time || 'N/A'}</td>
                                            <td>${schedule.shift_type || 'N/A'} ${overnight_type}</td>
                                            <td>CAD ${parseFloat(schedule.pay_per_hour || 0).toFixed(2)}</td>
                                            <td>${schedule.actual_time || 'N/A - N/A'}</td>
                                            <td class="hours-cell">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">Worked: ${schedule.hours_worked || '0h 00m'}</span>
                                                    <small class="text-muted">Scheduled: ${schedule.hours_scheduled || schedule.hours_worked || '0h 00m'}</small>
                                                </div>
                                            </td>
                                            <td>${efficiencyHtml}</td>
                                            <td>CAD ${schedule.pay || '0.00'}</td>
                                            <td><span class="badge ${statusClass}">${schedule.status || 'Pending'}</span></td>
                                        </tr>
                                    `);
                                });
                                
                                // Staff summary row
                                const staffEfficiency = staff.total_minutes_scheduled > 0 ? 
                                    ((staff.total_minutes_worked / staff.total_minutes_scheduled) * 100).toFixed(1) : 0;
                                const staffEfficiencyClass = getEfficiencyColor(staffEfficiency);
                                
                                $tbody.append(`
                                    <tr class="staff-summary bg-light fw-bold">
                                        <td colspan="8" class="text-end">
                                            <div class="d-flex flex-column align-items-end">
                                                <span>Total for ${staff.name}:</span>
                                                ${staffEfficiency > 0 ? 
                                                    `<small class="text-muted fw-normal">Efficiency: <span class="${staffEfficiencyClass}">${staffEfficiency}%</span></small>` : 
                                                    ''}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span>Scheduled: ${staff.total_hours_scheduled || '0h 00m'}</span>
                                                <span>Worked: ${staff.total_hours_worked || '0h 00m'}</span>
                                            </div>
                                        </td>
                                        <td>
                                            ${staffEfficiency > 0 ? `<span class="${staffEfficiencyClass}">${staffEfficiency}%</span>` : 'N/A'}
                                        </td>
                                        <td>CAD ${staff.total_pay || '0.00'}</td>
                                        <td></td>
                                    </tr>
                                    <tr class="spacer-row">
                                        <td colspan="12" style="height: 20px; background-color: transparent;"></td>
                                    </tr>
                                `);
                                
                                // Update grand totals
                                grandTotalWorked += staff.total_minutes_worked || 0;
                                grandTotalScheduled += staff.total_minutes_scheduled || 0;
                                grandTotalPay += parseFloat(staff.total_pay) || 0;
                            });

                            // Calculate grand total efficiency
                            const grandTotalEfficiency = grandTotalScheduled > 0 ? 
                                ((grandTotalWorked / grandTotalScheduled) * 100).toFixed(1) : 0;
                            const grandEfficiencyClass = getEfficiencyColor(grandTotalEfficiency);
                            
                            // Add grand total footer
                            $tfooter.append(`
                                <tr>
                                    <td colspan="8" class="text-end">
                                        <div class="d-flex flex-column align-items-end">
                                            <strong>GRAND TOTAL:</strong>
                                            ${grandTotalEfficiency > 0 ? 
                                                `<small class="text-muted fw-normal">Efficiency: <span class="${grandEfficiencyClass}">${grandTotalEfficiency}%</span></small>` : 
                                                ''}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>Scheduled: ${formatMinutes(grandTotalScheduled)}</strong>
                                            <strong>Worked: ${formatMinutes(grandTotalWorked)}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        ${grandTotalEfficiency > 0 ? `<strong class="${grandEfficiencyClass}">${grandTotalEfficiency}%</strong>` : 'N/A'}
                                    </td>
                                    <td><strong>CAD ${grandTotalPay.toFixed(2)}</strong></td>
                                    <td></td>
                                </tr>
                            `);

                            // Update pagination
                            updatePagination(response.pagination, page);
                            
                            // Show results
                            $('#reportResults').removeClass('d-none');
                            $('#noResults').addClass('d-none');
                        } else {
                            // No results
                            $('#reportResults').addClass('d-none');
                            $('#noResults').removeClass('d-none');
                        }
                    },
                    error: function(xhr, status, error) {
                        spinner.style.display = "none";
                        loadingText.textContent = "Loading...";
                        console.error('AJAX Error:', error);
                        iziToast.error({
                            title: 'Error',
                            message: 'An error occurred while loading the report data.',
                            position: 'topRight'
                        });
                    }
                });
            }
            
            // Function to update pagination controls
            function updatePagination(pagination, currentPage) {
                const $pagination = $('#pagination');
                $pagination.empty();
                
                const totalPages = pagination.totalPages;
                
                // Previous button
                const prevDisabled = currentPage <= 1 ? 'disabled' : '';
                $pagination.append(`
                    <li class="page-item ${prevDisabled}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
                    </li>
                `);
                
                // Page numbers
                const maxVisiblePages = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
                
                if (endPage - startPage + 1 < maxVisiblePages) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }
                
                if (startPage > 1) {
                    $pagination.append(`
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="1">1</a>
                        </li>
                        ${startPage > 2 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                    `);
                }
                
                for (let i = startPage; i <= endPage; i++) {
                    const active = i === currentPage ? 'active' : '';
                    $pagination.append(`
                        <li class="page-item ${active}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }
                
                if (endPage < totalPages) {
                    $pagination.append(`
                        ${endPage < totalPages - 1 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                        </li>
                    `);
                }
                
                // Next button
                const nextDisabled = currentPage >= totalPages ? 'disabled' : '';
                $pagination.append(`
                    <li class="page-item ${nextDisabled}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                    </li>
                `);
                
                // Add click handlers
                $pagination.on('click', 'a.page-link', function(e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    loadReportData(page);
                });
            }
        });

        // Print function
        function printAllRecords() {
            const spinner = document.querySelector(".loader-container");
            const loadingText = document.querySelector(".loading-text");
            
            spinner.style.display = 'flex';
            loadingText.textContent = "Please wait, processing...";
            
            const formData = $('#reportForm').serializeArray();
            const email = $('form#reportForm input[name="email"]').val();
            const location = $('form#reportForm select[name="location"]').val();
            const dateRange = $('form#reportForm input[name="daterange"]').val();
            
            // Build filter title
            let filters = [];
            formData.forEach(input => {
                if (input.value.trim() !== '') {
                    filters.push(`${input.name.charAt(0).toUpperCase() + input.name.slice(1)}: ${input.value}`);
                }
            });
            let filterTitle = filters.length > 0 ? filters.join(', ') : 'All Records';
            
            // Fetch all records without pagination
            $.ajax({
                url: 'generate_report_result',
                method: 'POST',
                dataType: 'json',
                data: {
                    email: email,
                    location: location,
                    daterange: dateRange,
                    print: 'true'
                },
                success: function(response) {
                    spinner.style.display = "none";
                    loadingText.textContent = "Loading...";
                    
                    if (response.success && response.data) {
                        // Create print view
                        const printWindow = window.open('', '_blank');
                        const printContent = `
                            <html>
                                <head>
                                    <title>Schedule Report - ${filterTitle}</title>
                                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                                    <style>
                                        @page { size: auto; margin: 5mm; }
                                        body { padding: 20px; font-family: Arial, sans-serif; }
                                        table { width: 100%; font-size: 11px; border-collapse: collapse; }
                                        th { background-color: #f8f9fa !important; padding: 8px; border: 1px solid #dee2e6; }
                                        td { padding: 6px; border: 1px solid #dee2e6; }
                                        .staff-header { background-color: #e9ecef; }
                                        .text-success { color: #28a745; }
                                        .text-warning { color: #ffc107; }
                                        .text-danger { color: #dc3545; }
                                        .text-center { text-align: center; }
                                        .text-end { text-align: right; }
                                        .fw-bold { font-weight: bold; }
                                        .small { font-size: 10px; }
                                        .mb-3 { margin-bottom: 1rem; }
                                        .mt-4 { margin-top: 1.5rem; }
                                    </style>
                                </head>
                                <body>
                                    <div class="container-fluid">
                                        <h3 class="text-center mb-3">Schedule Report</h3>
                                        <h5 class="text-center mb-4 text-muted">${filterTitle}</h5>
                                        ${generatePrintTable(response.data, response.summary)}
                                        <div class="text-end mt-4 small">
                                            <div>Generated on: ${new Date().toLocaleDateString()}</div>
                                            <div>Generated by: ${response.generated_by || 'System'}</div>
                                            <div>Total Records: ${response.summary?.totalRecords || 0}</div>
                                        </div>
                                    </div>
                                </body>
                            </html>
                        `;
                        
                        printWindow.document.write(printContent);
                        printWindow.document.close();
                        
                        printWindow.onload = function() {
                            setTimeout(() => {
                                printWindow.print();
                                printWindow.close();
                            }, 500);
                        };
                    } else {
                        iziToast.warning({
                            title: 'No Data',
                            message: 'No records found to print',
                            position: 'topRight'
                        });
                    }
                },
                error: function() {
                    spinner.style.display = "none";
                    loadingText.textContent = "Loading...";
                    iziToast.error({
                        title: 'Error',
                        message: 'Failed to load data for printing',
                        position: 'topRight'
                    });
                }
            });
        }

        // Function to generate print table
        function generatePrintTable(data, summary) {
            let tableHtml = '';
            let rowNum = 1;
            let grandTotalWorked = 0;
            let grandTotalScheduled = 0;
            let grandTotalPay = 0;

            tableHtml += `
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Staff Name</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Scheduled Time</th>
                            <th>Shift Type</th>
                            <th>Rate/hr</th>
                            <th>Actual Time</th>
                            <th>Hours</th>
                            <th>Efficiency</th>
                            <th>Pay</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>`;

            data.forEach(staff => {
                // Staff header
                const staffEfficiency = staff.total_minutes_scheduled > 0 ? 
                    ((staff.total_minutes_worked / staff.total_minutes_scheduled) * 100).toFixed(1) : 0;
                
                tableHtml += `
                    <tr class="staff-header">
                        <td colspan="12" class="fw-bold">
                            <i class="bi bi-person-circle"></i> ${staff.name} (${staff.email}) - 
                            Scheduled: ${staff.total_hours_scheduled || '0h 00m'}, 
                            Worked: ${staff.total_hours_worked || '0h 00m'}, 
                            Efficiency: ${staffEfficiency}%
                        </td>
                    </tr>`;

                // Staff schedules
                staff.schedules.forEach(schedule => {
                    const statusClass = schedule.status === 'Completed' ? 'text-success' : 
                                      schedule.status === 'In Progress' ? 'text-warning' : 'text-muted';
                    const overnight_type = schedule.shift_type === 'overnight' ? `(${schedule.overnight_type || 'N/A'})` : '';
                    
                    // Calculate efficiency
                    let efficiency = 'N/A';
                    if (schedule.minutes_scheduled > 0 && schedule.minutes_worked > 0) {
                        const efficiencyPercent = (schedule.minutes_worked / schedule.minutes_scheduled * 100).toFixed(1);
                        efficiency = `${efficiencyPercent}%`;
                    }
                    
                    tableHtml += `
                        <tr>
                            <td>${rowNum++}</td>
                            <td></td>
                            <td>${schedule.location || 'N/A'}</td>
                            <td>${schedule.schedule_date || 'N/A'}</td>
                            <td>${schedule.scheduled_time || 'N/A'}</td>
                            <td>${schedule.shift_type || 'N/A'} ${overnight_type}</td>
                            <td>CAD ${parseFloat(schedule.pay_per_hour || 0).toFixed(2)}</td>
                            <td>${schedule.actual_time || 'N/A'}</td>
                            <td>
                                Worked: ${schedule.hours_worked || '0h 00m'}<br>
                                <small>Scheduled: ${schedule.hours_scheduled || schedule.hours_worked || '0h 00m'}</small>
                            </td>
                            <td>${efficiency}</td>
                            <td>CAD ${schedule.pay || '0.00'}</td>
                            <td class="${statusClass}">${schedule.status || 'Pending'}</td>
                        </tr>`;
                });
                
                // Update grand totals
                grandTotalWorked += staff.total_minutes_worked || 0;
                grandTotalScheduled += staff.total_minutes_scheduled || 0;
                grandTotalPay += parseFloat(staff.total_pay) || 0;
                
                // Add spacer
                tableHtml += `<tr><td colspan="12" style="height: 10px;"></td></tr>`;
            });

            tableHtml += `</tbody>`;
            
            // Calculate grand totals
            const formatMinutes = (minutes) => {
                const hours = Math.floor(minutes / 60);
                const mins = minutes % 60;
                return `${hours}h ${mins.toString().padStart(2, '0')}m`;
            };
            
            const grandTotalEfficiency = grandTotalScheduled > 0 ? 
                ((grandTotalWorked / grandTotalScheduled) * 100).toFixed(1) : 0;
            
            // Add footer
            tableHtml += `
                <tfoot style="background-color: #f8f9fa;">
                    <tr>
                        <td colspan="8" class="text-end fw-bold">GRAND TOTAL</td>
                        <td class="fw-bold">
                            Scheduled: ${formatMinutes(grandTotalScheduled)}<br>
                            Worked: ${formatMinutes(grandTotalWorked)}
                        </td>
                        <td class="fw-bold">${grandTotalEfficiency}%</td>
                        <td class="fw-bold">CAD ${grandTotalPay.toFixed(2)}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>`;

            return tableHtml;
        }
    </script>
</body>
</html>