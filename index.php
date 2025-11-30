<?php
require_once('config/config.php');
require_once('app/controllers/db_controller.php');
require_once('app/controllers/view_controller.php');
require_once('app/controllers/model_controller.php');
require_once('app/models/allmodels.php');
// Handle routing
$baseDir = '/betterchoicehomeadmin';  // Base directory where your app is located
$url = str_replace($baseDir, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// Initialize database
$db = (new Database())->connect();
$rootUrl = (new allmodels($db))->getCurrentUrl();
$viewController = new ViewController($db);
$modelController = new ModelController($db);

switch ($url) {
    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showLoginPage($rootUrl);
        }
        break;
    case '/forgot_password':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showForgotPage($rootUrl);
        }
        break;
    case '/allusers':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showAllUsersPage($rootUrl);
        }
        break;
    case '/locations':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showAllLocationsPage($rootUrl);
        }
        break;
    case '/createuser':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showCreateUserPage($rootUrl);
        }
        break;
    case '/generatereport':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showGenerateReportPage($rootUrl);
        }
        break;
    case (preg_match('/^\/userdetails\/(\d+)$/', $url, $matches) ? '/userdetails/' . $matches[1] : null):
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userId = $matches[1];
            $viewController->showUserDetailsPage($userId,$rootUrl);
        }
        break;
    case (preg_match('/^\/editstaffprofile\/(\d+)$/', $url, $matches) ? '/editstaffprofile/' . $matches[1] : null):
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userId = $matches[1];
            $viewController->showEditStaffProfilePage($userId,$rootUrl);
        }
        break;
    case '/createlocation':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showCreateLocationPage($rootUrl);
        }
        break;
    case '/createschedule':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showCreateSchedulePage($rootUrl);
        }
        break;
    case '/allschedules':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showAllSchedulePage($rootUrl);
        }
        break;
    case '/change_password':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showChangePasswordPage($rootUrl);
        }
        break;
    case '/profile_details':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showProfilePage($rootUrl);
        }
        break;
    case '/edit_profile':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showEditProfilePage($rootUrl);
        }
        break;
    case '/role_permissions':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showRolePermissionsPage($rootUrl);
        }
        break;
    case '/document_management':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showDocumentManagementPage($rootUrl);
        }
        break;
    case '/create_agency':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showAgencyPage($rootUrl);
        }
        break;
    case '/agency_staffs':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showAgencyStaffs($rootUrl);
        }
        break;
    case '/create_agency_schedule':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showCreateAgencySchedulePage($rootUrl);
        }
        break;
    case '/forbidden':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->ForbiddenPage($rootUrl);
        }
        break;
    case '/logout':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->Logout($rootUrl);
        }
        break;
    case '/dashboard':
    case '/':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $viewController->showDashboardPage($rootUrl);
        }
        break;
    case '/get_roles_permissions':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $modelController->getRolesPermissions();
        }
        break;
    case '/fetch_document_details':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $modelController->getDocumentDetails();
        }
        break;
    case '/fetch_all_documents':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $modelController->getDocumentList();
        }
        break;
    case '/get_role_details':
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            $modelController->getRoleDetails();
        }
        break;
    case '/run_schedule_check':
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            $modelController->runScheduleCheck();
        }
        break;
    case '/run_role_permissions':
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            $viewController->runRolePermissions();
        }
        break;
    case '/testing_page':
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            $viewController->TestingPage();
        }
        break;
    case '/fetch_agency_staffs':
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            $modelController->fetchAgencyStaffs();
        }
        break;
    case '/agency_schedules':
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            $viewController->showAllAgencySchedulePage($rootUrl);
        }
        break;
    case '/handlelogin':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelController->handleLogin();
        }
        break;
    case '/fetch_all_staffs':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelController->fetchStaffsList();
        }
        break;
    case '/fetch_all_locations':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelController->fetchAllLocationsData();
        }
        break;
    case '/get-coordinates':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelController->getCoordinates();
        }
        break;
    case '/processlocationregistration':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelController->ProcessLocation();
        }
        break;
    case '/processcreateuser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->ProcessCreateUser();
        }
        break;
    case '/fetch_user_documents':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->fetchUserDocumentData();
        }
        break;
    case '/fetch_user_certificates':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->fetchUserCertificateData();
        }
        break;
    case '/fetch_all_schedule':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->fetchAllSchedule();
        }
        break;
    case '/delete_user_details':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->DeleteUserDetails();
        }
        break;
    case '/update_account_status':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->UpdateUserAccountStatus();
        }
        break;
    case '/generatescheduleform':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->GenerateScheduleForm();
        }
        break;
    case '/save_schedule':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->saveSchedule();
        }
        break;
    case '/delete_schedule':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->DeleteSchedule();
        }
        break;
    case '/update_schedule':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->updateSchedule();
        }
        break;
    case '/processchangepassword':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->changePassword();
        }
        break;
    case '/delete_user_document':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->deleteDocument();
        }
        break;
    case '/document_activation':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->documentActivation();
        }
        break;
    case '/generate_report_result':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->generateReports();
        }
        break;
    case '/schedule_testing':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->scheduleTesting();
        }
        break;
    case '/update_profile':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->updateProfile();
        }
        break;
    case '/process_forgot_password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->processForgotPassword();
        }
        break;
    case '/update_role_permission_status':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->updatePermissions();
        }
        break;
    case '/get_schedule_details':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->getScheduleDetails();
        }
        break;
    case '/process_documents':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->processDocuments();
        }
        break;
    case '/delete_document_type':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->deleteTypeDocument();
        }
        break;
    case '/add_new_role':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->AddNewRole();
        }
        break;
    case '/delete_role':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->deleteARole();
        }
        break;
    case '/fetch_all_agencies':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->fetchAllAgenciesData();
        }
        break;
    case '/fetch_all_agency_users':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->fetchAllAgenciesStaffData();
        }
        break;
    case '/insertagency':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->processAgency();
        }
        break;
    case '/insertagencystaff':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->processAgencyStaffRegistration();
        }
        break;
    case '/delete_agencystaff':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->processAgencystaffDeletion();
        }
        break;
    case '/process_agency_staff_schedules':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->processAgencyStaffSchedules();
        }
        break;
    case '/fetch_agency_schedules':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->agencySchedules();
        }
        break;
    case '/update_agency_schedule':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $modelController->updateAgencySchedule();
        }
        break;
    
    }
