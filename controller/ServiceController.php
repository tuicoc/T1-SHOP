<?php
require_once('../config/config.php');
require_once(APP_ROOT.'/services/ProductService.php');

class ServiceController{
    public function index(){
        var_dump(password_hash("admin", PASSWORD_DEFAULT));

        $productsPerPage = 9;

        // Get current page from URL, default is 1
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $sort = $_GET['sort'] ?? 'trending';
        if ($currentPage < 1) {
            $currentPage = 1;
        }

        // Load service
        $product_service = new ProductService();

        // Get total products count
        $totalProducts = count($product_service->getAllProducts());

        // Calculate total pages
        $totalPages = ceil($totalProducts / $productsPerPage);

        $products = [];
        if($currentPage == $totalPages){
            $products = $product_service->getPaginatedProducts($currentPage, $totalProducts - ($totalPages-1)*$productsPerPage, $sort);    
        }
        else{
            $products = $product_service->getPaginatedProducts($currentPage, $productsPerPage, $sort);
        }
        

        // $product_service = new ProductService();
        // $products = $product_service->getAllProducts();

        // render view
        include APP_ROOT.'/views/product/index.php'; 
    }

    
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = $_POST['search'] ?? '';
            
            $product_service = new ProductService();
            // Giả sử ProductService có phương thức searchProducts
            $products = $product_service->searchProducts($searchTerm);
            
            // Trả về HTML trực tiếp
            ob_start();
            foreach($products as $product) {
                ?>
                <div class="card">
                    <img src="../<?= $product->getImageUrl(); ?>" alt="Heart">
                    <h3><?= $product->getName() ?></h3>
                    <h3><?= number_format($product->getPrice(), 0, ',', '.') ?> VND</h3>
                </div>
                <?php
            }
            $html = ob_get_clean();
            echo $html;
            exit;
        }
    }
        
}


?>