
<?php
session_start();
include "dbconfig.php";
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

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">StockZen</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
       <div class="input-group">
                <input class="form-control" type="text" id="searchInput" placeholder="Procurar por..." aria-label="Search for..." aria-describedby="btnNavbarSearch" onkeyup="buscarPeca()" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
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
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.php">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.php">Light Sidenav</a>
                                </nav>
                            </div>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.php">Login</a>
                                            <a class="nav-link" href="register.php">Register</a>
                                            <a class="nav-link" href="password.php">Forgot Password</a>
                                        </nav>
                                    </div>
                            </div>
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
                    <h1 class="mt-4">Registo de Fornecedor</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Fornecedores</li>
                    </ol>


                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-truck me-1"></i>
                            Registo de Fornecedor
                        </div>
                  <!-- Formulário -->
                        <div class="card-body">
                            <form id="formFornecedor" action="/insert_fornecedores.php">
                                <div class="mb-3">
                                    <label for="nomeFornecedor" class="form-label">Nome do Fornecedor</label>
                                    <input type="text" class="form-control" id="nomeFornecedor" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tipoContatoFornecedor" class="form-label">Tipo de Contato</label>
                                    <select class="form-control" id="tipoContatoFornecedor" required>
                                        <option value="">Selecione</option>
                                        <option value="Email">Email</option>
                                        <option value="Telefone">Telefone</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="contatoFornecedor" class="form-label">Contato (Email ou Número)</label>
                                    <input type="text" class="form-control" id="contatoFornecedor" required>
                                </div>
                                <div class="mb-3">
                                    <label for="localidadeFornecedor" class="form-label">Localidade</label>
                                    <input type="text" class="form-control" id="localidadeFornecedor" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Adicionar Fornecedor</button>
                            </form>
                        </div>
                    </div>

                    <!-- Lista de Fornecedores -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-list me-1"></i>
                            Lista de Fornecedores
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="tabelaFornecedores">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Tipo de Contato</th>
                                        <th>Contato</th>
                                        <th>Localidade</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Os fornecedores são carregados aqui -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">StockZen &copy; Since 2024</div>

                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Carregar fornecedores 
        function carregarFornecedores() {
            const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
            const tabelaFornecedores = document.getElementById('tabelaFornecedores').getElementsByTagName('tbody')[0];
            tabelaFornecedores.innerHTML = '';

            fornecedores.forEach((fornecedor, index) => {
                const row = tabelaFornecedores.insertRow();
                row.innerHTML = `
                    <td>${fornecedor.nome}</td>
                    <td>${fornecedor.tipoContato}</td>
                    <td>${fornecedor.contato}</td>
                    <td>${fornecedor.localidade}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarFornecedor(${index})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deletarFornecedor(${index})">Excluir</button>
                    </td>
                `;
            });
        }

        // Adicionar novo fornecedor
        function adicionarFornecedor(event) {
            event.preventDefault();

            const nome = document.getElementById('nomeFornecedor').value;
            const tipoContato = document.getElementById('tipoContatoFornecedor').value;
            const contato = document.getElementById('contatoFornecedor').value;
            const localidade = document.getElementById('localidadeFornecedor').value;

            if (!nome || !tipoContato || !contato || !localidade) {
                alert('Por favor, preencha todos os campos.');
                return;
            }

            // Criar um novo fornecedor
            const fornecedor = { nome, tipoContato, contato, localidade };

            // Salvar no localStorage
            let fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
            fornecedores.push(fornecedor);
            localStorage.setItem('fornecedores', JSON.stringify(fornecedores));

            alert('Fornecedor registrado com sucesso!');
            carregarFornecedores();

    
            document.getElementById('formFornecedor').reset();
        }

        // Editar fornecedor
        function editarFornecedor(index) {
            const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
            const fornecedor = fornecedores[index];

            // Preencher o formulário com os dados do fornecedor
            document.getElementById('nomeFornecedor').value = fornecedor.nome;
            document.getElementById('tipoContatoFornecedor').value = fornecedor.tipoContato;
            document.getElementById('contatoFornecedor').value = fornecedor.contato;
            document.getElementById('localidadeFornecedor').value = fornecedor.localidade;

            // Alterar o botão de submit para editar
            const botaoSubmit = document.querySelector('button[type="submit"]');
            botaoSubmit.innerHTML = 'Atualizar Fornecedor';
            botaoSubmit.onclick = function () {
                atualizarFornecedor(index);
            };
        }

        // Atualizar fornecedor
        function atualizarFornecedor(index) {
            const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];

            const nome = document.getElementById('nomeFornecedor').value;
            const tipoContato = document.getElementById('tipoContatoFornecedor').value;
            const contato = document.getElementById('contatoFornecedor').value;
            const localidade = document.getElementById('localidadeFornecedor').value;

            fornecedores[index] = { nome, tipoContato, contato, localidade };
            localStorage.setItem('fornecedores', JSON.stringify(fornecedores));

            alert('Fornecedor atualizado com sucesso!');
            carregarFornecedores();

            // Limpar o formulário e voltar o botão ao estado original
            document.getElementById('formFornecedor').reset();
            const botaoSubmit = document.querySelector('button[type="submit"]');
            botaoSubmit.innerHTML = 'Adicionar Fornecedor';
            botaoSubmit.onclick = adicionarFornecedor;
        }

        // Deletar fornecedor
        function deletarFornecedor(index) {
            if (confirm('Tem certeza que deseja excluir este fornecedor?')) {
                const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
                fornecedores.splice(index, 1);
                localStorage.setItem('fornecedores', JSON.stringify(fornecedores));

                alert('Fornecedor excluído com sucesso!');
                carregarFornecedores();
            }
        }

        // Carregar fornecedores ao iniciar a página
        window.onload = function () {
            carregarFornecedores();

            // Configurar o formulário para capturar o submit
            document.getElementById('formFornecedor').addEventListener('submit', adicionarFornecedor);
        };
    </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
</body>
</html>
