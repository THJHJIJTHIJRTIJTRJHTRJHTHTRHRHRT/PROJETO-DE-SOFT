<?php
session_start();

// Destrói todas as sessões
session_unset();
session_destroy();

// Redireciona para a página inicial
header("Location: home.php");
exit();
?>
