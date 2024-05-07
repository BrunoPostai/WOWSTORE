<?php
session_start();
include('../config/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produto = $_POST['id_produto'];
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    // Verifique se uma nova imagem foi enviada
    if ($_FILES['nova_imagem']['size'] > 0) {
        $nova_imagem = $_FILES['nova_imagem']['name'];
        $nova_imagem_temp = $_FILES['nova_imagem']['tmp_name'];
        $nova_imagem_caminho = "../img/" . $nova_imagem;

        // Verifique se o arquivo foi enviado com sucesso
        if (move_uploaded_file($nova_imagem_temp, $nova_imagem_caminho)) {
            // Atualize os dados do produto, incluindo a nova imagem
            $sql = "UPDATE produtos SET nome_produto = ?, quantidade = ?, preco = ?, imagem = ? WHERE id_produto = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sidsi", $nome, $quantidade, $preco, $nova_imagem_caminho, $id_produto);
        } else {
            // Erro no upload da nova imagem
            $_SESSION['produto_error'] = "Erro ao fazer upload da nova imagem.";
            header("Location: editar_produto.php?id=$id_produto");
            exit();
        }
    } else {
        // Atualize os dados do produto sem a imagem
        $sql = "UPDATE produtos SET nome_produto = ?, quantidade = ?, preco = ? WHERE id_produto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sidi", $nome, $quantidade, $preco, $id_produto);
    }

    if ($stmt->execute()) {
        // Produto atualizado com sucesso
        $_SESSION['success_message'] = "Produto atualizado com sucesso.";
        header("Location: lista_produtos.php");
        exit();
    } else {
        // Erro ao atualizar o produto
        $_SESSION['produto_error'] = "Erro ao atualizar o produto.";
        header("Location: editar_produto.php?id=$id_produto");
        exit();
    }
}

// Verifique se um ID de produto foi fornecido via parâmetro GET
if (isset($_GET['id'])) {
    $id_produto = $_GET['id'];

    // Recupere os dados do produto com base no ID
    $sql = "SELECT id_produto, nome_produto, quantidade, preco, imagem FROM produtos WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        // Produto não encontrado
        $_SESSION['produto_error'] = "Produto não encontrado.";
        header("Location: lista_produtos.php");
        exit();
    }
} else {
    // ID de produto não fornecido
    $_SESSION['produto_error'] = "ID de produto não fornecido.";
    header("Location: lista_produtos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/editar_produto.css">
</head>
<body>
    <div class="container">
    <h2>Editar Produto</h2>
        <?php
        if (isset($_SESSION['produto_error'])) {
            echo '<div class="error">' . $_SESSION['produto_error'] . '</div>';
            unset($_SESSION['produto_error']);
        }
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        ?>
        <form action="editar_produto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" value="<?php echo $row["id_produto"]; ?>">
            <label for="nome">Nome do Produto</label>
            <input type="text" name="nome" value="<?php echo $row["nome_produto"]; ?>" required>

            <label for="preco">Preço</label>
            <input type="number" name="preco" step="0.01" value="<?php echo $row["preco"]; ?>" required>

            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" value="<?php echo $row["quantidade"]; ?>" required>

            <label for="nova_imagem">Nova Imagem (opcional)</label>
            <input type="file" name="nova_imagem" accept="image/*">

            <input type="submit" value="Salvar Alterações">
        </form>
    </div>
</body>
</html>
