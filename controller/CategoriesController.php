<?php
require_once(APP_ROOT.'/services/ProductService.php');

class CategoriesController{
    public function index(){

        $productsPerPage = 9;

        // Get current page from URL, default is 1
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $sort = $_GET['sort'] ?? 'trending';

        $categories = ["LOL Team", "VAL Team"];

        // Lấy index từ URL, đảm bảo nó là số hợp lệ
        $currentCategoryIndex = isset($_GET['category']) ? (int)$_GET['category'] : 0;

        // var_dump($currentCategoryIndex);

        // Đảm bảo index nằm trong phạm vi hợp lệ
        if ($currentCategoryIndex < 0 || $currentCategoryIndex >= count($categories)) {
            $currentCategoryIndex = 0; // Mặc định là "Esports Merch"
        }

        // Lấy tên danh mục từ mảng
        $currentCategory = $categories[$currentCategoryIndex];


        if ($currentPage < 1) {
            $currentPage = 1;
        }

        // Load service
        $product_service = new ProductService();

        // Get total products count for the selected category
        $totalProducts = $product_service->countProductsByCategory($currentCategory);
        // var_dump($totalProducts);

        // Calculate total pages
        $totalPages = ceil($totalProducts / $productsPerPage);

        $products = [];
        if($currentPage == $totalPages){
            $products = $product_service->getCategories($currentCategory, $currentPage, $totalProducts - ($totalPages-1)*$productsPerPage, $sort);    
        }
        else{
            $products = $product_service->getCategories($currentCategory, $currentPage, $productsPerPage, $sort);
        }
        

        // $product_service = new ProductService();
        // $products = $product_service->getAllProducts();

        // render view
        include APP_ROOT.'/views/category/index.php'; 
    }
}


?>