<?php 
session_start();
if (!isset($_SESSION["admin"])){
    session_unset();
    header("Location: ../login.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
    <link rel="stylesheet" href="../css/index-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <section>
        <input type="checkbox" id="check">
        <header>
            <h2> <a href="#" class="logo">WOW STORE</a></h2>
            <div class="navigation">
                <a href="../index.php">Home</a>
                <a href="../register.php">Register</a>
                
                <div class="dropdown">
                    <button class="dropbtn">Funções</button>
                    <div class="dropdown-content">
                        <a href="../filtros/lista_produtos.php">Produtos</a>
                        <a href="../filtros/inserir_produtos.php">Inserir Produto</a>
                        <a href="encomendas.php">Encomendas</a>
                        <a href="admin_users.php">Users</a>
                        <!-- Adicione outros links relacionados a produtos aqui -->
                    </div>
                </div>
                <a href="../filtros/logout.php?logout=1">Logout</a>
            </div>

            <label for="check">
                <i class=" fas fa-bars menu-btn"></i>
                <i class=" fas fa-time menu-btn"></i>
            </label>
        </header>
        <div class="content">
            <div class="info">
                <h2>Bem-vindo<span><br></span></h2>
                <p>Bem vindo administrador, aqui voce pode chegar as encomendas, produtos, inseri-los ou edita-los</p>
            </div>
        </div>
        <div class="media-icons">
            <a href="#" class="icon-hover"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon-hover"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#" class="icon-hover"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </section>
</body>
</html>