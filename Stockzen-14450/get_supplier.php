<?php
include "dbconfig.php";

if (isset($_GET['supplier_id'])) {
    $supplier_id = intval($_GET['supplier_id']);
    $sql = "SELECT * FROM suppliers_info WHERE id = $supplier_id";
    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $supplier = mysqli_fetch_assoc($result);
        echo json_encode($supplier);
    } else {
        echo json_encode(['error' => 'Fornecedor não encontrado']);
    }
}
?>
