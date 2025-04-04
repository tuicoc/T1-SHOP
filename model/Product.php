<?php

class Product{
    // Properties
    private int $product_id;
    private string $name;
    private string $description;
    private float $price;
    private string $category;
    private int	$stock_quantity;
    private string $image_url;	

    // Method
    // Trong PHP, __construct() là một magic method (phương thức ma thuật).
    //  PHP yêu cầu tất cả các magic methods phải bắt đầu bằng hai dấu gạch dưới (__)
    public function __construct(int $product_id, string $name, string $description, 
                              string $price, string $category, string $stock_quantity, string $image_url){ // hàm tạo, khởi tạo ra đối tượng
        $this->product_id = $product_id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->stock_quantity = $stock_quantity;
        $this->image_url = $image_url;
    }

    // Getters
    public function getProductId(): int {
        return $this->product_id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getStockQuantity(): int {
        return $this->stock_quantity;
    }

    public function getImageUrl(): string {
        return $this->image_url;
    }

    // Setters
    public function setProductId(int $product_id): void {
        $this->product_id = $product_id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setPrice(string $price): void {
        $this->price = $price;
    }

    public function setCategory(string $category): void {
        $this->category = $category;
    }

    public function setStockQuantity(int $stock_quantity): void {
        $this->stock_quantity = $stock_quantity;
    }

    public function setImageUrl(string $image_url): void {
        $this->image_url = $image_url;
    }
}

?>

