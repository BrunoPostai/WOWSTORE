<?php
session_start();
require('../config/config.php');

if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}

$user_id = isset($_GET['id']) ? $_GET['id'] : null;

$sql_user = "SELECT id_utilizadores, nome_utilizador, email FROM utilizadores WHERE id_utilizadores = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows === 1) {
    $user_info = $result_user->fetch_assoc();
} else {
    $_SESSION['edit_error'] = "Usuário não encontrado.";
    header("Location: admin_users.php");
    exit();
}

$stmt_user->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar-info'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $nova_senha = $_POST['senha'];


    $sql_update = "UPDATE utilizadores SET nome_utilizador = ?, email = ?, senha = ? WHERE id_utilizadores = ?";
    $stmt_update = $conn->prepare($sql_update);

    if (!empty($nova_senha)) {

        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt_update->bind_param("sssi", $nome, $email, $senha_hash, $user_id);
    } else {

        $stmt_update->bind_param("ssi", $nome, $email, $user_id);
    }

    if ($stmt_update->execute()) {

        $_SESSION['edit_success'] = "Informações do usuário atualizadas com sucesso.";
    } else {

        $_SESSION['edit_error'] = "Erro ao atualizar informações do usuário: " . $stmt_update->error;
    }

    $stmt_update->close();
    $conn->close();

    header("Location: admin_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Editar Usuário</title>
    <link rel="stylesheet" href="../css/edit_user.css">
</head>
<body>

    <h1>Editar Usuário</h1>

    <p>ID: <?php echo $user_info['id_utilizadores']; ?></p>
    <p>Nome: <?php echo $user_info['nome_utilizador']; ?></p>
    <p>Email: <?php echo $user_info['email']; ?></p>


    <form action="edit_user.php?id=<?php echo $user_id; ?>" method="post">
        <label for="nome">Novo Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $user_info['nome_utilizador']; ?>" required>

        <label for="email">Novo Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user_info['email']; ?>" required>

        <label for="senha">Nova Senha:</label>
        <input type="password" id="senha" name="senha">

        <button type="submit" name="atualizar-info">Atualizar Informações</button>
        <button><a href="admin_users.php">Voltar</a></button>
    </form>

    <?php
    if (isset($_SESSION['edit_success'])) {
        echo '<p class="success">' . $_SESSION['edit_success'] . '</p>';
        unset($_SESSION['edit_success']);
    } elseif (isset($_SESSION['edit_error'])) {
        echo '<p class="error">' . $_SESSION['edit_error'] . '</p>';
        unset($_SESSION['edit_error']);
    }
    ?>

</body>
</html>
