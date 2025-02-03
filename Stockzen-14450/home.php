<?php
session_start();
include "dbconfig.php";

// Consulta para obter os produtos com Stock inferior ou igual a 5
$query = "SELECT name FROM products WHERE stock_quantity <= 5";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Erro ao consultar produtos: " . mysqli_error($con));
}

// Verificar se há produtos com Stock baixo e salvar os nomes na sessão
$lowStockProducts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $lowStockProducts[] = $row['name'];
}

// Se houver produtos com Stock baixo, salva na variável de sessão
if (count($lowStockProducts) > 0) {
    $_SESSION['low_stock_products'] = $lowStockProducts;
} else {
    unset($_SESSION['low_stock_products']); // Limpar se não houver produtos com Stock baixo
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>StockZen: Página Inicial</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="home.php">StockZen</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" id="searchInput" placeholder="Procurar por..." aria-label="Search" />
                <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="index.php">Sair</a></li>
                </ul>
            </li>
        </ul>
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
                    <h1 class="mt-4">Bem-vindo ao StockZen</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="home.php">Página Inicial</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    <?php
                    // Exibir mensagem se houver produtos com Stock baixo
                    if (isset($_SESSION['low_stock_products'])) {
                        $products = implode(", ", $_SESSION['low_stock_products']); // Junta os nomes dos produtos em uma string
                        echo "<div class='alert alert-warning'>
                                Atenção! Os seguintes produtos estão com Stock baixo (5 ou menos): $products
                              </div>";
                        unset($_SESSION['low_stock_products']); // Limpar a variável após exibição
                    }
                    ?>

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white shadow mb-4">
                                <div class="card-body">
                                    <h5>Produtos</h5>
                                    <p>Total: 120</p>
                                </div>
                                <div class="card-footer text-end">
                                    <a href="produtos.php" class="text-white">Ver Detalhes <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white shadow mb-4">
                                <div class="card-body">
                                    <h5>Fornecedores</h5>
                                    <p>Total: 15</p>
                                </div>
                                <div class="card-footer text-end">
                                    <a href="fornecedores.php" class="text-white">Ver Detalhes <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white shadow mb-4">
                                <div class="card-body">
                                    <h5>Pedidos Pendentes</h5>
                                    <p>Total: 8</p>
                                </div>
                                <div class="card-footer text-end">
                                    <a href="gestao.php" class="text-white">Ver Detalhes <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white shadow mb-4">
                                <div class="card-body">
                                    <h5>Alertas</h5>
                                    <p>3 Produtos com stock Crítico</p>
                                </div>
                                <div class="card-footer text-end">
                                    <a href="gestao.php" class="text-white">Ver Detalhes <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-xl-6">
                            <div class="card shadow">
                                <div class="card-header">
                                    <i class="fas fa-chart-line"></i> Estatísticas de Stock
                                </div>
                                <div class="card-body">
                                    <canvas id="stockChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card shadow">
                                <div class="card-header">
                                    <i class="fas fa-users"></i> Fornecedores Ativos
                                </div>
                                <div class="card-body">
                                    <canvas id="supplierChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between small">
                        <div class="text-muted">StockZen &copy; 2025</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const stockCtx = document.getElementById('stockChart').getContext('2d');
        const supplierCtx = document.getElementById('supplierChart').getContext('2d');

        new Chart(stockCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar'],
                datasets: [{
                    label: 'Stock',
                    data: [120, 150, 100],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107']
                }]
            }
        });

        new Chart(supplierCtx, {
            type: 'pie',
            data: {
                labels: ['Ativos', 'Inativos'],
                datasets: [{
                    data: [12, 3],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            }
        });
    </script>
</body>

</html>
