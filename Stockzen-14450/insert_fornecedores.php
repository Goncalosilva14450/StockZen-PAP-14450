<?php
session_start();
include "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $tipo_contato = $_POST['tipo_contato'];
    $contato = $_POST['contato'];
    $localidade = $_POST['localidade'];

    // Validate inputs
    if (empty($nome) || empty($tipo_contato) || empty($contato) || empty($localidade)) {
        $_SESSION['error'] = "Todos os campos são obrigatórios!";
        header("Location: fornecedores.php");
        exit();
    }

    // Insert into database
    $sql = "INSERT INTO fornecedores (nome, tipo_contato, contato, localidade) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $nome, $tipo_contato, $contato, $localidade);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Fornecedor adicionado com sucesso!";
    } else {
        $_SESSION['error'] = "Erro ao adicionar: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

header("Location: fornecedores.php");
exit();
?>