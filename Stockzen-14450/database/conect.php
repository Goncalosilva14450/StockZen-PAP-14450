<?php
$host = 'localhost';
$usuario = 'root';  
$senha = '';      
$banco = 'papa_stockzen'; 

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida!";
}

$conn->close();
?>



