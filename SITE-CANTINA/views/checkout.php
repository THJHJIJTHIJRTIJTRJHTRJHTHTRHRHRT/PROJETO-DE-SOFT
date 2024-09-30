<?php
session_start();

// Verificar se o carrinho está vazio
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header('Location: cart.php'); // Redireciona para o carrinho se estiver vazio
    exit();
}

// Inicializar o total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantidade']; // Calcular o total considerando a quantidade
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total {
            font-weight: bold;
            font-size: 1.2em;
            text-align: right;
            margin-top: 20px;
        }
        .buttons {
            margin-top: 30px;
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
        form {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Finalizar Compra</h1>

    <h2>Itens no Carrinho:</h2>
    <table>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th> <!-- Coluna para quantidade -->
            <th>Preço</th>
            <th>Subtotal</th> <!-- Coluna para subtotal -->
        </tr>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['quantidade']); ?></td> <!-- Exibe a quantidade -->
                <td>R$ <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                <td>R$ <?php echo number_format($item['price'] * $item['quantidade'], 2, ',', '.'); ?></td> <!-- Exibe o subtotal -->
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="total">
        Total: R$ <?php echo number_format($total, 2, ',', '.'); ?>
    </div>

    <h2>Informações de Pagamento</h2>
    <form method="POST" action="process_checkout.php">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="address">Endereço:</label>
        <input type="text" id="address" name="address" required>
        
        <input type="submit" value="Concluir Compra">
    </form>

    <div class="buttons">
        <a href="cart.php">Voltar ao Carrinho</a>
        <a href="home.php">Continuar Comprando</a>
    </div>
</body>
</html>

