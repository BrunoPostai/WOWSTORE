<?php
session_start();
require('../config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['concluir-compra'])) {
    // Verifique se o carrinho está vazio
    if (empty($_SESSION['carrinho'])) {
        $_SESSION['erro_compra'] = 'Seu carrinho está vazio. Adicione produtos ao carrinho antes de concluir a compra.';
        header("Location: loja.php");
        exit();
    }

    // Validações para cada produto no carrinho
    foreach ($_SESSION['carrinho'] as $produto_id => $produto) {
        // Consulte a quantidade disponível na base de dados
        $sql = "SELECT quantidade, nome_produto FROM produtos WHERE id_produto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $produto_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $quantidade_disponivel = $row['quantidade'];

            // Verifique se a quantidade a comprar é maior que a quantidade disponível
            if ($produto['quantidade'] > $quantidade_disponivel) {
                $erro = 'Não há estoque suficiente para o produto ' . $row['nome_produto'] . '.';
                $_SESSION['erro_compra'] = $erro;
                header("Location: loja.php");
                exit(); // Você pode redirecionar de volta à página do carrinho ou fazer algo mais aqui
            }

            // Se a quantidade disponível for zero, mostre uma mensagem de estoque esgotado
            if ($quantidade_disponivel == 0) {
                $erro = 'O produto ' . $row['nome_produto'] . ' está sem estoque.';
                $_SESSION['erro_compra'] = $erro;
                header("Location: loja.php");
                exit();
            }
        }
    }

    // Redirecione para uma página de confirmação ou sucesso após a compra
    $_SESSION['compra_concluida'] = true; // Defina a compra como concluída
    // Limpe o carrinho após a compra
    header("Location: envio.php");
    exit();
} else {
    // Redirecione de volta à página do carrinho ou faça algo apropriado se o formulário não foi submetido corretamente
    header("Location: carrinho.php");
    exit();
}
?>
