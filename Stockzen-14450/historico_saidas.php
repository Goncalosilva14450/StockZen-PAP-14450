<?php
session_start();
include "dbconfig.php";
$sql = "SELECT movement_id, product_name, quantity, observation, date
        FROM stock_movement
        JOIN products p ON movement_id = movement_id
        ORDER BY date DESC";   
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>StockZen: Histórico de Saídas</title>
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
                    <h1 class="mt-4">Histórico de Saídas</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Histórico de movimentação de saídas de estoque</li>
                    </ol>

                    <!-- Tabela de Histórico de Saídas -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                        <th>Motivo</th>
                                        <th>Data de Saída</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        // Exibir os resultados da consulta
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["movement_id"] . "</td>";
                                            echo "<td>" . $row["product_name"] . "</td>";
                                            echo "<td>" . $row["quantity"] . "</td>";
                                            echo "<td>" . $row["observation"] . "</td>";
                                            echo "<td>" . $row["date"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>Nenhum registro encontrado</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="/js/scripts.js"></script>
</body>

</html>

<?php
$con->close();
?>
