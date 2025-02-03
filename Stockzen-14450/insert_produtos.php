<?php
include "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $category_id = intval($_POST['category_id']);
    
    //upload
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $image_name = basename($_FILES['product_image']['name']);
    $target_file = $upload_dir . time() . "_" . $image_name;

    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
        $query = "INSERT INTO products (name, description, price, stock_quantity, category_id, image_path) 
                  VALUES ('$name', '$description', $price, $stock_quantity, $category_id, '$target_file')";
        if (mysqli_query($con, $query)) {
            // Mensagem de sucesso e redirecionamento
            echo "<script>
                    alert('Produto adicionado com sucesso!');
                    window.location.href = 'gestao.php';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Erro ao adicionar o produto: " . mysqli_error($con) . "');
                    window.history.back();
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Erro ao fazer o upload da imagem.');
                window.history.back();
              </script>";
        exit;
    }
}
?>
