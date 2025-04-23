<?php
require_once(APP_ROOT.'/services/ProductService.php');
require_once(APP_ROOT.'/services/UserService.php');

class LoginController{
    public function index(){
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', 0); 
            session_start();
        }
        include APP_ROOT.'/views/login/index.php'; 
    }

    public function signup() {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', 0); 
            session_start();
        }

        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            // $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
                header('Location: ' . DOMAIN . '/public/index.php?controller=home');
                exit();
            }

            // if ($password !== $confirmPassword) {
            //     $_SESSION['error'] = "Mật khẩu xác nhận không khớp!";
            //     header("Location: " . APP_ROOT . "/signup");
            //     exit();
            // }

            $userService = new UserService();
            $existingUser = $userService->getUserByEmail($email);
            if ($existingUser) {
                $_SESSION['error'] = "This email is already registered!";
                header('Location: ' . DOMAIN . '/public/index.php?controller=login&action=index&form=register');
                exit();
            }

            $user = $userService->createUser($name, $email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user->getUserId();
                $_SESSION['name'] = $user->getName();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['role'] = $user->getRole();

                header('Location: ' . DOMAIN . '/public/index.php?controller=home');
                exit();
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại!";
                // header("Location: " . APP_ROOT . "/signup");
                exit();
            }
        } else {
            include APP_ROOT . '/views/signup/index.php'; 
        }
    }
    
    public function signin(){
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', 0); 
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userService = new UserService();
            $user = $userService->login($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user->getUserId();
                $_SESSION['name'] = $user->getName();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['role'] = $user->getRole();

                header('Location: ' . DOMAIN . '/public/index.php?controller=home');
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password!";
                header('Location: ' . DOMAIN . '/public/index.php?controller=login&action=index');
                exit();
            }
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', 0); 
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: ' . DOMAIN . '/public/index.php?controller=home');
        exit();
    }
}
?>