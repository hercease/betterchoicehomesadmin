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
        $protocol = $isHttps ? 'https://' . $host : 'http://' . $host .'/betterchoicehomeadmin';

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
        $stmt = $this->db->prepare("SELECT firstname, lastname, reg_date FROM users WHERE NOT isAdmin = ? ORDER BY id DESC LIMIT 5");
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
                $searchQuery = " WHERE doc-tag LIKE ?";
                $params[] = "%$searchValue%";
                $paramTypes .= "s";
            }

            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";

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
            } else if($tabletype === 'usercertificates') {

                $status = $row['isApproved'] ? "<span class='badge bg-success'>Verified</span>" : "<span class='badge bg-danger'>Pending verification</span>";

                $data[] = [
                    "id" => ++$i,
                    "tag" => $row['title'],
                    "name" => $row['certificate_name'],
                    "status" => $status,
                    "uploaded_date" => date('Y-m-d', strtotime($row['created_on'])),
                    "action" => (!empty($row['certificate_name']) ? "<a data-file='/public/assets/img/".htmlspecialchars($row['certificate_name'])."' data-bs-toggle='modal' data-bs-target='#previewModal' class='btn btn-sm btn-outline-primary me-1 preview-btn'>
                                        <i class='fas fa-eye'></i>
                                </a>
                                <a href='/public/assets/img/".htmlspecialchars($row['certificate_name'])."' download class='btn btn-sm btn-outline-success me-1'>
                                    <i class='fas fa-download'></i>
                                </a>
                                <a data-id='".$row['id']."' data-type='certificates' class='btn btn-sm btn-outline-danger del_document me-1'>
                                    <i class='fas fa-trash'></i>
                                </a>" . 
                                ($row['isApproved'] ? 
                                "<a data-id='".$row['id']."' data-type='certificates' data-status='0' class='btn btn-sm btn-outline-warning decision-btn'>
                                    <i class='fas fa-thumbs-down'></i>
                                </a>" : 
                                "<a data-id='".$row['id']."' data-type='certificates' data-status='1' class='btn btn-sm btn-outline-success decision-btn'>
                                    <i class='fas fa-thumbs-up'></i>
                                </a>") 

                                :

                                "<a class='btn btn-sm btn-outline-primary me-1 disabled'>
                                    <i class='fas fa-eye'></i>
                                </a>
                                <a class='btn btn-sm btn-outline-success me-1 disabled'>
                                    <i class='fas fa-download'></i>
                                </a>
                                <a class='btn btn-sm btn-outline-danger me-1 disabled'>
                                    <i class='fas fa-trash'></i>
                                </a>
                                <a class='btn btn-sm btn-outline-success disabled'>
                                    <i class='fas fa-thumbs-up'></i>
                                </a>")
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
                $query = "SELECT COUNT(*) AS count FROM users WHERE role IN ('manager', 'staff', 'hr', 'scheduler', 'accountant', 'director of service')";
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
    
        // Determine query based on count type
        if ($count_type === "total_users") {
            $query = "SELECT COUNT(*) FROM users WHERE role IN ('manager', 'staff', 'hr', 'scheduler', 'accountant', 'directorofservice')";
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
        }  else {
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
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }

     public function deleteUser($userId,$email) {
        try {
            // Start transaction
            $this->db->begin_transaction();

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
            $status = $input['role'] == "staff" ? 0 : 1;

            // Begin transaction
            $this->db->begin_transaction();

            if ($isUpdate) {
                $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, location = ? WHERE id = ?";
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
                    "ssssi",
                    $input['firstname'],
                    $input['lastname'],
                    $input['email'],
                    $input['location'],
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

                foreach ($expectedDocs as $tag => $title) {
                    $optional = ($tag === 'covid_vaccine_3') ? 1 : 0;
                    $docStmt->bind_param("issssi", $userId, $title, $tag, $now, $now, $optional);
                    if (!$docStmt->execute()) {
                        throw new Exception("Failed to insert document record for $tag: " . $docStmt->error);
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



}