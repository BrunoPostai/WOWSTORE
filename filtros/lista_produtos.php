<?php 
session_start();
include("../config/config.php");
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
    <title>Lista dos Produtos</title>
    <link rel="stylesheet" href="../css/lista_produtos.css">
</head>
<body>
<ul class="navbar">
        <li><a href="../index.php">Página Inicial</a></li>
        <li><a href="inserir_produtos.php">Inserir produtos</a></li>
    </ul>
<section>
    <table>
        <thead>
            <tr>
                <th>Imagem</th>
                <th>ID do Produto</th>
                <th>Nome do Produto</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
                
                <?php 
                    $sql = "SELECT id_produto, nome_produto, quantidade, preco, imagem FROM produtos";
                    $result = $conn->query($sql);

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo '<td><img src="' . $row["imagem"] . '" alt="Imagem do Produto" width="100"></td>';
                        echo "<td>" . $row["id_produto"] . "</td>";
                        echo "<td>" . $row["nome_produto"] . "</td>";
                        echo "<td>" . $row["quantidade"] . "</td>";
                        echo "<td>R$ " . $row["preco"] . "</td>";
                        echo '<td>
                        <a href="editar_produto.php?id=' . $row["id_produto"] . '">Editar</a>
                        <a href="excluir_produto.php?id=' . $row["id_produto"] . '">Excluir</a>
                            </td>';
                        echo "</tr>";
                    }
                } else{
                    // Se não houver produtos
                    echo "<tr><td colspan='6'>Nenhum produto encontrado.</td></tr>";
                }
                ?>
        </tbody>

    </table>
</section>
</body>
</html>
