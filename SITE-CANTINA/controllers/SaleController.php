<?php

class SaleController {
    private $model;

    public function __construct($db) {
        $this->model = new Sale($db);
    }

    public function showSales() {
        $stmt = $this->model->read();
        $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sales;
    }

    public function addSale($user_id, $product_id, $quantity) {
        return $this->model->create($user_id, $product_id, $quantity);
    }
}



?>