<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Spreadsheet</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .schedule-container {
            overflow-x: auto;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        
        .date-header {
            background: #2c3e50;
            color: white;
            padding: 15px 10px;
            text-align: center;
            border-right: 1px solid #dee2e6;
            min-width: 200px;
        }
        
        .location-row {
            background: white;
            border-bottom: 1px solid #dee2e6;
        }
        
        .location-cell {
            background: #34495e;
            color: white;
            padding: 15px;
            font-weight: bold;
            min-width: 150px;
            border-right: 2px solid #dee2e6;
            vertical-align: top;
        }
        
        .schedule-cell {
            min-width: 200px;
            min-height: 120px;
            padding: 10px;
            border-right: 1px solid #dee2e6;
            background: #f8f9fa;
            vertical-align: top;
        }
        
        .schedule-card {
            background: white;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #007bff;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .schedule-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
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
        
        .status-badge {
            font-size: 0.7em;
            padding: 4px 8px;
            border-radius: 12px;
        }
        
        .person-name {
            font-weight: bold;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        
        .time-slot {
            font-size: 0.8em;
            color: #6c757d;
            margin-bottom: 3px;
        }
        
        .table-fixed {
            table-layout: fixed;
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
            background: #34495e;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Schedule Overview</h1>
                <p class="text-muted">Weekly Schedule Spreadsheet View</p>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm">
                        Current Week
                    </button>
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="schedule-container">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <!-- Dates Header -->
                    <thead class="sticky-header">
                        <tr>
                            <th class="location-cell">Location / Date</th>
                            <th class="date-header">
                                <div>Mon</div>
                                <div class="fw-normal">Dec 11, 2023</div>
                            </th>
                            <th class="date-header">
                                <div>Tue</div>
                                <div class="fw-normal">Dec 12, 2023</div>
                            </th>
                            <th class="date-header">
                                <div>Wed</div>
                                <div class="fw-normal">Dec 13, 2023</div>
                            </th>
                            <th class="date-header">
                                <div>Thu</div>
                                <div class="fw-normal">Dec 14, 2023</div>
                            </th>
                            <th class="date-header">
                                <div>Fri</div>
                                <div class="fw-normal">Dec 15, 2023</div>
                            </th>
                            <th class="date-header">
                                <div>Sat</div>
                                <div class="fw-normal">Dec 16, 2023</div>
                            </th>
                            <th class="date-header">
                                <div>Sun</div>
                                <div class="fw-normal">Dec 17, 2023</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Location Rows -->
                        <tr class="location-row">
                            <td class="location-cell sticky-location">
                                <i class="fas fa-building me-2"></i>Main Office
                            </td>
                            <!-- Monday -->
                            <td class="schedule-cell">
                                <div class="schedule-card completed">
                                    <div class="person-name">John Smith</div>
                                    <div class="time-slot">
                                        <i class="far fa-clock"></i> 09:00 - 11:00
                                    </div>
                                    <span class="badge bg-success status-badge">Completed</span>
                                </div>
                                <div class="schedule-card ongoing">
                                    <div class="person-name">Sarah Johnson</div>
                                    <div class="time-slot">
                                        <i class="far fa-clock"></i> 14:00 - 16:00
                                    </div>
                                    <span class="badge bg-warning text-dark status-badge">Ongoing</span>
                                </div>
                            </td>
                            <!-- Tuesday -->
                            <td class="schedule-cell">
                                <div class="schedule-card">
                                    <div class="person-name">Mike Chen</div>
                                    <div class="time-slot">
                                        <i class="far fa-clock"></i> 10:00 - 12:00
                                    </div>
                                    <span class="badge bg-primary status-badge">Scheduled</span>
                                </div>
                            </td>
                            <!-- Wednesday -->
                            <td class="schedule-cell">
                                <div class="schedule-card missed">
                                    <div class="person-name">Lisa Wong</div>
                                    <div class="time-slot">
                                        <i class="far fa-clock"></i> 08:00 - 10:00
                                    </div>
                                    <span class="badge bg-danger status-badge">Missed</span>
                                </div>
                            </td>
                            <!-- Thursday to Sunday -->
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell"></td>
                        </tr>

                        <tr class="location-row">
                            <td class="location-cell sticky-location">
                                <i class="fas fa-store me-2"></i>Branch A
                            </td>
                            <!-- Days data -->
                            <td class="schedule-cell">
                                <div class="schedule-card">
                                    <div class="person-name">David Brown</div>
                                    <div class="time-slot">
                                        <i class="far fa-clock"></i> 13:00 - 15:00
                                    </div>
                                    <span class="badge bg-primary status-badge">Scheduled</span>
                                </div>
                            </td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell">
                                <div class="schedule-card completed">
                                    <div class="person-name">Emma Davis</div>
                                    <div class="time-slot">
                                        <i class="far fa-clock"></i> 11:00 - 13:00
                                    </div>
                                    <span class="badge bg-success status-badge">Completed</span>
                                </div>
                            </td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell"></td>
                        </tr>

                        <tr class="location-row">
                            <td class="location-cell sticky-location">
                                <i class="fas fa-warehouse me-2"></i>Warehouse
                            </td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell">
                                <div class="schedule-card ongoing">
                                    <div class="person-name">Robert Wilson</div>
                                    <div class="time-slot">
                                        <i class="far fa-clock"></i> 08:00 - 17:00
                                    </div>
                                    <span class="badge bg-warning text-dark status-badge">Ongoing</span>
                                </div>
                            </td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell">
                                <div class="schedule-card">
                                    <div class="person-name">Maria Garcia</div>
                                    <div class="time-slot">
                                        <i class="far fa-clock"></i> 09:00 - 12:00
                                    </div>
                                    <span class="badge bg-primary status-badge">Scheduled</span>
                                </div>
                            </td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell"></td>
                            <td class="schedule-cell"></td>
                        </tr>

                        <!-- Add more location rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Legend -->
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Status Legend</h6>
                        <div class="d-flex gap-3 flex-wrap">
                            <span class="badge bg-primary">Scheduled</span>
                            <span class="badge bg-success">Completed</span>
                            <span class="badge bg-warning text-dark">Ongoing</span>
                            <span class="badge bg-danger">Missed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add click functionality to schedule cards
        document.querySelectorAll('.schedule-card').forEach(card => {
            card.addEventListener('click', function() {
                const personName = this.querySelector('.person-name').textContent;
                const timeSlot = this.querySelector('.time-slot').textContent;
                const status = this.querySelector('.badge').textContent;
                
                alert(`Schedule Details:\n\nPerson: ${personName}\nTime: ${timeSlot}\nStatus: ${status}`);
            });
        });
    </script>
</body>
</html>