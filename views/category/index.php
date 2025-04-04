<?php
require_once '../config/config.php';
include APP_ROOT.'/views/shared/header.php';
?>


<section class="dataset-page">
    <!-- <h1>Datasets</h1>

    <div class="categories">
        <button>All datasets</button>
        <button>Computer Science</button>
        <button>Education</button>
        <button>Classification</button>
        <button>Computer Vision</button>
        <button>NLP</button>
        <button>Data Visualization</button>
        <button>Pre-Trained Model</button>
    </div> -->

    <div class="header-container">
        <h2>🔥 Trending Clothes</h2>
        <div class="dropdown">
            <div class="dropdown-btn">Sorting</div>
            <div class="dropdown-content">
                <a href="?controller=categories&page=1&sort=trending&category=<?= strval($currentCategoryIndex) ?>">Trending</a>
                <a href="?controller=categories&page=1&sort=price_asc&category=<?= strval($currentCategoryIndex) ?>">Price: Low to High</a>
                <a href="?controller=categories&page=1&sort=price_desc&category=<?= strval($currentCategoryIndex) ?>">Price: High to Low</a>
                <a href="?controller=categories&page=1&sort=name_asc&category=<?= strval($currentCategoryIndex) ?>">Name: A to Z</a>
                <a href="?controller=categories&page=1&sort=name_desc&category=<?= strval($currentCategoryIndex) ?>">Name: Z to A</a>
            </div>
        </div>
    </div>



    <div class="datasets">
        <?php        
            // echo "<p>Number of products: " . count($products) . "</p>";
            // var_dump($products);
            foreach($products as $product){
        ?>
            <div class="card">
            <img src="../<?= $product->getImageUrl();?>" alt="Heart">
            <h3><?= $product->getName() ?></h3>
            <h3><?= number_format($product->getPrice(), 0, ',', '.') ?> VND</h3>
        </div>
        <?php
            }
        ?>
    </div>

    <ul class="pagination" id="pagination-container">
        <li class="<?= ($currentPage == 1 || $totalPages == 0) ? 'disabled' : '' ?>">
            <a href="?controller=categories&page=<?= max(1, $currentPage - 1) ?>&sort=<?= $sort ?>&category=<?= strval($currentCategoryIndex) ?>">«</a>
        </li>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                <a href="?controller=categories&page=<?= $i ?>&sort=<?= $sort ?>&category=<?= strval($currentCategoryIndex) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <li class="<?= ($currentPage == $totalPages || $totalPages == 0) ? 'disabled' : '' ?>">
            <a href="?controller=categories&page=<?= min($totalPages, $currentPage + 1) ?>&sort=<?= $sort ?>&category=<?= strval($currentCategoryIndex) ?>">»</a>
        </li>
    </ul>




    
    
    
    <!-- <ul class="pagination">
        <li class="disabled"><a href="#">«</a></li>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">»</a></li>
    </ul>
     -->
</section>


<script> 

document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript đang chạy!');
    var searchForm = document.querySelector('.search-bar');
    var searchInput = searchForm.querySelector('input');
    var datasets = document.querySelector('.datasets');
    var pagination = document.getElementById('pagination-container');

    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var searchTerm = searchInput.value.trim();
            
            // Ẩn pagination khi search
            if (pagination) {
                pagination.hidden = true;
            }
            
            fetch('../public/index.php?controller=service&action=search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'search=' + encodeURIComponent(searchTerm)
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(data) {
                datasets.innerHTML = data;
            })
            .catch(function(error) {
                console.error('Error:', error);
                datasets.innerHTML = '<p>Có lỗi xảy ra khi tìm kiếm</p>';
                
                // Hiện lại pagination nếu có lỗi
                if (pagination) {
                    pagination.hidden = false;
                }
            });
        });
        
        // Hiện pagination khi load trang (nếu đang ẩn)
        if (pagination && pagination.hidden) {
            pagination.hidden = false;
        }
    } else {
        console.error('Không tìm thấy form .search-bar');
    }
});
  </script>


<?php
require_once '../config/config.php';
include APP_ROOT.'/views/shared/footer.php';
?>