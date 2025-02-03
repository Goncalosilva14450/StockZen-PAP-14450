<?php
session_start(); // Inicia a sessão para armazenar dados do usuário logado

// Conectar ao banco de dados
include('dbconfig.php');

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Verificar se o email existe no banco de dados
    $sql = "SELECT user_id, email, password FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);

    // Se encontrar o usuário
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Verificar se a senha está correta
        if (password_verify($password, $row['password'])) {
            // Senha correta, iniciar sessão e redirecionar
            $_SESSION['userid'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            header("Location: home.php");
            exit();
        } else {
            // Senha incorreta
            $error = "Senha incorreta.";
        }
    } else {
        // Usuário não encontrado
        $error = "Email não encontrado.";
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
    <title>StockZen - Login</title>
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
        .login-container {
            display: flex;
            background-color: #1a1a1a;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 800px;
            height: 500px;
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
        .create-account {
            position: absolute;
            bottom: 10px;
            right: 10px;
            color: #d4f8d4;
        }
        .create-account a {
            color: #d4f8d4;
            text-decoration: underline;
        }
        .create-account a:hover {
            color: #a1e6a1;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="brand-section">
            <h1>StockZen</h1>
            <p>Bem-vindo de volta!</p>
        </div>
        <div class="form-section">
            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <h3>Login</h3>
            <form method="POST" action="index.php">
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" name="email" required />
                    <label for="inputEmail">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password" required />
                    <label for="inputPassword">Palavra Passe</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                    <label class="form-check-label" for="inputRememberPassword">Lembrar Palavra Passe</label>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <div class="social-login">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-google"></i></a>
                </div>
            </form>
            <div class="create-account">
                <p>Não tem uma conta? <a href="register.php">Crie uma agora!</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
