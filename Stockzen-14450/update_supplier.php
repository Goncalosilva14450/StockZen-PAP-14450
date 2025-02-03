<?php
session_start();
include "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nome = trim($_POST['name']);
    $tipo_contato = trim($_POST['contact_type']);
    $contato = trim($_POST['contact']);
    $localidade = trim($_POST['location']);

    if (empty($nome) || empty($tipo_contato) || empty($contato) || empty($localidade)) {
        $_SESSION['error'] = "Todos os campos são obrigatórios!";
        header("Location: fornecedores.php");
        exit();
    }

    $sql = "UPDATE suppliers_info SET name = ?, contact_type = ?, contact = ?, location = ? WHERE suppliers_info_id = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $tipo_contato, $contato, $localidade, $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Fornecedor atualizado com sucesso!";
        } else {
            $_SESSION['error'] = "Erro ao atualizar: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Erro na preparação da query: " . mysqli_error($con);
    }

    header("Location: fornecedores.php");
    exit();
}
?>