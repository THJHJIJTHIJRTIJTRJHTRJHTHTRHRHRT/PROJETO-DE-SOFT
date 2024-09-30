<?php
session_start();

// Verificar se o carrinho está vazio
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header('Location: cart.php'); // Redireciona para o carrinho se estiver vazio
    exit();
}

// Processar os dados do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Aqui você pode adicionar lógica para armazenar a ordem em um banco de dados, enviar um e-mail de confirmação, etc.
    
    // Limpar o carrinho após a compra
    $_SESSION['cart'] = [];

    // Exibir uma mensagem de sucesso
    echo "<h1>Obrigado pela sua compra, $name!</h1>";
    echo "<p>Você receberá um e-mail de confirmação em $email.</p>";
    echo "<p>Endereço de entrega: $address</p>";
    echo "<a href='home.php'>Voltar para a página inicial</a>";
}
?>
