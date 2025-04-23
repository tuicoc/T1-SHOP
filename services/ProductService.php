<?php
// require_once('../mywebsite/config/config.php'); // chạy tới config để hiểu APP_ROOT là gì
require_once APP_ROOT.'/model/Product.php'; // include model vào
require_once APP_ROOT.'/libs/DBConnection.php';
class ProductService{
    public function getAllProducts(){

        // connect database
        try{
    
            $dbconnection = new DBConnection();
            $conn = $dbconnection->getConnection();

            // Query
            $sql = "SELECT * FROM products";
            $stmt = $conn->query($sql);
        
            // Get data
            $products = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  // Use PDO::FETCH_ASSOC
                $product = new Product($row['product_id'], $row['name'], $row['description'], 
                                       $row['price'], $row['category'], $row['stock_quantity'], $row['image_url']);
                $products[] = $product;
            }
        
            return $products;
        }catch(PDOException $e){
            // $conn = null;
            // echo "Connection failed: " . $e->getMessage();
            return $products = []; // được không được vẫn return rỗng
        }
    
    }

    public function getPaginatedProducts($currentPage, $productsPerPage, $sort) {
        $dbconnection = new DBConnection();
        $conn = $dbconnection->getConnection();
    
        $startIndex = ($currentPage - 1) * 9;
    
        // Xác định sorting
        switch ($sort) {
            case 'price_asc':  $orderBy = "price ASC"; break;
            case 'price_desc': $orderBy = "price DESC"; break;
            case 'name_asc':   $orderBy = "name ASC"; break;
            case 'name_desc':  $orderBy = "name DESC"; break;
            default:           $orderBy = "product_id ASC"; 
        }
    
        // Query SQL với ORDER BY
        $query = "SELECT * FROM products ORDER BY $orderBy LIMIT :limit OFFSET :offset";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':limit', $productsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $startIndex, PDO::PARAM_INT);
        $stmt->execute();
    
        // Chuyển đổi dữ liệu thành danh sách Product
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                $row['product_id'], 
                $row['name'], 
                $row['description'], 
                $row['price'], 
                $row['category'], 
                $row['stock_quantity'], 
                $row['image_url']
            );
        }
    
        return $products;
    }

    public function getCategories(string $category, int $currentPage, int $productsPerPage, string $sort) {
        $dbconnection = new DBConnection();
        $conn = $dbconnection->getConnection();
    
        $startIndex = ($currentPage - 1) * 9;
    
        // Xác định sorting
        switch ($sort) {
            case 'price_asc':  $orderBy = "price ASC"; break;
            case 'price_desc': $orderBy = "price DESC"; break;
            case 'name_asc':   $orderBy = "name ASC"; break;
            case 'name_desc':  $orderBy = "name DESC"; break;
            default:           $orderBy = "product_id ASC"; 
        }
    
        // Query SQL với ORDER BY, LIMIT & OFFSET (phân trang)
        $query = "SELECT * FROM products WHERE category = :category ORDER BY $orderBy LIMIT :limit OFFSET :offset";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $productsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $startIndex, PDO::PARAM_INT);
        $stmt->execute();
    
        // Chuyển đổi dữ liệu thành danh sách Product
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                $row['product_id'], 
                $row['name'], 
                $row['description'], 
                $row['price'], 
                $row['category'], 
                $row['stock_quantity'], 
                $row['image_url']
            );
        }
    
        return $products;
    }
    
    public function countProductsByCategory(string $category) {
        $dbconnection = new DBConnection();
        $conn = $dbconnection->getConnection();
    
        // Query to count products in the selected category
        $query = "SELECT COUNT(*) FROM products WHERE category = :category";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->execute();
    
        return (int) $stmt->fetchColumn();
    }

    public function getProductsBySearch($searchTerm, $sort = 'trending') {
        try {
            $dbconnection = new DBConnection();
            $conn = $dbconnection->getConnection();
    
            // Xác định cách sắp xếp (tương tự các hàm khác)
            switch ($sort) {
                case 'price_asc':  $orderBy = "price ASC"; break;
                case 'price_desc': $orderBy = "price DESC"; break;
                case 'name_asc':   $orderBy = "name ASC"; break;
                case 'name_desc':  $orderBy = "name DESC"; break;
                default:           $orderBy = "product_id ASC"; 
            }
    
            // Chuẩn bị truy vấn tìm kiếm (tìm trong cả name và description)
            $query = "SELECT * FROM products 
                     WHERE name LIKE :searchTerm 
                     OR description LIKE :searchTerm
                     ORDER BY $orderBy";
            
            $stmt = $conn->prepare($query);
            $searchParam = "%" . $searchTerm . "%";
            $stmt->bindValue(':searchTerm', $searchParam, PDO::PARAM_STR);
            $stmt->execute();
    
            // Xử lý kết quả trả về (tương tự các hàm khác)
            $products = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[] = new Product(
                    $row['product_id'], 
                    $row['name'], 
                    $row['description'], 
                    $row['price'], 
                    $row['category'], 
                    $row['stock_quantity'], 
                    $row['image_url']
                );
            }
    
            return $products;
    
        } catch(PDOException $e) {
            // Ghi log lỗi và trả về mảng rỗng nếu có lỗi
            error_log("Database search error: " . $e->getMessage());
            return [];
        }
    }
    



    public function searchProducts($searchTerm) {
        // Thực hiện truy vấn database với search term
        // Ví dụ: 
        // $query = "SELECT * FROM products WHERE name LIKE :search";
        // Thay bằng logic thực tế của bạn
        $searchTerm = "%" . $searchTerm . "%";
        // Trả về mảng products phù hợp
        return $this->getProductsBySearch($searchTerm);
    }
    
    
    // Thêm sản phẩm mới
    public function addProduct($name, $description , $price, $category, $imageUrl) {
        try {
            $dbconnection = new DBConnection();
            $conn = $dbconnection->getConnection();
    
            $sql = "INSERT INTO products (name, description, price, category, stock_quantity, image_url) 
                    VALUES (:name, :description, :price, :category, :stock_quantity, :image_url)";
            
            $stmt = $conn->prepare($sql);
            
            // Gán giá trị mặc định cho các trường NOT NULL
            $stockQuantity = 0; // Giá trị mặc định cho stock_quantity
            
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);
            $stmt->bindValue(':price', (float)$price, PDO::PARAM_STR);
            $stmt->bindValue(':category', $category, PDO::PARAM_STR);
            $stmt->bindValue(':stock_quantity', $stockQuantity, PDO::PARAM_INT);
            $stmt->bindValue(':image_url', $imageUrl, PDO::PARAM_STR);
    
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("SQL Error: " . print_r($stmt->errorInfo(), true));
                return false;
            }
            
            return true;
        } catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    // Cập nhật sản phẩm
    public function updateProduct($productId, $name, $description, $price, $category, $imageUrl = null) {
        try {
            $dbconnection = new DBConnection();
            $conn = $dbconnection->getConnection();

            // Nếu có ảnh mới
            if ($imageUrl) {
                $sql = "UPDATE products SET 
                        name = :name, 
                        description = :description, 
                        price = :price, 
                        category = :category,
                        image_url = :image_url
                        WHERE product_id = :product_id";
            } else {
                $sql = "UPDATE products SET 
                        name = :name, 
                        description = :description, 
                        price = :price, 
                        category = :category
                        WHERE product_id = :product_id";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_id', $productId);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category', $category);
            
            if ($imageUrl) {
                $stmt->bindParam(':image_url', $imageUrl);
            }

            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }

    // Xóa sản phẩm
    public function deleteProduct($productId) {
        try {
            $dbconnection = new DBConnection();
            $conn = $dbconnection->getConnection();

            $sql = "DELETE FROM products WHERE product_id = :product_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_id', $productId);

            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }

    // Lấy thông tin 1 sản phẩm theo ID
    public function getProductById($productId) {
        try {
            $dbconnection = new DBConnection();
            $conn = $dbconnection->getConnection();

            $sql = "SELECT * FROM products WHERE product_id = :product_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_id', $productId);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                return new Product(
                    $row['product_id'],
                    $row['name'],
                    $row['description'],
                    $row['price'],
                    $row['category'],
                    $row['stock_quantity'],
                    $row['image_url']
                );
            }
            
            return null;
        } catch(PDOException $e) {
            error_log("Error getting product: " . $e->getMessage());
            return null;
        }
    }
    
}

?>