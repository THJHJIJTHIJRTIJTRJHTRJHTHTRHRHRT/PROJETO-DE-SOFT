<?php
require_once '../controllers/ProductController.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: home.php');
    exit();
}

$productController = new ProductController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (isset($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'])) {
        $productController->update($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'], $_FILES['image']);
        header('Location: admin.php'); 
        exit();
    }
}

$product = $productController->readOne($_GET['id']); 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .form-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h1 {
            margin-bottom: 2rem;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        form input, form select {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        form input[type="file"] {
            padding: 0.5rem;
        }

        .product-image {
            margin-bottom: 1rem;
        }

        .product-image img {
            width: 100%;
            max-width: 150px;
            border-radius: 5px;
        }

        button {
            padding: 0.8rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            margin-top: 1rem;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Editar Produto</h1>

    <div class="product-image">
        <img src="<?php echo '../uploads/' . $product['image']; ?>" alt="Imagem do produto">
    </div>

    <?php

$productController = new ProductController();
$product = $productController->readOne($_GET['id']); // Obtendo o produto a ser editado
?>
<form action="update_product.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php echo $product['name']; ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Descrição</label>
        <textarea class="form-control" name="description" id="description" required><?php echo $product['description']; ?></textarea>
    </div>

    <div class="form-group">
        <label for="price">Preço</label>
        <input type="number" class="form-control" name="price" id="price" value="<?php echo $product['price']; ?>" required>
    </div>

    <div class="form-group">
        <label for="category">Categoria</label>
        <select class="form-control" name="category" id="category" required>
            <option value="" disabled selected>Selecione uma categoria</option>
            <option value="Bebidas" <?php echo ($product['category'] == 'Bebidas') ? 'selected' : ''; ?>>Bebidas</option>
            <option value="Salgados" <?php echo ($product['category'] == 'Salgados') ? 'selected' : ''; ?>>Salgados</option>
            <option value="Doces" <?php echo ($product['category'] == 'Doces') ? 'selected' : ''; ?>>Doces</option>
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Quantidade</label>
        <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo $product['quantity']; ?>" required>
    </div>

    <div class="form-group">
        <label for="image">Imagem</label>
        <input type="file" class="form-control" name="image" id="image">
    </div>

    <button type="submit" class="btn btn-primary">Atualizar Produto</button>
</form>

