<?php
class SaleDAO {
    private $conn;
    private $table_name = "sales";

    public function __construct($db) {
        $this->conn = $db;
    }
    

    public function getAllSales() {
        $query = "
            SELECT 
                s.id, u.name AS user_name, p.name AS product_name, 
                s.quantity, s.sale_date 
            FROM " . $this->table_name . " s
            JOIN users u ON s.user_id = u.id
            JOIN products p ON s.product_id = p.id
            ORDER BY s.sale_date DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    public function createSale($user_id, $product_id, $quantity) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $stmt = $this->conn->prepare($query);

    
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":quantity", $quantity);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readByUser($userId) {
        $query = "SELECT s.id, p.name AS product_name, s.quantity, s.sale_date
                  FROM sales s
                  JOIN products p ON s.product_id = p.id
                  WHERE s.user_id = :userId"; 
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    
        return $stmt;
    }
    
}
?>
