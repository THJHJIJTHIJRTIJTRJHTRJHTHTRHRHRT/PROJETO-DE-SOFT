<?php
session_start();
require_once '../models/Product.php';
require_once '../config/database.php';

$db = new Database();
$productModel = new Product($db->getConnection());

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'remove') {
        $productId = $_POST['id'];
        
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $productId) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart_message'] = "Produto removido com sucesso!";
                break;
            }
        }
    } else {
        $productId = $_POST['id'];
        $quantity = $_POST['quantity']; 
        $found = false;

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId) {
                $item['quantity'] = $quantity; 
                $found = true;
                $_SESSION['cart_message'] = "Quantidade do produto atualizada!";
                break;
            }
        }

        if (!$found) {
            $productModel->addToCart($productId, $quantity); 
            $_SESSION['cart_message'] = "Produto adicionado ao carrinho, escolha a quantidade";
        }
    }
    header('Location: cart.php');
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'];
$total = 0;


$invalidQuantity = false;
foreach ($cartItems as $item) {
    if ($item['quantity'] < 1 || !is_numeric($item['quantity'])) {
        $invalidQuantity = true;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'checkout' && $invalidQuantity) {
    $_SESSION['error_message'] = "Quantidade inválida! Corrija a quantidade do produto antes de finalizar a compra.";
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total {
            font-weight: bold;
        }
        .buttons {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0056b3;
        }
        .btn-remove {
            background-color: #dc3545; 
            color: white; 
            border: none; 
            padding: 5px 10px; 
            border-radius: 5px; 
            cursor: pointer;
        }
        .btn-remove:hover {
            background-color: #c82333;
        }
        .success-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            border-radius: 5px;
            font-size: 18px;
            text-align: center;
            z-index: 1000;
        }
        .error-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f44336;
            color: white;
            padding: 20px;
            border-radius: 5px;
            font-size: 18px;
            text-align: center;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <h1>Carrinho de Compras</h1>

  
    <?php if (isset($_SESSION['cart_message'])): ?>
        <div class="success-message">
            <?php echo $_SESSION['cart_message']; ?>
        </div>
        <?php unset($_SESSION['cart_message']);  ?>
    <?php endif; ?>

  
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="error-message">
            <?php echo $_SESSION['error_message']; ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <table>
        <tr>
            <th>Produto</th>
            <th>Imagem</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>

        <?php if (count($cartItems) > 0): ?>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 100px;"></td>
                    <td>R$ <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px;" required>
                            <button type="submit">Atualizar</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="btn-remove">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr class="total">
                <td>Total</td>
                <td></td>
                <td>R$ <?php echo number_format($total, 2, ',', '.'); ?></td>
                <td></td> 
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center;">O carrinho está vazio.</td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="buttons">
        <a href="home.php">Continuar Comprando</a>
        <a href="checkout.php" class="<?php echo $invalidQuantity ? 'disabled' : ''; ?>">Finalizar Compra</a>
    </div>
</body>
</html>
