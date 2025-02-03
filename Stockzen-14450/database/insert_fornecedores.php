<?php
$host = 'localhost';
$usuario = 'admin';  
$senha = 'admin12';      
$banco = 'papa_stockzen'; 

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega os dados do formulário e faz a sanitização
    $name = $conn->real_escape_string($_POST['nome']);
    $location = $conn->real_escape_string($_POST['endereco']);
    $phone = $conn->real_escape_string($_POST['telefone']);
    $email = $conn->real_escape_string($_POST['email']);

    // SQL para inserir dados
    $sql = "INSERT INTO suppliers_info (name, location, phone, email) VALUES ('$name', '$location', '$phone', '$email')";

    // Executa a query
    if ($conn->query($sql) === TRUE) {
        echo "Novo fornecedor cadastrado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Fecha a conexão
$conn->close();
?>
