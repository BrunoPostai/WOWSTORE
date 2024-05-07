<?php
session_start();
require('../config/config.php');

// Initialize variables
$nome_default = $email_default = $senha_hash = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar-info'])) {
    // Retrieve user ID from the session
    $usuario_id = $_SESSION["usuario_id"];

    // Retrieve user information from the database
    $sql = "SELECT nome_utilizador, email, senha FROM utilizadores WHERE id_utilizadores = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
        $nome_default = $user_info['nome_utilizador'];
        $email_default = $user_info['email'];
        $senha_hash = $user_info['senha'];
    } else {
        // Handle the case where user information is not found
        $_SESSION['update_error'] = "Erro ao obter informações do usuário.";
        header("Location: modificar_info.php");
        exit();
    }

    // Retrieve user input from the form
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $nova_senha = $_POST['senha'];

    // Check if the new email is already in use
    $sql_check_email = "SELECT id_utilizadores FROM utilizadores WHERE email = ? AND id_utilizadores != ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("si", $email, $usuario_id);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    if ($result_check_email->num_rows > 0) {
        // The new email is already in use
        $_SESSION['update_error'] = "O novo email já está em uso. Escolha outro.";
        header("Location: modificar_info.php");
        exit();
    }

    $stmt_check_email->close();

    // Check if a new password is provided
    if (!empty($nova_senha)) {
        // Hash the new password
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
    }

    // Update user information in the database
    $sql_update = "UPDATE utilizadores SET nome_utilizador = ?, email = ?, senha = ? WHERE id_utilizadores = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $nome, $email, $senha_hash, $usuario_id);

    if ($stmt_update->execute()) {
        // Update successful
        $_SESSION['update_success'] = "Informações atualizadas com sucesso.";
    } else {
        // Update failed
        $_SESSION['update_error'] = "Erro ao atualizar informações: " . $stmt_update->error;
    }

    $stmt_update->close();
    $conn->close();

    // Redirect back to the form page
    header("Location: modificar_info.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Informações</title>
    <link rel="stylesheet" href="../css/modificar.css">
</head>
<body>

    <!-- Your HTML form -->
    <form action="modificar_info.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"required>

        <label for="senha">Nova Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit" name="atualizar-info">Atualizar Informações</button>
        <button><a href="../index.php">Voltar ao menu</a></button>
    </form>

    <!-- Display success or error messages if needed -->
    <?php
    if (isset($_SESSION['update_success'])) {
        echo '<p class="success">' . $_SESSION['update_success'] . '</p>';
        unset($_SESSION['update_success']);
    } elseif (isset($_SESSION['update_error'])) {
        echo '<p class="error">' . $_SESSION['update_error'] . '</p>';
        unset($_SESSION['update_error']);
    }
    ?>

</body>
</html>
