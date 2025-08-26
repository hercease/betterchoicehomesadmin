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
                        <h3 class="mb-4"><i class="bi bi-file-earmark-bar-graph"></i> Schedule Report Generator</h3>
                       

                       
                        <div class="card p-4 mb-3 shadow">
                        <form id="reportForm" class="row g-3">
                                <!-- Location -->
                                <div class="col-md-4">
                                    <label class="form-label">Location</label>
                                    <select class="form-control border-0 shadow" name="location" id="location">
                                        <option value="">--------- Select location --------</option>
                                        <?php foreach($data['all_location'] as $location){ ?>
                                            <option value="<?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?>"><?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- Date To -->
                                <div class="col-md-4">
                                    <label for="dateRange" class="form-label">Date Range</label>
                                    <div class="input-group input-group-joined border-0 shadow">
                                        <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
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
                        <!-- Filters Card -->
                        
                    <!-- Report Preview -->

                    <div id="reportResults" class="d-none">
                        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
                            <h4><i class="bi bi-list-check"></i> Report Results</h4>
                            <div class="export-btn-group">
                                <!--<button class="btn btn-outline-success" id="exportExcel">
                                    <i class="bi bi-file-earmark-excel"></i> Excel
                                </button>
                                <button class="btn btn-outline-danger" id="exportPDF">
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                </button>
                                <button class="btn btn-outline-info" id="exportCSV">
                                    <i class="bi bi-file-earmark-text"></i> CSV
                                </button>-->
                                <button id="printAll" onclick="printAllRecords()" class="btn btn-outline-dark">
                                    <i class="bi bi-printer"></i> Print All Records
                                </button>
                            </div>
                        </div>

                        <!-- Summary Stats -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Total Records</h6>
                                        <h3 class="card-title" id="totalRecords">0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Total Hours</h6>
                                        <h3 class="card-title total-hours" id="totalHours">0h 0m</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Date Range</h6>
                                        <h3 class="card-title" id="displayDateRange">-</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Results Table -->
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
                                        <th class="text-nowrap">Hours Worked</th>
                                        <th class="text-nowrap">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="resultsBody">
                                    <!-- Will be populated via AJAX -->
                                </tbody>
                                <tfoot id="resultsFooter" class="fw-bold table-light">
                                    
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
        <!-- For Excel export -->
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="/public/js/litepicker.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
        <script src="print/js/print.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('reportForm');
                const button = document.getElementById('generateReport');

                function checkInputs() {
                    let hasValue = false;

                    // Check all inputs/selects in the form
                    form.querySelectorAll('input, select').forEach(el => {
                        if (el.type === 'checkbox' || el.type === 'radio') {
                            if (el.checked) hasValue = true;
                        } else if (el.value.trim() !== '') {
                            hasValue = true;
                        }
                    });

                    // Enable or disable the button
                    button.disabled = !hasValue;
                }

                // Run check on every change
                form.addEventListener('input', checkInputs);
                form.addEventListener('change', checkInputs);

                // Run check initially
                checkInputs();
            });
            $(document).ready(function() {
            // Load locations dropdown
                $.ajax({
                    url: 'api/get_locations.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            const $locationDropdown = $('#location');
                            response.data.forEach(function(location) {
                                $locationDropdown.append(`<option value="${location}">${location}</option>`);
                            });
                        }
                    }
                });

                // Handle form submission
                $('#reportForm').on('submit', function(e) {
                    e.preventDefault();
                    loadReportData(1); // Always load first page when submitting new filters
                });

                // Handle reset filters
                $('#resetFilters').on('click', function() {
                    $('#reportForm')[0].reset();
                    $('#reportResults').addClass('d-none');
                    $('#noResults').addClass('d-none');
                });

                // Handle print
                $('#printReport').on('click', function() {
                    window.print();
                });

                var spinner = document.querySelector(".loader-container");
                var loadingText = document.querySelector(".loading-text");

                // Function to load report data
                function loadReportData(page) {
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
                            console.log(response);
                            spinner.style.display = "none";
                            loadingText.textContent = "Loading...";
                            
                            if (response.success && response.data.length > 0) {
                                // Update summary info
                                $('#totalRecords').text(response.pagination.totalRecords);
                                $('#totalHours').text(response.summary.totalHours);
                                
                                // Format date range for display
                                //const startDateDisplay = startDate ? new Date(startDate).toLocaleDateString() : 'Start';
                                //const endDateDisplay = endDate ? new Date(endDate).toLocaleDateString() : 'End';
                                //$('#displayDateRange').text(`${startDateDisplay} to ${endDateDisplay}`);
                                
                                // Populate table
                                const $tbody = $('#resultsBody');
                                $tbody.empty();
                                const $tfooter = $('#resultsFooter');
                                $tfooter.empty();
                                
                                response.data.forEach(function(schedule, index) {
                                    const rowNum = ((page - 1) * 10) + index + 1;
                                    const statusClass = schedule.status === 'Completed' ? 'bg-success' : 
                                                    schedule.status === 'In Progress' ? 'bg-warning' : 'bg-secondary';
                                    const overnight_type = schedule.shift_type==='overnight' ? `(${schedule.overnight_type})` : '';
                                    
                                    $tbody.append(`
                                        <tr>
                                            <td>${rowNum}</td>
                                            <td>${schedule.name}</td>
                                            <td>${schedule.location}</td>
                                            <td>${schedule.schedule_date}</td>
                                            <td>${schedule.scheduled_time}</td>
                                            <td>${schedule.shift_type + overnight_type}</td>
                                            <td>CAD${schedule.pay_per_hour}</td>
                                            <td>${schedule.actual_time}</td>
                                            <td>CAD${schedule.pay}</td>
                                            <td><span class="badge ${statusClass}">${schedule.status}</span></td>
                                        </tr>
                                    `);
                                });

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
                            console.error(error);
                            alert('An error occurred while loading the report data.');
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
                
                // Export functions (simplified - would need proper implementation)
                $('#exportExcel').on('click', function() {
                    alert('Excel export would be implemented here');
                    // In a real implementation, you would:
                    // 1. Collect all data (not just current page) from the server
                    // 2. Use SheetJS to create and download the Excel file
                });
                
                $('#exportPDF').on('click', function() {
                    alert('PDF export would be implemented here');
                    // In a real implementation, you would:
                    // 1. Collect all data (not just current page) from the server
                    // 2. Use jsPDF to create and download the PDF
                });
                
                $('#exportCSV').on('click', function() {
                    alert('CSV export would be implemented here');
                    // In a real implementation, you would:
                    // 1. Collect all data (not just current page) from the server
                    // 2. Convert to CSV and download
                });
            });

            var spinner = document.querySelector(".loader-container");
            var loadingText = document.querySelector(".loading-text");

            function printAllRecords() {
                // Show loading indicator
                spinner.style.display = 'flex';
                loadingText.textContent = "Please wait, processing...";
                let form = $('#reportForm').serializeArray();
                //console.log(form);

                // Build the title based on filter inputs
                let filters = [];
                form.forEach(input => {
                    if (input.value.trim() !== '') {
                        filters.push(`${input.name.charAt(0).toUpperCase() + input.name.slice(1)}: ${input.value}`);
                    }
                });
                let filterTitle = filters.length > 0 ? `${filters.join(', ')}` : 'All Records';

                const email = $('form#reportForm input[name="email"]').val();
                const location = $('form#reportForm select[name="location"]').val();
                const dateRange = $('form#reportForm input[name="daterange"]').val();
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
                        if (response.success) {
                            // Create print view
                            const printWindow = window.open('', '_blank');
                            const printContent = `
                                <html>
                                    <head>
                                        <title>Schedule Report for ${filterTitle} </title>
                                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                                        <style>
                                            @page { size: auto; margin: 5mm; }
                                            body { padding: 20px; }
                                            table { width: 100%; font-size: 12px; }
                                            th { background-color: #f8f9fa !important; }
                                        </style>
                                    </head>
                                    <body>
                                        <h3 class="text-center mb-4">Schedule Report for ${filterTitle}</h3>
                                        ${generatePrintTable(response.data)}
                                        <div class="text-end mt-4">
                                            <small>Generated on : ${new Date().toLocaleDateString()}</small><br>
                                            <small>Generated by : ${response.generated_by}</small><br>
                                            <small>Total Records: ${response['summary'].totalRecords}</small>
                                        </div>
                                    </body>
                                </html>
                            `;
                            
                            printWindow.document.write(printContent);
                            printWindow.document.close();
                            
                            // Print after content loads
                            printWindow.onload = function() {
                                setTimeout(() => {
                                    printWindow.print();
                                    printWindow.close();
                                }, 500);
                            };
                        }
                    },
                    complete: function() {
                        spinner.style.display = "none";
                        loadingText.textContent = "Loading...";
                    }
                });
            }

            function generatePrintTable(data) {

                let tableHtml = `
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Employee Email</th>
                                <th>Location</th>
                                <th>Schedule Date</th>
                                <th>Scheduled Time</th>
                                <th>Shift Type</th>
                                <th>Pay Rate/hr</th>
                                <th>Actual Time</th>
                                <th>Hours Worked</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    <tbody>`;

                    let rowNum = 1; // Initialize counter
                
                data.forEach(item => {
                    
                    tableHtml += `
                        <tr>
                            <td>${rowNum++}</td>
                            <td>${item.name}</td>
                            <td>${item.location}</td>
                            <td>${item.schedule_date}</td>
                            <td>${item.scheduled_time}</td>
                            <td>${item.shift_type}${item.shift_type === 'overnight' ? ' (' + item.overnight_type + ')' : ''}</td>
                            <td>CAD ${item.pay_per_hour}</td>
                            <td>${item.actual_time}</td>
                            <td>CAD ${item.pay}</td>
                            <td><span class="badge ${getStatusClass(item.status)}">${item.status}</span></td>
                        </tr>`;
                });

                tableHtml += `</tbody`;
                tableHtml += `<tfooter><tr><td colspan="8" class="text-end">TOTAL</td><td>CAD ${data.reduce((total, item) => total + parseFloat(item.pay), 0)}</td></tr></tfooter>`;
                
                tableHtml += `</table>`;
                return tableHtml;
            }

            function getStatusClass(status) {
                const classes = {
                    'Completed': 'bg-success',
                    'In Progress': 'bg-warning',
                    'Pending': 'bg-secondary'
                };
                return classes[status] || 'bg-secondary';
            }

        </script>
</body>
</html>
