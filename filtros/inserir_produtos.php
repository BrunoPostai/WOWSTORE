<?php 
session_start();
require('../config/config.php');
if (!isset($_SESSION["admin"])){
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Produtos</title>
    <link rel="stylesheet" href="../css/inserir_produtos.css">
</head>
<body>
<ul class="navbar">
        <li><a href="../index.php">Página Inicial</a></li>
        <li><a href="lista_produtos.php">Editar produtos</a></li>
    </ul>
    <div class="container">
    <form action="processo_inserir.php" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome de Produto</label>
        <input type="text" name="nome" required>

        <label for="preco">Preço</label>
        <input type="number" name="preco" step="0.01" required>

        <label for="quantidade">Quantidade</label>
        <input type="number" name="quantidade" required>

        <label for="imagem">Imagem</label>
        <input type="file" name="imagem" accept="image/*" required>

        <input type="submit" value="Adicionar Produto">
        <div class="erro">
            <?php 
                if(isset($_SESSION['produto_error'])){
                    echo$_SESSION['produto_error'];
                    unset($_SESSION['produto_error']);
                }
            ?>
        </div>
    </form>   
    </div>


</body>
</html>
