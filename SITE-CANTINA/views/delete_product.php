<?php
require_once '../controllers/ProductController.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: home.php');
    exit();
}

if (isset($_GET['id'])) {
    $productController = new ProductController();
    $productController->delete($_GET['id']); // Adicione um método delete ao ProductController
    header('Location: admin.php'); // Redirecionar para a página de listagem de produtos
    exit();
}
?>
