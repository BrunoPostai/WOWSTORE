<?php
session_start();
if (!isset($_SESSION["admin"])){
    session_unset();
    header("Location: ../login.php");
    exit();
}
include("../config/config.php");

// Consulta para selecionar todas as encomendas
$sql = "SELECT * FROM encomendas";

$result = $conn->query($sql);

// Feche a conexão com o banco de dados após a consulta
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/encomendas.css">
    <title>Lista de Encomendas</title>
    <!-- Seus estilos CSS aqui -->
</head>
<body>
    <h1>Lista de Encomendas</h1>

    <?php
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr>';
        echo '<th>ID da Encomenda</th>';
        echo '<th>Nome do Utilizador</th>';
        echo '<th>Produtos Comprados e quantidade</th>';
        echo '<th>Preço Total</th>';
        echo '</tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["id_encomenda"] . '</td>';
            echo '<td>' . $row["nome_utilizador"] . '</td>';
            echo '<td>' . $row["produtos_comprados"] . '</td>';
            echo '<td>R$ ' . $row["preco_total"] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo 'Nenhuma encomenda encontrada.';
    }
    ?>

    <a href="../admin/index_admin.php">Voltar ao Menu Admin</a>
</body>
</html>
