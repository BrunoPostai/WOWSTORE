<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_produto'])) {
    $produto_id = $_POST['id_produto'];

    // Remova o produto do carrinho usando o ID
    unset($_SESSION['carrinho'][$produto_id]);
}

// Redirecione de volta para a página do carrinho ou qualquer outra página desejada
header("Location: loja.php"); // Substitua "carrinho.php" pelo nome da página do carrinho
exit();
?>
