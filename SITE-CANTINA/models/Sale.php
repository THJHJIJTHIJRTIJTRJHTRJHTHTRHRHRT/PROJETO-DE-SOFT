<?php


require_once '../models/SaleDAO.php';

class Sale {
    private $conn;
    private $dao;

    public function __construct($db) {
        $this->conn = $db;
        $this->dao = new SaleDAO($db);  
    }

    
    public function read() {
        return $this->dao->getAllSales();
    }

    public function create($user_id, $product_id, $quantity) {
        return $this->dao->createSale($user_id, $product_id, $quantity);
    }
    public function readByUser($userId) {
        return $this->dao->readByUser($userId);
    }
}