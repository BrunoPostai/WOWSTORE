<?php 

session_start();
if (isset($_SESSION["admin"])){
    header("Location: admin/index_admin.php");
    exit();
} elseif (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
    <link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <section>
        <input type="checkbox" id="check">
        <header>
            <h2> <a href="#" class="logo">WOW STORE</a></h2>
            <div class="navigation">
                <a href="index.php">Home</a>
                <a href="register.php">Register</a>
                <a href="filtros/loja.php">Loja</a>
                <a href="filtros/modificar_info.php">Modificar Info</a>
                <a href="admin/index_admin.php" id="admin-link">Acesso Admin</a>
                <a href="filtros\logout.php?logout=1">Logout</a>
                </div>
            </div>

            <label for="check">
                <i class=" fas fa-bars menu-btn"></i>
                <i class=" fas fa-time menu-btn"></i>
            </label>
        </header>
        <div class="content">
            <div class="info">
                <h2>BEM-VINDO<span><br>Confira o nosso catalogo!</span></h2>
                <p>Aqui você encontrará uma incrível variedade de transmogs, itens e acessórios para aprimorar sua experiência em Azeroth! Nossa seleção cuidadosamente escolhida é perfeita para todos os aventureiros, desde novatos até veteranos, e oferece uma maneira única de mostrar seu estilo e dominar os desafios do mundo de WoW.</p>
                <a href="filtros/loja.php" class="info-btn">Produtos</a>
            </div>
        </div>
        <div class="media-icons">
            <a href="#" class="icon-hover"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon-hover"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#" class="icon-hover"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </section>

</div>

</body>
</html>