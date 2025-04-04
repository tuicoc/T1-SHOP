<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../public/css/admin/style.css">
</head>
<body>
<section class="dataset-page">
    <div class="title-container">
        <button class="back-button" onclick="window.location.href='../public/index.php?controller=home'">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h2 class="title-back">PRODUCTS</h2>
        <h2 class="title-front">PRODUCTS</h2>
    </div>

    <!-- Product Form -->
    <div class="product-form">
        <div class="form-header">
            <i class="fas fa-plus-circle"></i>
            <h3>ADD NEW PRODUCT</h3>
        </div>
        
        <form id="productForm" action="<?='../public/index.php?controller=admin&action=addProduct'?>" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                    <label for="name"><i class="fas fa-tag"></i>Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="price"><i class="fas fa-dollar-sign"></i>Price</label>
                    <input type="number" id="price" name="price" step="1" class="form-control" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description"><i class="fas fa-align-left"></i>Description</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="category"><i class="fas fa-list"></i>Collection</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="" disabled required>Choose Collection</option>
                        <option value="LOL Team">LOL Team</option>
                        <option value="VAL Team">VAL Team</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="image"><i class="fas fa-image"></i>Image</label>
                    <div class="image-upload-container">
                        <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                        <div class="image-preview" id="imagePreview">
                            <i class="fas fa-image" style="font-size: 2rem; color: #ddd;"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> LƯU SẢN PHẨM
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> NHẬP LẠI
                </button>
            </div>
        </form>
    </div>

    <!-- Product List -->
    <div class="product-list">
        <div class="list-header">
            <h3><i class="fas fa-list"></i>PRODUCT LIST</h3>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Collection</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php        
                        // echo "<p>Number of products: " . count($products) . "</p>";
                        // var_dump($products);
                        foreach($products as $product){
                    ?>
                    <tr>
                        <td class="product-id" style="display: none;"><?= $product->getProductId() ?></td>
                        <td>
                            <img src="../<?= $product->getImageUrl();?>" alt="Product Image" class="table-img">
                        </td>
                        <td class="product-name"><?= $product->getName() ?></td>
                        <td class="price"><?= number_format($product->getPrice(), 0, ',', '.') ?> VND</td>
                        <td>
                                <?php 
                                $category = $product->getCategory();
                                $badgeClass = ($category === 'VAL Team') ? 'badge-valorant' : 'badge-lol';
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= $category ?>
                                </span>
                            </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-primary btn-sm edit-btn" data-edit-id="edit1">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <!-- Form xóa ẩn -->

                                <!-- Sửa lại form trong HTML -->
                                <form method="POST" action="../public/index.php?controller=admin&action=deleteProduct" class="delete-form">
                                    <input type="hidden" name="id" value="<?= $product->getProductId() ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Do you want to delete this product?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>

                </tbody>
            </table>
        </div>
    </div>


    <div class="edit-section" id="edit-section" style="margin-top: 3rem;">
        <div class="form-header">
            <i class="fas fa-edit"></i>
            <h3>EDIT PRODUCT</h3>
        </div>
        <form id="editForm" action="<?='../public/index.php?controller=admin&action=updateProduct'?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">

            <div class="form-row">
                <div class="form-group">
                    <label for="edit_name"><i class="fas fa-tag"></i>Name</label>
                    <input type="text" id="edit_name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_price"><i class="fas fa-dollar-sign"></i>Price</label>
                    <input type="number" id="edit_price" name="price" step="1000" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label for="edit_description"><i class="fas fa-align-left"></i>Description</label>
                <textarea id="edit_description" name="description" class="form-control" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="edit_category"><i class="fas fa-list"></i>Collection</label>
                    <select id="edit_category" name="category" class="form-control" required>
                        <option value="LOL Team">LOL Team</option>
                        <option value="VAL Team">VAL Team</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_image"><i class="fas fa-image"></i>Image</label>
                    <div class="image-upload-container">
                        <input type="file" id="edit_image" name="image" class="form-control" accept="image/*">
                        <div class="image-preview" id="editImagePreview">
                            <img src="" alt="Current Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> UPDATE
                </button>
                <button type="button" class="btn btn-secondary" id="cancelEdit">
                    <i class="fas fa-times"></i> CANCEL
                </button>
            </div>
        </form>
    </div>



</section>

<script>
    // Xử lý hiển thị ảnh preview khi chọn ảnh mới
    document.getElementById('image').addEventListener('change', function(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = '';
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        }
        
        if (file) {
            reader.readAsDataURL(file);
        }
    });

    // Xử lý hiển thị ảnh preview khi chọn ảnh trong chỉnh sửa
    document.getElementById('edit_image').addEventListener('change', function(event) {
        const preview = document.getElementById('editImagePreview');
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = '';
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        }
        
        if (file) {
            reader.readAsDataURL(file);
        }
    });

    // Xử lý nút edit sản phẩm
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Lấy hàng chứa sản phẩm (row)
            const row = this.closest('tr');
            
            // Lấy thông tin sản phẩm từ các cột trong hàng
            const productId = row.querySelector('.product-id').textContent; // Thêm data-id vào thẻ tr nếu cần
            const productName = row.querySelector('.product-name').textContent;
            const productPrice = row.querySelector('.price').textContent.replace(/[^\d]/g, '');
            // const productCategory = row.querySelector('.badge').textContent;
            const productImage = row.querySelector('.table-img').src;

             // Lấy category từ badge
                const productCategoryBadge = row.querySelector('.badge');
                let productCategory = '';
                
                // Xác định category dựa trên class của badge
                if (productCategoryBadge.classList.contains('badge-lol')) {
                    productCategory = 'LOL Team';
                } else if (productCategoryBadge.classList.contains('badge-valorant')) {
                    productCategory = 'VAL Team';
                }
            
            // Lấy mô tả sản phẩm (cần thêm data-description vào thẻ tr hoặc ẩn trong HTML)
            const productDescription = row.dataset.description || '';
            
            // Điền thông tin vào form chỉnh sửa
            document.getElementById('edit_id').value = productId;
            document.getElementById('edit_name').value = productName;
            document.getElementById('edit_price').value = productPrice;
            // document.getElementById('edit_category').value = productCategory;
            document.getElementById('edit_description').value = productDescription;

            const categorySelect = document.getElementById('edit_category');
            for (let i = 0; i < categorySelect.options.length; i++) {
                if (categorySelect.options[i].value === productCategory) {
                    categorySelect.selectedIndex = i;
                    break;
                }
            }
                
            // Hiển thị ảnh hiện tại
            const preview = document.getElementById('editImagePreview');
            preview.innerHTML = '';
            const img = document.createElement('img');
            img.src = productImage;
            preview.appendChild(img);
            
            // Hiển thị form chỉnh sửa
            document.getElementById('edit-section').classList.add('active');
            
            // Cuộn đến form chỉnh sửa
            document.getElementById('edit-section').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Xử lý nút hủy chỉnh sửa
    document.getElementById('cancelEdit').addEventListener('click', function() {
        document.getElementById('edit-section').classList.remove('active');
    });

</script>


</body>
</html>