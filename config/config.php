<?php 
// configuracoes do banco de dados
    $hostname = "localhost";
    $username = "root";
    $password = "senha123";
    $database = "loja_wow";
    $conn = mysqli_connect($hostname, $username, $password, $database);
     
    if (!$conn) {
        die("A conexão ao banco de dados falhou: " . mysqli_connect_error());
    }

?>