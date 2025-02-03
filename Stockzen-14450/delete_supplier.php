<?php
// Inicia a sessão para mostrar mensagens de sucesso ou erro
session_start();
include "dbconfig.php";  // Inclui a configuração de conexão com o banco de dados

// Verifica se foi enviado o ID do fornecedor
if (isset($_POST['supplier_id'])) {
    $supplier_id = intval($_POST['supplier_id']);  // Converte o ID do fornecedor para um número inteiro
    
    // Verifica se o fornecedor existe no banco de dados
    $sql = "SELECT * FROM suppliers_info WHERE suppliers_info_id = $supplier_id";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Deleta o fornecedor
        $deleteQuery = "DELETE FROM suppliers_info WHERE suppliers_info_id = $supplier_id";
        if (mysqli_query($con, $deleteQuery)) {
            // Define uma mensagem de sucesso na sessão
            $_SESSION['message'] = "Fornecedor excluído com sucesso!";
        } else {
            // Define uma mensagem de erro na sessão
            $_SESSION['message'] = "Erro ao excluir fornecedor: " . mysqli_error($con);
        }
    } else {
        // Caso o fornecedor não seja encontrado
        $_SESSION['message'] = "Fornecedor não encontrado!";
    }

    // Redireciona de volta para a página de fornecedores
    header("Location: fornecedores.php");
    exit();
}
?>
