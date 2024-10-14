<?php


require_once '../models/ProductDAO.php';

class Product {
    private $conn;
    private $dao;

    public $id;
    public $name;
    public $description;
    public $price;
    public $category;
    public $image;
    public $quantity;

    public function __construct($db) {
        $this->conn = $db;
        $this->dao = new ProductDAO($db); 
    }

 
    public function create() {
        return $this->dao->create($this);
    }

  
    public function read() {
        return $this->dao->read();
    }

   
    public function readByCategory($category) {
        return $this->dao->readByCategory($category);
    }

  
    public function readOne($id) {
        return $this->dao->readOne($id);
    }

  
    public function update($id) {
        $this->id = $id;
        return $this->dao->update($this);
    }

    
    public function delete($id) {
        return $this->dao->delete($id);
    }

  
    public function addToCart($id, $quantity) {
        session_start();

     
        $product = $this->readOne($id);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $productFound = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product['id']) {
                $item['quantity'] += $quantity;
                $productFound = true;
                break;
            }
        }

        if (!$productFound) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'description' => $product['description'],
                'quantity' => $quantity
            ];
        }
    }
}

?>
