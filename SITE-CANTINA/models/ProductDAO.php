<?php
class ProductDAO {
    private $conn;
    private $table_name = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

 
    public function create($product) {
        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category, image, quantity) 
                  VALUES (:name, :description, :price, :category, :image, :quantity)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $product->name);
        $stmt->bindParam(':description', $product->description);
        $stmt->bindParam(':price', $product->price);
        $stmt->bindParam(':category', $product->category);
        $stmt->bindParam(':image', $product->image);
        $stmt->bindParam(':quantity', $product->quantity); 

        return $stmt->execute();
    }

    
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    
    public function readByCategory($category) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE category = :category";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt;
    }

    
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    public function update($product) {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, description = :description, price = :price, 
                      category = :category, image = :image, quantity = :quantity 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $product->id);
        $stmt->bindParam(':name', $product->name);
        $stmt->bindParam(':description', $product->description);
        $stmt->bindParam(':price', $product->price);
        $stmt->bindParam(':category', $product->category);
        $stmt->bindParam(':image', $product->image);
        $stmt->bindParam(':quantity', $product->quantity); 

        return $stmt->execute();
    }

    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

 
    $_SESSION['cart_message'] = 'Lanche inserido com sucesso no carrinho';

   
   
    

if (isset($_SESSION['cart_message'])) {
    echo "<div class='success-message'>" . $_SESSION['cart_message'] . "</div>";
    unset($_SESSION['cart_message']); // Remove a mensagem após exibi-la
}
}