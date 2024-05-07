<?php
session_start();

// Função para fazer logout
function logout() {
    // Verifique se há uma sessão ativa
    if (isset($_SESSION['usuario_id']) || isset($_SESSION['admin']) || isset($_SESSION['username']) ) {
        // Unset todas as variáveis de sessão
        session_unset();

        // Destrua a sessão
        session_destroy();
    }

    // Redirecione para a página de login ou qualquer outra página
    header("Location: ../login.php");
    exit();
}

// Exemplo de como chamar a função de logout
if (isset($_GET['logout'])) {
    logout();
}
?>
