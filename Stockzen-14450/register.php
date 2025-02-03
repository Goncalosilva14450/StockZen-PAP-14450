<?php
include('dbconfig.php');  // Inclui a conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber dados do formulário
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $username = mysqli_real_escape_string($con, $_POST['username']); // Captura o username
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $passwordConfirm = mysqli_real_escape_string($con, $_POST['passwordConfirm']);

    // Validar que as senhas correspondem
    if ($password !== $passwordConfirm) {
        $error = "As senhas não correspondem.";
    } else {
        // Hash da senha para segurança
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Verificar se o email ou username já existe
        $sql = "SELECT user_id FROM users WHERE email = '$email' OR username = '$username'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error = "O email ou nome de usuário já está em uso.";
        } else {
            // Inserir novo usuário no banco de dados
            $sql = "INSERT INTO users (first_name, last_name, username, email, password) 
                    VALUES ('$firstName', '$lastName', '$username', '$email', '$hashedPassword')";

            if (mysqli_query($con, $sql)) {
                header("Location: index.php");  // Redireciona para a página de login
                exit();
            } else {
                $error = "Erro ao criar a conta. Tente novamente.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>StockZen - Criar Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            background-color: #0f0f0f;
            font-family: Arial, sans-serif;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            display: flex;
            background-color: #1a1a1a;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 800px;
            height: 600px;
        }
        .brand-section {
            background-color: #144d14;
            color: #d4f8d4;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 40%;
        }
        .brand-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .brand-section img {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .form-section {
            padding: 50px;
            flex: 1;
            position: relative;
        }
        .form-section h3 {
            margin-bottom: 20px;
            color: #d4f8d4;
        }
        .form-control {
            background-color: #2a2a2a;
            border: none;
            color: #d4f8d4;
        }
        .form-control:focus {
            background-color: #3a3a3a;
            border: 1px solid #144d14;
            color: #fff;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #144d14;
            border: none;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #196f19;
        }
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .social-login a {
            color: #d4f8d4;
            font-size: 1.5rem;
            text-decoration: none;
        }
        .login-link {
            position: absolute;
            bottom: 10px;
            right: 10px;
            color: #d4f8d4;
        }
        .login-link a {
            color: #d4f8d4;
            text-decoration: underline;
        }
        .login-link a:hover {
            color: #a1e6a1;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="brand-section">
            <h1>StockZen</h1>
            <p>Junte-se a nós agora!</p>
        </div>
        <div class="form-section">
            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <h3>Criar Conta</h3>
            <form method="POST" action="register.php">
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputUsername" type="text" placeholder="Nome de Usuário" name="username" required />
                    <label for="inputUsername">Nome de Utilizador</label>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputFirstName" type="text" placeholder="Primeiro Nome" name="firstName" required />
                            <label for="inputFirstName">Primeiro Nome</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputLastName" type="text" placeholder="Ultimo Nome" name="lastName" required />
                            <label for="inputLastName">Ultimo Nome</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" name="email" required />
                    <label for="inputEmail">Email</label>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputPassword" type="password" placeholder="Criar uma senha" name="password" required />
                            <label for="inputPassword">Palavra Passe</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirmar senha" name="passwordConfirm" required />
                            <label for="inputPasswordConfirm">Confirmar Palavra Passe</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><button type="submit" class="btn btn-primary btn-block">Criar Conta</button></div>
                </div>
            </form>
            <div class="login-link">
                <p>Já tem uma conta? <a href="index.php">Vá para o Login</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
