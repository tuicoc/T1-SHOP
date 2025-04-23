<!-- <?php 
    // header('location: controller/HomeController.php')
?> -->

<?php
require_once('../config/config.php'); //require_once là include nhưng check coi có xuất hiện chưa, rồi thì ko include
require_once('../libs/DBConnection.php');

// Bắt đầu hoặc tiếp tục session
if (session_status() === PHP_SESSION_NONE) {
    // Cấu hình session timeout 30 phút
    ini_set('session.gc_maxlifetime', 1800); // 30 phút
    session_set_cookie_params(1800);
    session_start();
}

// Kiểm tra timeout session
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // Nếu quá 30 phút không hoạt động, logout
    session_unset();
    session_destroy();
    header('Location: ../index.php?controller=login&action=logout');
    exit();
}

// Cập nhật thời gian hoạt động cuối cùng
$_SESSION['LAST_ACTIVITY'] = time();


$dbconnection = new DBConnection();
$dbconnection->setUp();

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
          // Kiểm tra nếu các session cần thiết rỗng hoặc không tồn tại
            if (empty($_SESSION['user_id']) || empty($_SESSION['name']) || 
            empty($_SESSION['email']) || empty($_SESSION['role'])) {
            header('Location: ../index.php?controller=login&action=index');
            exit();
            }

        // Kiểm tra role nếu cần (ví dụ chỉ admin mới được vào)
        if ($_SESSION['role'] != 'admin') {
            header('Location: ../index.php?controller=home&action=index');
            exit();
            }

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
