<?php //include "../view/shared/header.php"; ?>
<?php 
    // if(isset($_GET['act'])){
    //     switch($_GET['act']){
    //         case 'services':
    //             include "../view/services.php";
    //             break;
    //         default:
    //             include "../view/index.php";
    //             break;
    //     }
    // }
    // else{
    //     include "../view/index.php";
    // }

?>

<?php //include "../view/shared/footer.php"; ?>


<?php
require_once(APP_ROOT.'/services/ProductService.php');

class AdminController{
    public function index(){
        $product_service = new ProductService();
        $products = $product_service->getAllProducts();
        
        include APP_ROOT.'/views/admin/index.php'; 
    }

     // Xử lý thêm sản phẩm
     public function addProduct() {
        $product_service = new ProductService();
        // $products = $product_service->getAllProducts();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Validate và lấy dữ liệu từ form
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $price = (float)($_POST['price'] ?? 0);
                $category = $_POST['category'] ?? 'LOL';
                
                // Xử lý upload ảnh
                $imageUrl = $this->handleImageUpload();
                
                // Validate dữ liệu cơ bản
                if (empty($name) || empty($description) || $price <= 0) {
                    throw new Exception("Invalid product data");
                }
                
                // Gọi service để thêm sản phẩm
                $result = $product_service->addProduct(
                    $name,
                    $description,
                    $price,
                    $category,
                    $imageUrl
                );
                
                if ($result) {
                    header('Location: ' . DOMAIN . '/public/index.php?controller=admin');
                    exit();
                } else {
                    // header('Location: /admin?error=add');
                    exit();
                }
            } catch (Exception $e) {
                error_log("Add product error: " . $e->getMessage());
                // header('Location: /admin?error=add');
                exit();
            }
        }
    }
    // Xử lý cập nhật sản phẩm
    public function updateProduct() {
        $product_service = new ProductService();
        // $products = $product_service->getAllProducts();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $productId = (int)($_POST['id'] ?? 0);
                $name = $_POST['name'] ?? '';
                $description = $_POST['description'] ?? '';
                $price = (float)($_POST['price'] ?? 0);
                $category = $_POST['category'] ?? 'LOL';
                
                $imageUrl = $this->handleImageUpload();
                
                // Lấy thông tin sản phẩm hiện tại nếu không có ảnh mới
                if (empty($imageUrl)) {
                    $product = $product_service->getProductById($productId);
                    if ($product !== null) {
                        $imageUrl = $product->getImageUrl();
                    } else {
                        throw new Exception("Product not found");
                    }
                }
                
                // Gọi phương thức update
                $result = $product_service->updateProduct(
                    $productId,
                    $name,
                    $description,
                    $price,
                    $category,
                    $imageUrl
                );
                
                if ($result) {
                    header('Location: ' . DOMAIN . '/public/index.php?controller=admin');
                    exit();
                } else {
                    header('Location: /admin?error=update');
                    exit();
                }
            } catch (Exception $e) {
                error_log("Update product error: " . $e->getMessage());
                header('Location: /admin?error=update');
                exit();
            }
        }
    }

    // Xử lý xóa sản phẩm
    public function deleteProduct() {
        $product_service = new ProductService();
        // $products = $product_service->getAllProducts();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($_POST['id'] ?? 0);
            
            if ($product_service->deleteProduct($productId)) {
                header('Location: ' . DOMAIN . '/public/index.php?controller=admin');
                exit();
            } else {
                header('Location: /admin?error=delete');
                exit();
            }
        }
    }

    // Xử lý upload ảnh
    private function handleImageUpload() {
         $product_service = new ProductService();
        // $products = $product_service->getAllProducts();
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = APP_ROOT . '/public/uploads/';
            
            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Tạo tên file mới để tránh trùng lặp
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            // Kiểm tra và di chuyển file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                return '/public/uploads/' . $fileName;
            }
        }
        
        return null;
    }
}


?>