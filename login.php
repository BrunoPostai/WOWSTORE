<?php 
    session_start();
    require('config/config.php');
    echo $_SESSION["usuario_id"];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <section>
        <!--<audio autoplay controls>
            <source src="midia/through_the_roof_of_the_world.mp3" type="audio/mpeg">
        </audio>-->
        
        <div class="form-box">
            <div class="form-value">
                <form action="filtros/processo_login.php" method="POST">
                    <h2>Login</h2>
                    <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="email" required>
                        <label for="email">E-mail</label>
                    </div>
                    <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" required name="password">
                        <label for="password">Senha</label>
                    </div>
                    <div class="error">
                        <?php
                            if (isset($_SESSION['login_error'])){
                                echo $_SESSION['login_error'];
                                unset ($_SESSION['login_error']);
                            }
                        ?>
                    </div>
                    <button>Login</button>
                    <div class="register">
                        <p>Não tem uma conta? <a href="register.php">Registre-se</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
