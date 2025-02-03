<?php
include "dbconfig.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM suppliers_info WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $fornecedor = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $tipoContato = $_POST['tipoContato'];
    $contato = $_POST['contato'];
    $address = $_POST['address'];

    if ($tipoContato == "Email") {
        $sql = "UPDATE suppliers_info SET name = ?, email = ?, phone = NULL, address = ? WHERE id = ?";
    } else {
        $sql = "UPDATE suppliers_info SET name = ?, email = NULL, phone = ?, address = ? WHERE id = ?";
    }

    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssi", $name, $contato, $address, $id);

    if ($stmt->execute()) {
        header("Location: fornecedores.php");
        exit();
    } else {
        echo "Erro ao atualizar o fornecedor.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar Fornecedor</title>
</head>
<body>
    <h1>Editar Fornecedor</h1>
    <form method="POST" action="editar_fornecedor.php">
        <input type="hidden" name="id" value="<?php echo $fornecedor['id']; ?>">
        <div>
            <label>Nome:</label>
            <input type="text" name="name" value="<?php echo $fornecedor['name']; ?>" required>
        </div>
        <div>
            <label>Tipo de Contato:</label>
            <select name="tipoContato" required>
                <option value="Email" <?php if (!empty($fornecedor['email'])) echo 'selected'; ?>>Email</option>
                <option value="Telefone" <?php if (!empty($fornecedor['phone'])) echo 'selected'; ?>>Telefone</option>
            </select>
        </div>
        <div>
            <label>Contato:</label>
            <input type="text" name="contato" value="<?php echo !empty($fornecedor['email']) ? $fornecedor['email'] : $fornecedor['phone']; ?>" required>
        </div>
        <div>
            <label>Localidade:</label>
            <input type="text" name="address" value="<?php echo $fornecedor['address']; ?>" required>
        </div>
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
