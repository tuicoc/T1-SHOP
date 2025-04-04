<?php 
class DBConnection{
    private $servername = "127.0.0.1";
    private $username = "root";
    private $password = "root";
    private $database = "T1_GOODS";
    private $port = 3306; 
    private $conn;
    
    public function __construct() {
        try {
            // Bước 1: Kết nối MySQL mà KHÔNG chọn database
            $pdo = new PDO("mysql:host=$this->servername;port=$this->port;charset=utf8mb4", 
                           $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Bước 2: Tạo database nếu chưa tồn tại
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$this->database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
            // Bước 3: Kết nối lại với database đã tạo
            $this->conn = new PDO("mysql:host=$this->servername;port=$this->port;dbname=$this->database;charset=utf8mb4", 
                                  $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        } catch (PDOException $e) {
            // die("Database connection failed: " . $e->getMessage());
        }
    }
    

    public function getConnection(){
        return $this->conn;
    }

    public function setUp(): void{
        try {
            // Chọn database
            $this->conn->exec("USE $this->database");
        
            // echo "Connected successfully!";
        
            // Tạo bảng
            $this->conn->exec("
                CREATE TABLE IF NOT EXISTS products (
                    product_id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    description TEXT,
                    price DECIMAL(10,2) NOT NULL,
                    category VARCHAR(100),
                    stock_quantity INT NOT NULL,
                    image_url VARCHAR(255),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ");
        
            $this->conn->exec("
                CREATE TABLE IF NOT EXISTS categories (
                    category_id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL UNIQUE
                )
            ");

            $this->conn->exec("
            CREATE TABLE IF NOT EXISTS reviews (
                review_id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                rating INT CHECK (rating BETWEEN 1 AND 5),
                average_rating DECIMAL(3,2) DEFAULT 0,
                review_count INT DEFAULT 0,
                review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                review_text TEXT,
                FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
            )");
    
            $this->conn->exec("CREATE TABLE IF NOT EXISTS users (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('user', 'admin') DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            
    
        
            // Danh sách sản phẩm

            // Danh sách danh mục cần thêm
            $categories = ["Esports Merch", "Valorant Team"];

            // Chuẩn bị câu lệnh chèn danh mục
            $categoryStmt = $this->conn->prepare("INSERT IGNORE INTO categories (name) VALUES (?)");

            // Chèn danh mục vào bảng categories
            foreach ($categories as $category) {
                $categoryStmt->execute([$category]);
            }


            $products = [
                ["[LoL] 2025 T1 Uniform Jacket", "2025 T1 Uniform Jacket", 2630000, "LOL Team", 50, "public/images/pic1.png"],
                ["[PRE-ORDER] [VAL] 2025 T1 Masters Champions Muffler", "Pre-Order Valorant Team", 635000, "VAL Team", 100, "public/images/pic2.jpg"],
                ["2025 T1 Uniform Pants", "2025 T1 Uniform Pants", 1747000, "LOL Team", 40, "public/images/pic3.jpg"],
                ["[VAL] 2025 T1 Uniform Jacket", "2025 VAL Uniform Jacket", 2630000, "VAL Team", 50, "public/images/pic4.jpg"],
                ["[LoL] 2025 T1 Uniform Jersey", "2025 T1 Uniform Jersey", 2110000, "LOL Team", 35, "public/images/pic5.jpg"],
                ["[PRE-ORDER] [VAL] 2025 T1 Masters Champions T-Shirt", "Pre-Order Valorant Team", 794000, "VAL Team", 80, "public/images/pic6.jpg"],
                ["T1 Hwarang Zip-Up Hoodie", "T1 Hwarang Hoodie", 1571000, "LOL Team", 20, "public/images/pic7.jpg"],
                ["T1 Logo Polo Shirt - Black", "T1 Polo Shirt Black", 740000, "LOL Team", 15, "public/images/pic8.jpg"],
                ["T1 Logo Sweatshirt - Grey", "T1 Sweatshirt Grey", 1410000, "LOL Team", 30, "public/images/pic9.jpg"],
                ["T1 20th Anniv. Faker T-Shirt", "T1 Faker Anniversary T-Shirt", 740000, "LOL Team", 25, "public/images/pic10.jpg"]
            ];

            // Chuẩn bị câu lệnh để thêm danh mục nếu chưa tồn tại
            $categoryStmt = $this->conn->prepare("INSERT IGNORE INTO categories (name) VALUES (?)");

            // Chuẩn bị câu lệnh lấy category_id
            $getCategoryIdStmt = $this->conn->prepare("SELECT category_id FROM categories WHERE name = ?");
        
            // Chuẩn bị lệnh SQL
            $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, category, stock_quantity, image_url) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
        
            // Chèn dữ liệu
            foreach ($products as $product) {
                $stmt->execute($product);
            }

            // Chèn đánh giá mẫu
            $reviews = [
                [1, 5, 4.8, 120, "2025-03-01", "Amazing quality, really love it!"],
                [2, 4, 4.2, 85, "2025-03-05", "Great product, but took a while to arrive."],
                [3, 3, 3.5, 45, "2025-03-10", "Average quality, expected better."],
                [4, 5, 4.9, 200, "2025-03-12", "Perfect fit and design!"],
                [5, 2, 2.8, 30, "2025-03-15", "Not what I expected, material feels cheap."],
                [6, 4, 4.0, 95, "2025-03-18", "Good value for the price."],
                [7, 5, 4.7, 150, "2025-03-20", "Best hoodie ever!"],
                [8, 3, 3.2, 40, "2025-03-22", "Size runs small, order a size up."],
                [9, 4, 4.1, 60, "2025-03-25", "Comfortable but a bit expensive."],
                [10, 5, 4.9, 180, "2025-03-28", "Absolutely love it, must-buy!"],
            ];
        
            $reviewStmt = $this->conn->prepare("INSERT INTO reviews (product_id, rating, average_rating, review_count, review_date, review_text) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($reviews as $review) {
                $reviewStmt->execute($review);
            }

            $hashedPassword = password_hash("admin", PASSWORD_DEFAULT);
            $this->conn->exec("INSERT IGNORE INTO users (name, email, password, role) VALUES
                ('admin', 'admin@example.com', '$hashedPassword', 'admin')");
        
        
        
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

}

?>