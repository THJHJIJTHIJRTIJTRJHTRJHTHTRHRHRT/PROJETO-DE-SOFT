<?php

require_once '../controllers/ProductController.php';

$productController = new ProductController();


$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category = $_POST['category'];
$image = $_FILES['image']; 
$quantity = $_POST['quantity']; 


if ($productController->update($id, $name, $description, $price, $category, $image, $quantity)) {
    
    header("Location: /SITE-CANTINA/index.php"); 
    exit(); 
} else {
    echo "Erro ao atualizar o produto.";
}
?>

