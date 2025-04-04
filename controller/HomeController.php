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

class HomeController{
    public function index(){
        // $product_service = new ProductService();
        // $products = $product_service->getAllProducts();
    
        // render view
        include APP_ROOT.'/views/home/index.php'; 
    }
}


?>