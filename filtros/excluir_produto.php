<?php
session_start();
include('../config/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifique se um ID de produto foi fornecido via parâmetro GET
if (isset($_GET['id'])) {
    $id_produto = $_GET['id'];

    // Verifique se o produto existe no banco de dados
    $verificar_sql = "SELECT id_produto FROM produtos WHERE id_produto = ?";
    $verificar_stmt = $conn->prepare($verificar_sql);
    $verificar_stmt->bind_param("i", $id_produto);
    $verificar_stmt->execute();
    $verificar_result = $verificar_stmt->get_result();

    if ($verificar_result->num_rows == 1) {
        // O produto existe, execute a exclusão
        $excluir_sql = "DELETE FROM produtos WHERE id_produto = ?";
        $excluir_stmt = $conn->prepare($excluir_sql);
        $excluir_stmt->bind_param("i", $id_produto);

        if ($excluir_stmt->execute()) {
            // Produto excluído com sucesso
            $_SESSION['success_message'] = "Produto excluído com sucesso.";
        } else {
            // Erro ao excluir o produto
            $_SESSION['produto_error'] = "Erro ao excluir o produto.";
        }
    } else {
        // Produto não encontrado
        $_SESSION['produto_error'] = "Produto não encontrado.";
    }
} else {
    // ID de produto não fornecido
    $_SESSION['produto_error'] = "ID de produto não fornecido.";
}

// Redirecione de volta para a página de lista de produtos
header("Location: lista_produtos.php");
exit();
?>
