<?php 
session_start();
require('../config/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST['nome'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];

        //manipulacao da imagem
        $imagem = $_FILES['imagem']['name'];
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem_caminho = "../img/" . $imagem;
        
        if (move_uploaded_file($imagem_temp, $imagem_caminho)){
            //upload bem-sucedido, agora voce pode inserir os dados
            $sql = "INSERT INTO produtos (nome_produto, quantidade, preco, imagem) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sids", $nome, $quantidade, $preco, $imagem_caminho);

            if ($stmt->execute()){
                //Produto adicionado com sucesso
                header("Location: lista_produtos.php");
                exit();
            } else {
                //Erro ao adicionar o produto
                $_SESSION['produto_error'] = "Erro ao adicionar o produto";
                header("Location: inserir_produtos.php");
                exit();
            }
        } else{
            //Erro no upload da imagem
            $_SESSION['produto_error'] = "Erro ao adicionar a imagem";
            header("Location: inserir_produtos.php");
            exit();
        }
        $conn->close();
    }

?>