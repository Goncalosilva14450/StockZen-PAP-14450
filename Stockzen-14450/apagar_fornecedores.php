<?php
include "dbconfig.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM suppliers_info WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: fornecedores.php");
        exit();
    } else {
        echo "Erro ao apagar o fornecedor.";
    }
} else {
    echo "ID não fornecido.";
}
?>
