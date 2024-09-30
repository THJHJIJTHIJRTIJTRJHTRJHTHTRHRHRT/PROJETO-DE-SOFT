<?php
// Exemplo de uso do método create
session_start();
require_once '../config/database.php'; // Arquivo de conexão com o banco de dados
require_once '../models/Product.php'; // Modelo de vendas (corrigido)
require_once '../models/Product.php'; // Modelo de produtos
require_once '../models/User.php'; // Modelo de usuários
require_once '../models/Product.php'; // Modelo de vendas (adicionado)

// Criação da conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Criação da instância do modelo Sale
$sale = new Sale($db);

// Supondo que você tenha os dados do usuário e do produto prontos para inserção
$user_id = 1; // ID do usuário (deve existir na tabela users)
$product_id = 1; // ID do produto (deve existir na tabela products)
$quantity = 2; // Quantidade vendida

// Verificando se o usuário existe
$user = new User($db); // Criação da instância do modelo User
$userData = $user->readOne($user_id); // Método para ler um usuário pelo ID

// Verificando se o produto existe
$product = new Product($db);
$productData = $product->readOne($product_id); // Método para ler um produto pelo ID

if ($userData && $productData) {
    // Inserindo a venda
    if ($sale->create($user_id, $product_id, $quantity)) {
        echo "Venda registrada com sucesso.";
    } else {
        echo "Erro ao registrar a venda.";
    }
} else {
    echo "Usuário ou produto não encontrado.";
}

// Recuperando todas as vendas para exibição
$salesData = $sale->read();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Vendas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Histórico de Vendas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Data da Venda</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificando se há vendas para exibir
                if ($salesData->rowCount() > 0) {
                    while ($row = $salesData->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['user_name']}</td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['quantity']}</td>
                                <td>{$row['sale_date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma venda registrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

