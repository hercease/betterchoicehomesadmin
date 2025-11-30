<?php
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class allmodels{

    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

     // Method to detect the current URL and check if HTTPS is used
     public function getCurrentUrl() {
        // Check if HTTPS is on or not
        $isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? true : false;
		// Get the host (domain name) and the requested URI
        $host = $_SERVER['HTTP_HOST'];
        // Get the HTTP protocol (http or https)
        $protocol = $isHttps ? 'https://' . $host : 'http://' . $host;

        //$uri = $_SERVER['REQUEST_URI'];

        // Build the full URL
        $fullUrl = $protocol;

        // Return an associative array with the information
        return $fullUrl;
    }

   public function getUserInfo($emailOrId) {

        $stmt = $this->db->prepare("
            SELECT 
                u.*, 
                ud.driver_license_expiry_date, ud.address, ud.dob, ud.sin, ud.contact_number, ud.transit_number, ud.institution_number, ud.city, ud.province, ud.account_number,
                ud.driver_license_number, ud.postal_code
            FROM users u
            LEFT JOIN user_details ud ON u.id = ud.user_id
            WHERE u.email = ? OR u.id = ?
        ");
        $stmt->bind_param("si", $emailOrId, $emailOrId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if(!$row){
            return null;
        }

        $user = null;
        $documents = [];
        $certificates = [];

                // Build user core data only once
                $user = [
                    'id' => $row['id'],
                    'firstname' => $row['firstname'],
                    'lastname' => $row['lastname'],
                    'password' => $row['password'],
                    'email' => $row['email'],
                    'location' => $row['location'],
                    'role' => $row['role'],
                    'isActive' => $row['isActive'],
                    'reg_date' => $row['reg_date'],
                    'isAdmin' => $row['isAdmin'],
                    'userdetails' => [
                        'address' => $row['address'],
                        'driver_license_expiry_date' => $row['driver_license_expiry_date'],
                        'driver_license_number' => $row['driver_license_number'],
                        'dob' => $row['dob'],
                        'sin' => $row['sin'],
                        'city' => $row['city'],
                        'province' => $row['province'],
                        'contact_number' => $row['contact_number'],
                        'postal_code' => $row['postal_code'],
                        'transit_number' => $row['transit_number'],
                        'institution_number' => $row['institution_number'],
                        'account_number' => $row['account_number'],
                    ]
                ];
        

        // Fetch documents separately
        $docStmt = $this->db->prepare("
            SELECT id, title, doc_tag, name, isApproved, optional 
            FROM documents 
            WHERE user_id = ?
        ");
        $docStmt->bind_param("i", $user['id']);
        $docStmt->execute();
        $docResult = $docStmt->get_result();
        $documents = [];
        while ($doc = $docResult->fetch_assoc()) {
            $documents[] = [
                'id'         => $doc['id'],
                'title'      => $doc['title'],
                'tag'        => $doc['doc_tag'],
                'file_name'  => $doc['name'],
                'file_url'   => (defined('IMAGE_URL') ? IMAGE_URL : '') . "/public/assets/img/" . $doc['name'],
                'isApproved' => (bool)$doc['isApproved'],
                'optional'   => (bool)$doc['optional'],
            ];
        }
        $docStmt->close();

        // Fetch certificates separately
        $certStmt = $this->db->prepare("
            SELECT id, certificate_name, isApproved, cert_tag, title 
            FROM certificates 
            WHERE user_id = ?
            ORDER BY id ASC
        ");
        $certStmt->bind_param("i", $user['id']);
        $certStmt->execute();
        $certResult = $certStmt->get_result();
        $certificates = [];
        while ($cert = $certResult->fetch_assoc()) {
            $certificates[] = [
                'id'         => $cert['id'],
                'cert_tag'   => $cert['cert_tag'],
                'title'      => $cert['title'],
                'file_name'  => $cert['certificate_name'],
                'file_url'   => (defined('IMAGE_URL') ? IMAGE_URL : '') . "/public/assets/img/" . $cert['certificate_name'],
                'isApproved' => (bool)$cert['isApproved'],
                'optional'   => true,
            ];
        }
        $certStmt->close();

        $user['documents'] = $documents;
        $user['certificates'] = $certificates;
            

        return $user;
    }


    public function getUserDocuments($id,$document_type) {
        $stmt = $this->db->prepare("SELECT * FROM $document_type WHERE user_id = ? OR id = ?");
        $stmt->bind_param("ii", $id, $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchRecentUsers() {
        $zero = 0;
        $stmt = $this->db->prepare("SELECT firstname, lastname, reg_date, email FROM users WHERE NOT isAdmin = ? ORDER BY id DESC LIMIT 5");
        $stmt->bind_param("i", $zero);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // ✅ returns all matching rows
    }

    public function fetchlocations($id = null){

        if(!is_null($id)){
           $stmt = $this->db->prepare("SELECT id, address, city, postal_code, province FROM locations WHERE id = $id"); 
        } else {
            $stmt = $this->db->prepare("SELECT id, address, city, postal_code, province FROM locations");
        }
        
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // ✅ returns all matching rows
    }

    public function fetchscheduledetails($id){
        $stmt = $this->db->prepare("SELECT * FROM scheduling WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // ✅ returns all matching rows
    }

    public function getDatesBetween($start, $end) {
        $dates = [];
        $current = strtotime($start);
        $end = strtotime($end);

        while ($current <= $end) {
            $dates[] = date("Y-m-d", $current);
            $current = strtotime("+1 day", $current);
        }

        return $dates;
    }


    function getFormattedDateTime($datetime = 'now', $timezone = 'UTC') {
        $date = new DateTime($datetime, new DateTimeZone($timezone));
        return $date->format('l, F j · g:i A');
    }

    function generateRandomPassword($length = 10): string {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        $maxIndex = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $maxIndex)];
        }

        return $password;
    }

    public function sendmail($email,$name,$body,$subject){

        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        
        try {
            
            $mail->isSMTP();                           
            $mail->Host       = SMTP_HOST;      
            $mail->SMTPAuth   = true;
            $mail->SMTPKeepAlive = true; //SMTP connection will not close after each email sent, reduces SMTP overhead	
            $mail->Username   = SMTP_USERNAME;    
            $mail->Password   = SMTP_PASSWORD;             
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   
            $mail->Port       = 465;               
    
            //Recipients
            $mail->setFrom(SMTP_FROM_EMAIL, 'Better Choice Group Homes'); // Sender's email and name
            $mail->addAddress("$email", "$name"); 
            
            $mail->isHTML(true); 
            $mail->Subject = $subject;
            $mail->Body    = $body;
    
            $mail->send();
            $mail->clearAddresses();
            //return true;
            
        } catch (Exception $e){
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendPushToMobile($to, $title, $body) {
        $data = [
            "to" => $to,
            "sound" => "default",
            "title" => $title,
            "body" => $body,
        ];

        $ch = curl_init("https://exp.host/--/api/v2/push/send");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function processUnsentSchedules() {
        try {
            // Get all user_ids with unsent schedules
            $query = "SELECT user_id FROM scheduling WHERE mailer = 0 LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0) return;
            $row = $result->fetch_assoc();
            $userId = $row['user_id'];

            $this->sendScheduleEmail($userId);

            return ['success' => true, 'message' => 'Email sent successfully'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function fetchMobileNotificationToken($email) {
        $query = "SELECT token FROM notification_token WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['token'] ?? '';
    }

    private function sendScheduleEmail($userId) {
        // Get user details
        $user = $this->getUserInfo($userId);
        if (!$user) return;

        // Fetch Notification Token
        $token = $this->fetchMobileNotificationToken($user['email']);

        // Get all unsent schedules for this user
        $schedules = $this->getUserSchedules($userId);
        if (empty($schedules)) return;

        // Prepare email content
        $emailContent = $this->prepareEmailTemplate($user, $schedules);

        // Send email
        $this->sendmail($user['email'], $user['lastname'].' '.$user['firstname'], $emailContent, 'Your Schedule');

        // Mark schedules as sent
        $this->markSchedulesAsSent($userId);

        // Send push notification
        !empty($token) && $this->sendPushToMobile($token, 'Schedule Update', 'You have a new schedule appointment.'); 
    }

    private function prepareEmailTemplate($user, $schedules) {
        $scheduleRows = '';
        $totalHours = 0;
        $totalEarnings = 0;
    
        foreach ($schedules as $schedule) {
            $startTime = date('h:i A', strtotime($schedule['start_time']));
            $endTime = date('h:i A', strtotime($schedule['end_time']));
            $scheduleDate = date('D, M j, Y', strtotime($schedule['schedule_date']));
            
            $shiftType = $schedule['shift_type'];
            if ($shiftType === 'overnight' && !empty($schedule['overnight_type'])) {
                $shiftType .= ' (' . $schedule['overnight_type'] . ')';
            }
    
            // Calculate hours and earnings
            $hours = (strtotime($schedule['end_time']) - strtotime($schedule['start_time'])) / 3600;
            $earnings = $hours * $schedule['pay_per_hour'];
            
            $totalHours += $hours;
            $totalEarnings += $earnings;
    
            $scheduleRows .= "
            <tr>
                <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'>{$scheduleDate}</td>
                <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'>{$schedule['location_name']}</td>
                <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'>{$startTime}</td>
                <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'>{$endTime}</td>
                <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'>{$shiftType}</td>
                <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'>$" . number_format($schedule['pay_per_hour'], 2) . "</td>
                <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'>" . number_format($hours, 2) . "h</td>
                <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'>$" . number_format($earnings, 2) . "</td>
            </tr>";
        }
    
        return $this->getEmailTemplate($user, $scheduleRows, $totalHours, $totalEarnings, $schedules);
    }
    
    private function getEmailTemplate($user, $scheduleRows, $totalHours, $totalEarnings, $schedules) {
        $mobileCards = $this->generateMobileCards($schedules);
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Your Schedule</title>
            <!--[if !mso]><!-->
            <style type='text/css'>
                /* Mobile Styles */
                @media only screen and (max-width: 620px) {
                    .container {
                        width: 100% !important;
                        margin: 0 !important;
                        border-radius: 0 !important;
                    }
                    .desktop-table {
                        display: none !important;
                    }
                    .mobile-view {
                        display: block !important;
                    }
                    .mobile-card {
                        display: block !important;
                        width: 100% !important;
                    }
                }
                /* Desktop Styles */
                @media only screen and (min-width: 621px) {
                    .mobile-view {
                        display: none !important;
                    }
                    .desktop-table {
                        display: block !important;
                    }
                }
            </style>
            <!--<![endif]-->
        </head>
        <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f4f6f9;'>
            <div class='container' style='max-width: 800px; margin: 20px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08);'>
                <!-- Header -->
                <div style='background: linear-gradient(135deg, #004aad 0%, #00a859 100%); color: #ffffff; text-align: center; padding: 35px 20px;'>
                    <h1 style='margin: 0; font-size: 24px; letter-spacing: 0.5px; font-family: Arial, sans-serif;'>Your Upcoming Schedule</h1>
                    <p style='margin: 6px 0 0; font-size: 15px; font-family: Arial, sans-serif;'>Hello {$user['lastname']}, here are your scheduled shifts</p>
                </div>
                
                <!-- Content -->
                <div style='padding: 30px;'>
                    <!-- Summary Highlight -->
                    <div style='background: #e8f1ff; border-left: 5px solid #004aad; padding: 15px 20px; border-radius: 6px; margin-bottom: 25px; font-size: 15px; font-family: Arial, sans-serif;'>
                        <strong>📋 Schedule Summary:</strong><br>
                        You have " . count($schedules) . " shifts scheduled.
                    </div>
    
                    <!-- Desktop Table View -->
                    <div class='desktop-table' style='overflow-x: auto;'>
                        <table class='schedule-table' style='width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 750px;'>
                            <thead>
                                <tr>
                                    <th style='background: #004aad; color: #ffffff; padding: 14px; text-align: left; font-size: 14px; font-family: Arial, sans-serif; font-weight: bold;'>Date</th>
                                    <th style='background: #004aad; color: #ffffff; padding: 14px; text-align: left; font-size: 14px; font-family: Arial, sans-serif; font-weight: bold;'>Location</th>
                                    <th style='background: #004aad; color: #ffffff; padding: 14px; text-align: left; font-size: 14px; font-family: Arial, sans-serif; font-weight: bold;'>Start Time</th>
                                    <th style='background: #004aad; color: #ffffff; padding: 14px; text-align: left; font-size: 14px; font-family: Arial, sans-serif; font-weight: bold;'>End Time</th>
                                    <th style='background: #004aad; color: #ffffff; padding: 14px; text-align: left; font-size: 14px; font-family: Arial, sans-serif; font-weight: bold;'>Shift Type</th>
                                    <th style='background: #004aad; color: #ffffff; padding: 14px; text-align: left; font-size: 14px; font-family: Arial, sans-serif; font-weight: bold;'>Rate/Hour</th>
                                    <th style='background: #004aad; color: #ffffff; padding: 14px; text-align: left; font-size: 14px; font-family: Arial, sans-serif; font-weight: bold;'>Hours</th>
                                    <th style='background: #004aad; color: #ffffff; padding: 14px; text-align: left; font-size: 14px; font-family: Arial, sans-serif; font-weight: bold;'>Earnings</th>
                                </tr>
                            </thead>
                            <tbody>
                                {$scheduleRows}
                                <tr style='background: #e8f5e8 !important; font-weight: bold; color: #004aad;'>
                                    <td colspan='6' style='padding: 12px; border: 1px solid #e0e0e0; text-align: right; font-family: Arial, sans-serif; font-size: 14px;'><strong>Total:</strong></td>
                                    <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'><strong>" . number_format($totalHours, 2) . "h</strong></td>
                                    <td style='padding: 12px; border: 1px solid #e0e0e0; font-family: Arial, sans-serif; font-size: 14px;'><strong>$" . number_format($totalEarnings, 2) . "</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
    
                    <!-- Mobile Card View -->
                    <div class='mobile-view' style='display: none;'>
                        {$mobileCards}
                        <div style='background: #e8f5e8; border: 1px solid #cce5cc; padding: 12px; border-radius: 6px; text-align: center; color: #004aad; font-weight: bold; margin-top: 20px; font-family: Arial, sans-serif;'>
                            Total Hours: " . number_format($totalHours, 2) . "h &nbsp; | &nbsp; Total Earnings: $" . number_format($totalEarnings, 2) . "
                        </div>
                    </div>
                </div>
    
                <!-- Footer -->
                <div style='text-align: center; background: #f4f6f9; padding: 25px; color: #666666; font-size: 14px; font-family: Arial, sans-serif;'>
                    <p style='margin: 0 0 10px 0;'>If you have any questions about your schedule, please contact the HR department.</p>
                    <p style='margin: 0;'>© " . date('Y') . " <strong>Better Choice Group Homes</strong>. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    private function generateMobileCards($schedules) {
        $cards = '';
        foreach ($schedules as $schedule) {
            $scheduleDate = date('D, M j, Y', strtotime($schedule['schedule_date']));
            $startTime = date('h:i A', strtotime($schedule['start_time']));
            $endTime = date('h:i A', strtotime($schedule['end_time']));
            $shiftType = $schedule['shift_type'];
            if ($shiftType === 'overnight' && !empty($schedule['overnight_type'])) {
                $shiftType .= ' (' . $schedule['overnight_type'] . ')';
            }
            $hours = (strtotime($schedule['end_time']) - strtotime($schedule['start_time'])) / 3600;
            $earnings = $hours * $schedule['pay_per_hour'];
    
            $cards .= "
            <div class='mobile-card' style='display: none; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-family: Arial, sans-serif;'>
                <h3 style='margin: 0 0 8px 0; color: #004aad; font-size: 16px; font-family: Arial, sans-serif; font-weight: bold;'>{$schedule['location_name']}</h3>
                <p style='margin: 4px 0; font-size: 14px; line-height: 1.4; font-family: Arial, sans-serif;'><strong>Date:</strong> {$scheduleDate}</p>
                <p style='margin: 4px 0; font-size: 14px; line-height: 1.4; font-family: Arial, sans-serif;'><strong>Time:</strong> {$startTime} - {$endTime}</p>
                <p style='margin: 4px 0; font-size: 14px; line-height: 1.4; font-family: Arial, sans-serif;'><strong>Shift:</strong> {$shiftType}</p>
                <p style='margin: 4px 0; font-size: 14px; line-height: 1.4; font-family: Arial, sans-serif;'><strong>Rate:</strong> $" . number_format($schedule['pay_per_hour'], 2) . "/hr</p>
                <p style='margin: 4px 0; font-size: 14px; line-height: 1.4; font-family: Arial, sans-serif;'><strong>Hours:</strong> " . number_format($hours, 2) . "h</p>
                <p style='margin: 4px 0; font-size: 14px; line-height: 1.4; font-family: Arial, sans-serif;'><strong>Earnings:</strong> $" . number_format($earnings, 2) . "</p>
            </div>";
        }
        return $cards;
    }
    
    

    private function markSchedulesAsSent($userId) {
        $query = "UPDATE scheduling SET mailer = 1 WHERE user_id = ? AND mailer = 0";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
    }

    private function getUserSchedules($userId) {
        $query = "SELECT 
                    s.location_name, 
                    s.start_time, 
                    s.end_time, 
                    s.shift_type, 
                    s.overnight_type,
                    s.schedule_date,
                    s.pay_per_hour
                  FROM scheduling s 
                  WHERE s.user_id = ? AND s.mailer = 0
                  ORDER BY s.schedule_date, s.start_time";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



    function getCoordinatesFromAddress($address, $apiKey) {

        $baseUrl = "https://api.opencagedata.com/geocode/v1/json";

        $url = $baseUrl . "?" . http_build_query([
            'q' => $address,
            'key' => $apiKey,
            'limit' => 1,
            'no_annotations' => 1,
        ]);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return ['error' => 'Curl error: ' . curl_error($ch)];
        }

        curl_close($ch);
     
        $data = json_decode($response, true);
        //error_log("OpenCage response: " . print_r($data, true));
        

        if (!empty($data['results'][0]['geometry'])){
            return [
                'latitude' => $data['results'][0]['geometry']['lat'],
                'longitude' => $data['results'][0]['geometry']['lng'],
            ];
        }

        return ['error' => 'Coordinates not found'];
    }


    public function sanitizeInput($data) {
        if (is_array($data)) {
            // Loop through each element of the array and sanitize recursively
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitizeInput($value);
            }
        } else {
            // If it's not an array, sanitize the string
            $data = trim($data); // Remove unnecessary spaces
            $data = stripslashes($data); // Remove backslashes
            $data = htmlspecialchars($data); // Convert special characters to HTML entities
        }
        return $data;
    }

    public function fetchTableRows($start, $rowperpage, $searchValue, $tabletype, $userId = null) {
        //session_start();
        $searchQuery = "";
        $params = [];
        $paramTypes = "";
        $query = "";
    
        // Determine the table and construct the query accordingly
         if ($tabletype === 'allusers') {
            // Query for the 'users' table
            $query = "SELECT id, email, firstname, lastname, isAdmin, role, isActive, location, reg_date FROM users WHERE role IN ('manager', 'staff', 'hr', 'scheduler', 'accountant', 'director of service')";
            
            if (!empty($searchValue)) {
                $searchQuery = " AND email LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR reg_date LIKE ? OR location LIKE ?";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $paramTypes .= "sssss";
            }
    
            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";

        } elseif ($tabletype === 'locations') {

            $query = "SELECT * FROM locations";

            if (!empty($searchValue)) {
                $searchQuery = " WHERE name LIKE ? OR address LIKE ? OR city LIKE ? OR province LIKE ?";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $paramTypes .= "ssss";
            }

            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";

        } elseif ($tabletype === 'userdocuments') {
            
            $query = "SELECT * FROM documents WHERE user_id = $userId ";

            if (!empty($searchValue)) {
                $searchQuery = " AND doc_tag LIKE ?";
                $params[] = "%$searchValue%";
                $paramTypes .= "s";
            }

            $query .= "$searchQuery ORDER BY id ASC LIMIT ?, ?";

        } elseif ($tabletype === 'usercertificates') {
            
            $query = "SELECT * FROM certificates WHERE user_id = $userId  AND certificate_name != ''";

            if (!empty($searchValue)) {
                $searchQuery = " WHERE cert_tag LIKE ?";
                $params[] = "%$searchValue%";
                $paramTypes .= "s";
            }

            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";

        } elseif ($tabletype === 'allschedules') {
            
            $query = "SELECT * FROM scheduling ";

            if (!empty($searchValue)) {
                $searchQuery = " WHERE schedule_date LIKE ? OR start_time LIKE ? OR end_time LIKE ? OR location LIKE ? OR shift_type LIKE ? OR pay_per_hour LIKE ?";
                $params[] = "%$searchValue%";
                $paramTypes .= "s";
            }

            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";

        } elseif($tabletype === 'allagencies'){

            $query = "SELECT * FROM agencies ";

            if (!empty($searchValue)) {
                $searchQuery = " WHERE name LIKE ? OR address LIKE ? OR phone LIKE ? OR province LIKE ? OR email LIKE ?";
                $params[] = "%$searchValue%";
                $paramTypes .= "s";
            }

            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";

        } elseif ($tabletype === 'allagencystaffs'){

            $query = "SELECT ast.*, ag.name as agency_name FROM agency_staffs ast LEFT JOIN agencies ag ON ast.agency_id = ag.id";
            if(!empty($searchValue)){

                $searchQuery = " WHERE ast.firstname LIKE ? 
                        OR ast.email LIKE ? 
                        OR ast.lastname LIKE ? 
                        OR ast.phone LIKE ? 
                        OR ag.name LIKE ?";
                $params = array_fill(0, 5, "%$searchValue%");
                $paramTypes = "sssss";

            }

            $query .= "$searchQuery ORDER BY ast.id DESC LIMIT ?, ?";

        } else {
            // Handle invalid table type
            die("Invalid table type provided.");
        }
    
        // Append pagination parameters
        $params[] = $start;
        $params[] = $rowperpage;
        $paramTypes .= "ii";
    
        // Prepare the statement
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Query preparation failed: " . $this->db->error);
        }
    
        // Bind parameters dynamically
        $stmt->bind_param($paramTypes, ...$params);

        //var_export($query);die;
    
        // Execute the query and fetch results
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Collect the data into an array
        $data = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {

            if ($tabletype === 'allusers') {
                // Format data for the 'allusers' table
                $row['reg_date'] = date('Y-m-d', strtotime($row['reg_date']));
                $status = $row['isActive'] ? "<span class='badge bg-success'>Active</span>" : "<span class='badge bg-danger'>Inactive</span>";
                // Format data for the 'users' table
                $action = "<div class='dropdown'>";
                $action .= "<button class='btn btn-sm btn-primary dropdown-toggle' id='dropdownMenuButton' type='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action</button>";
                $action .= "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
               
                    $action .= "<a data-id='".$row['id']."' class='dropdown-item del_user'><i class='fas fa-trash me-2'></i> Delete user</a>";
                    $action .= "<a data-id='".$row['id']."' data-bs-toggle='modal'  data-bs-target='#modal-default' data-role='".$row['role']."' data-lastname='".$row['lastname']."' data-email='".$row['email']."' data-location='".$row['location']."' data-firstname='".$row['firstname']."' class='dropdown-item edit_user'><i class='fas fa-edit me-2'></i> Edit user</a>";
                    $action .= "<a href='/userdetails/".$row['id']."' class='dropdown-item view_user'><i class='fas fa-info me-2'></i> View user info</a>";
                    $action .= "<a data-id='".$row['id']."' data-status='".$row['isActive']."' class='dropdown-item toggle_user_status'><i class='fas fa-toggle-on me-2'></i> Toggle user status</a>";
                $action .= "</div></div>";

                $data[] = [
                    "id" => ++$i,
                    "firstname" => $row['firstname'],
                    "lastname" => $row['lastname'],
                    "email" => $row['email'],
                    "role" => $row['role'],
                    "location" => $row['location'],
                    "status" => $status,
                    "reg_date" => $row['reg_date'],
                    "action" => $action
                ];

            } else if ($tabletype === 'locations'){

                $action = "<div class='dropdown'>";
                $action .= "<button class='btn btn-sm btn-primary dropdown-toggle' id='dropdownMenuButton' type='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action</button>";
                $action .= "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
               
                $action .= "<a data-id='".$row['id']."' class='dropdown-item del_location'><i class='fas fa-trash me-2'></i> Delete location</a>";
                $action .= "<a data-bs-toggle='modal'  data-bs-target='#modal-default' data-longitude='".$row['longitude']."' data-latitude='".$row['latitude']."' data-country='".$row['country']."' data-postal='".$row['postal_code']."' data-province='".$row['province']."' data-city='".$row['city']."' data-address='".$row['address']."' data-id='".$row['id']."' class='dropdown-item edit_location'><i class='fas fa-edit me-2'></i> Edit location</a>";
                $action .= "</div></div>";

                $data[] = [
                    "id" => ++$i,
                    "address" => $row['address'],
                    "city" => $row['city'],
                    "province" => $row['province'],
                    "postal_code" => $row['postal_code'],
                    "country" => $row['country'],
                    "created_on" => date('Y-m-d', strtotime($row['created_on'])),
                    "action" => "<a data-bs-toggle='modal' data-longitude='".$row['longitude']."' data-latitude='".$row['latitude']."' data-country='".$row['country']."' data-postal='".$row['postal_code']."' data-province='".$row['province']."' data-city='".$row['city']."' data-address='".$row['address']."' data-id='".$row['id']."'  data-bs-target='#modal-default' class='btn btn-sm btn-primary me-1'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                    <a data-id='".$row['id']."' class='btn btn-sm btn-danger del_location'>
                                        <i class='fas fa-trash'></i>
                                    </a>"
                ];

            } else if($tabletype === 'allagencies'){

                $data[] = [
                    "id" => ++$i,
                    "name" => $row['name'],
                    "email" => $row['email'],
                    "address" => $row['address'],
                    "phone" => $row['phone'],
                    "province" => $row['province'],
                    "zip" => $row['zip'],
                    "created_on" => date('Y-m-d', strtotime($row['created_on'])),
                    "action" => "<a data-bs-toggle='modal' data-name='".$row['name']."' data-email='".$row['email']."' data-phone='".$row['phone']."' data-zip='".$row['zip']."' data-province='".$row['province']."' data-address='".$row['address']."' data-id='".$row['id']."'  data-bs-target='#addAgencyModal' class='btn btn-sm btn-primary me-1'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                    <a data-id='".$row['id']."' class='btn btn-sm btn-danger del_agency'>
                                        <i class='fas fa-trash'></i>
                                    </a>"
                ];

            } else if($tabletype === 'allagencystaffs'){

                $data[] = [
                    "id" => ++$i,
                    "firstname" => $row['firstname'] . ' ' . '<span class="badge bg-primary">' . $row['agency_name'] . '</span>',
                    "lastname" => $row['lastname'],
                    "email" => $row['email'],
                    "address" => $row['address'],
                    "phone" => $row['phone'],
                    "created_on" => date('Y-m-d', strtotime($row['created_on'])),
                    "action" => "<a data-bs-toggle='modal'data-agency='".$row['agency_id']."' data-firstname='".$row['firstname']."' data-email='".$row['email']."' data-phone='".$row['phone']."' data-lastname='".$row['lastname']."'  data-address='".$row['address']."' data-id='".$row['id']."'  data-bs-target='#addAgencystaffModal' class='btn btn-sm btn-primary me-1'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                    <a data-id='".$row['id']."' class='btn btn-sm btn-danger del_agencystaff'>
                                        <i class='fas fa-trash'></i>
                                    </a>"
                ];

            } else if($tabletype === 'userdocuments') {

                $status = $row['isApproved'] ? "<span class='badge bg-success'>Verified</span>" : "<span class='badge bg-danger'>Pending verification</span>";
                $data[] = [
                    "id" => ++$i,
                    "tag" => $row['title'],
                    "name" => $row['name'],
                    "status" => $status,
                    "uploaded_date" => date('Y-m-d', strtotime($row['created_on'])),
                    "action" => (!empty($row['name']) ? "<a data-file='/public/assets/img/".htmlspecialchars($row['name'])."' data-bs-toggle='modal' data-bs-target='#previewModal' class='btn btn-sm btn-outline-primary me-1 preview-btn'>
                                        <i class='fas fa-eye'></i>
                                    </a>
                                    <a href='/public/assets/img/".htmlspecialchars($row['name'])."' download class='btn btn-sm btn-outline-success me-1'>
                                        <i class='fas fa-download'></i>
                                    </a>
                                    <a data-id='".$row['id']."' data-type='documents' class='btn btn-sm btn-outline-danger del_document me-1'>
                                        <i class='fas fa-trash'></i>
                                    </a>" : 
                                    "<a class='btn btn-sm btn-outline-primary me-1' disabled>
                                        <i class='fas fa-eye'></i>
                                    </a>
                                    <a class='btn btn-sm btn-outline-success me-1' disabled>
                                        <i class='fas fa-download'></i>
                                    </a>
                                    <a class='btn btn-sm btn-outline-danger me-1' disabled>
                                        <i class='fas fa-trash'></i>
                                    </a>") . 
                                    ((bool)$row['isApproved'] ? 
                                        "<a data-id='".$row['id']."' data-type='documents' data-status='0' class='btn btn-sm btn-outline-warning decision-btn'>
                                            <i class='fas fa-thumbs-down'></i>
                                        </a>" : 
                                        "<a data-id='".$row['id']."' data-type='documents' data-status='1' class='btn btn-sm btn-outline-success decision-btn'>
                                            <i class='fas fa-thumbs-up'></i>
                                        </a>")
                ];

            } else if($tabletype === 'allschedules') {

                $data[] = [
                    "id" => ++$i,
                    "email" => $row['email'],
                    "start_time" => $row['start_time'],
                    "end_time" => $row['end_time'],
                    "schedule_date" => $row['schedule_date'],
                    "pay_per_hour" => 'CAD'.' '.$row['pay_per_hour'],
                    "shift_type" => $row['shift_type'],
                    "action" => "<a data-bs-toggle='modal' data-email='".$row['email']."' data-end_time='".$row['end_time']."' data-pay_per_hour='".$row['pay_per_hour']."' data-id='".$row['id']."' data-schedule_date='".$row['schedule_date']."' data-shift_type='".$row['shift_type']."' data-start_time='".$row['start_time']."'  data-bs-target='#modal-default' class='btn btn-sm btn-primary me-1'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                    <a data-id='".$row['id']."' class='btn btn-sm btn-danger del_schedule'>
                                        <i class='fas fa-trash'></i>
                                    </a>"
                ];
            } else if ($tabletype === 'usercertificates') {
                $status = $row['isApproved']
                    ? "<span class='badge bg-success'>Verified</span>"
                    : "<span class='badge bg-danger'>Pending verification</span>";

                    function buildCertificateActions(array $row): string
                    {
                        if (!empty($row['certificate_name'])) {
                            $file = htmlspecialchars($row['certificate_name']);

                            $preview = "<a data-file='/public/assets/img/{$file}' 
                                            data-bs-toggle='modal' data-bs-target='#previewModal' 
                                            class='btn btn-sm btn-outline-primary me-1 preview-btn'>
                                            <i class='fas fa-eye'></i>
                                        </a>";

                            $download = "<a href='/public/assets/img/{$file}' download 
                                            class='btn btn-sm btn-outline-success me-1'>
                                            <i class='fas fa-download'></i>
                                        </a>";

                            $delete = "<a data-id='{$row['id']}' data-type='certificates' 
                                            class='btn btn-sm btn-outline-danger del_document me-1'>
                                            <i class='fas fa-trash'></i>
                                    </a>";

                            $decision = $row['isApproved']
                                ? "<a data-id='{$row['id']}' data-type='certificates' data-status='0' 
                                    class='btn btn-sm btn-outline-warning decision-btn'>
                                    <i class='fas fa-thumbs-down'></i>
                                </a>"
                                : "<a data-id='{$row['id']}' data-type='certificates' data-status='1' 
                                    class='btn btn-sm btn-outline-success decision-btn'>
                                    <i class='fas fa-thumbs-up'></i>
                                </a>";

                            return $preview . $download . $delete . $decision;
                        }

                        // Disabled buttons (when no certificate uploaded)
                        return "
                            <a class='btn btn-sm btn-outline-primary me-1 disabled'><i class='fas fa-eye'></i></a>
                            <a class='btn btn-sm btn-outline-success me-1 disabled'><i class='fas fa-download'></i></a>
                            <a class='btn btn-sm btn-outline-danger me-1 disabled'><i class='fas fa-trash'></i></a>
                            <a class='btn btn-sm btn-outline-success disabled'><i class='fas fa-thumbs-up'></i></a>
                        ";
                    }


                $data[] = [
                    "id"            => ++$i,
                    "tag"           => $row['title'],
                    "name"          => $row['certificate_name'],
                    "status"        => $status,
                    "uploaded_date" => date('Y-m-d', strtotime($row['created_on'])),
                    "action"        => buildCertificateActions($row),
                ];
            }
        }
    
        return [
            "recordsTotal" => $this->getTotalRecords($tabletype, $userId),
            "totalRecordsWithFilter" => $this->getTotalRecordswithFilter($tabletype,$userId,$searchValue),
            "data" => $data
        ];
    }


    public function getTotalRecords($tabletype, $userId) {

        $query = "";
        $params = [];
        $paramTypes = "";
    
        switch ($tabletype){
            case 'allusers':
                $query = "SELECT COUNT(*) AS count FROM users WHERE role IN ('manager', 'staff', 'hr', 'scheduler', 'accountant', 'dos')";
                break;
            case 'locations':
                $query = "SELECT COUNT(*) AS count FROM locations";
                break;
            case 'userdocuments':
                $query = "SELECT COUNT(*) AS count FROM documents WHERE user_id = $userId";
                break;
            case 'allschedules':
                $query = "SELECT COUNT(*) AS count FROM scheduling ";
                break;
            case 'usercertificates':
                $query = "SELECT COUNT(*) AS count FROM certificates ";
                break;
            case 'allagencies':
                $query = "SELECT COUNT(*) AS count FROM agencies ";
                break;
            case 'allagencystaffs':
                $query = "SELECT COUNT(*) AS count FROM agency_staffs";
                break;
            default:
                throw new Exception("Invalid table type provided.");
        }
    
        // Prepare the SQL query
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Query preparation failed: " . $this->db->error);
        }
    
        // Bind parameters if any
        if (!empty($params)) {
            $stmt->bind_param($paramTypes, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        return $row['count'] ?? 0;
    }

    public function getTotalRecordswithFilter($tabletype, $userId, $searchValue = "") {
        $searchQuery = "";
        $params = [];
        $paramTypes = "";
    
        // Base query setup
        $query = "";

        if ($tabletype === 'allusers') {
            $query = "SELECT COUNT(*) AS count FROM users WHERE role IN ('manager', 'staff', 'hr', 'scheduler', 'accountant', 'director of service')";
            if (!empty($searchValue)) {
                $searchQuery = " AND email LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR reg_date LIKE ?";
                $params = ["%$searchValue%", "%$searchValue%", "%$searchValue%", "%$searchValue%"];
                $paramTypes = "ssss";
            }
        } else if($tabletype === 'locations'){
             $query = "SELECT COUNT(*) AS count FROM locations";
            if (!empty($searchValue)) {
                $searchQuery = " WHERE name LIKE ? OR address LIKE ? OR city LIKE ? OR province LIKE ?";
                $params = ["%$searchValue%", "%$searchValue%", "%$searchValue%", "%$searchValue%"];
                $paramTypes = "ssss";
            }
        } else if($tabletype === 'userdocuments'){
             $query = "SELECT COUNT(*) AS count FROM documents WHERE user_id = $userId";
            if (!empty($searchValue)) {
                $searchQuery = " AND doc_tag LIKE ?";
                $params = ["%$searchValue%"];
                $paramTypes = "s";
            }
        }else if($tabletype === 'usercertificates'){
             $query = "SELECT COUNT(*) AS count FROM certificates WHERE user_id = $userId";
            if (!empty($searchValue)) {
                $searchQuery = " AND cert_tag LIKE ?";
                $params = ["%$searchValue%"];
                $paramTypes = "s";
            }
        } else if($tabletype === 'allschedules'){
             $query = "SELECT COUNT(*) AS count FROM scheduling ";
            if (!empty($searchValue)) {
                $searchQuery = " WHERE schedule_date LIKE ? OR start_time LIKE ? OR end_time LIKE ? OR location LIKE ? OR shift_type LIKE ? OR pay_per_hour LIKE ?";
                $params = ["%$searchValue%", "%$searchValue%", "%$searchValue%", "%$searchValue%", "%$searchValue%", "%$searchValue%"];
                $paramTypes = "ssssss";
            }
        } else if($tabletype === 'allagencies'){
             $query = "SELECT COUNT(*) AS count FROM agencies ";
            if (!empty($searchValue)) {
                $searchQuery = " WHERE name LIKE ? OR address LIKE ? OR city LIKE ? OR province LIKE ?";
                $params = ["%$searchValue%", "%$searchValue%", "%$searchValue%", "%$searchValue%"];
                $paramTypes = "ssss";
            }
        } else if($tabletype === 'allagencystaffs'){
            $query = "SELECT ast.*, ag.name as agency_name FROM agency_staffs ast LEFT JOIN agencies ag ON ast.agency_id = ag.id";
            if(!empty($searchValue)){

                $searchQuery = " WHERE ast.firstname LIKE ? 
                        OR ast.email LIKE ? 
                        OR ast.lastname LIKE ? 
                        OR ast.phone LIKE ? 
                        OR ag.name LIKE ?";
                $params = array_fill(0, 5, "%$searchValue%");
                $paramTypes = "sssss";

            }
        }  else {
            throw new InvalidArgumentException("Invalid table type provided.");
        }
    
        $query .= " $searchQuery";
    
        // Prepare and execute query
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new RuntimeException("Query preparation failed: " . $this->db->error);
        }
    
        if (!empty($params)) {
            $stmt->bind_param($paramTypes, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        return $row['count'] ?? 0; // Return 0 if no count is found
    }

    public function allCounts($count_type, $username = null) {
        $totalRows = 0;
        $date = date("Y-m-d");
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
        //$fetch_roles = $this->fetchAllRoles()['roles'];
        
        // Extract all 'tag' values from the roles array
        //$role_tags = array_column($fetch_roles, 'tag');
        //error_log("Fetch roles tags: " . print_r($role_tags, true));
        
        // Determine query based on count type
        if ($count_type === "total_users") {
            $query = "SELECT COUNT(*) FROM users";
            $stmt = $this->db->prepare($query);
        } elseif ($count_type === "total_schedule") {
            $query = "SELECT COUNT(*) FROM scheduling";
            $stmt = $this->db->prepare($query);
        } elseif ($count_type === "total_location") {
            $query = "SELECT COUNT(*) FROM locations";
            $stmt = $this->db->prepare($query);
        } elseif ($count_type === "total_schedule_weekly") {
            $query = "SELECT COUNT(*) FROM scheduling WHERE schedule_date BETWEEN ? AND ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $startOfWeek, $endOfWeek);
        } elseif ($count_type === "total_appointments_weekly") {
            $query = "SELECT COUNT(*) FROM scheduling WHERE (clockin IS NULL OR clockin = '') AND schedule_date BETWEEN ? AND ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $startOfWeek, $endOfWeek);
        } elseif ($count_type === "total_expected_hours_weekly") {
            $query = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(clockout, clockin))) AS total_seconds FROM scheduling WHERE schedule_date BETWEEN ? AND ? AND clockin IS NOT NULL AND clockin != '' AND clockout IS NOT NULL AND clockout != ''";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $startOfWeek, $endOfWeek);
        } elseif ($count_type === "schedule_completion_rate_weekly") {
            // Calculate completion rate: (completed schedules / total schedules) * 100
            $query = "SELECT 
                        ROUND(
                            (SUM(CASE WHEN clockin IS NOT NULL AND clockin != '' AND clockout IS NOT NULL AND clockout != '' THEN 1 ELSE 0 END) / 
                            NULLIF(COUNT(*), 0)
                            ) * 100, 2
                        ) as completion_rate 
                    FROM scheduling 
                    WHERE schedule_date BETWEEN ? AND ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $startOfWeek, $endOfWeek);
        } elseif ($count_type === "user_registration_growth") {
            // Calculate percentage difference between this month and last month using reg_date
            $currentMonthStart = date('Y-m-01');
            $currentMonthEnd = date('Y-m-t');
            $lastMonthStart = date('Y-m-01', strtotime('-1 month'));
            $lastMonthEnd = date('Y-m-t', strtotime('-1 month'));
            
            $query = "SELECT 
                        ROUND(
                            ((SELECT COUNT(*) FROM users WHERE reg_date BETWEEN ? AND ?) - 
                            (SELECT COUNT(*) FROM users WHERE reg_date BETWEEN ? AND ?)
                            ) / NULLIF((SELECT COUNT(*) FROM users WHERE reg_date BETWEEN ? AND ?), 0) * 100, 
                        2) as growth_percentage";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssss", $currentMonthStart, $currentMonthEnd, $lastMonthStart, $lastMonthEnd, $lastMonthStart, $lastMonthEnd);
        } else {
            return $totalRows; // Return 0 if no valid count_type is provided
        }

        // Execute query and fetch the result
        $stmt->execute();
        $stmt->bind_result($totalRows);
        $stmt->fetch();
        $stmt->close();

        return $totalRows;
    }

    public function checkLocationExists($address, $city, $province): bool {
        $sql = "SELECT 1 FROM locations WHERE address = ? AND city = ? AND province = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("sss", $address, $city, $province);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function saveLocation(array $input): array {
        try {
            // Sanitize inputs
            $input = $this->sanitizeInput($input);

            $isUpdate = !empty($input['id']);
            $timestamp = date('Y-m-d H:i:s');

            // Choose query
            if ($isUpdate) {
                $sql = "UPDATE locations SET address = ?, city = ?, province = ?, postal_code = ?, country = ?, latitude = ?, longitude = ? WHERE id = ?";
            } else {
                $sql = "INSERT INTO locations (address, city, province, postal_code, country, latitude, longitude, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            }

            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare SQL: " . $this->db->error);
            }

            // Bind params dynamically
            if ($isUpdate) {
                $stmt->bind_param(
                    "sssssdds",
                    $input['address'],
                    $input['city'],
                    $input['province'],
                    $input['postal_code'],
                    $input['country'],
                    $input['latitude'],
                    $input['longitude'],
                    $input['id']
                );
            } else {
                $stmt->bind_param(
                    "sssssdds",
                    $input['address'],
                    $input['city'],
                    $input['province'],
                    $input['postal_code'],
                    $input['country'],
                    $input['latitude'],
                    $input['longitude'],
                    $timestamp
                );
            }

            if ($stmt->execute()) {
                return ['status' => true, 'message' => $isUpdate ? 'Location updated successfully' : 'Location saved successfully'];
            } else {
                return ['status' => false, 'message' => 'Failed to save location: ' . $stmt->error];
            }

        } catch (Exception $e) {
            return ['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }

    public function deleteLocation($id) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
        date_default_timezone_set($timezone);

        try {
            $stmt = $this->db->prepare("DELETE FROM locations WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Failed to prepare SQL: " . $this->db->error);
            }
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {

                $this->logActivity($_SESSION['better_email'], $_SESSION['user_id'], 'delete-location', 'Deleted a location',  date('Y-m-d H:i:s'));

                return ['status' => true, 'message' => 'Location deleted successfully'];
            }
            return ['status' => false, 'message' => 'Failed to delete location: ' . $stmt->error];
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }
    public function deleteSchedule($id,$email) {
        try {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $userInfo = $this->getUserInfo($_SESSION['better_email']);
            // Define allowed roles for admin access
            $user_role = $userInfo['role'];
            if($userInfo['isAdmin'] > 0 || $this->roleHasPermission($user_role, 'delete.schedule')){
              
                $stmt = $this->db->prepare("DELETE FROM scheduling WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Failed to prepare SQL: " . $this->db->error);
                }
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {

                    $this->logActivity($_SESSION['better_email'], $_SESSION['userid'], 'delete-schedule', 'Deleted a schedule for ' . $email . '',  date('Y-m-d H:i:s'));

                    return ['status' => true, 'message' => 'Schedule deleted successfully'];
                }
                return ['status' => false, 'message' => 'Failed to delete schedule: ' . $stmt->error];

            } else {
                throw new Exception("Unauthorized access. Insufficient privileges.");
            }

        } catch (Exception $e) {
            return ['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }

     public function deleteUser($userId,$email) {
        try {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            // Start transaction
            $this->db->begin_transaction();

            $userInfo = $this->getUserInfo($_SESSION['better_email']);
            // Define allowed roles for admin access
            $user_role = $userInfo['role'];
            if($userInfo['isAdmin'] > 0 || $this->roleHasPermission($user_role, 'delete.staff')){

                // 1. Delete from documents table first (due to likely foreign key constraints)
                $stmt1 = $this->db->prepare("DELETE FROM documents WHERE user_id = ?");
                if (!$stmt1) throw new Exception("Documents delete preparation failed: " . $this->db->error);
                $stmt1->bind_param("i", $userId);
                if (!$stmt1->execute()) throw new Exception("Documents delete failed: " . $stmt1->error);

                // 2. Delete from user_details
                $stmt2 = $this->db->prepare("DELETE FROM user_details WHERE user_id = ?");
                if (!$stmt2) throw new Exception("User details delete preparation failed: " . $this->db->error);
                $stmt2->bind_param("i", $userId);
                if (!$stmt2->execute()) throw new Exception("User details delete failed: " . $stmt2->error);

                // 2. Delete from certificates
                $stmt3 = $this->db->prepare("DELETE FROM certificates WHERE user_id = ?");
                if (!$stmt3) throw new Exception("Certificates delete preparation failed: " . $this->db->error);
                $stmt3->bind_param("i", $userId);
                if (!$stmt3->execute()) throw new Exception("Certificates delete failed: " . $stmt3->error);

                // 3. Finally, delete from scheduling table
                $stmt4 = $this->db->prepare("DELETE FROM scheduling WHERE user_id = ?");
                if (!$stmt4) throw new Exception("Schedule deletes preparation failed: " . $this->db->error);
                $stmt4->bind_param("i", $userId);
                if (!$stmt4->execute()) throw new Exception("Schedule deletes failed: " . $stmt4->error);

                // 3. Finally, delete from activity table
                $stmt5 = $this->db->prepare("DELETE FROM activities WHERE user_id = ?");
                if (!$stmt5) throw new Exception("Activities deletes preparation failed: " . $this->db->error);
                $stmt5->bind_param("i", $userId);
                if (!$stmt5->execute()) throw new Exception("Activities deletes failed: " . $stmt5->error);

                // 3. Finally, delete from users table
                $stmt6 = $this->db->prepare("DELETE FROM users WHERE id = ?");
                if (!$stmt6) throw new Exception("User delete preparation failed: " . $this->db->error);
                $stmt6->bind_param("i", $userId);
                if (!$stmt6->execute()) throw new Exception("User delete failed: " . $stmt6->error);
                
                $this->logActivity($_SESSION['better_email'], $_SESSION['userid'], 'delete-user', 'Deleted user ' . $email. ' account',  date('Y-m-d H:i:s'));

                // Commit if all queries succeed
                $this->db->commit();
                return ['status' => true, 'message' => 'User and all related data deleted successfully'];

            } else {
                throw new Exception("Unauthorized access. Insufficient privileges.");
            }

        } catch (Exception $e) {
            // Rollback on failure
            $this->db->rollback();
            return ['status' => false, 'message' => 'Deletion failed: ' . $e->getMessage()];
        }
    }

    public function saveUser(array $input): array {
        try {
            // Sanitize inputs
            $isUpdate = !empty($input['id']);
            $timestamp = date('Y-m-d H:i:s');
            $status = 0;

            // Begin transaction
            $this->db->begin_transaction();

            if ($isUpdate) {
                $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, location = ?, role = ? WHERE id = ?";
            } else {
                $sql = "INSERT INTO users (firstname, lastname, email, password, location, role, isActive, reg_date) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            }

            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare SQL: " . $this->db->error);
            }

            if ($isUpdate) {
                $stmt->bind_param(
                    "sssssi",
                    $input['firstname'],
                    $input['lastname'],
                    $input['email'],
                    $input['location'],
                    $input['role'],
                    $input['id']
                );
            } else {
                $stmt->bind_param(
                    "ssssssis",
                    $input['firstname'],
                    $input['lastname'],
                    $input['email'],
                    $input['password'],
                    $input['location'],
                    $input['role'],
                    $status,
                    $timestamp
                );
            }

            if (!$stmt->execute()) {
                throw new Exception("Failed to save user: " . $stmt->error);
            }

            // If new user, insert document records
            if (!$isUpdate) {
                $userId = $this->db->insert_id;

                //insert userid into userdetails table
                $detailsStmt = $this->db->prepare("INSERT INTO user_details (user_id) VALUES (?)");
                if (!$detailsStmt) {
                    throw new Exception("Failed to prepare user details insert: " . $this->db->error);
                }
                $detailsStmt->bind_param("i", $userId);
                if (!$detailsStmt->execute()) {
                    throw new Exception("Failed to insert user details: " . $detailsStmt->error);
                }

                $now = $timestamp;

                $fetch_document_types = $this->getDocuments();

                $expectedDocs = [
                    'education_doc'           => 'Education Document (DSW/SSW/BSW)',
                    'driver_licence_frontpage' => 'Driver Licence (Front Page)',
                    'driver_license_backpage'  => 'Driver Licence (Back Page)',
                    'resume'                   => 'Resume',
                    'driver_abstract'          => 'Driver Abstract',
                    'insurance_pink_copy'      => 'Insurance Pink Copy',
                    'aoda_certificate'         => 'AODA Certificate',
                    'whims_certificate'        => 'WHMIS Certificate',
                    'safe_management_group'    => 'Valid Safe Management Group',
                    'void_check'               => 'Void Cheque',
                    'reference_1'              => 'Reference 1',
                    'reference_2'              => 'Reference 2',
                    'reference_3'              => 'Reference 3',
                    'vunerable_sector_check'   => 'Vulnerable Sector Check',
                    'medical_fit_letter'       => 'Medical Fitness Letter',
                    'tuberculosis'             => 'Tuberculosis Test',
                    'covid_vaccine_1'          => 'COVID Vaccine Dose 1',
                    'covid_vaccine_2'          => 'COVID Vaccine Dose 2',
                    'covid_vaccine_3'          => 'COVID Vaccine Dose 3 (optional)',
                    'first_aid_and_cpr'        => 'First Aid & CPR'
                ];

                $expectedCert = [
                    'certificate_1' => 'Certificate 1',
                    'certificate_2' => 'Certificate 2',
                    'certificate_3' => 'Certificate 3',
                    'certificate_4' => 'Certificate 4',
                    'certificate_5' => 'Certificate 5'
                ];


                // Define required doc tags
                $docStmt = $this->db->prepare("
                    INSERT INTO documents (user_id, title, doc_tag, created_on, updated_on, optional)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                if (!$docStmt) {
                    throw new Exception("Failed to prepare document insert: " . $this->db->error);
                }

                foreach ($fetch_document_types['documents'] as $docs) {
                    $optional = $docs['is_required'] === true ? 0 : 1;
                    $docStmt->bind_param("issssi", $userId, $docs['name'], $docs['tag'], $now, $now, $optional);
                    if (!$docStmt->execute()) {
                        throw new Exception("Failed to insert document record for {$docs['tag']}: " . $docStmt->error);
                    }
                }

                $docStmt->close();

                // Define required cert tags
                $certStmt = $this->db->prepare("
                    INSERT INTO certificates (user_id, title, cert_tag, created_on, updated_on)
                    VALUES (?, ?, ?, ?, ?)
                ");
                if (!$certStmt) {
                    throw new Exception("Failed to prepare certificate insert: " . $this->db->error);
                }

                foreach ($expectedCert as $tag => $title) {
                    $certStmt->bind_param("issss", $userId, $title, $tag, $now, $now);
                    if (!$certStmt->execute()) {
                        throw new Exception("Failed to insert certificate record for $tag: " . $certStmt->error);
                    }
                }

                $certStmt->close();
            }

            $stmt->close();

            $this->db->commit();
            return ['status' => true, 'message' => $isUpdate ? 'User updated successfully' : 'User saved successfully'];

        } catch (Exception $e) {
            $this->db->rollback();
            return ['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }


    public function logActivity($user, $user_id, $action, $description, $date) {
        $stmt = $this->db->prepare("INSERT INTO activities (action, user, user_id, description, date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $action, $user, $user_id, $description, $date);
        $stmt->execute();
        $stmt->close();
    }

    public function updatePermissionRole($roleId, $permission_id, $status)
    {

        try {
            $this->db->begin_transaction();

            // First, check if the record exists
            $checkStmt = $this->db->prepare("SELECT id, is_active FROM role_permissions WHERE role_id = ? AND permission_id = ?");
            $checkStmt->bind_param("ii", $roleId, $permission_id);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $existing = $result->fetch_assoc();
            $checkStmt->close();

            $isActive = $status === 'true' ? 1 : 0;

            if ($existing) {
                // Update existing record
                error_log("Updating existing record");
                $stmt = $this->db->prepare("UPDATE role_permissions SET is_active = ? WHERE role_id = ? AND permission_id = ?");
                $stmt->bind_param("iii", $isActive, $roleId, $permission_id);
            } else {
                // Insert new record
                error_log("Inserting new record");
                $stmt = $this->db->prepare("INSERT INTO role_permissions (role_id, permission_id, is_active) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $roleId, $permission_id, $isActive);
            }

            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $this->db->error);
            }

            if (!$stmt->execute()) {
                throw new Exception("Failed to execute: " . $stmt->error);
            }

            $affectedRows = $stmt->affected_rows;
            $stmt->close();
            $this->db->commit();


            return [
                'status' => true,
                'message' => $isActive ? 'Role permission activated successfully' : 'Role permission deactivated successfully'
            ];

        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Error in updatePermissionRole: " . $e->getMessage());
            return [
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function getScheduleById($scheduleId)
    {
        $stmt = $this->db->prepare("SELECT * FROM scheduling WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->db->error);
        }

        $stmt->bind_param("i", $scheduleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $schedule = $result->fetch_assoc();
        $stmt->close();

        return [
            'status' => true,
            'data' => $schedule
        ];

        return $schedule ?: null;
    }

    public function getDocuments() {
        try {
            $sql = "SELECT * FROM document_types order BY sort_order ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $documents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $alldoc = [];
            foreach ($documents as &$doc) {
                $alldoc[] = [
                    'id' => $doc['id'],
                    'name' => $doc['name'],
                    'tag' => $doc['tag'],
                    'sort_order' => $doc['sort_order'],
                    'is_required' => (bool)$doc['is_required'],
                ];
            }
            
            return [
                'status' => true,
                'documents' => $alldoc
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    // Get single document
    public function getSingleDocument($id) {
        try {
           
            $sql = "SELECT * FROM document_types WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $document = $stmt->get_result()->fetch_assoc();
            
            return [
                'status' => true,
                'document' => $document
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function saveDocument($id, $name, $tag, $sort_order, $is_required) {
        try {
            
            if ($id > 0) {
                // Update existing document
                $sql = "UPDATE document_types SET name = ?, tag = ?, sort_order = ?, is_required = ? 
                        WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param('ssiii', $name, $tag, $sort_order, $is_required, $id);

            } else {
                // Insert new document
                $sql = "INSERT INTO document_types (name, tag, sort_order, is_required) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param('ssii', $name, $tag, $sort_order, $is_required);
            }
            
            $stmt->execute();
            
            return [
                'status' => true,
                'message' => 'Document saved successfully'
            ];
            
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function deleteDocumentType($id) {
        try {
            $sql = "DELETE FROM document_types WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            
            return [
                'status' => true,
                'message' => 'Document type deleted successfully'
            ];
            
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function fetchAllRoles() {
        try {
            $sql = "SELECT * FROM roles ORDER BY id ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $roles = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
            return [
                'status' => true,
                'roles' => $roles
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function addRole($name, $description = '', $tag = null, $welcomeMessage = '', $id = 0, $activation_message = '')
    {
        try {
            $this->db->begin_transaction();

            // Validate required fields
            if (empty(trim($name))) {
                throw new Exception("Role name is required");
            }

            if (empty(trim($description))) {
                throw new Exception("Role description is required");
            }

            // Generate tag from name if not provided
            if (empty($tag)) {
                $tag = $this->generateRoleTag($name);
            }

            // Validate welcome message
            if (empty(trim($welcomeMessage))) {
                throw new Exception("Welcome message is required");
            }

            // Validate activation message
            if (empty(trim($activation_message))) {
                throw new Exception("Activation message is required");
            }

            // Check if role name or tag already exists
            if ($id == 0 && $this->roleExists($name, $tag)) {
                throw new Exception("Role name or tag already exists");
            }

            // Prepare and execute insert statement
            if($id > 0) {
                $stmt = $this->db->prepare("UPDATE roles SET name = ?, tag = ?, description = ?, role_message = ?, activation_message = ? WHERE id = ?");
                $stmt->bind_param("sssssi", $name, $tag, $description, $welcomeMessage, $activation_message, $id);
            } else {
                $stmt = $this->db->prepare("INSERT INTO roles (name, tag, description, role_message, activation_message) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $name, $tag, $description, $welcomeMessage, $activation_message);
            }

            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $this->db->error);
            }

            if (!$stmt->execute()) {
                throw new Exception("Failed to execute: " . $stmt->error);
            }

            $roleId = $this->db->insert_id;
            $stmt->close();
            $this->db->commit();

            return [
                'status' => true,
                'message' => $id > 0 ? 'Role updated successfully' : 'Role created successfully',
            ];

        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Error in addRole: " . $e->getMessage());
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function deleteRole($roleId)
    {
        try {
            $this->db->begin_transaction();

            // Validate role ID
            if (empty($roleId) || !is_numeric($roleId)) {
                throw new Exception("Invalid role ID");
            }

            // First, delete all permissions associated with this role
            $this->deleteRolePermissions($roleId);

            // Then delete the role itself
            $stmt = $this->db->prepare("DELETE FROM roles WHERE id = ?");
            
            if (!$stmt) {
                throw new Exception("Failed to prepare delete statement: " . $this->db->error);
            }

            $stmt->bind_param("i", $roleId);

            if (!$stmt->execute()) {
                throw new Exception("Failed to delete role: " . $stmt->error);
            }

            $affectedRows = $stmt->affected_rows;
            $stmt->close();
            $this->db->commit();

            if ($affectedRows > 0) {
                return [
                    'status' => true,
                    'message' => 'Role deleted successfully',
                ];
            } else {
                throw new Exception("No role was deleted");
            }

        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Error in deleteRole: " . $e->getMessage());
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function generateRoleTag($name)
    {
        // Convert to lowercase, replace spaces with underscores, and remove non-alphanumeric characters
        $tag = strtolower($name);
        $tag = preg_replace('/\s+/', '_', $tag);
        $tag = preg_replace('/[^a-z0-9_]/', '', $tag);
        return $tag;
    }

    private function roleExists($name, $tag)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM roles WHERE name = ? OR tag = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->db->error);
        }

        $stmt->bind_param("ss", $name, $tag);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['count'] > 0;
    }

    // Delete all permissions for a role
    private function deleteRolePermissions($roleId)
    {
        $stmt = $this->db->prepare("DELETE FROM role_permissions WHERE role_id = ?");
        
        if (!$stmt) {
            throw new Exception("Failed to prepare permissions delete statement: " . $this->db->error);
        }

        $stmt->bind_param("i", $roleId);

        if (!$stmt->execute()) {
            throw new Exception("Failed to delete role permissions: " . $stmt->error);
        }

        $deletedPermissions = $stmt->affected_rows;
        $stmt->close();
        
        return $deletedPermissions;
    }

    public function roleHasPermission($roleTag, $permissionName) {
        // Fetch the role ID from the role tag
        $roleQuery = $this->db->prepare("SELECT id FROM roles WHERE tag = ?");
        $roleQuery->bind_param("s", $roleTag);
        $roleQuery->execute();
        $roleResult = $roleQuery->get_result()->fetch_assoc();

        if (!$roleResult) {
            return false; // Role not found
        }
        $roleId = $roleResult['id'];

        // Fetch permission ID from permission name
        $permQuery = $this->db->prepare("SELECT id FROM permissions WHERE name = ?");
        $permQuery->bind_param("s", $permissionName);
        $permQuery->execute();
        $permResult = $permQuery->get_result()->fetch_assoc();

        if (!$permResult) {
            return false; // Permission not found
        }
        $permId = $permResult['id'];

        // Check if role_permission exists and is active
        $checkQuery = $this->db->prepare("
            SELECT COUNT(*) AS cnt 
            FROM role_permissions 
            WHERE role_id = ? AND permission_id = ? AND is_active = 1
        ");
        $checkQuery->bind_param("ii", $roleId, $permId);
        $checkQuery->execute();
        $result = $checkQuery->get_result()->fetch_assoc();

        return $result['cnt'] > 0;
    }

    public function getRoleByIdOrTag($role) {
        $message = '';
        $stmt = $this->db->prepare("SELECT * FROM roles WHERE tag = ? OR id = ?");
        $stmt->bind_param("si", $role, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $message = ['status' => true, 'data' => $result->fetch_assoc()];
        } else {
            $message = ['status' => false, 'message' => 'Role not found'];
        }
        
        return $message;
    }

    public function saveAgency($id, $name, $email, $phone, $address, $province, $zip) {
    
    // Validate inputs
        if (empty($name) || empty($email) || empty($address)) {
            return ['status' => false, 'message' => 'Name, email, and address are required'];
        }
        
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['status' => false, 'message' => 'Invalid email format'];
        }

        $date = date('Y-m-d H:i:s');

        try {
            if ($id > 0) {
                $sql = "UPDATE agencies SET name = ?, email = ?, phone = ?, address = ?, province = ?, zip = ? WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("ssssssi", $name, $email, $phone, $address, $province, $zip, $id);
            } else {
                $sql = "INSERT INTO agencies (name, email, address, phone, province, zip, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("sssssss", $name, $email, $address, $phone, $province, $zip, $date);
            }
            
            $stmt->execute();
            $affected = $stmt->affected_rows;
            $insertId = $stmt->insert_id;
            $stmt->close();
            
            return [
                'status' => $affected > 0,
                'message' => $affected > 0 ? ($id > 0 ? 'Agency updated successfully' : 'Agency created successfully') : 'No changes made',
                'insert_id' => $insertId
            ];
            
        } catch (mysqli_sql_exception $e) {
            // Handle duplicate key errors
            if ($e->getCode() === 1062) { // MySQL duplicate entry error code
                return ['status' => false, 'message' => 'Email or address already exists'];
            }
            return ['status' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function deleteAgency($id){
        try {
            $sql = "DELETE FROM agencies WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $affected = $stmt->affected_rows;
            $stmt->close();
            return [
                'status' => $affected > 0,
                'message' => $affected > 0 ? 'Agency deleted successfully' : 'No changes made'
            ];
        } catch (mysqli_sql_exception $e) {
            return ['status' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function fetchAgencies($id = 0) {
        try {
            if ($id > 0) {
                $sql = "SELECT * FROM agencies WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $id);
            } else {
                $sql = "SELECT * FROM agencies ORDER BY name ASC";
                $stmt = $this->db->prepare($sql);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            
            $message = $id > 0 
                ? ($result->num_rows > 0 ? 'Agency found' : 'No agency found with this ID')
                : ($result->num_rows > 0 ? 'Agencies retrieved successfully' : 'No agencies found');
                
            return [
                'status' => $result->num_rows > 0,
                'data' => $data,
                'message' => $message
            ];
            
        } catch (mysqli_sql_exception $e) {
            return [
                'status' => false, 
                'data' => [],
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public function saveAgencystaff($id, $firstname, $lastname, $email, $phone, $address, $agency){
        // Validate inputs
        if (empty($firstname) || empty($lastname) || empty($email) || empty($address)) {
            return ['status' => false, 'message' => 'Firstname, lastname, email, and address are required'];
        }
        
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['status' => false, 'message' => 'Invalid email format'];
        }

        $date = date('Y-m-d H:i:s');

        try {
            if ($id > 0) {
                $sql = "UPDATE agency_staffs SET firstname = ?, lastname = ?, email = ?, address = ?, phone = ?, agency_id = ? WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("ssssssi", $firstname, $lastname, $email, $address, $phone, $agency, $id);
            } else {
                $sql = "INSERT INTO agency_staffs (firstname, lastname, email, address, phone, created_on, agency_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("ssssssi", $firstname, $lastname, $email, $address, $phone, $date, $agency);
            }
            
            $stmt->execute();
            $affected = $stmt->affected_rows;
            $insertId = $stmt->insert_id;
            $stmt->close();
            
            return [
                'status' => $affected > 0,
                'message' => $affected > 0 ? ($id > 0 ? 'Staff details updated successfully' : 'Staff details created successfully') : 'No changes made',
                'insert_id' => $insertId
            ];
            
        } catch (mysqli_sql_exception $e) {
            // Handle duplicate key errors
            if ($e->getCode() === 1062) { // MySQL duplicate entry error code
                return ['status' => false, 'message' => 'Phone or email already exists'];
            }
            return ['status' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function deleteAgencystaff($id) {
        try {
            $sql = "DELETE FROM agency_staffs WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $affected = $stmt->affected_rows;
            $stmt->close();
            return [
                'status' => $affected > 0,
                'message' => $affected > 0 ? 'Staff deleted successfully' : 'No changes made'
            ];
        } catch (mysqli_sql_exception $e) {
            return ['status' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

     public function getAgencyStaffs() {
        try {

            // SQL query to fetch staff for the specified location
            $sql = "
                SELECT 
                    s.id,
                    s.email,
                    CONCAT(s.firstname, ' ', s.lastname) AS staff_name,
                    a.name AS agency_name
                FROM agency_staffs s
                LEFT JOIN agencies a ON s.agency_id = a.id
                ORDER BY s.firstname, s.lastname
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $staff = [];

            while ($row = $result->fetch_assoc()) {
                $staff[] = [
                    'id' => $row['id'],
                    'name' => $row['staff_name'],
                    'email' => $row['email'],
                    'agency_name' => $row['agency_name']
                ];
            }

            $stmt->close();

            return [
                'status' => true,
                'data' => $staff,
                'count' => count($staff)
            ];

        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Error fetching staff: ' . $e->getMessage(),
                'data' => [],
                'count' => 0
            ];
        }
    }

    public function saveStaffAgencySchedules($schedules, $locationId) {
        try {

            // Validate input - $schedules should already be a PHP array
            if (empty($schedules) || !is_array($schedules)) {
                throw new Exception("No schedule data provided or invalid format");
            }

            $savedCount = 0;
            $failedSchedules = [];
            $skippedSchedules = 0;

            // Begin transaction for data consistency
            $this->db->begin_transaction();

            foreach ($schedules as $index => $schedule) {
                try {
                    // Debug: Log each schedule
                    error_log("Processing schedule {$index}: " . print_r($schedule, true));

                    // Skip schedules that don't have all required fields
                    if (empty($schedule['start_time']) || empty($schedule['end_time']) || empty($schedule['shift_type'])) {
                        error_log("Skipping schedule {$index} - missing required fields");
                        $skippedSchedules++;
                        continue;
                    }

                    // Validate other required fields
                    if (empty($schedule['staff_id']) || empty($schedule['schedule_date']) || empty($schedule['pay_per_hour'])) {
                        throw new Exception("Missing required fields for schedule at index {$index}");
                    }

                    // Use the agency_id from parameter for consistency
                    $locationId = (int)$locationId;

                    // Validate staff exists
                    if (!$this->validateStaffExists($schedule['staff_id'])) {
                        throw new Exception("Staff member does not exist");
                    }

                    // Check for duplicate schedule
                    if ($this->scheduleExists($schedule['staff_id'], $schedule['schedule_date'])) {
                        throw new Exception("Schedule already exists for a staff member on this date");
                    }

                    // Prepare schedule data
                    $staffId = (int)$schedule['staff_id'];
                    $scheduleDate = $this->db->real_escape_string($schedule['schedule_date']);
                    $startTime = $this->db->real_escape_string($schedule['start_time']);
                    $endTime = $this->db->real_escape_string($schedule['end_time']);
                    $shiftType = $this->db->real_escape_string($schedule['shift_type']);
                    $overnightType = $this->db->real_escape_string($schedule['overnight_type'] ?? '');
                    $payPerHour = (float)$schedule['pay_per_hour'];

                    // Get agency name
                    $locationName = $this->getAgencyName($locationId);
                    if (!$locationName) {
                        throw new Exception("Could not find location name");
                    }

                    // Insert schedule
                    $sql = "
                        INSERT INTO agency_staffs_schedule (
                            staff_id,
                            location_id, 
                            location_name,
                            start_time, 
                            end_time,
                            shift_type,
                            schedule_date,
                            pay_per_hour,
                            overnight_type,
                            created_at,
                            updated_at
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                    ";

                    $stmt = $this->db->prepare($sql);
                    if (!$stmt) {
                        throw new Exception("Failed to prepare statement: " . $this->db->error);
                    }

                    $stmt->bind_param(
                        'iisssssds', 
                        $staffId,
                        $locationId, 
                        $locationName,
                        $startTime,
                        $endTime,
                        $shiftType,
                        $scheduleDate,
                        $payPerHour,
                        $overnightType
                    );

                    if (!$stmt->execute()) {
                        throw new Exception("Failed to execute statement: " . $stmt->error);
                    }

                    $stmt->close();
                    $savedCount++;
                    error_log("Successfully saved schedule {$index}");

                } catch (Exception $e) {
                    error_log("Failed to save schedule at index {$index}: " . $e->getMessage());
                    $failedSchedules[] = [
                        'staff_id' => $schedule['staff_id'] ?? 'unknown',
                        'schedule_date' => $schedule['schedule_date'] ?? 'unknown',
                        'error' => $e->getMessage()
                    ];
                }
            }

            // Commit transaction if we have any successful inserts
            if ($savedCount > 0) {
                $this->db->commit();
                return [
                    'status' => true,
                    'saved_count' => $savedCount,
                    'skipped_count' => $skippedSchedules,
                    'failed_count' => count($failedSchedules),
                    'message' => "Successfully saved {$savedCount} schedules"
                ];
            } else {
                $this->db->rollback();
                return [
                    'status' => false,
                    'saved_count' => 0,
                    'skipped_count' => $skippedSchedules,
                    'failed_count' => count($failedSchedules),
                    'message' => "No schedules were saved"
                ];
            }

        } catch (Exception $e) {
           
            $this->db->rollback();
            
            return [
                'status' => false,
                'saved_count' => 0,
                'message' => 'Error saving schedules: ' . $e->getMessage()
            ];
        }
    }

    // Helper function to get agency name
    private function getAgencyName($locationId) {
        $sql = "SELECT CONCAT(address, ' , ', city) AS name FROM locations WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $locationId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['name'] ?? null;
    }

    // Helper function to validate staff exists
    private function validateStaffExists($staffId) {
        $sql = "SELECT COUNT(*) as count FROM agency_staffs WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $staffId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['count'] > 0;
    }

    // Check for duplicate schedule


    private function validateStaffLocation($staffId, $agencyId) {
        $sql = "SELECT COUNT(*) as count FROM agency_staffs WHERE id = ? AND agency_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ii', $staffId, $agencyId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['count'] > 0;
    }

    /**
     * Check if schedule already exists for staff on date
     */
    private function scheduleExists($staffId, $scheduleDate) {

        $sql = "SELECT COUNT(*) as count FROM agency_staffs_schedule WHERE staff_id = ? AND schedule_date = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('is', $staffId, $scheduleDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['count'] > 0;
    }

    /**
     * Get staff email from staff ID
     */
    private function getStaffEmail($staffId) {
        $sql = "SELECT email FROM agency_staffs WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $staffId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['email'] ?? null;
    }




}