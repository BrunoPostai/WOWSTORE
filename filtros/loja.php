<?php
session_start();
require('../config/config.php');
// Verifique se o usuário está logado
if (!isset($_SESSION['username'])) {
    // Se não estiver logado, redirecione para a página de login
    header("Location: ../login.php");
    exit();
}

// Verifique se o formulário de adicionar ao carrinho foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add-carrinho'])) {
    $produto_id = $_POST['id_produto'];
    $produto_valor = $_POST['valor'];
    $quantidade_selecionada = $_POST['quantidade']; // Obter a quantidade selecionada

    // Verifique se o produto já existe no carrinho
    if (isset($_SESSION['carrinho'][$produto_id])) {
        // Se existir, atualize a quantidade com a quantidade selecionada
        $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade_selecionada;
    } else {
        // Se não existir, adicione-o ao carrinho com a quantidade selecionada
        $_SESSION['carrinho'][$produto_id] = array(
            'quantidade' => $quantidade_selecionada,
            'valor' => $produto_valor
        );
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>
    <link rel="stylesheet" href="../css/loja.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <!--- TOPO DO SITE --->
    <div class="header">
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="../index.php">Página Inicial</a></li>
            </ul>
        </nav>
        <div class="cart">
            <i class="fa fa-shopping-cart"></i>
            <p>
                <?php
                // Calcule o número total de produtos no carrinho
                $total_produtos = 0;
                if (!empty($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $produto_id => $produto) {
                        $total_produtos += $produto['quantidade'];
                    }
                }
                echo $total_produtos;
                ?>
            </p>
        </div>
    </div>

    <!--- CONTEUDO DO SITE --->
    <div class="container">

        <!--- LINHA DE PRODUTOS --->
        <div class="linha-produtos">
            <?php
            // Consulta SQL para buscar produtos da sua base de dados
            $sql = "SELECT id_produto, nome_produto, preco, imagem, quantidade FROM produtos";
            $result = $conn->query($sql);

            // Verifique se há resultados
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="corpo-produto">';
                    echo '<div class="img-produto">';
                    echo '<img src="' . $row['imagem'] . '" alt="' . $row['nome_produto'] . '" class="produto-miniatura">';
                    echo '</div>';
                    echo '<div class="titulo">';
                    echo '<p>' . $row['nome_produto'] . '</p>';
                    echo '<h3>R$ ' . $row['preco'] . '</h3>';

                    // Formulário para adicionar ao carrinho
                    echo '<form action="loja.php" method="post">';
                    echo '<input type="hidden" name="id_produto" value="' . $row['id_produto'] . '">';
                    echo '<input type="hidden" name="valor" value="' . $row['preco'] . '">';

                    // Campo de seleção de quantidade
                    echo '<label for="quantidade">Quantidade:</label>';
                    echo '<select name="quantidade" id="quantidade">';
                    for ($i = 1; $i <= $row['quantidade']; $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    echo '</select>';

                    echo '<button type="submit" class="button" name="add-carrinho">Adicionar ao carrinho</button>';
                    echo '</form>';

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo 'Nenhum produto encontrado.';
            }
            ?>
        </div>
    </div>

    <!--- BARRA LATERAL --->
    <div class="barra-lateral">
        <div class="topo-carrinho">
            <p>Meu carrinho</p>
        </div>
        <!--- PRODUTO CARRINHO --->
        <?php
        // Verifique se o carrinho está vazio
        if (empty($_SESSION['carrinho'])) {
            echo '<div class="item-carrinho-vazio">';
            echo 'Seu carrinho está vazio!';
            echo '</div>';
        } else {
            foreach ($_SESSION['carrinho'] as $produto_id => $produto) {
                // Recupere os detalhes do produto a partir do banco de dados usando $produto_id
                $sql = "SELECT nome_produto, preco, imagem FROM produtos WHERE id_produto = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $produto_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo '<div class="item-carrinho">';
                    echo '<div class="linha-da-imagem">';
                    echo '<img src="' . $row['imagem'] . '" alt="' . $row['nome_produto'] . '" class="img-carrinho">';
                    echo '</div>';
                    echo '<p>' . $row['nome_produto'] . '</p>';
                    echo '<h3>R$ ' . $row['preco'] . '</h3>';
                    echo '<p>Quantidade: ' . $produto['quantidade'] . '</p>';

                    // Formulário para remover o produto do carrinho
                    echo '<form action="remover_do_carrinho.php" method="post">';
                    echo '<input type="hidden" name="id_produto" value="' . $produto_id . '">';
                    echo '<button type="submit" style="border:none; background:none"><i class="fa-solid fa-trash"></i></button>';
                    echo '</form>';

                    echo '</div>';
                }
            }
        }
        ?>

        <div class="rodape">
            <h3 id="total">Total</h3>
            <form action="concluir_compra.php" method="post">
                <button type="submit" class="button" name="concluir-compra">Concluir Compra</button>
            </form>
            <?php

            // Calcule o total dos produtos no carrinho
            $total = 0;
            foreach ($_SESSION['carrinho'] as $produto_id => $produto) {
                $total += ($produto['valor'] * $produto['quantidade']);
            }
            echo '<h3>R$ ' . $total . '</h3>';
            ?>
        </div>
        <br>
        <div class="error">
            <?php
            if (isset($_SESSION['erro_compra'])) {
                echo $_SESSION['erro_compra'];
                unset($_SESSION['erro_compra']);
            }
            ?>
        </div>
    </div>
</body>
</html>
