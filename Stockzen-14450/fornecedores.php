<?php
session_start();
include "dbconfig.php";

// Processar formulário de inserção
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    // Validar e sanitizar dados
    $nome = trim($_POST['name']);
    $tipo_contato = trim($_POST['contact_type']);
    $contato = trim($_POST['contact']);
    $localidade = trim($_POST['location']);

    // Validar campos obrigatórios
    if (empty($nome) || empty($tipo_contato) || empty($contato) || empty($localidade)) {
        $_SESSION['error'] = "Todos os campos são obrigatórios!";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    // Usar prepared statements
    $sql = "INSERT INTO suppliers_info (name, contact_type, contact, location) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $nome, $tipo_contato, $contato, $localidade);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Fornecedor adicionado com sucesso!";
        } else {
            $_SESSION['error'] = "Erro ao executar a query: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Erro na preparação da query: " . mysqli_error($con);
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Processar exclusão
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    $sql = "DELETE FROM suppliers_info WHERE 	suppliers_info_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Fornecedor excluído com sucesso!";
        } else {
            $_SESSION['error'] = "Erro ao excluir: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Erro na preparação da query: " . mysqli_error($con);
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Buscar todos os fornecedores
$sql = "SELECT * FROM suppliers_info ORDER BY name ASC";
$result = mysqli_query($con, $sql);

$fornecedores = [];
if ($result) {
    $fornecedores = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $_SESSION['error'] = "Erro ao carregar fornecedores: " . mysqli_error($con);
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <title>StockZen</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.html">StockZen</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Procurar..." id="searchInput">
        </div>
    </form>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="home.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Página Inicial
                    </a>
                    <a class="nav-link" href="gestao.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                        Controlo de Stock
                    </a>
                    <a class="nav-link" href="produtos.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                        Produtos
                    </a>
                    <a class="nav-link active" href="fornecedores.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                        Fornecedores
                    </a>
                </div>
            </div>
        </nav>
    </div>
<!-- Modal de Edição -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Fornecedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="update_supplier.php">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editContactType" class="form-label">Tipo de Contato</label>
                        <select class="form-select" id="editContactType" name="contact_type" required>
                            <option value="Email">Email</option>
                            <option value="Telefone">Telefone</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editContact" class="form-label">Contato</label>
                        <input type="text" class="form-control" id="editContact" name="contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLocation" class="form-label">Localidade</label>
                        <input type="text" class="form-control" id="editLocation" name="location" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success mt-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger mt-4"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <h1 class="mt-4">Gestão de Fornecedores</h1>
                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-truck me-1"></i>
                        Novo Fornecedor
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nomeFornecedor" class="form-label">Nome</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Contato</label>
                                    <select class="form-select" name="contact_type" required>
                                        <option value="">Selecione...</option>
                                        <option value="Email">Email</option>
                                        <option value="Telefone">Telefone</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contato</label>
                                    <input type="text" class="form-control" name="contact" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Localidade</label>
                                    <input type="text" class="form-control" name="location" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success" name="insert">
                                        <i class="fas fa-save me-2"></i>Salvar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <td>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-list me-1"></i>
                        Fornecedores Registados
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="dataTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Tipo Contato</th>
                                        <th>Contato</th>
                                        <th>Localidade</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($fornecedores as $fornecedor): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($fornecedor['name']) ?></td>
                                            <td><?= htmlspecialchars($fornecedor['contact_type']) ?></td>
                                            <td><?= htmlspecialchars($fornecedor['contact']) ?></td>
                                            <td><?= htmlspecialchars($fornecedor['location']) ?></td>
                                            <td>
                                            <button class="btn btn-warning btn-sm edit-btn" 
            data-id="<?= $fornecedor['suppliers_info_id'] ?>" 
            data-name="<?= htmlspecialchars($fornecedor['name']) ?>" 
            data-contact-type="<?= htmlspecialchars($fornecedor['contact_type']) ?>" 
            data-contact="<?= htmlspecialchars($fornecedor['contact']) ?>" 
            data-location="<?= htmlspecialchars($fornecedor['location']) ?>">
        Editar
    </button>
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete=<?= $fornecedor['suppliers_info_id'] ?>" 
       class="btn btn-danger btn-sm" 
       onclick="return confirm('Tem certeza que deseja excluir?')">
        Excluir
    </a>
</td>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-PT.json'
        },
        columnDefs: [
            { orderable: false, targets: 4 }
        ]
    });
});


$(document).ready(function() {
    // Abrir o modal e preencher os campos
    $('.edit-btn').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var contactType = $(this).data('contact-type');
        var contact = $(this).data('contact');
        var location = $(this).data('location');

        $('#editId').val(id);
        $('#editName').val(name);
        $('#editContactType').val(contactType);
        $('#editContact').val(contact);
        $('#editLocation').val(location);

        $('#editModal').modal('show');
    });

    // Configuração do DataTable
    $('#dataTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-PT.json'
        },
        columnDefs: [
            { orderable: false, targets: 4 }
        ]
    });
});
</script>

</body>
</html>

<?php
mysqli_close($con);
?>