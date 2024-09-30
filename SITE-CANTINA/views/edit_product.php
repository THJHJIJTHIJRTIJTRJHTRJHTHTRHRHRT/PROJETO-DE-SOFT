<?php
require_once '../controllers/ProductController.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: home.php');
    exit();
}

$productController = new ProductController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualiza o produto com os dados do formulário
    if (isset($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'])) {
        $productController->update($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'], $_FILES['image']);
        header('Location: admin.php'); // Redirecionar para a página de listagem de produtos
        exit();
    }
}

$product = $productController->readOne($_GET['id']); // Adicione um método readOne para pegar um único produto
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

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        
        <input type="text" name="name" placeholder="Nome" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        
        <input type="text" name="description" placeholder="Descrição" value="<?php echo htmlspecialchars($product['description']); ?>" required>
        
        <input type="number" name="price" placeholder="Preço" value="<?php echo $product['price']; ?>" required step="0.01">
        
        <label for="image">Imagem do Produto:</label>
        <input type="file" name="image" accept="image/*">
        
        <input type="text" name="category" placeholder="Categoria" value="<?php echo htmlspecialchars($product['category']); ?>" required>
        
        <button type="submit">Atualizar</button>
    </form>

    <a href="home.php">Voltar para a Home</a>
</div>

</body>
</html>
