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

            // Kiểm tra xem bảng 'products' đã tồn tại chưa (giả sử đây là bảng chính)
            $checkTable = $this->conn->query("SHOW TABLES LIKE 'products'");
            
            // Nếu bảng 'products' đã tồn tại, dừng thực thi
            if ($checkTable->rowCount() > 0) {
                return; // Thoát khỏi hàm nếu database đã được tạo
            }
                
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
                ["T1 20th Anniv. Faker T-Shirt", "T1 Faker Anniversary T-Shirt", 740000, "LOL Team", 25, "public/images/pic10.jpg"],

                ["T1 Logo Down Vest", "T1 Logo Down Vest", 135000, "LOL Team", 30, "public/images/pic11.jpg"],
                ["T1 Official Light Stick", "T1 Official Light Stick", 75000, "LOL Team", 100, "public/images/pic12.jpg"],
                ["T1 20th Anniversary Badge", "T1 20th Anniversary Badge", 12000, "LOL Team", 150, "public/images/pic13.jpg"],
                ["2025 T1 VAL Player Desk Mat", "2025 T1 VAL Player Desk Mat", 33000, "VAL Team", 60, "public/images/pic14.jpg"],
                ["2025 T1 VAL Player Slogan", "2025 T1 VAL Player Slogan", 12000, "VAL Team", 90, "public/images/pic15.jpg"],
                ["T1 Keycap Set", "T1 Keycap Set", 59000, "LOL Team", 50, "public/images/pic16.png"],
                ["T1 20th Anniv. Faker Keychain", "T1 20th Anniversary Faker Keychain", 15000, "LOL Team", 100, "public/images/pic17.jpg"],
                ["T1 20th Anniv. Faker Badge", "T1 20th Anniversary Faker Badge", 12000, "LOL Team", 150, "public/images/pic18.jpg"],
                ["T1 Logo T-Shirt", "T1 Logo T-Shirt", 36000, "LOL Team", 50, "public/images/pic19.jpg"],
                ["2023 World Champions T1 Desk Mat Ver.2", "2023 World Champions T1 Desk Mat Ver.2", 33000, "LOL Team", 60, "public/images/pic20.jpg"],

                ["2024 T1 MSI T-Shirt Chengdu Edition - White", "2024 T1 MSI T-Shirt Chengdu Edition - White", 42000, "LOL Team", 40, "public/images/pic21.jpg"],
                ["T1 Do or Die Desk Mat", "T1 Do or Die Desk Mat", 33000, "LOL Team", 60, "public/images/pic22.jpg"],
                ["T1 White Umbrella", "T1 White Umbrella", 34000, "LOL Team", 70, "public/images/pic23.jpg"],
                ["T1 x NIKE Hoodie", "T1 x NIKE Hoodie", 85000, "LOL Team", 30, "public/images/pic24.jpg"],
                ["T1 Summer Nylon Shorts", "T1 Summer Nylon Shorts", 50000, "LOL Team", 40, "public/images/pic25.jpg"],
                ["T1 Summer Sweat Shorts", "T1 Summer Sweat Shorts", 46000, "LOL Team", 40, "public/images/pic26.jpg"],
                ["T1 2022 LCK SPRING CHAMPIONS T-Shirt", "T1 2022 LCK SPRING CHAMPIONS T-Shirt", 42000, "LOL Team", 50, "public/images/pic27.jpg"],
                ["T1 Official Light Stick Charm - V5 Champions Edition", "T1 Official Light Stick Charm - V5 Champions Edition", 6500, "LOL Team", 100, "public/images/pic28.jpg"],
                ["T1 Champion's Legacy Keychain", "T1 Champion's Legacy Keychain", 20000, "LOL Team", 100, "public/images/pic29.jpg"],
                ["2024 T1 World Champions Half Zip-Up", "2024 T1 World Champions Half Zip-Up", 69000, "LOL Team", 30, "public/images/pic30.jpg"],
                ["T1 Clubhouse Sweatpants", "T1 Clubhouse Sweatpants", 79000, "LOL Team", 40, "public/images/pic31.jpg"],
                ["T1 Clubhouse Sweatshirt", "T1 Clubhouse Sweatshirt", 89000, "LOL Team", 40, "public/images/pic32.jpg"],
                ["T1 Clubhouse Piping Track Pants", "T1 Clubhouse Piping Track Pants", 109000, "LOL Team", 40, "public/images/pic33.jpg"],
                ["T1 Clubhouse Piping Track Jacket", "T1 Clubhouse Piping Track Jacket", 149000, "LOL Team", 30, "public/images/pic34.jpg"],
                ["T1 Logo Desk Mat Ver.2", "T1 Logo Desk Mat Ver.2", 22000, "LOL Team", 60, "public/images/pic35.jpg"],
                ["2024 T1 World Champions Fleece Jacket", "2024 T1 World Champions Fleece Jacket", 89000, "LOL Team", 30, "public/images/pic36.jpg"]
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