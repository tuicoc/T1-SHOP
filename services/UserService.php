<?php
require_once APP_ROOT . '/model/User.php';
require_once APP_ROOT . '/libs/DBConnection.php';

class UserService {
    
    // Lấy tất cả user
    public function getAllUsers() {
        try {
            $dbconnection = new DBConnection();
            $conn = $dbconnection->getConnection();
    
            $sql = "SELECT * FROM users";
            $stmt = $conn->query($sql);
    
            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    $row['user_id'], 
                    $row['name'], 
                    $row['email'], 
                    $row['password'], 
                    $row['role'], 
                    $row['created_at']
                );
            }
    
            return $users;
        } catch (PDOException $e) {
            return []; // Nếu lỗi, trả về mảng rỗng
        }
    }

    // Lấy danh sách user có phân trang
    public function getPaginatedUsers($currentPage, $usersPerPage, $sort) {
        $dbconnection = new DBConnection();
        $conn = $dbconnection->getConnection();
    
        $startIndex = ($currentPage - 1) * $usersPerPage;
    
        // Xác định sorting
        switch ($sort) {
            case 'name_asc':   $orderBy = "name ASC"; break;
            case 'name_desc':  $orderBy = "name DESC"; break;
            case 'role_asc':   $orderBy = "role ASC"; break;
            case 'role_desc':  $orderBy = "role DESC"; break;
            default:           $orderBy = "user_id ASC"; 
        }
    
        // Query SQL với ORDER BY, LIMIT, OFFSET
        $query = "SELECT * FROM users ORDER BY $orderBy LIMIT :limit OFFSET :offset";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':limit', $usersPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $startIndex, PDO::PARAM_INT);
        $stmt->execute();
    
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $row['user_id'], 
                $row['name'], 
                $row['email'], 
                $row['password'], 
                $row['role'], 
                $row['created_at']
            );
        }
    
        return $users;
    }

    // Lấy user theo role (admin/user)
    public function getUsersByRole(string $role, int $currentPage, int $usersPerPage, string $sort) {
        $dbconnection = new DBConnection();
        $conn = $dbconnection->getConnection();
    
        $startIndex = ($currentPage - 1) * $usersPerPage;
    
        switch ($sort) {
            case 'name_asc':   $orderBy = "name ASC"; break;
            case 'name_desc':  $orderBy = "name DESC"; break;
            default:           $orderBy = "user_id ASC"; 
        }
    
        $query = "SELECT * FROM users WHERE role = :role ORDER BY $orderBy LIMIT :limit OFFSET :offset";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $usersPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $startIndex, PDO::PARAM_INT);
        $stmt->execute();
    
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $row['user_id'], 
                $row['name'], 
                $row['email'], 
                $row['password'], 
                $row['role'], 
                $row['created_at']
            );
        }
    
        return $users;
    }

    // Đếm số lượng user theo vai trò (admin/user)
    public function countUsersByRole(string $role) {
        $dbconnection = new DBConnection();
        $conn = $dbconnection->getConnection();
    
        $query = "SELECT COUNT(*) FROM users WHERE role = :role";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
    
        return (int) $stmt->fetchColumn();
    }

    // Lấy user theo email (để đăng nhập)
    public function getUserByEmail(string $email) {
        $dbconnection = new DBConnection();
        $conn = $dbconnection->getConnection();
    
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User(
                $row['user_id'], 
                $row['name'], 
                $row['email'], 
                $row['password'], 
                $row['role'], 
                $row['created_at']
            );
        }
    
        return null;
    }

    // Thêm user mới
    public function createUser(string $name, string $email, string $password, string $role = 'user') {
        $dbconnection = new DBConnection();
        $conn = $dbconnection->getConnection();
        
        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Câu lệnh SQL để thêm người dùng
        $query = "INSERT INTO users (name, email, password, role, created_at) 
                  VALUES (:name, :email, :password, :role, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
    
        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            // Lấy ID của người dùng vừa được tạo
            $userId = $conn->lastInsertId();
            
            // Trả về đối tượng User
            return new User($userId, $name, $email, $role);
        }
        
        // Nếu có lỗi khi tạo người dùng, trả về false
        return false;
    }
    
    
    // Xóa user theo ID
    public function deleteUser(int $user_id) {
        $dbconnection = new DBConnection();
        $conn = $dbconnection->getConnection();
    
        $query = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    
        return $stmt->execute();
    }

    // Kiểm tra đăng nhập
    public function login(string $email, string $password) {
        $user = $this->getUserByEmail($email);
        
        if ($user && password_verify($password, $user->getPassword())) {
            // KHÔNG bắt đầu session ở đây, để controller xử lý
            return $user;
        }
        return null;
    }

    // Đăng xuất
    public function logout() {
        session_start();
        session_destroy();
    }
}

?>
