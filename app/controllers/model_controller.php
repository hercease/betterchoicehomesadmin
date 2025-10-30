<?php
 class ModelController{
    private $db;
    private $allmodels;

    public function __construct($db) {
        $this->db = $db;
        $this->allmodels = new allmodels($db);
    }

    // Method to handle the login logic
    public function handleLogin() {

        $this->db->begin_transaction();

        try{

            $requiredFields = ['email', 'password'];
            $input = [];
            foreach ($requiredFields as $field) {
                $input[$field] = $this->allmodels->sanitizeInput($_POST[$field] ?? '');
                if (empty($input[$field])) {
                    throw new Exception(ucfirst($field) . " is required");
                }
            }

            // Validate input
            $userInfo = $this->allmodels->getUserInfo($input['email']);
            if (!$userInfo) {
                throw new Exception("Invalid email or password");
            }

            if (!password_verify($input['password'], $userInfo['password'])){
                throw new Exception("Invalid email or password");
            }

            // Define allowed roles for admin access
            $allowedRoles = ['hr', 'manager', 'accountant', 'scheduler', 'dos', 'super-admin'];
            $fetch_all_roles = $this->allmodels->fetchAllRoles()['roles'];
            $role_tags = array_column($fetch_all_roles, 'tag');

            // Check if user is either an admin or has an allowed role
            if ($userInfo['isAdmin'] > 0 || in_array($userInfo['role'], $role_tags)) {
            //error_log(print_r($userInfo,true));

            session_start();
            // If we reach this point, the login is successful
            $_SESSION['better_email'] = $userInfo['email'];
            $_SESSION['userid'] = $userInfo['id'];
            $_SESSION['timezone'] = $this->allmodels->sanitizeInput($_POST['timezone']) ?? 'America/Toronto';
            date_default_timezone_set($_SESSION['timezone']);

            $this->allmodels->logActivity($userInfo['email'], $userInfo['id'], 'login', 'User logged in successfully', date('Y-m-d H:i:s'));

            echo json_encode([
                'status' => true,
                'message' => 'Login was successful, redirecting you to dashboard...',
            ]);

            } else {
              throw new Exception("Unauthorized access. Insufficient privileges.");
            }

        } catch (Exception $e) {
            // Handle any exceptions that occur during the login process
            $this->db->rollback();
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
       
    }

     public function processForgotPassword(){
        try{

            $email = $this->allmodels->sanitizeInput($_POST['email']);
            $userInfo = $this->allmodels->getUserInfo($email);

            if (!$userInfo) {
                throw new Exception("User not found");
            }

            $firstName = $userInfo['firstname'] ?? '';
            $password = $this->allmodels->generateRandomPassword(7);
            $newPassword = password_hash($password, PASSWORD_DEFAULT);
            $year = date("Y");

            $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $newPassword, $email);
            $stmt->execute();
            $stmt->close();

            $subject = "Password Reset - Better Choice Group Homes";

        $message = <<<EMAIL
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <title>Password Reset - Better Choice Homes</title>
            <style>
                body { font-family: 'Segoe UI', sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; color: #333; }
                .container { max-width: 600px; margin: 30px auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
                .header { background-color: #0a3d62; padding: 20px; color: #ffffff; text-align: center; }
                .body { padding: 30px; }
                .body h2 { color: #0a3d62; margin-top: 0; }
                .password-box {
                    background-color: #f1f3f5;
                    padding: 15px;
                    border-radius: 5px;
                    font-size: 18px;
                    font-weight: bold;
                    text-align: center;
                    letter-spacing: 1px;
                    color: #0a3d62;
                    margin: 20px 0;
                }
                .footer { text-align: center; font-size: 13px; color: #888; padding: 20px; }
            </style>
            </head>
            <body>
            <div class="container">
                <div class="header">
                    <h1>Password Reset</h1>
                </div>
                <div class="body">
                    <h2>Hello {$firstName},</h2>
                    <p>You recently requested to reset your password for your Better Choice Homes account.</p>
                    <p>Here is your new temporary password:</p>
                    <div class="password-box">{$password}</div>
                    <p>For your security, please log in and change your password immediately.</p>
                    <p>If you did not request this change, please contact our support team right away.</p>
                </div>
                <div class="footer">
                    &copy; {$year} Better Choice Group Homes. All rights reserved.
                </div>
            </div>
            </body>
            </html>
            EMAIL;

            $this->allmodels->sendmail($email, $firstName, $message, $subject);

            echo json_encode([
                'status' => true,
                'message' => 'Password reset email sent successful'
            ]);

        } catch(Exception $th){
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
       

    }

    public function fetchAllUsersData() {
        session_start();
        // Fetch data for DataTables
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
        $rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $searchValue = $this->allmodels->sanitizeInput($_POST['search']['value']); // Search value
        
        $data = $this->allmodels->fetchTableRows($start,$rowperpage,$searchValue,"allusers");
        $response = array(
                "draw" => intval($draw),
                "recordsTotal" => $data['recordsTotal'],
                "recordsFiltered" => $data['totalRecordsWithFilter'],
                "data" => $data['data']
        );

        echo json_encode($response);
    } 

        public function fetchAllLocationsData() {
            session_start();
            // Fetch data for DataTables
            $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
            $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
            $rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
            $searchValue = $this->allmodels->sanitizeInput($_POST['search']['value']); // Search value
            
            $data = $this->allmodels->fetchTableRows($start,$rowperpage,$searchValue,"locations");
            $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $data['recordsTotal'],
                    "recordsFiltered" => $data['totalRecordsWithFilter'],
                    "data" => $data['data']
            );

            echo json_encode($response);
        }

        public function fetchAllScheduleData() {
            session_start();
            // Fetch data for DataTables
            $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
            $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
            $rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
            $searchValue = $this->allmodels->sanitizeInput($_POST['search']['value']); // Search value
            
            $data = $this->allmodels->fetchTableRows($start,$rowperpage,$searchValue,"allschedules");
            $response = array(
                "draw" => intval($draw),
                "recordsTotal" => $data['recordsTotal'],
                "recordsFiltered" => $data['totalRecordsWithFilter'],
                "data" => $data['data']
            );

            echo json_encode($response);
        } 

        public function fetchUserDocumentData() {
            session_start();
            // Fetch data for DataTables
            $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
            $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
            $rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
            $searchValue = $this->allmodels->sanitizeInput($_POST['search']['value']); // Search value
            $data = $this->allmodels->fetchTableRows($start,$rowperpage,$searchValue,"userdocuments", $_POST['id']);
            $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $data['recordsTotal'],
                    "recordsFiltered" => $data['totalRecordsWithFilter'],
                    "data" => $data['data']
            );

            echo json_encode($response);
        } 

        public function fetchUserCertificateData() {
            session_start();
            // Fetch data for DataTables
            $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
            $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
            $rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
            $searchValue = $this->allmodels->sanitizeInput($_POST['search']['value']); // Search value
            $data = $this->allmodels->fetchTableRows($start,$rowperpage,$searchValue,"usercertificates", $_POST['id']);
            $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $data['recordsTotal'],
                    "recordsFiltered" => $data['totalRecordsWithFilter'],
                    "data" => $data['data']
            );

            echo json_encode($response);
        } 

        public function getCoordinates(){
            $address = $this->allmodels->sanitizeInput($_POST['address']);
            if (!isset($address) || empty($address)) {
                echo json_encode(['Address is required']);
                exit;
            }

            $fetchcoordinates = $this->allmodels->getCoordinatesFromAddress($address,OPENCAGE_API_KEY);
            echo json_encode($fetchcoordinates);
        }

        public function ProcessLocation(){

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $this->db->begin_transaction();

            try {

                $input = [];
                $requiredFields = ['country', 'address', 'city', 'province', 'longitude', 'latitude', 'postal_code'];
                foreach ($requiredFields as $field) {
                    $input[$field] = $this->allmodels->sanitizeInput($_POST[$field] ?? '');
                    if (empty($input[$field])) {
                        throw new Exception(ucfirst($field) . " is required");
                    }
                }

                $userInfo = $this->allmodels->getUserInfo($_SESSION['better_email']);
                // Define allowed roles for admin access
                $user_role = $userInfo['role'];
                if($userInfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'create.location')){
                  

                    $input['id'] = isset($_POST['id']) ? intval($_POST['id']) : null;
                    //check if address exists
                    $existingLocation = !isset($_POST['id']) && $this->allmodels->checkLocationExists($input['address'], $input['city'], $input['province']);
                    if ($existingLocation) {
                        throw new Exception("This address already exists in the database");
                    }

                    $timezone = $_POST['timezone'] ?? 'America/Toronto';
                    date_default_timezone_set($timezone);
                    //save into database
                    $result = $this->allmodels->saveLocation($input);

                    if ($result['status']==false) {
                        $msg = isset($_POST['id']) ? "Failed to update location" : "Failed to save location";
                        throw new Exception($msg);
                    }

                    $logmessage = isset($_POST['id']) ? 'Updated Location: ' . $input['address'] . ' successfully' : 'Saved Location: ' . $input['address'] . ' successfully';
                    $this->allmodels->logActivity($_SESSION['better_email'], $_SESSION['userid'], 'update-location', $logmessage,  date('Y-m-d H:i:s'));


                    $this->db->commit();
                    echo json_encode([
                        'status' => true,
                        'message' => isset($_POST['id']) ? 'Location updated successfully' : 'Location saved successfully'
                    ]);

                } else {
                    throw new Exception("Unauthorized access. Insufficient privileges.");
                }

            } catch (Exception $e) {
                $this->db->rollback();
                echo json_encode([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }

        public function ProcessCreateUser() {
        if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['better_email'])) {
                echo json_encode(['status' => false, 'message' => 'Unauthorized access']);
                return;
            }
        $this->db->begin_transaction();

        try {
            $input = [];
            $requiredFields = $_POST['role'] == 'staff' ? ['firstname', 'lastname', 'email', 'role', 'location'] : ['firstname', 'lastname', 'email', 'role'];

            foreach ($requiredFields as $field) {
                $input[$field] = $this->allmodels->sanitizeInput($_POST[$field] ?? '');
                if (empty($input[$field])) {
                    throw new Exception(ucfirst($field) . " is required");
                }
            }

            $userInfo = $this->allmodels->getUserInfo($_SESSION['better_email']);
            // Define allowed roles for admin access
            $user_role = $userInfo['role'];
            if($userInfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'create.staff')){
             

            if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format");
            }

            $isNew = !isset($_POST['id']);
            if ($isNew && $this->allmodels->getUserInfo($input['email'])) {
                throw new Exception("Email already exists");
            }

            $timezone = $_POST['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);

            $password = $this->allmodels->generateRandomPassword(7);
            $input['password'] = password_hash($password, PASSWORD_DEFAULT);
            $input['id'] = isset($_POST['id']) ? intval($_POST['id']) : null;

            $result = $this->allmodels->saveUser($input);
            if ($result['status'] == false) {
                throw new Exception($isNew ? $result['message'] : $result['message']);
            }

            $this->allmodels->logActivity($_SESSION['better_email'], $_SESSION['userid'], $isNew ? 'register-user' : 'update-user', $isNew ? 'Processed the creation of ' . $input['email'] . ' account' : 'Updated ' . $input['email'] . ' account',  date('Y-m-d H:i:s'));

            $name = $input['firstname'] . ' ' . $input['lastname'];
            $loginUrl = BASE_URL . 'login';
            $year = date('Y');
            $logo = BASE_URL . 'public/assets/img/better-icon-removebg-preview.png';
            if($isNew){

                $fetch_role_details = $this->allmodels->getRoleByIdOrTag($input['role']);
                $roleMessage = str_replace(
                        ['{name}', '{email}', '{role}', '{password}', '{loginUrl}', '{playstore}', '{appstore}'],
                        [$name, $input['email'], $fetch_role_details['data']['name'], $password, $loginUrl, PLAYSTORE_URL, APPLESTORE_URL],
                        $fetch_role_details['data']['role_message']
                );
                
            
                $message = <<<EMAIL
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                    <meta charset="UTF-8">
                    <title>Welcome to Better Choice Group Homes</title>
                    <style>
                        body { font-family: 'Segoe UI', sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; color: #333; }
                        .container { max-width: 600px; margin: 30px auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
                        .header { background-color: #0a3d62; padding: 20px; color: #ffffff; text-align: center; }
                        .header img { max-height: 60px; margin-bottom: 10px; }
                        .body { padding: 30px; text-align: left; }
                        .body h2 { color: #0a3d62; margin-top: 0; }
                        .body p { line-height: 1.6; font-size: 15px; }
                        .button {
                            display: inline-block;
                            margin: 20px 0;
                            padding: 12px 24px;
                            background-color: #0a3d62;
                            color: white !important;
                            text-decoration: none;
                            border-radius: 5px;
                            font-size: 14px;
                        }
                        .footer { text-align: center; font-size: 13px; color: #888; padding: 20px; }
                    </style>
                    </head>
                    <body>
                    <div class="container">
                        <div class="header">
                            <img src={$logo} alt="Better Choice Group Homes Logo">
                            <h2>Better Choice Group Homes</h2>
                        </div>
                        <div class="body">
                        {$roleMessage}
                        <p>For your security, please change your password after logging in.</p>
                        <p>Need help? Reach out to your team lead or HR.</p>
                        </div>
                        <div class="footer">
                        &copy; {$year} Better Choice Group Homes. All rights reserved.
                        </div>
                    </div>
                    </body>
                    </html>
                    EMAIL;

                $this->allmodels->sendmail($input['email'], $name, $message, "Welcome to Better Choice Group Homes");
            }
            $this->db->commit();

            echo json_encode([
                'status' => true,
                'message' => $isNew ? 'User created successfully' : 'User updated successfully'
            ]);
        } else {
            throw new Exception("Unauthorized access. Insufficient privileges.");
        }

        } catch (Exception $e) {
            $this->db->rollback();
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function DeleteUserDetails(){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
        date_default_timezone_set($timezone);

        $userId = $_POST['id'];
        $userInfo = $this->allmodels->getUserInfo($userId);
        

        $delete_details = $this->allmodels->deleteUser($userId,$userInfo['email']);

        if($delete_details['status']==true){
            
            echo json_encode([
                'status' => true,
                'message' => $delete_details['message']
            ]);
        } else {
             echo json_encode([
                'status' => false,
                'message' => $delete_details['message']
            ]);
        }
    }

    public function DeleteSchedule(){
    
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
        date_default_timezone_set($timezone);

        $scheduleId = $_POST['id'];
        $fetchschedule = $this->allmodels->fetchscheduledetails($scheduleId);

        $delete_details = $this->allmodels->deleteSchedule($scheduleId, $fetchschedule[0]['email']);

        if($delete_details['status']==true){
            echo json_encode([
                'status' => true,
                'message' => $delete_details['message']
            ]);
        } else {
             echo json_encode([
                'status' => false,
                'message' => $delete_details['message']
            ]);
        }
    }

    public function UpdateUserAccountStatus(){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
        date_default_timezone_set($timezone);

        try {
            // Start transaction
            $this->db->begin_transaction();

            $id = intval($_POST['id']);
            $status = intval($_POST['status']);
            $isActive = $status === 1 ? 0 : 1;
            $userInfo = $this->allmodels->getUserInfo($id);
            if (!$userInfo) {
                throw new Exception("User not found");
            }
            $fetch_user_role = $this->allmodels->getUserInfo($_SESSION['better_email']);
            $name = $userInfo['firstname'].' '.$userInfo['lastname'];
            $loginUrl = BASE_URL . 'login';
            $year = date('Y');
            $logo = BASE_URL . 'public/assets/img/better-icon-removebg-preview.png';

            if($fetch_user_role['isAdmin'] > 0 || $this->allmodels->roleHasPermission($fetch_user_role['role'], 'change.staffstatus')){
              
            
            $stmt = $this->db->prepare("UPDATE users SET isActive = ? WHERE id = ?");
            $stmt->bind_param("ii", $isActive, $id);
            if (!$stmt->execute()) {
                throw new Exception("User details update failed: " . $stmt->error);
            }

            $logmessage =  $status === 1 ? 'Deactivated ' . $userInfo['email'] . ' successfully' : 'Account ' . $userInfo['email'] . ' successfully activated';

                $fetch_role_details = $this->allmodels->getRoleByIdOrTag($userInfo['role']);
                $roleMessage = str_replace(
                        ['{name}', '{role}', '{loginUrl}', '{playstore}', '{appstore}'],
                        [$name, $fetch_role_details['data']['name'], $loginUrl, PLAYSTORE_URL, APPLESTORE_URL],
                        $fetch_role_details['data']['activation_message']
                );

            $message = <<<EMAIL
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                    <meta charset="UTF-8">
                    <title>Welcome to Better Choice Group Homes</title>
                    <style>
                        body { font-family: 'Segoe UI', sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; color: #333; }
                        .container { max-width: 600px; margin: 30px auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
                        .header { background-color: #0a3d62; padding: 20px; color: #ffffff; text-align: center; }
                        .header img { max-height: 60px; margin-bottom: 10px; }
                        .body { padding: 30px; text-align: left; }
                        .body h2 { color: #0a3d62; margin-top: 0; }
                        .body p { line-height: 1.6; font-size: 15px; }
                        .button {
                            display: inline-block;
                            margin: 20px 0;
                            padding: 12px 24px;
                            background-color: #0a3d62;
                            color: white !important;
                            text-decoration: none;
                            border-radius: 5px;
                            font-size: 14px;
                        }
                        .footer { text-align: center; font-size: 13px; color: #888; padding: 20px; }
                    </style>
                    </head>
                    <body>
                    <div class="container">
                        <div class="header">
                            <img src={$logo} alt="Better Choice Group Homes Logo">
                            <h2>Better Choice Group Homes</h2>
                        </div>
                        <div class="body">
                        {$roleMessage}
                        <p>For your security, please change your password after logging in.</p>
                        <p>Need help? Reach out to your team lead or HR.</p>
                        </div>
                        <div class="footer">
                        &copy; {$year} Better Choice Group Homes. All rights reserved.
                        </div>
                    </div>
                    </body>
                    </html>
                    EMAIL;

            if($isActive==1){
                $this->allmodels->sendmail($userInfo['email'], $name, $message, "Account Activation");
            }
                
            $this->allmodels->logActivity($_SESSION['better_email'], $_SESSION['userid'], 'update-account', $logmessage,  date('Y-m-d H:i:s'));

            // Commit if all queries succeed
            $this->db->commit();
            
            echo json_encode([
                'status' => true,
                'message' => $status === 1 ? "Account deactivated successfully" : "Account activated successfully"
            ]);

        } else {
            throw new Exception("Unauthorized access {$userInfo['isAdmin']}. Insufficient privileges.");
        }

        } catch (Exception $e) {
            // Rollback on failure
            $this->db->rollback();
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function GenerateScheduleForm() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
        date_default_timezone_set($timezone);

        $locationid = $_POST['location'] ?? '';
        $date_range = $_POST['daterange'] ?? '';

        if (empty($locationid) || empty($date_range)) {
            echo json_encode(['status' => false, 'message' => 'Location and date range are required']);
            return;
        }

        $userInfo = $this->allmodels->getUserInfo($_SESSION['better_email']);
        // Define allowed roles for admin access
        $user_role = $userInfo['role'];
        if($userInfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'create.schedule')){
          

        $location_details = $this->allmodels->fetchlocations($locationid);
        $location = $location_details[0]['address'].', '.$location_details[0]['city'].', '.$location_details[0]['province'];

        list($start_date, $end_date) = explode(" - ", $date_range);

        $usersQuery = $this->db->prepare("SELECT id, email, firstname, lastname FROM users WHERE location = ?");
        $usersQuery->bind_param("s", $location);
        $usersQuery->execute();
        $users = $usersQuery->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($users)) {
            echo json_encode(['status' => false, 'message' => 'No users found for the selected location.']);
            return;
        }

        $dates = $this->allmodels->getDatesBetween($start_date, $end_date);

        // Start output buffering
        ob_start();
        ?>

        <div class="accordion" id="scheduleAccordion">
            <?php foreach ($dates as $index => $date): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $index ?>">
                        <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>">
                            Schedule for <?= date("l, F j, Y", strtotime($date)) ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index == 0 ? 'show' : '' ?>" data-bs-parent="#scheduleAccordion">
                        <div class="accordion-body p-0">
                            <div class="table-responsive">
                           <table class="table table-sm table-hover table-bordered table-striped text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap" scope="col">Staff</th>
                                        <th class="text-nowrap" scope="col">Start Time</th>
                                        <th class="text-nowrap" scope="col">End Time</th>
                                        <th class="text-nowrap" scope="col">Shift Type</th>
                                        <th class="text-nowrap" scope="col">Pay/Hour</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr class="align-item-center">
                                            <td><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></td>
                                            <td><input type="time" class="form-control border-0 shadow" required name="start_time[<?= $user['id'] ?>][<?= $date ?>]"></td>
                                            <td><input type="time" class="form-control border-0 shadow" required name="end_time[<?= $user['id'] ?>][<?= $date ?>]"></td>
                                            <td>
                                                <select class="form-select border-0 shadow shift_type" required name="shift_type[<?= $user['id'] ?>][<?= $date ?>]">
                                                    <option value="day">Day</option>
                                                    <option value="evening">Evening</option>
                                                    <option value="overnight">Over Night</option>
                                                </select>

                                                <!-- Hidden Overnight Type -->
                                                <select class="form-select border-0 shadow mt-2 overnight-type d-none" 
                                                        name="overnight_type[<?= $user['id'] ?>][<?= $date ?>]">
                                                    <option value="rest">Rest</option>
                                                    <option value="awake">Awake</option>
                                                </select>

                                            </td>
                                            <input type="hidden" name="email[<?= $user['id'] ?>][<?= $date ?>]" value="<?= $user['email'] ?>" />
                                            <input type="hidden" name="location_id[<?= $user['id'] ?>][<?= $date ?>]" value="<?= $locationid ?>" />
                                            <input type="hidden" name="location[<?= $user['id'] ?>][<?= $date ?>]" value="<?= $location ?>" />
                                            <td><input type="number" class="form-control border-0 shadow" required name="pay[<?= $user['id'] ?>][<?= $date ?>]" placeholder="Pay per hour ₦/hr"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
        $html = ob_get_clean();

        $logmessage =  "Generated schedule form for location: " . $location . " and date range: " . $date_range;

        $this->allmodels->logActivity($_SESSION['better_email'], $_SESSION['userid'], 'generate-schedule-form', $logmessage,  date('Y-m-d H:i:s'));

        echo json_encode([
            'status' => true,
            'html' => $html
        ]);

        } else {
            echo json_encode(['status' => false, 'message' => 'Unauthorized access. Insufficient privileges.']);
            return;
        }
    }

        public function saveSchedule(){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);

            $userInfo = $this->allmodels->getUserInfo($_SESSION['better_email']);

            $user_role = $userInfo['role'];
        
            try {

                if($userInfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'create.schedule')){

                $startTimes  = $this->allmodels->sanitizeInput($_POST['start_time'] ?? []);
                $endTimes    = $this->allmodels->sanitizeInput($_POST['end_time'] ?? []);
                $shiftTypes  = $this->allmodels->sanitizeInput($_POST['shift_type'] ?? []);
                $pays        = $this->allmodels->sanitizeInput($_POST['pay'] ?? []);
                $email       = $this->allmodels->sanitizeInput($_POST['email'] ?? []);
                $location_id    = $this->allmodels->sanitizeInput($_POST['location_id'] ?? []);
                $location    = $this->allmodels->sanitizeInput($_POST['location'] ?? []);
                $overnight_type    = $this->allmodels->sanitizeInput($_POST['overnight_type'] ?? []);

                if (empty($startTimes)) {
                    echo json_encode(['status' => false, 'message' => 'No schedule data submitted']);
                    return;
                }

                // Begin transaction
                $this->db->begin_transaction();

                $stmt = $this->db->prepare("
                    INSERT INTO scheduling (user_id, email, location_name, location_id, schedule_date, start_time, end_time, shift_type, overnight_type, pay_per_hour)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    start_time = VALUES(start_time),
                    end_time = VALUES(end_time),
                    shift_type = VALUES(shift_type),
                    overnight_type = VALUES(overnight_type),
                    pay_per_hour = VALUES(pay_per_hour)
                ");

                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $this->db->error);
                }

                foreach ($startTimes as $userId => $dates) {
                    foreach ($dates as $date => $startTime) {

                        $endTime    = $endTimes[$userId][$date] ?? null;
                        $shiftType  = $shiftTypes[$userId][$date] ?? '';
                        $payPerHour = $pays[$userId][$date] ?? 0;
                        $useremail = $email[$userId][$date] ?? '';
                        $locations = $location[$userId][$date] ?? '';
                        $locationid = $location_id[$userId][$date] ?? '';
                        $overnightType  = $overnight_type[$userId][$date] ?? 'rest';

                        // Skip empty rows
                        if (empty($startTime) || empty($endTime) || empty($shiftType) || empty($payPerHour)) {
                            throw new Exception("All fields are required");
                        }

                        $stmt->bind_param("ississsssd", $userId, $useremail, $locations, $locationid, $date, $startTime, $endTime, $shiftType, $overnightType, $payPerHour);
                        if (!$stmt->execute()) {
                            throw new Exception("Execution failed: " . $stmt->error);
                        }
                    }
                }

                $stmt->close();

                $dates = array_keys(reset($startTimes));
                $dateRange = min($dates) . " to " . max($dates);
                $logmessage =  "Insert schedule form for location: " . $locations . " and date range: " . $dateRange;

                $this->allmodels->logActivity($_SESSION['better_email'], $_SESSION['userid'], 'insert-schedule', $logmessage,  date('Y-m-d H:i:s'));


                $this->db->commit();

                echo json_encode([
                    'status' => true,
                    'message' => 'Schedule saved successfully'
                ]);

                } else {
                    throw new Exception("Unauthorized access. Insufficient privileges.");
                }
            

            } catch (Exception $e) {
                $this->db->rollback();

                echo json_encode([
                    'status' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        public function updateSchedule(){

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);

            $userInfo = $this->allmodels->getUserInfo($_SESSION['better_email']);

            $user_role = $userInfo['role'];

            $this->db->begin_transaction();

            try{

                if($userInfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'update.schedule')){
              

                $input = [];
                $requiredFields = ['start_time', 'end_time', 'shift_type', 'pay_per_hour', 'id'];
                foreach ($requiredFields as $field) {
                    $input[$field] = $this->allmodels->sanitizeInput($_POST[$field] ?? '');
                    if (empty($input[$field])) {
                        throw new Exception(ucfirst($field) . " is required");
                    }
                }

                //error_log(print_r($_POST, true));

                $email = $_POST['email'];
                $overnight_type = $_POST['overnight_type'];

                $stmt = $this->db->prepare("UPDATE scheduling SET start_time = ?, end_time = ?, shift_type = ?, pay_per_hour = ?, overnight_type = ? WHERE id = ?");
                $stmt->bind_param("sssssi", $input['start_time'], $input['end_time'], $input['shift_type'], $input['pay_per_hour'], $overnight_type, $input['id']);
                if($stmt->execute()){

                    $logmessage =  "Update schedule for user: " . $email;
                    $this->allmodels->logActivity($_SESSION['better_email'], $_SESSION['userid'], 'update-schedule', $logmessage,  date('Y-m-d H:i:s'));
                
                    $this->db->commit();
                    echo json_encode([
                        'status' => true,
                        'message' => 'Schedule updated successfully'
                    ]);

                } else {
                    throw new Exception("Execution failed: " . $stmt->error);
                }
                $stmt->close();

                } else {
                    throw new Exception("Unauthorized access. Insufficient privileges.");
                }

    
            }catch(Exception $e){
                $this->db->rollback();

                echo json_encode([
                    'status' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
            
        }

        public function changePassword(){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);

            try {

                $input = [];
                $requiredFields = ['old_password', 'new_password', 'repeat_password'];
                foreach ($requiredFields as $field) {
                    $input[$field] = $this->allmodels->sanitizeInput($_POST[$field] ?? '');
                    if (empty($input[$field])) {
                        throw new Exception(ucfirst($field) . " is required");
                    }
                }

                $email = $_SESSION['better_email'];

                if(!$this->allmodels->getUserInfo($email)){
                    throw new Exception("User Not found");
                }

                $userInfo = $this->allmodels->getUserInfo($email);

                if($input['new_password'] != $input['repeat_password']){
                    throw new Exception("Your new password details are not the same");
                }

                if (!password_verify($input['old_password'], $userInfo['password'])){
                    throw new Exception("Incorrect old Password");
                }

                $newpassword = password_hash($input['new_password'], PASSWORD_DEFAULT);

                $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE email = ?");
                $stmt->bind_param("ss", $newpassword, $email);
                $stmt->execute();

                echo json_encode([
                    'status' => true,
                    'message' => 'Password Changed successfully'
                ]);

            } catch(Exception $e){

                echo json_encode([
                    'status' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);

            }
        }

        /**
         * Delete a document given its id
         *
         * @return JSON with status and message
         */
        public function deleteDocument(){

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);

            $userInfo = $this->allmodels->getUserInfo($_SESSION['better_email']);

            $user_role = $userInfo['role'];
            if($userInfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'delete.staffdoc')){
             

            $id = $_POST['id'];
            $type = $_POST['type'];

            $docinfo = $this->allmodels->getUserDocuments($id,$type);
            $doc_tag = $type == 'certificates' ? $docinfo[0]['cert_tag'] : $docinfo[0]['doc_tag'];
            $name = $type == 'certificates' ? $docinfo[0]['certificate_name'] : $docinfo[0]['name'];
            $userId = $docinfo[0]['user_id'];
            $userInfo = $this->allmodels->getUserInfo($userId);
            $useremail = $userInfo['email'];
            $email = $_SESSION['better_email'] ?? null;

            
            if(empty($name)){

                echo json_encode([
                    'status' => false,
                    'message' => 'Document field is empty'
                ]);

                exit;

            }

            $filePath = UPLOAD_URL . $name;

            if (file_exists($filePath)) {
                unlink(UPLOAD_URL . $name);
            }

            $stmt = $this->db->prepare("DELETE FROM $type WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $logmessage =  "Delete document: " . $doc_tag . " for user: " . $useremail;
            $this->allmodels->logActivity($_SESSION['better_email'], $_SESSION['userid'], 'delete-document', $logmessage,  date('Y-m-d H:i:s'));

            echo json_encode([
                'status' => true,
                'message' => 'Document Cleared Successfully'
            ]);

            } else {

                echo json_encode([
                    'status' => false,
                    'message' => 'Unauthorized access. Insufficient privileges.'
                ]);
                exit;
            }

        }

        public function documentActivation(){

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Use default timezone or fallback
            date_default_timezone_set($_SESSION['timezone'] ?? 'America/Toronto');
            $userInfo = $this->allmodels->getUserInfo($_SESSION['better_email']);

            $user_role = $userInfo['role'];
            
    

            try{
                
                if($userInfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'activate.staffdoc')){
                // Sanitize and validate input
                $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
                $status = isset($_POST['status']) ? intval($_POST['status']) : null;

                if (!$id || !in_array($status, [0, 1], true)) {
                    throw new Exception("Invalid document ID or status.");
                }

                $type = $_POST['type'];

                error_log($status);

                // Fetch document and user info
                $docInfo = $this->allmodels->getUserDocuments($id, $type);
                if (empty($docInfo)) {
                    throw new Exception("Document not found");
                }

                $doc = $docInfo[0];

                $docTag = $type == 'certificates' ? $doc['cert_tag'] : $doc['doc_tag'];
                $userId = $doc['user_id'];
                $name = $type == 'certificates' ? $doc['certificate_name'] : $doc['name'];

                if(empty($name)){

                    throw new Exception("Ooops, sorry document has not yet been uploaded");

                }

                $userInfo = $this->allmodels->getUserInfo($userId);
                $userEmail = $userInfo['email'] ?? 'Unknown';

                // Update activation status
                $stmt = $this->db->prepare("UPDATE $type SET isApproved = ? WHERE id = ?");
                if (!$stmt) {
                    throw new Exception('Database error: ' . $this->db->error);
                }

                $stmt->bind_param("ii", $status, $id);
                $stmt->execute();

                // Log activity
                $action = $status ? 'Activate' : 'Deactivate';
                $logMessage = "$action document: $docTag for user: $userEmail";
                $this->allmodels->logActivity(
                    $_SESSION['better_email'],
                    $_SESSION['userid'],
                    'confirm-document',
                    $logMessage,
                    date('Y-m-d H:i:s')
                );

                echo json_encode([
                    'status' => true,
                    'message' => "Document {$action}d successfully"
                ]);

            } else {
                throw new Exception("Unauthorized access. Insufficient privileges.");
            }

            } catch(Exception $e) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
            
        }

        public function fetchAllSchedule() {
            
            $search    = $_POST['q']    ?? '';
            $fromDate  = $_POST['fromDate']  ?? '';
            $toDate    = $_POST['toDate']    ?? '';
            $location  = $_POST['location']  ?? '';
            $status    = $_POST['status']    ?? '';

            $perPage   = $_POST['per_page']  ?? 20;
            $page      = $_POST['page']      ?? 1;
            $offset    = ($page - 1) * $perPage;

            $conditions = [];
            $params     = [];
            $types      = '';

            // Default: only current week unless search or date filter provided
            if (empty($search) && empty($fromDate) && empty($toDate)) {
                $startOfWeek = date('Y-m-d', strtotime('monday this week'));
                $endOfWeek   = date('Y-m-d', strtotime('sunday this week'));
                $conditions[] = "schedule_date BETWEEN ? AND ?";
                $params[]     = $startOfWeek;
                $params[]     = $endOfWeek;
                $types       .= 'ss';
            }

            // Search term
            if (!empty($search)) {
                $conditions[] = "(location_name LIKE ? OR schedule_date LIKE ? OR CONCAT(u.firstname, ' ', u.lastname) LIKE ?)";
                $searchTerm   = "%{$search}%";
                $params[]     = $searchTerm;
                $params[]     = $searchTerm;
                $params[]     = $searchTerm;
                $types       .= 'sss';
            }

            // Date range filter
            if (!empty($fromDate)) {
                $conditions[] = "schedule_date >= ?";
                $params[]     = $fromDate;
                $types       .= 's';
            }
            if (!empty($toDate)) {
                $conditions[] = "schedule_date <= ?";
                $params[]     = $toDate;
                $types       .= 's';
            }

            // Location filter
            if (!empty($location)) {
                $conditions[] = "location_name LIKE ?";
                $params[]     = "%{$location}%";
                $types       .= 's';
            }

            // Status filter (completed/in-progress/pending)
            if (!empty($status)) {
                if ($status === 'completed') {
                    $conditions[] = "(clockin IS NOT NULL AND clockout IS NOT NULL)";
                } elseif ($status === 'in-progress') {
                    $conditions[] = "(clockin IS NOT NULL AND clockout IS NULL)";
                } elseif ($status === 'scheduled') {
                    $conditions[] = "(clockin IS NULL)";
                }
            }

            $whereSQL = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

            $sql = "
                SELECT s.*, u.firstname, u.lastname
                FROM scheduling s
                JOIN users u ON u.id = s.user_id
                $whereSQL
                ORDER BY s.id DESC
                LIMIT ?, ?
            ";

            $params[] = $offset;
            $params[] = $perPage;
            $types   .= 'ii';

            $stmt = $this->db->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = [];
            $countSchedule   = 0;
            $countInProgress = 0;
            $countCompleted  = 0;
            $totalHours      = 0;
            $totalPay        = 0;
            $datesInResult   = [];

            while ($row = $result->fetch_assoc()) {
                $fullname  = $row['firstname'] . ' ' . $row['lastname'];
                $hoursUsed = 0;
                $schedulePay = null;
                $statusValue = 'pending';

                if (!empty($row['clockin']) && !empty($row['clockout'])) {
                    $start      = new DateTime($row['clockin']);
                    $end        = new DateTime($row['clockout']);
                    $hoursUsed  = round(($end->getTimestamp() - $start->getTimestamp()) / 3600, 2);
                    $statusValue = 'completed';
                    $countCompleted++;
                    $schedulePay = $hoursUsed * (float)$row['pay_per_hour']; // Pay only for this schedule
                } elseif (!empty($row['clockin'])) {
                    $statusValue = 'in-progress';
                    $countInProgress++;
                }

                $countSchedule++;
                $totalHours += $hoursUsed;
                if ($schedulePay !== null) {
                    $totalPay += $schedulePay;
                }

                // Date formats
                $formattedDate    = date('D M jS', strtotime($row['schedule_date']));
                $formattedStart   = date('g:ia', strtotime($row['start_time']));
                $formattedEnd     = date('g:ia', strtotime($row['end_time']));
                $formattedClockIn = $row['clockin'] ? date('g:ia', strtotime($row['clockin'])) : null;
                $formattedClockOut= $row['clockout'] ? date('g:ia', strtotime($row['clockout'])) : null;

                $datesInResult[] = $row['schedule_date'];

                $data[] = [
                    'id'            => $row['id'],
                    'fullname'      => $fullname,
                    'date'          => $formattedDate,
                    'location'      => $row['location_name'],
                    'startTime'     => $formattedStart,
                    'endTime'       => $formattedEnd,
                    'resumedAt'     => $formattedClockIn,
                    'leftAt'        => $formattedClockOut,
                    'hoursUsed'     => $hoursUsed,
                    'status'        => $statusValue,
                    'shift_type'         => $row['shift_type'],
                    'pay_per_hour'  => $row['pay_per_hour'],
                    'overnight_type'  => $row['overnight_type'],
                    'total_pay'     => $schedulePay // pay for THIS schedule only
                ];
            }

            // Date range for the result
            $rangeStart = !empty($datesInResult) ? date('M j Y', strtotime(min($datesInResult))) : null;
            $rangeEnd   = !empty($datesInResult) ? date('M j Y', strtotime(max($datesInResult))) : null;

            echo json_encode([
                'status' => 'success',
                'range'  => $rangeStart && $rangeEnd ? "$rangeStart to $rangeEnd" : null,
                'stats'  => [
                    'total_schedule' => $countSchedule,
                    'in_progress'    => $countInProgress,
                    'completed'      => $countCompleted,
                    'total_hours'    => $totalHours,
                    'total_pay'      => $totalPay
                ],
                'data' => $data
            ]);
        }
 
        public function generateReports(){

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $session_mail = $_SESSION['better_email'];
            $userInfo = $this->allmodels->getUserInfo($_SESSION['better_email']);

            $user_role = $userInfo['role'];
            if($userInfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'generate.report')){
              
            // Initialize variables
            $whereClauses = [];
            $params = [];
            $types = '';

            // Get and sanitize input parameters
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $location = isset($_POST['location']) ? trim($_POST['location']) : '';
            $date_range = isset($_POST['daterange']) ? trim($_POST['daterange']) : '';
            $isPrint = isset($_POST['print']) && $_POST['print'] === 'true';

           // list($startDate, $endDate) = explode(" - ", $date_range);

            // Split the range into start and end dates
            $dates = explode(" - ", $date_range);

            // Convert each date to MySQL format
            $startDate = !empty($dates[0]) ? date('Y-m-d', strtotime(trim($dates[0]))) : '';
            $endDate = !empty($dates[1]) ? date('Y-m-d', strtotime(trim($dates[1]))) : '';

            //error_log('location:  '$location);

            // Pagination parameters
            $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
            $perPage = isset($_POST['perPage']) ? (int)$_POST['perPage'] : 10;
            $offset = ($page - 1) * $perPage;

            // Build WHERE clauses based on input
            if (!empty($email)) {
                $whereClauses[] = "s.email LIKE ?";
                $params[] = "%$email%";
                $types .= 's';
            }

            if (!empty($location)) {
                $whereClauses[] = "s.location_name = ?";
                $params[] = $location;
                $types .= 's';
            }

            if (!empty($startDate) && !empty($endDate)) {
                $whereClauses[] = "schedule_date BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
                $types .= 'ss';
            } elseif (!empty($startDate)) {
                $whereClauses[] = "schedule_date >= ?";
                $params[] = $startDate;
                $types .= 's';
            } elseif (!empty($endDate)) {
                $whereClauses[] = "schedule_date <= ?";
                $params[] = $endDate;
                $types .= 's';
            }

            // Prepare base query
            $query = "SELECT 
                u.firstname, 
                u.lastname,
                s.location_name, 
                s.start_time, 
                s.end_time, 
                s.clockin, 
                s.clockout, 
                s.schedule_date, 
                s.shift_type,
                s.pay_per_hour,
                s.overnight_type,
                s.email,
                TIMESTAMPDIFF(MINUTE, s.clockin, s.clockout) AS minutes_worked
              FROM scheduling s JOIN users u ON s.email = u.email";

            // Add WHERE clauses if any
            if (!empty($whereClauses)) {
                $query .= " WHERE " . implode(" AND ", $whereClauses);
            }

            // Count total records for pagination
            $countQuery = "SELECT COUNT(*) as total FROM scheduling s JOIN users u ON s.email = u.email";
            if (!empty($whereClauses)) {
                $countQuery .= " WHERE " . implode(" AND ", $whereClauses);
            }
            $stmt = $this->db->prepare($countQuery);

            // Bind parameters if any
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $countResult = $stmt->get_result();
            $totalRecords = $countResult->fetch_assoc()['total'];
            $totalPages = ceil($totalRecords / $perPage);

            if (!$isPrint) {
                // Add pagination to main query
                $query .= " LIMIT ? OFFSET ?";
                $params[] = $perPage;
                $params[] = $offset;
                $types .= 'ii';
            }

            // Prepare and execute main query
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            // Process results
            $schedules = [];
            $totalMinutes = 0;

            while ($row = $result->fetch_assoc()) {
                $totalMinutes += $row['minutes_worked'];
                
                // Format hours worked
                $hours = floor($row['minutes_worked'] / 60);
                $minutes = $row['minutes_worked'] % 60;
                $hoursWorked = sprintf("%dh %02dm", $hours, $minutes);
                
                // Determine status
                $status = 'Pending';
                if ($row['clockin'] && $row['clockout']) {
                    $status = 'Completed';
                } elseif ($row['clockin']) {
                    $status = 'In Progress';
                }
                
                $schedules[] = [
                    'name' => $row['firstname'] . ' ' . $row['lastname'],
                    'location' => $row['location_name'],
                    'schedule_date' => date('D M jS', strtotime($row['schedule_date'])),
                    'scheduled_time' => date('g:i A', strtotime($row['start_time'])) . ' - ' . date('g:i A', strtotime($row['end_time'])),
                    'actual_time' => ($row['clockin'] ? date('g:i A', strtotime($row['clockin'])) : 'N/A') . ' - ' . 
                                    ($row['clockout'] ? date('g:i A', strtotime($row['clockout'])) : 'N/A') .'(' . $hoursWorked . ')',
                    'shift_type' => $row['shift_type'],
                    'pay_per_hour' => $row['pay_per_hour'],
                    'overnight_type' => $row['overnight_type'],
                    'pay' => number_format($hours * $row['pay_per_hour']),
                    'status' => $status
                ];
            }

            // Format total hours
            $totalHours = floor($totalMinutes / 60);
            $totalMinutesRemainder = $totalMinutes % 60;
            $totalHoursFormatted = sprintf("%dh %02dm", $totalHours, $totalMinutesRemainder);

            // Return JSON response
            echo json_encode([
                'success' => true,
                'data' => $schedules,
                'generated_by' => $session_mail ?? 'Admin',
                'pagination' => [
                    'totalRecords' => $totalRecords,
                    'totalPages' => $totalPages,
                    'currentPage' => $page,
                    'perPage' => $perPage
                ],
                'summary' => [
                    'totalHours' => $totalHoursFormatted,
                    'totalRecords' => $totalRecords
                ]
            ]);

            $stmt->close();
            $this->db->close();

            } else {
                echo json_encode(['status' => false, 'message' => 'Unauthorized access. Insufficient privileges.']);
                return;
            }

        }

        public function fetchStaffsList() {
            $search   = $_POST['q'] ?? '';
            $location = $_POST['location'] ?? '';
            $status   = $_POST['status'] ?? '';
            $role     = $_POST['role'] ?? '';
            $sort     = $_POST['sort'] ?? 'newest';
            $limit    = isset($_POST['perPage']) ? (int) $_POST['perPage'] : 20;
            $page     = isset($_POST['page']) ? (int) $_POST['page'] : 1;
            $offset   = ($page - 1) * $limit;
        
            // Base query (always exclude super-admin)
            $baseQuery = "FROM users u 
                          LEFT JOIN user_details ud ON u.id = ud.user_id 
                          WHERE u.role != 'super-admin'";
        
            $conditions = [];
            $params = [];
            $types = '';
        
            // Search condition
            if (!empty($search)) {
                $conditions[] = "(u.firstname LIKE ? OR u.lastname LIKE ? OR u.email LIKE ?)";
                $searchTerm = "%$search%";
                $params[] = $searchTerm; 
                $params[] = $searchTerm; 
                $params[] = $searchTerm;
                $types .= 'sss';
            }
        
            // Location
            if (!empty($location)) {
                $conditions[] = "u.location = ?";
                $params[] = $location;
                $types .= 's';
            }
        
            // Status
            if ($status !== '') {
                $conditions[] = "u.isActive = ?";
                $params[] = (int) $status;
                $types .= 'i';
            }
        
            // Role filter (other than super-admin, already excluded)
            if (!empty($role)) {
                $conditions[] = "u.role = ?";
                $params[] = $role;
                $types .= 's';
            }
        
            // Append conditions to base query
            if (!empty($conditions)) {
                $baseQuery .= " AND " . implode(" AND ", $conditions);
            }
        
            // Sorting
            switch (strtolower($sort)) {
                case 'az':     $orderBy = "u.firstname ASC"; break;
                case 'za':     $orderBy = "u.firstname DESC"; break;
                case 'oldest': $orderBy = "u.reg_date ASC"; break;
                default:       $orderBy = "u.reg_date DESC"; break;
            }
        
            // Final query
            $query = "SELECT u.id, u.firstname, u.lastname, u.email, u.role, u.location, u.isActive, u.reg_date, ud.address 
                      $baseQuery
                      ORDER BY $orderBy
                      LIMIT ? OFFSET ?";
        
            $params[] = $limit;
            $params[] = $offset;
            $types .= 'ii';
        
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
        
            $staffs = [];
            while ($row = $result->fetch_assoc()) {
                $staffs[] = [
                    "id"        => $row['id'],
                    "firstname" => $row['firstname'],
                    "lastname"  => $row['lastname'],
                    "email"     => $row['email'],
                    "role"      => $row['role'],
                    "address"   => $row['address'],
                    "location"  => $row['location'],
                    "status"    => $row['isActive'] ? "Active" : "Inactive",
                    "reg_date"  => date("F j, Y", strtotime($row['reg_date'])),
                ];
            }
        
            // Count total
            $countQuery = "SELECT COUNT(*) as total $baseQuery";
            $countStmt = $this->db->prepare($countQuery);
            if (!empty($conditions)) {
                // Exclude LIMIT params from binding
                $countStmt->bind_param(substr($types, 0, -2), ...array_slice($params, 0, -2));
            }
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $totalRows = $countResult ? (int) $countResult->fetch_assoc()['total'] : 0;

            /**
             * 1️⃣ Overall counts (no filter)
             */
            $sqlOverall = "SELECT SUM(isActive = 1) AS total_active, SUM(isActive = 0) AS total_inactive, COUNT(*) AS total_users FROM users WHERE role != 'super-admin'";
            $stmtOverall = $this->db->prepare($sqlOverall);
            $stmtOverall->execute();
            $resultOverall = $stmtOverall->get_result();
            $overallStats = $resultOverall->fetch_assoc();

            /**
            * 2️⃣ Filtered counts (with search/filter)
            */
            $sqlFiltered = "SELECT SUM(isActive = 1) AS total_active,  SUM(isActive = 0) AS total_inactive,  COUNT(*) AS total_users $baseQuery";
            $stmtFiltered = $this->db->prepare($sqlFiltered);
            if (!empty($conditions)) {
                $stmtFiltered->bind_param(substr($types, 0, -2), ...array_slice($params, 0, -2));
            }
            $stmtFiltered->execute();
            $resultFiltered = $stmtFiltered->get_result();
            $filteredStats = $resultFiltered->fetch_assoc();
        
            echo json_encode([
                "status"      => "success",
                "data"        => $staffs,
                "total"       => $totalRows,
                "page"        => $page,
                "limit"       => $limit,
                "total_pages" => ceil($totalRows / $limit),
                "overall_stats" => $overallStats,
                "filtered_stats" => $filteredStats,
            ]);
        
            $this->db->close();
        }

       public function scheduleTesting(){
            $action = $_POST['action'] ?? ($_POST['action'] ?? '');

            try {
                if ($action === 'month') {
                    $month = $_POST['month'] ?? date('Y-m');
                    // Count schedules by date
                    $sql = "
                    SELECT DATE(schedule_date) AS d, COUNT(*) AS cnt
                    FROM scheduling
                    WHERE DATE_FORMAT(schedule_date, '%Y-%m') = ?
                    GROUP BY DATE(schedule_date)
                    ORDER BY d
                    ";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bind_param('s', $month);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    $marked = [];
                    while ($r = $res->fetch_assoc()) {
                        $d = $r['d'];
                        $marked[$d] = ['count' => (int)$r['cnt']];
                    }

                    echo json_encode([
                        'status' => true,
                        'marked_dates' => $marked
                    ]);
                }
                elseif ($action === 'day') {
                    $date = $_POST['date'] ?? date('Y-m-d');
                    $name = trim($_POST['name'] ?? '');
                    $location = trim($_POST['location'] ?? '');
                    $status = $_POST['status'] ?? '';

                    // Build filter conditions
                    $conds = ["DATE(schedule_date) = ?"];
                    $bind  = [$date];
                    $types = "s";

                    if ($name !== '') {
                        $conds[] = "(u.firstname LIKE CONCAT('%', ?, '%') OR u.lastname LIKE CONCAT('%', ?, '%'))";
                        $bind[] = $name; $bind[] = $name;
                        $types .= "ss";
                    }
                    if ($location !== '') {
                        $conds[] = "(s.location_name LIKE CONCAT('%', ?, '%'))";
                        $bind[] = $location;
                        $types .= "s";
                    }

                    // Status filter (completed/in-progress/pending)
                    if (!empty($status)) {
                        if ($status === 'completed') {
                            $conds[] = "(s.clockin IS NOT NULL AND s.clockout IS NOT NULL)";
                        } elseif ($status === 'in-progress') {
                            $conds[] = "(s.clockin IS NOT NULL AND s.clockout IS NULL)";
                        } elseif ($status === 'scheduled') {
                            $conds[] = "(s.clockin IS NULL)";
                        }
                    }

                    // Calculate cross-midnight safely by adding a day if end <= start
                    $sql = "
                    SELECT
                        s.id,
                        s.email,
                        CONCAT(u.firstname, ' ', u.lastname) AS staff_name,
                        s.location_name AS location,
                        s.schedule_date AS date,

                        s.start_time,
                        s.end_time,
                        s.clockin,
                        s.clockout,
                        s.pay_per_hour,
                        s.shift_type,
                        s.overnight_type,

                        -- Pretty formats
                        DATE_FORMAT(s.start_time, '%h:%i %p') AS start_time_fmt,
                        DATE_FORMAT(s.end_time,   '%h:%i %p') AS end_time_fmt,
                        IFNULL(DATE_FORMAT(s.clockin, '%h:%i %p'), NULL)  AS clockin_fmt,
                        IFNULL(DATE_FORMAT(s.clockout, '%h:%i %p'), NULL) AS clockout_fmt,

                        -- scheduled hours (decimal)
                        (
                        CASE
                            WHEN TIME(s.end_time) <= TIME(s.start_time)
                            THEN TIMESTAMPDIFF(SECOND, s.start_time, DATE_ADD(s.end_time, INTERVAL 1 DAY)) / 3600
                            ELSE TIMESTAMPDIFF(SECOND, s.start_time, s.end_time) / 3600
                        END
                        ) AS scheduled_hours,

                        -- hours worked (decimal) — only if both exist
                        (
                        CASE
                            WHEN s.clockin IS NOT NULL AND s.clockout IS NOT NULL THEN
                            CASE
                                WHEN TIME(s.clockout) <= TIME(s.clockin)
                                THEN TIMESTAMPDIFF(SECOND, s.clockin, DATE_ADD(s.clockout, INTERVAL 1 DAY)) / 3600
                                ELSE TIMESTAMPDIFF(SECOND, s.clockin, s.clockout) / 3600
                            END
                            ELSE 0
                        END
                        ) AS hours_worked
                    FROM scheduling s
                    LEFT JOIN users u ON u.email = s.email
                    WHERE " . implode(' AND ', $conds) . "
                    ORDER BY s.start_time ASC
                    ";

                    $stmt = $this->db->prepare($sql);
                    $stmt->bind_param($types, ...$bind);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    $rows = [];
                    while ($r = $res->fetch_assoc()) {
                        // Normalize numeric precision (2 dp)
                        $status = 'scheduled';
                        if ($r['clockin'] && $r['clockout']) {
                            $status = 'completed';
                        } elseif ($r['clockin']) {
                            $status = 'in-progress';
                        }
                        $r['pay_per_hour']   = isset($r['pay_per_hour']) ? number_format((float)$r['pay_per_hour'], 2, '.', '') : '0.00';
                        $r['scheduled_hours']= number_format((float)$r['scheduled_hours'], 2, '.', '');
                        $r['hours_worked']   = number_format((float)$r['hours_worked'], 2, '.', '');
                        $r['status'] = $status;
                        $rows[] = $r;
                    }

                    echo json_encode([
                        'status' => true,
                        'data' => $rows
                    ]);
                }
                elseif ($action === 'spreadsheet') {
                    $page = max(1, (int)($_POST['page'] ?? 1));
                    $limit = max(1, (int)($_POST['limit'] ?? 50));
                    $offset = ($page - 1) * $limit;
                    
                    $name = trim($_POST['name'] ?? '');
                    $location = trim($_POST['location'] ?? '');
                    $status = $_POST['status'] ?? '';
                    $date = $_POST['date'] ?? '';

                    // Build filter conditions
                    $conds = ["1=1"];
                    $bind = [];
                    $types = "";

                    if ($name !== '') {
                        $conds[] = "(u.firstname LIKE CONCAT('%', ?, '%') OR u.lastname LIKE CONCAT('%', ?, '%'))";
                        $bind[] = $name; $bind[] = $name;
                        $types .= "ss";
                    }
                    if ($location !== '') {
                        $conds[] = "s.location_id = ?";
                        $bind[] = $location;
                        $types .= "s";
                    }
                    if ($date !== '') {
                        $conds[] = "DATE(s.schedule_date) = ?";
                        $bind[] = $date;
                        $types .= "s";
                    }

                    // Status filter
                    if (!empty($status)) {
                        if ($status === 'completed') {
                            $conds[] = "(s.clockin IS NOT NULL AND s.clockout IS NOT NULL)";
                        } elseif ($status === 'in-progress') {
                            $conds[] = "(s.clockin IS NOT NULL AND s.clockout IS NULL)";
                        } elseif ($status === 'scheduled') {
                            $conds[] = "(s.clockin IS NULL)";
                        }
                    }

                    // Count total records for pagination
                    $countSql = "SELECT COUNT(*) as total FROM scheduling s 
                                LEFT JOIN users u ON u.email = s.email 
                                WHERE " . implode(' AND ', $conds);
                    
                    $countStmt = $this->db->prepare($countSql);
                    if (!empty($bind)) {
                        $countStmt->bind_param($types, ...$bind);
                    }
                    $countStmt->execute();
                    $countResult = $countStmt->get_result();
                    $totalRecords = $countResult->fetch_assoc()['total'];

                    // Main query for schedules
                    $sql = "
                    SELECT
                        s.id,
                        s.email,
                        CONCAT(u.firstname, ' ', u.lastname) AS staff_name,
                        l.address AS location,
                        s.schedule_date AS date,

                        s.start_time,
                        s.end_time,
                        s.clockin,
                        s.clockout,
                        s.pay_per_hour,
                        s.shift_type,
                        s.overnight_type,

                        -- Pretty formats
                        DATE_FORMAT(s.start_time, '%h:%i %p') AS start_time_fmt,
                        DATE_FORMAT(s.end_time,   '%h:%i %p') AS end_time_fmt,
                        IFNULL(DATE_FORMAT(s.clockin, '%h:%i %p'), NULL)  AS clockin_fmt,
                        IFNULL(DATE_FORMAT(s.clockout, '%h:%i %p'), NULL) AS clockout_fmt,

                        -- scheduled hours (decimal)
                        (
                        CASE
                            WHEN TIME(s.end_time) <= TIME(s.start_time)
                            THEN TIMESTAMPDIFF(SECOND, s.start_time, DATE_ADD(s.end_time, INTERVAL 1 DAY)) / 3600
                            ELSE TIMESTAMPDIFF(SECOND, s.start_time, s.end_time) / 3600
                        END
                        ) AS scheduled_hours,

                        -- hours worked (decimal) — only if both exist
                        (
                        CASE
                            WHEN s.clockin IS NOT NULL AND s.clockout IS NOT NULL THEN
                            CASE
                                WHEN TIME(s.clockout) <= TIME(s.clockin)
                                THEN TIMESTAMPDIFF(SECOND, s.clockin, DATE_ADD(s.clockout, INTERVAL 1 DAY)) / 3600
                                ELSE TIMESTAMPDIFF(SECOND, s.clockin, s.clockout) / 3600
                            END
                            ELSE 0
                        END
                        ) AS hours_worked
                    FROM scheduling s
                    LEFT JOIN users u ON u.email = s.email
                    LEFT JOIN locations l ON s.location_id = l.id
                    WHERE " . implode(' AND ', $conds) . "
                    ORDER BY s.schedule_date DESC, s.start_time ASC
                    LIMIT ? OFFSET ?
                    ";

                    // Add limit and offset to bind parameters
                    $bind[] = $limit;
                    $bind[] = $offset;
                    $types .= "ii";

                    $stmt = $this->db->prepare($sql);
                    $stmt->bind_param($types, ...$bind);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    $rows = [];
                    while ($r = $res->fetch_assoc()) {
                        // Determine status
                        $status = 'scheduled';
                        if ($r['clockin'] && $r['clockout']) {
                            $status = 'completed';
                        } elseif ($r['clockin']) {
                            $status = 'in-progress';
                        } elseif(!$r['clockin'] && !$r['clockout'] && date('Y-m-d') > $r['date']){
                            $status = 'missed';
                        }
                        
                        // Normalize numeric precision (2 dp)
                        $r['pay_per_hour'] = isset($r['pay_per_hour']) ? number_format((float)$r['pay_per_hour'], 2, '.', '') : '0.00';
                        $r['scheduled_hours'] = number_format((float)$r['scheduled_hours'], 2, '.', '');
                        $r['hours_worked'] = number_format((float)$r['hours_worked'], 2, '.', '');
                        $r['status'] = $status;
                        $rows[] = $r;
                    }

                    echo json_encode([
                        'status' => true,
                        'data' => [
                            'schedules' => $rows,
                            'total' => $totalRecords,
                            'page' => $page,
                            'limit' => $limit,
                            'total_pages' => ceil($totalRecords / $limit)
                        ]
                    ]);
                }
                elseif ($action === 'datatable') {
                    // DataTables server-side processing parameters
                    $start = $_POST['start'] ?? 0;
                    $length = $_POST['length'] ?? 25;
                    $searchValue = $_POST['search']['value'] ?? '';
                    $draw = intval($_POST['draw'] ?? 1);
                    
                    // Custom filters from our form
                    $date = $_POST['date'] ?? '';
                    $name = trim($_POST['name'] ?? '');
                    $location = $_POST['location'] ?? '';
                    $status = $_POST['status'] ?? '';

                    // Build base conditions
                    $conds = ["1=1"];
                    $bind = [];
                    $types = "";

                    // Apply custom filters
                    if ($date !== '') {
                        $conds[] = "DATE(s.schedule_date) = ?";
                        $bind[] = $date;
                        $types .= "s";
                    }
                    if ($name !== '') {
                        $conds[] = "(u.firstname LIKE CONCAT('%', ?, '%') OR u.lastname LIKE CONCAT('%', ?, '%'))";
                        $bind[] = $name; $bind[] = $name;
                        $types .= "ss";
                    }
                    if ($location !== '') {
                        $conds[] = "s.location_id = ?";
                        $bind[] = $location;
                        $types .= "s";
                    }

                    // Status filter
                    if (!empty($status)) {
                        if ($status === 'completed') {
                            $conds[] = "(s.clockin IS NOT NULL AND s.clockout IS NOT NULL)";
                        } elseif ($status === 'in-progress') {
                            $conds[] = "(s.clockin IS NOT NULL AND s.clockout IS NULL)";
                        } elseif ($status === 'scheduled') {
                            $conds[] = "(s.clockin IS NULL)";
                        }
                    }

                    // Global search
                    $searchCond = "";
                    if (!empty($searchValue)) {
                        $searchCond = " AND (u.firstname LIKE CONCAT('%', ?, '%') OR u.lastname LIKE CONCAT('%', ?, '%') OR l.address LIKE CONCAT('%', ?, '%') OR s.shift_type LIKE CONCAT('%', ?, '%'))";
                        $bind[] = $searchValue; $bind[] = $searchValue; $bind[] = $searchValue; $bind[] = $searchValue;
                        $types .= "ssss";
                    }

                    // Count total records
                    $countSql = "SELECT COUNT(*) as total FROM scheduling s 
                                LEFT JOIN users u ON u.email = s.email 
                                LEFT JOIN locations l ON s.location_id = l.id
                                WHERE " . implode(' AND ', $conds);
                    
                    $countStmt = $this->db->prepare($countSql);
                    if (!empty($bind)) {
                        $countStmt->bind_param($types, ...$bind);
                    }
                    $countStmt->execute();
                    $countResult = $countStmt->get_result();
                    $totalRecords = $countResult->fetch_assoc()['total'];

                    // Count filtered records (with search)
                    $filteredCountSql = "SELECT COUNT(*) as total FROM scheduling s 
                                    LEFT JOIN users u ON u.email = s.email 
                                    LEFT JOIN locations l ON s.location_id = l.id
                                    WHERE " . implode(' AND ', $conds) . $searchCond;
                    
                    $filteredStmt = $this->db->prepare($filteredCountSql);
                    if (!empty($bind)) {
                        $filteredStmt->bind_param($types, ...$bind);
                    }
                    $filteredStmt->execute();
                    $filteredResult = $filteredStmt->get_result();
                    $filteredRecords = $filteredResult->fetch_assoc()['total'];

                    // Main query with pagination and ordering
                    $orderColumn = $_POST['order'][0]['column'] ?? 0;
                    $orderDir = $_POST['order'][0]['dir'] ?? 'desc';
                    
                    // Map DataTables column index to actual column names
                    $columnMap = [
                        0 => 's.schedule_date',  // Date
                        1 => 'u.firstname',      // Staff Name
                        2 => 'l.address',        // Location
                        3 => 's.shift_type',     // Shift Type
                        4 => 's.start_time',     // Start Time
                        5 => 's.end_time',       // End Time
                        6 => 'scheduled_hours',  // Scheduled Hours
                        7 => 'hours_worked',     // Worked Hours
                        8 => 's.pay_per_hour',   // Pay Rate
                        9 => 'total_pay',        // Total Pay (calculated)
                        10 => 's.clockin',       // Clock In
                        11 => 's.clockout',      // Clock Out
                        12 => 'status'           // Status
                    ];
                    
                    $orderBy = isset($columnMap[$orderColumn]) ? $columnMap[$orderColumn] : 's.schedule_date';
                    $orderBy .= " " . ($orderDir === 'asc' ? 'ASC' : 'DESC');

                    $sql = "
                    SELECT
                        s.id,
                        s.email,
                        CONCAT(u.firstname, ' ', u.lastname) AS staff_name,
                        l.address AS location,
                        s.schedule_date AS date,

                        s.start_time,
                        s.end_time,
                        s.clockin,
                        s.clockout,
                        s.pay_per_hour,
                        s.shift_type,
                        s.overnight_type,

                        -- Pretty formats
                        DATE_FORMAT(s.start_time, '%h:%i %p') AS start_time_fmt,
                        DATE_FORMAT(s.end_time,   '%h:%i %p') AS end_time_fmt,
                        IFNULL(DATE_FORMAT(s.clockin, '%h:%i %p'), NULL)  AS clockin_fmt,
                        IFNULL(DATE_FORMAT(s.clockout, '%h:%i %p'), NULL) AS clockout_fmt,

                        -- scheduled hours (decimal)
                        (
                        CASE
                            WHEN TIME(s.end_time) <= TIME(s.start_time)
                            THEN TIMESTAMPDIFF(SECOND, s.start_time, DATE_ADD(s.end_time, INTERVAL 1 DAY)) / 3600
                            ELSE TIMESTAMPDIFF(SECOND, s.start_time, s.end_time) / 3600
                        END
                        ) AS scheduled_hours,

                        -- hours worked (decimal) — only if both exist
                        (
                        CASE
                            WHEN s.clockin IS NOT NULL AND s.clockout IS NOT NULL THEN
                            CASE
                                WHEN TIME(s.clockout) <= TIME(s.clockin)
                                THEN TIMESTAMPDIFF(SECOND, s.clockin, DATE_ADD(s.clockout, INTERVAL 1 DAY)) / 3600
                                ELSE TIMESTAMPDIFF(SECOND, s.clockin, s.clockout) / 3600
                            END
                            ELSE 0
                        END
                        ) AS hours_worked,

                        -- total pay calculation
                        (
                        CASE
                            WHEN s.clockin IS NOT NULL AND s.clockout IS NOT NULL THEN
                            (
                                CASE
                                    WHEN TIME(s.clockout) <= TIME(s.clockin)
                                    THEN TIMESTAMPDIFF(SECOND, s.clockin, DATE_ADD(s.clockout, INTERVAL 1 DAY)) / 3600
                                    ELSE TIMESTAMPDIFF(SECOND, s.clockin, s.clockout) / 3600
                                END
                            ) * s.pay_per_hour
                            ELSE 0
                        END
                        ) AS total_pay

                    FROM scheduling s
                    LEFT JOIN users u ON u.email = s.email
                    LEFT JOIN locations l ON s.location_id = l.id
                    WHERE " . implode(' AND ', $conds) . $searchCond . "
                    ORDER BY " . $orderBy . "
                    LIMIT ? OFFSET ?
                    ";

                    // Add pagination parameters
                    $bind[] = $length;
                    $bind[] = $start;
                    $types .= "ii";

                    $stmt = $this->db->prepare($sql);
                    $stmt->bind_param($types, ...$bind);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    $rows = [];
                    while ($r = $res->fetch_assoc()) {
                        // Determine status
                        $status = 'scheduled';
                        if ($r['clockin'] && $r['clockout']) {
                            $status = 'completed';
                        } elseif ($r['clockin']) {
                            $status = 'in-progress';
                        } elseif(!$r['clockin'] && !$r['clockout'] && date('Y-m-d') > $r['date']){
                            $status = 'missed';
                        }
                        
                        // Normalize numeric precision (2 dp)
                        $r['pay_per_hour'] = isset($r['pay_per_hour']) ? number_format((float)$r['pay_per_hour'], 2, '.', '') : '0.00';
                        $r['scheduled_hours'] = number_format((float)$r['scheduled_hours'], 2, '.', '');
                        $r['hours_worked'] = number_format((float)$r['hours_worked'], 2, '.', '');
                        $r['total_pay'] = number_format((float)$r['total_pay'], 2, '.', '');
                        $r['status'] = $status;
                        $rows[] = $r;
                    }

                    // Return DataTables formatted response
                    echo json_encode([
                        'draw' => $draw,
                        'recordsTotal' => $totalRecords,
                        'recordsFiltered' => $filteredRecords,
                        'data' => $rows
                    ]);
                }
                else {
                    echo json_encode([
                        'status' => false,
                        'message' => 'Invalid action specified'
                    ]);
                }

            } catch (Exception $e) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

    public function updateProfile(){
        try {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Use default timezone or fallback
            date_default_timezone_set($_SESSION['timezone'] ?? 'America/Toronto');

            $email = $_SESSION['better_email'];

            if(!$this->allmodels->getUserInfo($email)){
                throw new Exception("User not found");
            }

            $userinfo = $this->allmodels->getUserInfo($email);
            $input = [];
            $requiredFields = ['address', 'sin', 'emergencyContact', 'dateOfBirth', 'driverlicensenumber', 'driverlicenseexpirationdate', 'transitNumber', 'institutionNumber', 'accountNumber', 'province', 'city', 'postal_code'];
            foreach ($requiredFields as $field) {
                $input[$field] = $this->allmodels->sanitizeInput($_POST[$field] ?? '');
                if (empty($input[$field])) {
                    throw new Exception(ucfirst($field) . " is required");
                }
            }

            $this->db->begin_transaction();

            $user_id = intval($userinfo['id']);
            $uploadDir =  UPLOAD_URL;
            $tags = $_POST['tags'] ?? [];
            $certtags   = $_POST['certificates_tags'] ?? [];

            $stmt = $this->db->prepare("UPDATE user_details SET driver_license_expiry_date = ?, driver_license_number = ?, address = ?, city = ?, province = ?, postal_code = ?, dob = ?, sin = ?, contact_number = ?, transit_number = ?, institution_number = ?, account_number = ? WHERE user_id = ?");
            $stmt->bind_param("ssssssssssssi", $input['driverlicenseexpirationdate'], $input['driverlicensenumber'], $input['address'], $input['city'], $input['province'], $input['postal_code'], $input['dateOfBirth'], $input['sin'], $input['emergencyContact'], $input['transitNumber'], $input['institutionNumber'], $input['accountNumber'], $user_id);
            if (!$stmt->execute()) {
                throw new Exception("User details update failed: " . $stmt->error);
            }
            $stmt->close();

            foreach ($tags as $tag) {

                if (!isset($_FILES['document_files']['name'][$tag]) || empty($_FILES['document_files']['name'][$tag])) {
                    continue; // Skip if no file uploaded for this tag
                }

                $fileTmp  = $_FILES['document_files']['tmp_name'][$tag];
                $fileName = basename($_FILES['document_files']['name'][$tag]);
                $fileExt  = pathinfo($fileName, PATHINFO_EXTENSION);

                if (strtolower($fileExt) !== 'pdf') {
                    throw new Exception("Only PDF files allowed for $tag");
                }

                // Create unique name
                $newFileName = $user_id . "_" . $tag . "_" . time() . "." . $fileExt;
                $destPath    = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmp, $destPath)) {
                    // Save to DB
                    $stmt = $this->db->prepare("UPDATE documents SET name = ? WHERE user_id = ? AND doc_tag = ?");
                    $stmt->bind_param("sis", $newFileName, $user_id, $tag);
                    $stmt->execute();
                    $stmt->close();

                }
               
            }

            foreach ($certtags as $certtag) {

                if (!isset($_FILES['certificate_files']['name'][$certtag]) || empty($_FILES['certificate_files']['name'][$certtag])) {
                    continue; // Skip if no file uploaded for this tag
                }

                $fileTmp  = $_FILES['certificate_files']['tmp_name'][$certtag];
                $fileName = basename($_FILES['certificate_files']['name'][$certtag]);
                $fileExt  = pathinfo($fileName, PATHINFO_EXTENSION);

                if (strtolower($fileExt) !== 'pdf') {
                    throw new Exception("Only PDF files allowed for $certtag");
                }

                if ($_FILES['certificate_files']['size'][$certtag] > (5 * 1024 * 1024)) {
                    throw new Exception("Certificate $certtag is larger than 5MB");
                }

                // Create unique name
                $newFileName = $user_id . "_" . $certtag . "_" . time() . "." . $fileExt;
                $destPath    = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmp, $destPath)) {
                    // Save to DB
                    $stmt = $this->db->prepare("UPDATE certificates SET certificate_name = ? WHERE user_id = ? AND cert_tag = ?");
                    $stmt->bind_param("sis", $newFileName, $user_id, $certtag);
                    $stmt->execute();
                    $stmt->close();

                }
               
            }

            //error_log("I got here");

            $date = date("Y-m-d H:i:s");

            $this->allmodels->logActivity($userinfo['email'], $user_id, 'update-profile', 'User updated their profile', $date);

            $this->db->commit();

             echo json_encode([
                'status' => true,
                'message' => 'Profile updated successfully'
            ]);


        } catch (Exception $th) {
            $this->db->rollback();
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]); 
        }
    }

    public function getRolesPermissions() {
        // Enable error visibility for development
        ini_set('display_errors', 0);
        error_reporting(E_ALL);

        try {
            // Step 1: Fetch all roles
            $roles = [];
            $roleQuery = $this->db->query("SELECT id, name, tag FROM roles");

            if (!$roleQuery) {
                error_log("Role query failed: " . $this->db->error);
                throw new Exception("Failed to fetch roles");
            }

            while ($role = $roleQuery->fetch_assoc()) {
                $roles[$role['id']] = [
                    'id' => $role['id'],
                    'name' => $role['name'],
                    'tag' => $role['tag'],
                    'permissions' => []
                ];
            }

            if (empty($roles)) {
                error_log("No roles found in table");
                echo json_encode(['status' => false, 'data' => []]);
                return;
            }

            // Step 2: Fetch all permissions
            $permissions = [];
            $permQuery = $this->db->query("SELECT id, name, description FROM permissions");

            if (!$permQuery) {
                error_log("Permission query failed: " . $this->db->error);
                throw new Exception("Failed to fetch permissions");
            }

            while ($perm = $permQuery->fetch_assoc()) {
                $permissions[$perm['id']] = $perm;
            }

            // Step 3: Fetch role-permission links (with is_active)
            $rpQuery = $this->db->query("SELECT role_id, permission_id, is_active FROM role_permissions");

            if (!$rpQuery) {
                error_log("Role-Permission query failed: " . $this->db->error);
                throw new Exception("Failed to fetch role-permission links");
            }

            $activeMap = [];
            while ($rp = $rpQuery->fetch_assoc()) {
                $activeMap[$rp['role_id']][$rp['permission_id']] = (bool)$rp['is_active'];
            }

            // Step 4: Combine roles and permissions
            foreach ($roles as &$role) {
                foreach ($permissions as $perm) {
                    $isActive = isset($activeMap[$role['id']][$perm['id']])
                        ? $activeMap[$role['id']][$perm['id']]
                        : false;

                    $role['permissions'][] = [
                        'id' => $perm['id'],
                        'name' => $perm['name'],
                        'description' => $perm['description'],
                        'active' => $isActive
                    ];
                }
            }

            // Step 5: Final JSON output
            echo json_encode([
                'status' => true,
                'data' => array_values($roles)
            ]);

            // Log summary
            error_log("Roles fetched: " . count($roles));
            error_log("Permissions fetched: " . count($permissions));

        } catch (Exception $e) {
            error_log("Error in getRolesPermissions: " . $e->getMessage());
            echo json_encode([
                'status' => false,
                'message' => 'Error fetching data: ' . $e->getMessage()
            ]);
        }
    }



    public function updatePermissions() {

        $roleId = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;
        $permissions = isset($_POST['permission_id']) ? (int)$_POST['permission_id'] : 0;
        $status = isset($_POST['is_active']) ? $_POST['is_active'] : 1;

        //error_log("Controller Update Permissions: Role ID: $roleId, Permissions: " . $permissions . ", Status: $status");

        $response = $this->allmodels->updatePermissionRole($roleId, $permissions, $status);

        echo json_encode($response);
    }

    public function getScheduleDetails() {
        $scheduleId = isset($_POST['schedule_id']) ? (int)$_POST['schedule_id'] : 0;

        $response = $this->allmodels->getScheduleById($scheduleId);

        echo json_encode($response);
        
    }

    public function processDocuments(){

        $id = $_POST['id'] ?? 0;
        $name = trim($_POST['name']);
        $tag = trim($_POST['tag'] ?? '');
        $sort_order = $_POST['sort_order'] ?? 0;
        $is_required = isset($_POST['is_required']) ? 1 : 0;
        $response = $this->allmodels->saveDocument($id, $name, $tag, $sort_order, $is_required);

        echo json_encode($response);
    }

    public function getDocumentList(){

        $response = $this->allmodels->getDocuments();

        echo json_encode($response);
    }

    public function getDocumentDetails(){

        $id = $_GET['id'] ?? 0;
        $response = $this->allmodels->getSingleDocument($id);

        echo json_encode($response);
    }

    public function deleteTypeDocument(){

        $id = $_POST['id'] ?? 0;
        $response = $this->allmodels->deleteDocumentType($id);

        echo json_encode($response);
    }

    public function AddNewRole(){
        $name = $this->allmodels->sanitizeInput($_POST['role_name'] ?? '');
        $description = $this->allmodels->sanitizeInput($_POST['description'] ?? '');
        $tag = $this->allmodels->sanitizeInput($_POST['tag'] ?? '');
        $welcomeMessage = $_POST['welcome_message'] ?? '';
        $activationMessage = $_POST['activation_message'] ?? '';
        $id = $_POST['role_id'] ?? 0;

        $response = $this->allmodels->addRole($name, $description, $tag, $welcomeMessage, $id, $activationMessage);

        echo json_encode($response);
    }

    public function deleteARole(){
        $roleId = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;

        $response = $this->allmodels->deleteRole($roleId);

        echo json_encode($response);
    }

    public function getRoleDetails(){
        $roleId = isset($_GET['role_id']) ? (int)$_GET['role_id'] : 0;

        $response = $this->allmodels->getRoleByIdOrTag($roleId);

        echo json_encode($response);
    }

}

?>