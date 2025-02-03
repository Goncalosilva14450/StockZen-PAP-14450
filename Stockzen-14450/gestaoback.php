<?php
session_start();
include "dbconfig.php";  

// Para buscar"product_categories"
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
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.html">StockZen</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <!-- Sidebar -->
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Home</div>
                        <a class="nav-link" href="home.php">
    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
    Página Inicial
</a>
                        <div class="sb-sidenav-menu-heading">Stock</div>
                        <a class="nav-link" href="gestao.php" >
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                            Controlo de Stock
                        </a>
                        <a class="nav-link" href="produtos.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                            Produtos
                       
                        <a class="nav-link" href="fornecedores.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                            Fornecedores
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Registro de Produtos</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Produtos</li>
                    </ol>

<!-- Formulário de resgistr o edportuos -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-cogs me-1"></i>
                            Registro de Produto
                        </div>
                        <form id="formProduto" action="insert_fornecedores.php" method="POST">

    <div class="mb-3">
        <label for="nomeProduto" class="form-label">Nome do Produto</label>
        <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" required>
    </div>
    <div class="mb-3">
        <label for="descricaoProduto" class="form-label">Descrição</label>
        <input type="text" class="form-control" id="descricaoProduto" name="descricaoProduto" required>
    </div>
    <div class="mb-3">
        <label for="precoProduto" class="form-label">Preço</label>
        <input type="number" class="form-control" id="precoProduto" name="precoProduto" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="quantidadeProduto" class="form-label">Quantidade</label>
        <input type="number" class="form-control" id="quantidadeProduto" name="quantidadeProduto" required>
    </div>







    <div class="mb-3">
        <label for="categoriaProduto" class="form-label">Categorias</label>
        <select class="form-control" id="categoriaProduto" name="categoriaProduto" required>
            <option value="">Selecione uma Categoria</option>

            <?php

$query = "SELECT * FROM product_categories";
$result = mysqli_query($con, $query);  



if ($result) {
while ($row = mysqli_fetch_assoc($result)) {
    $categories_id = $row["id"];
    $categories_name = $row["name"];

echo "<option value=$categories_i>$categories_name</option>";
}


}


?>








        </select>
    </div>
    <button type="submit" class="btn btn-primary">Adicionar Produto</button>
</form>



            <!-- Rodapé -->
    <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">StockZen &copy; Since 2025</div>
                    </div>
                </div>
            </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

</body>
</html>