<?php
session_start();
require('../config/config.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM utilizadores WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $privilegios = $row["privilegios"];
        
        if(password_verify($password, $row['senha'])){
            if($privilegios == 1){
                $_SESSION["admin"] = $email;
                header("Location: ../admin/index_admin.php");
            } else {
                $_SESSION["username"] = $email;
                $_SESSION["usuario_id"] = $row['id_utilizadores'];
                $_SESSION['carrinho'] = array();

                header("Location: ../index.php");
                exit();
            }
        }else{
            $erro = "informação incorreta!";
            $_SESSION['login_error'] = $erro;
            header("Location: ../login.php");
            exit();
        }
    }
    $conn->close();
}




?>
