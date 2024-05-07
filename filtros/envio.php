<?php
session_start();
require('../config/config.php');

// Verifica se o a compra foi concluída com sucesso
if (!isset($_SESSION['compra_concluida'])) {
    header("Location: loja.php");
    exit();
}

// Função para evitar injeção de JavaScript e preparar os dados
function clean_input($input) {
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Prepare os dados para inserção no banco de dados
    $nome = clean_input($_POST['nome']);
    $usuario_id = $_SESSION['usuario_id']; // Obtenha o ID do usuário da sessão
    $dataNascimento = clean_input($_POST['data_nascimento']);
    $morada = clean_input($_POST['morada']);

    // Verificação de idade
    $dataNascimentoTimestamp = strtotime($dataNascimento);
    $hoje = strtotime('today');
    $idade = floor(($hoje - $dataNascimentoTimestamp) / (365.25 * 24 * 60 * 60)); // Calcula a idade em anos

    if ($idade < 18) {
        $_SESSION['erro_envio'] = "Você deve ter pelo menos 18 anos para concluir a compra.";
        header("Location: envio.php");
        exit();
    }
    // Processar produtos do carrinho e calcular a quantidade total e o preço total
    $produtosComprados = "";
    $quantidadeTotal = 0;
    $precoTotal = 0.0;

    foreach ($_SESSION['carrinho'] as $produto_id => $produto) {
        $quantidadeTotal += $produto['quantidade'];
        $precoTotal += $produto['quantidade'] * $produto['valor'];
        
        // Adicione o produto à lista de produtos comprados
        $produtosComprados .= "Produto: " . $produto_id . ", Quantidade: " . $produto['quantidade'] . "; ";
    }

    // Insira os dados na tabela Encomendas usando declaração preparada
    $stmt = $conn->prepare("INSERT INTO encomendas (nome_utilizador, id_utilizador, data_nascimento, morada, produtos_comprados,  preco_total) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsssd", $nome, $usuario_id , $dataNascimento, $morada, $produtosComprados, $precoTotal);

    if ($stmt->execute()) {
        // Inserção bem-sucedida, defina uma mensagem de sucesso
        $mensagem = "A sua compra foi concluida com sucesso";
        // Esvaziar o carrinho após a compra
        unset($_SESSION['carrinho']);
    } else {
        // Erro ao inserir dados na tabela Encomendas
        $_SESSION['erro_envio'] = "Erro ao inserir dados na tabela Encomendas: " . $stmt->error;
    }

    // Feche a conexão com o banco de dados
    $stmt->close();
    $conn->close();

    // Limpa as sessões de erro e compra concluída
    unset($_SESSION['erro_envio']);
    unset($_SESSION['compra_concluida']);
    unset($_SESSION["encomenda_concluida"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações de Envio</title>
    <link rel="stylesheet" href="../css/envio.css">
    <link rel="stylesheet" href="seu_estilo.css"> <!-- Inclua seu arquivo de estilo CSS aqui -->
</head>
<body>
    <h1>Informações de Envio</h1>
    <?php
    // Exibir mensagem de sucesso ou erro
    if (isset($_SESSION['erro_envio'])) {
        echo '<p class="erro">' . $_SESSION['erro_envio'] . '</p>';
    }
    if(isset($mensagem)){
        echo '<p class="mensagem">' . $mensagem . '</p>';
    }
    ?>
    <form action="envio.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required>

        <label for="morada">Morada:</label>
        <input type="text" id="morada" name="morada" required>

        <button type="submit">Concluir Transação</button>
    </form>
    <p><a href="../index.php">Voltar ao menu</a></p>
</body>
</html>
