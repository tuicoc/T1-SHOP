<!-- <?php 
    // header('location: controller/HomeController.php')
?> -->

<?php
require_once('../config/config.php'); //require_once là include nhưng check coi có xuất hiện chưa, rồi thì ko include
require_once('../libs/DBConnection.php');

// $dbconnection = new DBConnection();
// $dbconnection->setUp();

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action     = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($controller) {
    case 'login':
        require_once APP_ROOT.'/controller/LoginController.php';
        $login_controller = new LoginController();
        $login_controller->$action();
        break;
    case 'service':
        require_once APP_ROOT.'/controller/ServiceController.php';
        $service_controller = new ServiceController();
        $service_controller->$action();
        break;

    case 'categories':
        require_once APP_ROOT.'/controller/CategoriesController.php';
        $categories_controller = new CategoriesController();
        $categories_controller->$action();
        break;
    case 'contact':
        require_once APP_ROOT.'/controller/ContactController.php';
        $contact_controller = new ContactController();
        $contact_controller->$action();
        break;
    case 'admin':
        require_once APP_ROOT.'/controller/AdminController.php';
        $contact_controller = new AdminController();
        $contact_controller->$action();
        break;
    default:
        require_once APP_ROOT.'/controller/HomeController.php';
        $home_controller = new HomeController();
        $home_controller->$action();
        break;
}

?>
