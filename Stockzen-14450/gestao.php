<?php 
session_start();
include "dbconfig.php";  

// Para buscar categorias
$query = "SELECT * FROM product_categories";
$result = mysqli_query($con, $query);  

$categories = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }

    echo '<script>';
    echo 'var categories = ' . json_encode($categories) . ';';
    echo '</script>';
} else {
    echo '<script>';
    echo 'var categories = [];';
    echo '</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>StockZen</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">

    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.html">StockZen</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Home</div>
                        <a class="nav-link" href="home.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Página Inicial
                        </a>
                        <div class="sb-sidenav-menu-heading">Stock</div>
                        <a class="nav-link" href="gestao.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                            Controlo de Stock
                        </a>
                        <a class="nav-link" href="produtos.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                            Produtos
                        </a>
                        <a class="nav-link" href="fornecedores.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                            Fornecedores
                        </a>
                        <div class="sb-sidenav-menu-heading">Logs</div>
                        <a class="nav-link" href="historico_saidas.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                            Historico de Saidas
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Registo de Produtos</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Produtos</li>
                    </ol>

                    <!-- Formulário de Registro de Produtos -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-cogs me-1"></i>
                            Registo de Produto
                        </div>
                        <form id="formProduto" action="insert_produtos.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome do Produto</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição</label>
                                <input type="text" class="form-control" id="description" name="description" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Preço</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock_quantity" class="form-label">Quantidade</label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Categorias</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Selecione uma Categoria</option>
                                    <?php
                                    $query = "SELECT * FROM product_categories";
                                    $result = mysqli_query($con, $query);  
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $categories_id = $row["id"];
                                            $categories_name = $row["name"];
                                            echo "<option value='$categories_id'>$categories_name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="product_image" class="form-label">Imagem do Produto</label>
                                <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Adicionar Produto</button>
                        </form>
                    </div>
                </div>
            </main>

            <!-- Rodapé -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">StockZen &copy; Since 2025</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
