<?php 
require('config/config.php');
$sucesso = '';
$erro = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(empty($username)){
        echo"Please enter a username";
    } elseif (empty($password)){
        echo"Please enter a password";
    } elseif (empty($email)){
        echo"Please enter an e-mail";
    } else{
        $hash  = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilizadores (nome_utilizador, senha, email) VALUES ('$username', '$hash', '$email')";  

        try {
            if(mysqli_query($conn, $sql)){
                $sucesso = "Você foi registrado com sucesso!";
            } else {
                throw new mysqli_sql_exception("Erro ao registrar: " . mysqli_error($conn));
            }
        } catch (mysqli_sql_exception){
            $erro = "Este e-mail já está em uso";
        }
        
    }
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <section id="register-bg">
        <!--<audio autoplay controls>
            <source src="midia/through_the_roof_of_the_world.mp3" type="audio/mpeg">
        </audio>-->
        
        <div class="form-box">
            <div class="form-value">
                <form action="register.php" method="post">
                    <h2>Registro</h2>
                    <div class="inputbox">
                    <ion-icon name="person-outline"></ion-icon>
                        <input type="text"  name="username">
                        <label for="name">Nome de usuario</label>
                    </div>
                    <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                        <input type="email"  name="email">
                        <label for="email">E-mail</label>
                    </div>
                    <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password"  name="password">
                        <label for="password">Senha</label>
                    </div>
                    <div class="sucesso">
                        <?php 
                            echo $sucesso;
                        ?>
                    </div>
                    <div class="error">
                        <?php 
                            echo $erro;
                        ?>
                    </div>
                    <button>Registre-se</button>
                    <div class="register">
                        <p>Já tem uma conta?  <a href="login.php">Faça o login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
