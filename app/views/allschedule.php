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
        <style>
            :root {
            --brand:#0b184d;
            --brand-2:#5b8cff;
            --muted:#6c757d;
            --surface:#f5f6fa;
            --card:#ffffff;
            --success:#4caf50;
            --danger:#f44336;
            --info:#2196f3;
            }

            body{ background: var(--surface); }

            .app-header {
            background: linear-gradient(120deg, var(--brand), var(--brand-2));
            color: #fff;
            border-bottom-left-radius: 1.25rem;
            border-bottom-right-radius: 1.25rem;
            padding: 1.25rem 1rem 2rem;
            position: sticky; top:0; z-index: 10;
            box-shadow: 0 6px 16px rgba(0,0,0,.15);
            }
            .app-header h1 { font-size: 1.4rem; margin: 0; }
            .toolbar .form-control, .toolbar .form-select{ border-radius: 0.75rem; }
            .calendar {
            background: var(--card);
            border-radius: 1rem;
            box-shadow: 0 6px 16px rgba(0,0,0,.06);
            overflow: hidden;
            margin: auto;
            font-size: 12px; 
            }
            .calendar-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: .75rem 1rem; background:#fff; border-bottom: 1px solid #eef0f4;
            }
            .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0; background:#fff;
            }
            .calendar-weekday, .calendar-cell {
            padding-top: .75rem; text-align: center; border-right: 1px solid #f0f2f6;
            border-bottom: 1px solid #f0f2f6; min-height: 50px; cursor: pointer;
            }
            .calendar-weekday { font-weight: 600; color: var(--muted); background:#f8f9fb; }
            .calendar-cell.disabled { background: #fafbfc; color: #c0c6d1; }
            .calendar-cell .date {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 50%;
            font-weight: 600;
            }
            .calendar-cell.has-events .date { box-shadow: inset 0 0 0 2px var(--brand-2); }
            .calendar-cell.selected .date { background: var(--brand-2); color: #fff; }
            .dot {
            width: 8px; height: 8px; border-radius: 50%; margin: 6px auto 0;
            background: var(--success);
            }
            .badge-count {
            display: inline-block; font-size: .75rem; padding:.15rem .5rem; border-radius: 999px; background: #eef4ff; color: var(--brand);
            margin-top: .35rem;
            }

            .results-wrap { margin-top: 1rem; }
         
            .chip {
            display:inline-flex; align-items:center; gap:.35rem;
            background:#f0f4ff; color:var(--brand);
            font-size:.8rem; padding:.25rem .6rem; border-radius:999px;
            }
            .metric {
            display:flex; gap:.5rem; align-items:center; color:#263238;
            }
            .metric i { color:#9aa7b2; }
            .empty {
            color: var(--muted); text-align:center; padding: 2rem 0;
            }
            @media (max-width: 576px) { /* Small devices */
                .card-custom-padding {
                padding: 6px 0px 0px 11px !important;
                }
            }

             body {
                font-family: 'Nunito Sans', sans-serif;
                font-weight: 400;
                color: #333;
                background: #f7f9fc;
            }

                .schedule-card { transition: transform .12s ease; }
                .schedule-card:hover { transform: translateY(-4px); }
                .tiny { font-size: .78rem; }
                .duration-pill { min-width: 72px; }
                .muted { color: #6c757d; }
                .sidebar { max-width: 360px; }
                .map-placeholder { background: linear-gradient(90deg,#e9eef8,#f7fbff); border-radius: .5rem; min-height:110px; display:flex;align-items:center;justify-content:center;color:#6b7280 }

            /* Loader */
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
                    <!-- Main page content-->
                    <div class="container-xl mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold"><i class="fas fa-users"></i> Schedules</h4>
                             <div class="text-end small opacity-75" id="currentMonthLabel"></div>
                        </div>
                      <div class="row">
                        <!-- Filters -->
                          <aside class="col-lg-3 sidebar">
                              <div class="card mb-3">
                                <div class="card-body">
                                  <h6 class="mb-3">Search & Filters</h6>

                                  <div class="mb-2">
                                    <label class="form-label tiny mb-1">Search</label>
                                    <input id="searchName" name="searchName" class="form-control form-control-sm border-0 shadow" placeholder="Search by name…">
                                  </div>

                                    <div class="mb-3">
                                        <label class="form-label tiny mb-1">Date</label>
                                        <input id="fromDate" name="fromDate" type="date" class="form-control form-control-sm border-0 shadow">
                                    </div>

                                  <div class="mb-2">
                                    <label class="form-label tiny mb-1">Location</label>
                                    <select class="form-select form-select-sm border-0 shadow" name="searchLocation" id="searchLocation">
                                        <option value="">--------- Select location --------</option>
                                        <?php foreach($data['all_location'] as $location){ ?>
                                            <option value="<?php echo $location['id'] ?>"><?php echo $location['address'].', '.$location['city'].', '.$location['province'] ?></option>
                                        <?php } ?>
                                    </select>
                                  </div>

                                  <div class="mb-2">
                                    <label class="form-label tiny mb-1">Status</label>
                                    <select id="status" name="status" class="form-select form-select-sm border-0 shadow">
                                      <option value="">Any</option>
                                      <option value="scheduled">Scheduled</option>
                                      <option value="in-progress">In progress</option>
                                      <option value="completed">Completed</option>
                                    </select>
                                  </div>

                                  <div class="d-grid mt-2">
                                    <button id="btnSearch" class="btn btn-light btn-sm border"><i class="bi bi-search me-1"></i>Search</button>
                                    <button id="btnReset" class="btn btn-sm btn-link text-decoration-none mt-1">Clear</button>
                                  </div>
                                </div>
                              </div>

                            </aside>

                        <!-- Results -->
                        <div class="col-md-9">
                            <div class="calendar mb-3">
                                <div class="calendar-header">
                                        <div class="btn-group">
                                            <button id="prevMonth" class="btn btn-sm btn-outline-secondary"><i class="bi bi-chevron-left"></i></button>
                                            <button id="todayBtn" class="btn btn-sm btn-outline-secondary">Today</button>
                                            <button id="nextMonth" class="btn btn-sm btn-outline-secondary"><i class="bi bi-chevron-right"></i></button>
                                        </div>
                                        <div class="fw-semibold" id="monthTitle">—</div>
                                </div>
                                <div class="calendar-grid" id="calendarWeekdays"></div>
                                <div class="calendar-grid" id="calendarDays"></div>
                            </div>

                            <!-- Results -->
                            <div class="results-wrap">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h5 class="m-0 fw-bold"><i class="bi bi-people me-2"></i>Schedules on <span id="selectedDateLabel">—</span></h5>
                                    <div class="small text-muted"><span id="resultCount">0</span> result(s)</div>
                                </div>
                                <div id="cardsWrap" class="row g-3"></div>
                                <div id="emptyState" class="empty d-none">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No schedules for this date.
                                </div>
                            </div>
                        </div>
                        </div>
                      </div>
                </main>

             <?php include("app/views/includes/footer.php"); ?> 
            </div>
        </div>

        <div class="modal fade" id="modal-default" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="h6 modal-title"><i class="fas fa-pencil"></i> Update Schedule</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateschedule" name="updateschedule">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Start Time</label>
                                <input type="time" name="start_time" class="form-control" placeholder="Enter start time" />
                            </div>
                            <div class="mb-3">
                                <label>End Time</label>
                                <input type="time" name="end_time" class="form-control" placeholder="Enter end time" />
                            </div>
                            <div class="mb-3">
                                <label>Pay Per Hour</label>
                                <input type="number" name="pay_per_hour" class="form-control" placeholder="Enter pay per hour" />
                            </div>
                            <div class="mb-3">
                                <label>Shift Type</label>
                                <select name="shift_type" class="form-select">
                                    <option value="">------- Select Shift Type --------</option>
                                    <option value="day">Day</option>
                                    <option value="evening">Evening</option>
                                    <option value="overnight">Over Night</option>
                                </select>
                            </div>
                            <div class="mb-3 overnight-type d-none">
                                <label>Overnight Type</label>
                                <select name="overnight_type" class="form-select">
                                    <option value="">------- Select Overnight Type --------</option>
                                    <option value="rest">Rest</option>
                                    <option value="awake">Awake</option>
                                </select>
                            </div>

                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="email">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary">Continue</button>
                        </div>
                    </form>
                </div>
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

            $("form[name='updateschedule']").validate({
                    // Specify validation rules
                    // Make sure the form is submitted to the destination defined
                    // in the "action" attribute of the form when valid
                    submitHandler: function(form){
                        
                    var data = $("form[name='updateschedule']").serialize();
                    var spinner = document.querySelector(".loader-container");
                    var loadingText = document.querySelector(".loading-text");
                    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                    data += '&timezone=' + encodeURIComponent(timezone);

                    console.log(data);

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
                                ['<button><b>Yes</b></button>', function (instance, toast){
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                    
                                    // Run your AJAX function here
                                    $.ajax({
                                        type: "POST",
                                        url: "update_schedule",
                                        data: data,
                                        beforeSend: function () {
                                            spinner.style.display = 'flex';
                                            loadingText.textContent = "Please wait, processing...";
                                        },
                                        dataType: 'json',
                                        success: function(data) {

                                        spinner.style.display = "none";
                                        loadingText.textContent = "Loading...";
                                        
                                        console.log(data);
                                        if (data.status===true) {

                                            let selectedDate = fmtDateISO(new Date());
                                            fetchDay(selectedDate);
                                            $('#modal-default').modal('hide');
                                            showToast.success(data.message);
                                        
                                        } else {

                                            showToast.error(data.message);

                                        }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {
                                            loadingText.textContent = "Loading...";
                                            spinner.style.display = 'none';
                                            iziToast.warning({
                                                title: 'Error',
                                                message: 'An error occurred, kindly check your network',
                                            });
                                        }
                                    }); 

                                }, true],
                                ['<button>No</button>', function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                }]
                            ],
                            onClosing: function(instance, toast, closedBy){
                                console.info('Closing | closedBy: ' + closedBy);
                            },
                            onClosed: function(instance, toast, closedBy){
                                console.info('Closed | closedBy: ' + closedBy);
                            }
                        });

                        }
                    });


                    $('select[name="shift_type"]').on('change', function() {
                        var selectedValue = $(this).val();
                        if(selectedValue=='overnight'){
                            document.querySelector(".overnight-type").classList.remove("d-none");
                            document.querySelector('select[name="overnight_type"]').setAttribute("required", "required");
                        } else {
                            document.querySelector(".overnight-type").classList.add("d-none");
                            document.querySelector('select[name="overnight_type"]').removeAttribute("required");
                        }
                    });

                    $('#modal-default').on('show.bs.modal', function (event){
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var id = button.data('id'); // Extract info from data-* attributes
                        var start_time = button.data('start_time'); // Extract info from data-* attributes
                        var end_time = button.data('end_time'); // Extract info from data-* attributes
                        var pay_per_hour = button.data('pay_per_hour'); // Extract info from data-* attributes
                        var shift_type = button.data('shift_type'); // Extract info from data-* attributes
                        var overnight_type = button.data('overnight_type'); // Extract info from data-* attributes
                        var email = button.data('email'); // Extract info from data-* attributes
                      
                        var modal = $(this);

                        if(shift_type=='overnight'){
                            document.querySelector(".overnight-type").classList.remove("d-none");
                            document.querySelector('select[name="overnight_type"]').setAttribute("required", "required");
                            modal.find('.modal-body select[name="overnight_type"]').val(overnight_type);
                        } else {
                            document.querySelector(".overnight-type").classList.add("d-none");
                            document.querySelector('select[name="overnight_type"]').removeAttribute("required");
                        }
                        modal.find('.modal-body input#id').val(id);
                        modal.find('.modal-body input[name="start_time"]').val(start_time);
                        modal.find('.modal-body input[name="end_time"]').val(end_time);
                        modal.find('.modal-body input[name="pay_per_hour"]').val(pay_per_hour);
                        modal.find('.modal-body select[name="shift_type"]').val(shift_type);
                        modal.find('.modal-body input[name="email"]').val(email);

                    });

                    function deleteSchedule(id){

                    var spinner = document.querySelector(".loader-container");
                    var loadingText = document.querySelector(".loading-text");
                    
                    iziToast.question({
                        timeout: false,
                        close: false,
                        overlay: true,
                        displayMode: 'once',
                        id: 'question',
                        zindex: 999,
                        title: 'Delete Schedule',
                        message: 'Are you sure you want to delete this schedule, note that this is an irreversible action?',
                        position: 'center',
                        buttons: [
                            ['<button><b>YES</b></button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                $.ajax({
                                    type: 'POST',
                                    url: 'delete_schedule',
                                    data: { id: id },
                                    beforeSend: function () {
                                        spinner.style.display = 'flex';
                                        loadingText.textContent = "Please wait, processing...";
                                    },
                                    dataType: 'json',
                                    success: function (response) {

                                        spinner.style.display = "none";
                                        loadingText.textContent = "Loading...";

                                        if (response.status == true) {
                                            let selectedDate = fmtDateISO(new Date());
                                            fetchDay(selectedDate);
                                            showToast.success(response.message);
                                        } else {
                                            showToast.error(response.message);
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        loadingText.textContent = "Loading...";
                                        spinner.style.display = 'none';
                                        //showToast.error(errorThrown);
                                        iziToast.warning({
                                            title: 'Error',
                                            message: 'An error occurred, kindly check your network',
                                        });
                                    }
                                });
                            }, true],
                            ['<button>NO</button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            }]
                        ]
                    });
                }

             
                const fmtDateISO = (d) => d.toISOString().slice(0,10); // YYYY-MM-DD
                const pad = (n) => String(n).padStart(2,'0');

                // ------ State
                const weekdaysShort = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
                const calendarWeekdays = document.getElementById('calendarWeekdays');
                const calendarDays     = document.getElementById('calendarDays');
                const monthTitle       = document.getElementById('monthTitle');
                const selectedDateLabel= document.getElementById('selectedDateLabel');
                const cardsWrap        = document.getElementById('cardsWrap');
                const emptyState       = document.getElementById('emptyState');
                const resultCount      = document.getElementById('resultCount');
                const currentMonthLabel= document.getElementById('currentMonthLabel');

                const searchName       = document.getElementById('searchName');
                const searchLocation   = document.getElementById('searchLocation');
                const fromDate         = document.getElementById('fromDate');
                const status           = document.getElementById('status');
                const btnSearch        = document.getElementById('btnSearch');
                const btnReset         = document.getElementById('btnReset');
                const prevMonth        = document.getElementById('prevMonth');
                const nextMonth        = document.getElementById('nextMonth');
                const todayBtn         = document.getElementById('todayBtn');

                let viewYear, viewMonth; // 0-based month
                let selectedDate = fmtDateISO(new Date());
                let marked = {}; // { 'YYYY-MM-DD': {count:n} }

                // ------ Build weekday header
                function renderWeekdays() {
                    calendarWeekdays.innerHTML = '';
                    weekdaysShort.forEach(d => {
                        const el = document.createElement('div');
                        el.className = 'calendar-weekday';
                        el.textContent = d;
                        calendarWeekdays.appendChild(el);
                    });
                }

                // ------ Calendar grid
                function renderCalendar() {
                const monthStart = new Date(viewYear, viewMonth, 1);
                const monthEnd   = new Date(viewYear, viewMonth+1, 0);
                const startDay   = monthStart.getDay(); // 0-6
                const daysInMonth= monthEnd.getDate();

              

                monthTitle.textContent = monthStart.toLocaleString(undefined, { month:'long', year:'numeric' });
                console.log(monthTitle.textContent);
                currentMonthLabel.textContent = 'Viewing ' + monthTitle.textContent;

                calendarDays.innerHTML = '';

                // Leading blanks (prev month)
                const prevMonthEnd = new Date(viewYear, viewMonth, 0).getDate();
                for (let i=0; i<startDay; i++) {
                    const cell = document.createElement('div');
                    cell.className = 'calendar-cell disabled';
                    cell.innerHTML = `<div class="date">${prevMonthEnd - (startDay-1-i)}</div>`;
                    calendarDays.appendChild(cell);
                }

                // This month days
                for (let day=1; day<=daysInMonth; day++) {
                    const iso = `${viewYear}-${pad(viewMonth+1)}-${pad(day)}`;
                    const cell = document.createElement('div');
                    const has = marked[iso];
                    const isSelected = iso === selectedDate;

                    cell.className = 'calendar-cell' + (has ? ' has-events' : '') + (isSelected ? ' selected' : '');
                    cell.dataset.date = iso;

                    cell.innerHTML = `
                    <div class="date">${day}</div>
                    ${has ? `<div class="dot"></div><div class="badge-count">${has.count}</div>` : ''}
                    `;

                    cell.addEventListener('click', () => {
                        selectedDate = iso;
                        fromDate.value = selectedDate;
                        document.querySelectorAll('.calendar-cell.selected').forEach(c => c.classList.remove('selected'));
                        cell.classList.add('selected');
                        selectedDateLabel.textContent = new Date(iso).toLocaleDateString();
                        fromDate.value = selectedDate;
                        fetchDay(iso);
                    });

                    calendarDays.appendChild(cell);
                }

                // Trailing blanks
                const totalCells = startDay + daysInMonth;
                const trailing = (7 - (totalCells % 7)) % 7;
                for (let i=1; i<=trailing; i++) {
                    const cell = document.createElement('div');
                    cell.className = 'calendar-cell disabled';
                    cell.innerHTML = `<div class="date">${i}</div>`;
                    calendarDays.appendChild(cell);
                }
                }

                // ------ Fetchers
                async function fetchMonth(year, month) {
                // month format: YYYY-MM
                const ym = `${year}-${pad(month+1)}`;
                const params = new URLSearchParams();
                params.append('action','month');
                params.append('month', ym);

                const res = await fetch('schedule_testing', {
                    method:'POST',
                    headers:{ 'Content-Type':'application/x-www-form-urlencoded' },
                    body: params.toString()
                });
                const json = await res.json();
                //console.log(json);
                marked = json?.data?.marked_dates || {};
                renderCalendar();
                }

                async function fetchDay(dateISO) {
                    const params = new URLSearchParams();
                    dateValue = !fromDate.value ? dateISO : fromDate.value;
                    params.append('action','day');
                    params.append('date', dateValue);
                    params.append('name', searchName.value.trim());
                    params.append('location', searchLocation.value.trim());
                    params.append('status', status.value.trim());

                    console.log(params.toString());

                    const res = await fetch('schedule_testing', {
                        method:'POST',
                        headers:{ 'Content-Type':'application/x-www-form-urlencoded' },
                        body: params.toString()
                    });

                    const json = await res.json();
                    renderCards(json?.data || []);
                }

                // ------ Cards
                function renderCards(items) {
                cardsWrap.innerHTML = '';
                resultCount.textContent = items.length;
                if (!items.length) {
                    emptyState.classList.remove('d-none');
                    return;
                }
                emptyState.classList.add('d-none');

                items.forEach(r => {
                    const pay = Number(r.pay_per_hour ?? 0);
                    const hours = Number(r.hours_worked ?? 0);
                    const expectedHours = Number(r.scheduled_hours ?? 0);
                    const totalPay = (hours * pay).toFixed(2);


                    const card = document.createElement('div');
                    card.className = 'col-12 col-md-6 col-xl-4';
                    card.innerHTML = `
                    <div class="card schedule-card h-100">
                        <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                            <div class="fw-bold">${escapeHTML(r.staff_name || '—')}</div>
                            <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i>${escapeHTML(r.location || '—')}</div>
                            </div>
                            <span class="chip"><i class="bi bi-cash-coin"></i>$${Number(r.pay_per_hour).toFixed(2)}/hr</span>
                            <span>
                                <div class="dropdown">
                                    <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="0#" data-bs-toggle='modal'  data-bs-target='#modal-default' data-email="${r.email}" data-end_time="${r.end_time}" data-pay_per_hour="${r.pay_per_hour}" data-id="${r.id}" data-schedule_date="${r.date}" data-shift_type="${r.shift_type}" data-start_time="${r.start_time}" data-overnight_type="${r.overnight_type}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger sch_delete" onclick="deleteSchedule(${r.id})" href="#" data-action="delete" data-id="${r.id}"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </span>
                        </div>

                        <hr class="my-3">

                        <div class="row g-3">
                            <div class="col-6">
                            <div class="metric"><i class="bi bi-clock"></i>
                                <div>
                                <div class="small text-muted">Start</div>
                                <div class="fw-semibold">${escapeHTML(r.start_time_fmt || r.start_time)}</div>
                                </div>
                            </div>
                            </div>
                            <div class="col-6">
                            <div class="metric"><i class="bi bi-clock-history"></i>
                                <div>
                                <div class="small text-muted">End</div>
                                <div class="fw-semibold">${escapeHTML(r.end_time_fmt || r.end_time)}</div>
                                </div>
                            </div>
                            </div>

                            <div class="col-6">
                            <div class="metric"><i class="bi bi-box-arrow-in-right"></i>
                                <div>
                                <div class="small text-muted">Clock-in</div>
                                <div class="fw-semibold">${escapeHTML(r.clockin_fmt || r.clockin || '—')}</div>
                                </div>
                            </div>
                            </div>
                            <div class="col-6">
                            <div class="metric"><i class="bi bi-box-arrow-left"></i>
                                <div>
                                <div class="small text-muted">Clock-out</div>
                                <div class="fw-semibold">${escapeHTML(r.clockout_fmt || r.clockout || '—')}</div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex flex-wrap gap-3">
                            <div class="metric"><i class="bi bi-hourglass-split"></i>
                            <div>
                                <div class="small text-muted">Scheduled</div>
                                <div class="fw-semibold">${expectedHours.toFixed(2)} h</div>
                            </div>
                            </div>
                            <div class="metric"><i class="bi bi-stopwatch"></i>
                            <div>
                                <div class="small text-muted">Worked</div>
                                <div class="fw-semibold">${hours.toFixed(2)} h</div>
                            </div>
                            </div>
                            <div class="metric"><i class="bi bi-currency-dollar"></i>
                            <div>
                                <div class="small text-muted">Total Pay</div>
                                <div class="fw-semibold">$${totalPay}</div>
                            </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="small text-muted">Shift type</div>
                            <div class="fw-semibold text-capitalize">${r.shift_type} ${r.shift_type == 'overnight' ? `(${r.overnight_type})` : ''}</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Status</div>
                            <div class="badge ${r.status==='completed' ? 'bg-success' : r.status==='in-progress' ? 'bg-warning text-dark' : 'bg-secondary text-white'} tiny">${r.status}</div>
                        </div>
                        </div>

                        </div>
                    </div>
                    `;
                    cardsWrap.appendChild(card);
                });
                }

                function escapeHTML(s) {
                    return String(s ?? '').replace(/[&<>"']/g, m => ({
                        '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
                    }[m]));
                }

                // ------ Events
                //btnSearch.addEventListener('click', () =>  fetchDay(selectedDate));
                btnSearch.addEventListener('click', () => {
                    let searchDate = fromDate.value || fmtDateISO(new Date()); // use input or today
                    selectedDate = searchDate;

                    // set view month/year to match search date
                    const d = new Date(searchDate);
                    viewYear = d.getFullYear();
                    viewMonth = d.getMonth();

                    // re-render calendar so the correct date is highlighted
                    fetchMonth(viewYear, viewMonth).then(() => {
                        selectedDateLabel.textContent = d.toLocaleDateString();
                        fetchDay(searchDate);
                    });
                });

                btnReset.addEventListener('click', () => {
                searchName.value=''; searchLocation.value=''; status.value = ""; fromDate.value = fmtDateISO(new Date());
                fetchDay(selectedDate);
                });
                prevMonth.addEventListener('click', () => {
                if (viewMonth === 0) { viewMonth = 11; viewYear--; } else { viewMonth--; }
                fetchMonth(viewYear, viewMonth);
                });
                nextMonth.addEventListener('click', () => {
                if (viewMonth === 11) { viewMonth = 0; viewYear++; } else { viewMonth++; }
                fetchMonth(viewYear, viewMonth);
                });
                todayBtn.addEventListener('click', () => {
                const now = new Date();
                viewYear = now.getFullYear(); viewMonth = now.getMonth();
                selectedDate = fmtDateISO(now);
                fetchMonth(viewYear, viewMonth).then(() => {
                    selectedDateLabel.textContent = now.toLocaleDateString();
                    fetchDay(selectedDate);
                });
                });

                // ------ Init
                (function init() {
                    renderWeekdays();
                    const now = new Date();
                    viewYear = now.getFullYear();
                    viewMonth = now.getMonth();
                    selectedDate = fmtDateISO(now);
                    selectedDateLabel.textContent = now.toLocaleDateString();
                    fetchMonth(viewYear, viewMonth).then(() => fetchDay(selectedDate));
                })();
        </script>

        
</body>
</html>
