<?php
include "dbconfig.php";

$query = "SELECT * FROM suppliers";
$result = mysqli_query($con, $query);

$fornecedores = [];

while ($row = mysqli_fetch_assoc($result)) {
    $fornecedores[] = [
        'nome' => $row['name'],
        'tipo_contato' => $row['contact_type'],
        'contato' => $row['contact'],
        'localidade' => $row['location']
    ];
}

echo json_encode($fornecedores);
mysqli_close($con);
?>
