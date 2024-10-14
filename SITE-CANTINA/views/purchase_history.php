<?php
session_start();

require_once __DIR__ . '/../config/database.php'; 
require_once '../models/SaleDAO.php'; 
require_once '../models/Sale.php'; 

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


$database = new Database();
$db = $database->getConnection();

$sale = new Sale($db); 


$user_id = $_SESSION['user']['id'];


try {
    $stmt = $sale->readByUser($user_id);
} catch (Exception $e) {
    echo "Erro ao obter o histórico de compras: " . $e->getMessage();
    exit();
}

if ($stmt) {
    
    $num = $stmt->rowCount();

    
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Histórico de Compras</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
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
        </style>
    </head>
    <body>
        <h1>Histórico de Compras</h1>

        <?php if ($num > 0):  ?>
            <table>
                <tr>
                  

                    <th>ID</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Data da Venda</th>
                </tr>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Você ainda não realizou nenhuma compra.</p>
        <?php endif; ?>
    </body>
    </html>
    <?php
} else {
    echo "Erro ao obter o histórico de compras.";
}
?>
