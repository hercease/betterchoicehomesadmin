<?php

class ViewController {

    private $db;
    private $allmodels;
    

    public function __construct($db) {
        $this->db = $db;
        $this->allmodels = new allmodels($db);
    }
    // Display the login form
    public function showLoginPage($rootUrl){
        require_once('app/views/login.php');
    }

    public function showForgotPage($rootUrl){
        require_once('app/views/forgot_password.php');
    }
    // Display the dashboard page
    public function showDashboardPage($rootUrl){
        if (session_status() === PHP_SESSION_NONE){
                session_start();
        }
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $user_id = $_SESSION['userid'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $total_users = $this->allmodels->allCounts('total_users');
            $total_schedules = $this->allmodels->allCounts('total_schedule');
            $total_locations = $this->allmodels->allCounts('total_location');
            $total_schedule_weekly = $this->allmodels->allCounts('total_schedule_weekly');
            $total_appointment_weekly = $this->allmodels->allCounts('total_appointments_weekly');
            $total_expected_hours_weekly = $this->allmodels->allCounts('total_expected_hours_weekly');
            $total_completed_hours_weekly = $this->allmodels->allCounts('total_completed_hours_weekly');
            $schedule_completion_rate = $this->allmodels->allCounts('schedule_completion_rate_weekly');
            $user_registration_growth = $this->allmodels->allCounts('user_registration_growth');
            $fetch_all_roles = $this->allmodels->fetchAllRoles()['roles'];
            $role_tags = array_column($fetch_all_roles, 'tag');

             $role = ['hr', 'manager', 'accountant', 'scheduler', 'dos', 'super-admin'];

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role_tags)){

                $data = [
					'total_users' => $total_users,
					'user_info' => $fetchuserinfo,
					'total_schedules' => $total_schedules,
					'total_location' => $total_locations,
					'date_display' => $this->allmodels->getFormattedDateTime('now', $timezone),
                    'recent_users' => $this->allmodels->fetchRecentUsers(),
                    'total_schedule_weekly' => $total_schedule_weekly,
                    'total_appointment_weekly' => $total_appointment_weekly,
                    'total_completed_hours_weekly' => $total_completed_hours_weekly.' '. 'hrs',
                    'total_expected_hours_weekly' => round($total_expected_hours_weekly / 3600, 2) .' '.  'hrs',
                    'schedule_completion_rate' => $schedule_completion_rate.'%',
                    'user_registration_growth' => $user_registration_growth.'%',
				];

                require_once('app/views/dashboard.php');

            } else {
				$this->forbiddenPage();
			}

        } else {
			require_once('app/views/login.php');
		}
        
    }

    // Display the all users page
    public function showAllUsersPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $total_users = $this->allmodels->allCounts('total_users');
            $all_locations = $this->allmodels->fetchlocations();
            $all_roles = $this->allmodels->fetchAllRoles();
            $user_role = $fetchuserinfo['role'];

            if($fetchuserinfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'view.staff')){


                $data = [
					'total_users' => $total_users,
                    'all_location' => $all_locations,
                    'user_info' => $fetchuserinfo,
                    'all_roles' => $all_roles			
                ];

                require_once('app/views/allusers.php');

            } else {
				$this->forbiddenPage();
			}

        } else {
			require_once('app/views/login.php');
		}
    }

    // Display the all locations page
    public function showAllLocationsPage($rootUrl){

         if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $total_locations = $this->allmodels->allCounts('total_location');
            $user_role = $fetchuserinfo['role'];

            if($fetchuserinfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'view.location')){

                $data = [
					'total_location' => $total_locations,
                    'user_info' => $fetchuserinfo
				];

                require_once('app/views/locations.php');

            } else {
				$this->forbiddenPage();
			}

        } else {
			require_once('app/views/login.php');
		}
      
    }

    // Display the all locations page
    public function showCreateUserPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $all_locations = $this->allmodels->fetchlocations();
            $all_roles = $this->allmodels->fetchAllRoles();
            $user_role = $fetchuserinfo['role'];

            if($fetchuserinfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'view.staffcreation')){

                $data = [
					'all_location' => $all_locations,
                    'user_info' => $fetchuserinfo,
                    'all_roles' => $all_roles
				];

                require_once('app/views/createuser.php');

            } else {                
                $this->forbiddenPage();
            }           

        } else {
			require_once('app/views/login.php');
		}
    }

    // Display the all locations page
    public function showCreateLocationPage($rootUrl){
         if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $user_role = $fetchuserinfo['role'];

            if($fetchuserinfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'view.location')){

                $data = [
                    'user_info' => $fetchuserinfo
				];

                require_once('app/views/createlocation.php');

            } else {
				$this->forbiddenPage();
			}

        } else {
			require_once('app/views/login.php');
		}
    }

    public function showCreateSchedulePage($rootUrl){
       if (session_status() === PHP_SESSION_NONE) {
                session_start();
        }
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $all_locations = $this->allmodels->fetchlocations();
            $user_role = $fetchuserinfo['role'];

            if($fetchuserinfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'view.schedule')){

                $data = [
                    'user_info' => $fetchuserinfo,
					'all_location' => $all_locations
				];

                require_once('app/views/createschedule.php');

            } else {
				$this->forbiddenPage();
			}

        } else {
			require_once('app/views/login.php');
		}
    }

    public function showUserDetailsPage($userId,$rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchadmininfo = $this->allmodels->getUserInfo($email);
            $fetchuserinfo = $this->allmodels->getUserInfo($userId);
            $fetch_all_roles = $this->allmodels->fetchAllRoles()['roles'];
            $role_tags = array_column($fetch_all_roles, 'tag');

            $role = ['hr', 'manager', 'accountant', 'scheduler', 'dos', 'super-admin'];

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role_tags)){

                $data = [
                    "user_info" => $fetchuserinfo
                ];

                require_once('app/views/userdetails.php');

            } else {
				$this->forbiddenPage();
			}

        } else {
            require_once('app/views/login.php');
        }
    }

    public function showChangePasswordPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchadmininfo = $this->allmodels->getUserInfo($email);
            $fetch_all_roles = $this->allmodels->fetchAllRoles()['roles'];
            $role_tags = array_column($fetch_all_roles, 'tag');

            $role = ['hr', 'manager', 'accountant', 'scheduler', 'dos', 'super-admin'];

            if($fetchadmininfo['isAdmin'] > 0 || in_array($fetchadmininfo['role'], $role_tags)){

                $data = [
                    "user_info" => $fetchadmininfo
                ];

                require_once('app/views/change_password.php');

            } else {
				$this->forbiddenPage();
			}

        } else {
            require_once('app/views/login.php');
        }
    }

    public function showProfilePage($rootUrl){
       if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchadmininfo = $this->allmodels->getUserInfo($email);
            $fetch_all_roles = $this->allmodels->fetchAllRoles()['roles'];
            $role_tags = array_column($fetch_all_roles, 'tag');

            $role = ['hr', 'manager', 'accountant', 'scheduler', 'dos', 'super-admin'];

            if($fetchadmininfo['isAdmin'] > 0 || in_array($fetchadmininfo['role'], $role_tags)){

                $data = [
                    "user_info" => $fetchadmininfo
                ];

                require_once('app/views/profile.php');

            } else {
				$this->forbiddenPage();
			}

        } else {
            require_once('app/views/login.php');
        }
    }

    public function showEditProfilePage($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchadmininfo = $this->allmodels->getUserInfo($email);
            $fetch_all_roles = $this->allmodels->fetchAllRoles()['roles'];
            $role_tags = array_column($fetch_all_roles, 'tag');

            $role = ['hr', 'manager', 'accountant', 'scheduler', 'dos', 'super-admin'];

            if($fetchadmininfo['isAdmin'] > 0 || in_array($fetchadmininfo['role'], $role_tags)){

                $data = [
                    "user_info" => $fetchadmininfo
                ];

                require_once('app/views/edit_profile.php');

            } else { 
				$this->forbiddenPage();
			}

        } else {
            require_once('app/views/login.php');
        }
    }

    public function showEditStaffProfilePage($userId,$rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchadmininfo = $this->allmodels->getUserInfo($email);
            $fetchstaffinfo = $this->allmodels->getUserInfo($userId);
            $fetch_all_roles = $this->allmodels->fetchAllRoles()['roles'];
            $role_tags = array_column($fetch_all_roles, 'tag');

            $role = ['hr', 'manager', 'accountant', 'scheduler', 'dos', 'super-admin'];

            if($fetchadmininfo['isAdmin'] > 0 || in_array($fetchadmininfo['role'], $role_tags)){

                $data = [
                    "admin_info" => $fetchadmininfo,
                    "user_info" => $fetchstaffinfo
                ];

                require_once('app/views/edit_staff_profile.php');

            } else { 
				$this->forbiddenPage();
			}

        } else {
            require_once('app/views/login.php');
        }
    }

    public function showAllSchedulePage($rootUrl){
      if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchadmininfo = $this->allmodels->getUserInfo($email);
            $total_schedules = $this->allmodels->allCounts('total_schedule');
            $all_locations = $this->allmodels->fetchlocations();
            $user_role = $fetchadmininfo['role'];

            if($fetchadmininfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'view.schedule')){
                
                $data = [
                    'total_schedules' => $total_schedules,
                    'user_info' => $fetchadmininfo,
                    'all_location' => $all_locations	
                ];
               
                require_once('app/views/allschedule.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
			}

        } else {
            require_once('app/views/login.php');
        }
    }

    public function showGenerateReportPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $all_locations = $this->allmodels->fetchlocations();
            $fetch_all_roles = $this->allmodels->fetchAllRoles()['roles'];
            $role_tags = array_column($fetch_all_roles, 'tag');

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role_tags)){

                $data = [
                    'user_info' => $fetchuserinfo,
					'all_location' => $all_locations
				];

                require_once('app/views/generatereport.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
			}

        } else {
			require_once('app/views/login.php');
		}
    }

    public function showRolePermissionsPage($rootUrl) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['better_email'])) {
            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchadmininfo = $this->allmodels->getUserInfo($email);
            $user_role = $fetchadmininfo['role'];
            if(!($fetchadmininfo['isAdmin'] > 0)){
                $this->forbiddenPage();
            }
            $data = [
                'user_info' => $fetchadmininfo
            ];
            require_once('app/views/role_permissions.php');

        } else {
            require_once('app/views/login.php');
        }

    }

    public function showDocumentManagementPage($rootUrl) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['better_email'])) {
            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchadmininfo = $this->allmodels->getUserInfo($email);
            $user_role = $fetchadmininfo['role'];
            if(!($fetchadmininfo['isAdmin'] > 0)){
                $this->forbiddenPage();
            }
            $data = [
                'user_info' => $fetchadmininfo
            ];
            require_once('app/views/document_management.php');

        } else {
            require_once('app/views/login.php');
        }

    }



    public function showAgencyPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $all_locations = $this->allmodels->fetchlocations();
            $all_roles = $this->allmodels->fetchAllRoles();
            $user_role = $fetchuserinfo['role'];

            if($fetchuserinfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'view.agencycreation')){

                $data = [
					'all_location' => $all_locations,
                    'user_info' => $fetchuserinfo,
                    'all_roles' => $all_roles
				];

                require_once('app/views/create_agency.php');

            } else {                
                $this->forbiddenPage();
            }           

        } else {
			require_once('app/views/login.php');
		}
    }

    public function showAgencyStaffs($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $all_locations = $this->allmodels->fetchlocations();
            $all_roles = $this->allmodels->fetchAllRoles();
            $user_role = $fetchuserinfo['role'];

            if($fetchuserinfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'view.agencystaffs')){

                $data = [
					'all_location' => $all_locations,
                    'user_info' => $fetchuserinfo,
                    'all_roles' => $all_roles,
                    'all_agencies' => $this->allmodels->fetchAgencies(0)
				];

                require_once('app/views/agency_staffs.php');

            } else {                
                $this->forbiddenPage();
            }           

        } else {
			require_once('app/views/login.php');
		}
    }

    public function showCreateAgencySchedulePage($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $all_locations = $this->allmodels->fetchlocations();
            $all_roles = $this->allmodels->fetchAllRoles();
            $user_role = $fetchuserinfo['role'];

            if($fetchuserinfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'create.agencyschedule')){

                $data = [
					'all_locations' => $all_locations,
                    'user_info' => $fetchuserinfo,
                    'all_roles' => $all_roles
				];

                require_once('app/views/create_agency_schedule.php');

            } else {                
                $this->forbiddenPage();
            }           

        } else {
			require_once('app/views/login.php');
		}
    }

    public function showAllAgencySchedulePage($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['better_email'])){

            $email = $_SESSION['better_email'];
            $timezone = $_SESSION['timezone'] ?? 'America/Toronto';
            date_default_timezone_set($timezone);
            $fetchuserinfo = $this->allmodels->getUserInfo($email);
            $all_locations = $this->allmodels->fetchlocations();
            $all_roles = $this->allmodels->fetchAllRoles();
            $user_role = $fetchuserinfo['role'];

            if($fetchuserinfo['isAdmin'] > 0 || $this->allmodels->roleHasPermission($user_role, 'view.agencyschedule')){

                $data = [
					'all_locations' => $all_locations,
                    'user_info' => $fetchuserinfo,
                    'all_roles' => $all_roles
				];

                require_once('app/views/agency_schedule.php');

            } else {                
                $this->forbiddenPage();
            }           

        } else {
			require_once('app/views/login.php');
		}
    }

    public function runRolePermissions() {

        $roleArray = [
            'view.staff' => 'View staff members',
            'edit.staff' => 'Edit staff information',
            'view.staffinfo' => 'View detailed staff info',
            'delete.staff' => 'Delete staff members',
            'change.staffstatus' => 'Change staff status',
            'create.staff' => 'Create new staff',
            'view.location' => 'View locations',
            'create.location' => 'Create new location',
            'edit.location' => 'Edit locations',
            'delete.location' => 'Delete locations',
            'create.schedule' => 'Create schedules',
            'view.schedule' => 'View schedules',
            'view.report' => 'View reports',
            'generate.report' => 'Generate reports',
            'update.schedule' => 'Update schedule information',
            'delete.staffdoc' => 'Delete Staff Document',
            'activate.staffdoc' => 'Activate staff document status',
            'view.staffcreation' => 'View Staff creation page',
            'view.agencycreation' => 'View Agency creation page',
            'create.agencyschedule' => 'Create agency schedules',
            'view.agencystaffs' => "View agency's staffs", 
            'view.agencyschedule' => "View agency's schedules",
        ];

        $insertedCount = 0;
    
        foreach ($roleArray as $key => $value) {
            $sql = "INSERT IGNORE INTO permissions (name, description) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('ss', $key, $value);
            
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $insertedCount++;
            }
            
            $stmt->close();
        }

        $skippedCount = count($roleArray) - $insertedCount;
        echo "Role permissions completed. Inserted: {$insertedCount}, Skipped: {$skippedCount}";

    }

    public function ForbiddenPage() {
        http_response_code(403);
        require_once('app/views/forbidden.php');
        exit;
    }

    public function TestingPage() {
        require_once('app/views/testing.php');
    }

    /**
     * Logs out the user by unsetting the session variables and redirecting
     * back to the login page
     *
     * @param string $rootUrl the root URL of the application
     *
     * @return void
     */
    public function Logout($rootUrl){

        if (session_status() === PHP_SESSION_NONE) {
                session_start();
        }
        unset($_SESSION['better_email']);
        unset($_SESSION["timezone"]);
        unset($_SESSION["userid"]);
        if (!headers_sent()) {
            header("Location: login");
            exit;
        } else {
            echo "Error: Headers already sent. Cannot redirect.";
        }
    }

}