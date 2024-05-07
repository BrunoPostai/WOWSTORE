<?php
session_start();
require('../config/config.php');

if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}

$sql_users = "SELECT id_utilizadores, nome_utilizador, email, senha FROM utilizadores";
$result_users = $conn->query($sql_users);

if ($result_users->num_rows > 0) {
    $users = $result_users->fetch_all(MYSQLI_ASSOC);
} else {
    $users = [];
}
if (isset($_SESSION['edit_success'])) {
    echo '<p class="success">' . $_SESSION['edit_success'] . '</p>';
    unset($_SESSION['edit_success']);
} elseif (isset($_SESSION['edit_error'])) {
    echo '<p class="error">' . $_SESSION['edit_error'] . '</p>';
    unset($_SESSION['edit_error']);
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Lista de Usuários</title>
    <link rel="stylesheet" href="../css/admin_users.css">
</head>
<body>

    <h1>Lista de Usuários</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th> 
                <th>Senha</th> 
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id_utilizadores']; ?></td>
                    <td><?php echo $user['nome_utilizador']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['senha']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id_utilizadores']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
                <a href="index_admin.php">Voltar ao menu</a>
</body>
</html>
