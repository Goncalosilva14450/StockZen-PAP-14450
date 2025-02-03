<?php
session_start();
include "dbconfig.php"; 

// Consulta os produtos
$query = "SELECT product_id, name, description, price, stock_quantity, created_at, image_path FROM products";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Erro ao consultar produtos: " . mysqli_error($con));
}

// Processando a edição, saída de estoque e exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        // Editar produto
        $product_id = intval($_POST['product_id']);
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $price = floatval($_POST['price']);
        $stock_quantity = intval($_POST['stock_quantity']);

        $updateQuery = "UPDATE products SET name='$name', description='$description', price=$price, stock_quantity=$stock_quantity WHERE product_id=$product_id";
        if (!mysqli_query($con, $updateQuery)) {
            die("Erro ao atualizar produto: " . mysqli_error($con));
        }

        // Verifica estoque zerado e exclui automaticamente
        if ($stock_quantity === 0) {
            $deleteQuery = "DELETE FROM products WHERE product_id=$product_id";
            if (!mysqli_query($con, $deleteQuery)) {
                die("Erro ao excluir produto: " . mysqli_error($con));
            }
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    
    }

    if (isset($_POST['saida'])) {
        // Dar saída no estoque
        $product_id = intval($_POST['product_id']);
        $saida_quantity = intval($_POST['saida_quantity']);

        // Verificar se a quantidade de saída é válida
        $queryStock = "SELECT stock_quantity FROM products WHERE product_id=$product_id";
        $resultStock = mysqli_query($con, $queryStock);
        $row = mysqli_fetch_assoc($resultStock);
        $currentStock = $row['stock_quantity'];

        if ($currentStock >= $saida_quantity) {
            $newStock = $currentStock - $saida_quantity;
            $updateQuery = "UPDATE products SET stock_quantity = $newStock WHERE product_id=$product_id";
            if (!mysqli_query($con, $updateQuery)) {
                die("Erro ao registrar saída: " . mysqli_error($con));
            }

            // Verifica estoque zerado e exclui automaticamente
            if ($newStock === 0) {
                $deleteQuery = "DELETE FROM products WHERE product_id=$product_id";
                if (!mysqli_query($con, $deleteQuery)) {
                    die("Erro ao excluir produto: " . mysqli_error($con));
                }
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Quantidade insuficiente em estoque!');</script>";
        }
    }
}

// Excluir produto se confirmado
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM products WHERE product_id=$product_id";
    if (!mysqli_query($con, $deleteQuery)) {
        die("Erro ao excluir produto: " . mysqli_error($con));
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
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

    <style>
        /* Estilos do Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 60px;
            transition: opacity 0.3s ease-in-out;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .modal-actions {
            text-align: right;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        #Table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            border: 1px solid #ddd;
        }

        #Table thead th {
            background-color: #f4f4f4;
            color: #333;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        #Table td, #Table th {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        #Table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #Table td img {
            width: 100px;
            height: auto;
            border-radius: 3px;
            border: 1px solid #ccc;
        }
    </style>

</head>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.html">StockZen</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" id="searchInput" placeholder="Procurar por..." onkeyup="buscarPeca()" />
                <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
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
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Produtos</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="home.php">Página Inicial</a></li>
                        <li class="breadcrumb-item active">Produtos</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Produtos
                        </div>
                        <div class="card-body">
                            <table id="Table">
                                <thead>
                                    <tr>
                                        <th>Imagem</th>
                                        <th>Nome do Produto</th>
                                        <th>Descrição</th>
                                        <th>Preço (€)</th>
                                        <th>Quantidade em Stock</th>
                                        <th>Última Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>";
                                        if (!empty($row['image_path']) && file_exists($row['image_path'])) {
                                            echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Imagem do Produto'>";
                                        } else {
                                            echo "Sem imagem";
                                        }
                                        echo "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                        echo "<td>" . number_format($row['price'], 2, ',', '.') . "</td>";
                                        echo "<td>" . htmlspecialchars($row['stock_quantity']) . "</td>";
                                        echo "<td>" . date("d/m/Y H:i:s", strtotime($row['created_at'])) . "</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-primary editBtn' data-id='" . $row['product_id'] . "' data-name='" . $row['name'] . "' data-description='" . $row['description'] . "' data-price='" . $row['price'] . "' data-stock='" . $row['stock_quantity'] . "'>Editar</button>";
                                        echo "<button class='btn btn-danger saidaBtn' data-id='" . $row['product_id'] . "' data-stock='" . $row['stock_quantity'] . "'>Saída</button>";
                                        echo "</td>";
                                        echo "</tr>";
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

    <!-- Modal Editar -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Produto</h2>
            <form id="editForm" method="POST">
                <input type="hidden" id="modalProductId" name="product_id">
                <label for="modalName">Nome:</label>
                <input type="text" id="modalName" name="name" required>
                <label for="modalDescription">Descrição:</label>
                <input type="text" id="modalDescription" name="description" required>
                <label for="modalPrice">Preço (€):</label>
                <input type="number" id="modalPrice" name="price" step="0.01" required>
                <label for="modalStockQuantity">Quantidade em estoque:</label>
                <input type="number" id="modalStockQuantity" name="stock_quantity" required>
                <div class="modal-actions">
                    <button type="submit" name="edit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Saída Estoque -->
    <div id="saidaModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Saída de Estoque</h2>
            <form id="saidaForm" method="POST">
                <input type="hidden" id="saidaProductId" name="product_id">
                <label for="saidaQuantity">Quantidade a sair:</label>
                <input type="number" id="saidaQuantity" name="saida_quantity" min="1" required>
                <div class="modal-actions">
                    <button type="submit" name="saida" class="btn btn-danger">Confirmar Saída</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal de edição
        const editBtns = document.querySelectorAll('.editBtn');
        const editModal = document.getElementById('editModal');
        const closeEditModal = editModal.querySelector('.close');

        editBtns.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const description = this.getAttribute('data-description');
                const price = this.getAttribute('data-price');
                const stockQuantity = this.getAttribute('data-stock');

                document.getElementById('modalProductId').value = productId;
                document.getElementById('modalName').value = name;
                document.getElementById('modalDescription').value = description;
                document.getElementById('modalPrice').value = price;
                document.getElementById('modalStockQuantity').value = stockQuantity;

                editModal.style.display = "block";
            });
        });

        closeEditModal.addEventListener('click', () => {
            editModal.style.display = "none";
        });

        // Modal de saída de estoque
        const saidaBtns = document.querySelectorAll('.saidaBtn');
        const saidaModal = document.getElementById('saidaModal');
        const closeSaidaModal = saidaModal.querySelector('.close');

        saidaBtns.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const stockQuantity = this.getAttribute('data-stock');

                document.getElementById('saidaProductId').value = productId;
                document.getElementById('saidaQuantity').setAttribute('max', stockQuantity);

                saidaModal.style.display = "block";
            });
        });

        closeSaidaModal.addEventListener('click', () => {
            saidaModal.style.display = "none";
        });
    </script>
</body>

</html>
