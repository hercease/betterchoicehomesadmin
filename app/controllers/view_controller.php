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
    // Display the dashboard page
    public function showDashboardPage($rootUrl){
        if (session_status() === PHP_SESSION_NONE) {
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


             $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role)){

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
				];

                require_once('app/views/dashboard.php');

            } else {
				require_once('app/views/login.php');
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

             $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role)){


                $data = [
					'total_users' => $total_users,
                    'all_location' => $all_locations,
                    'user_info' => $fetchuserinfo,				
                ];

                require_once('app/views/allusers.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
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

             $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role)){

                $data = [
					'total_location' => $total_locations,
                    'user_info' => $fetchuserinfo
				];

                require_once('app/views/locations.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
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
            $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role)){

                $data = [
					'all_location' => $all_locations,
                    'user_info' => $fetchuserinfo
				];

                require_once('app/views/createuser.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
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

             $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role)){

                $data = [
                    'user_info' => $fetchuserinfo
				];

                require_once('app/views/createlocation.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
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

             $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role)){

                $data = [
                    'user_info' => $fetchuserinfo,
					'all_location' => $all_locations
				];

                require_once('app/views/createschedule.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
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
            $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchadmininfo['isAdmin'] > 0 || in_array($fetchadmininfo['role'], $role)){

                $data = [
                    "user_info" => $fetchuserinfo
                ];

                require_once('app/views/userdetails.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
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
            $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchadmininfo['isAdmin'] > 0 || in_array($fetchadmininfo['role'], $role)){

                $data = [
                    "user_info" => $fetchadmininfo
                ];

                require_once('app/views/change_password.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
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
            $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchadmininfo['isAdmin'] > 0 || in_array($fetchadmininfo['role'], $role)){

                $data = [
                    "user_info" => $fetchadmininfo
                ];

                require_once('app/views/profile.php');

            } else {
				echo "Sorry, you are not allowed to view this page";
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
            $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchadmininfo['isAdmin'] > 0 || in_array($fetchadmininfo['role'], $role)){

                $data = [
                    "user_info" => $fetchadmininfo
                ];

                require_once('app/views/edit_profile.php');

            } else { 
				echo "Sorry, you are not allowed to view this page";
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
            $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchadmininfo['isAdmin'] > 0 || in_array($fetchadmininfo['role'], $role)){
                
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

             $role = ['hr', 'manager', 'accountant', 'scheduler', 'directorofservices'];

            if($fetchuserinfo['isAdmin'] > 0 || in_array($fetchuserinfo['role'], $role)){

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